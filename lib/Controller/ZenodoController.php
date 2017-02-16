<?php

/**
 * Zenodo - Publish your work to Zenodo.org
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@pontapreta.net>
 * @copyright 2017
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace OCA\Zenodo\Controller;

use \OCA\Zenodo\Model\iError;
use \OCA\Zenodo\Service\ConfigService;
use \OCA\Zenodo\Service\MiscService;
use \OCA\Zenodo\Service\ApiService;
use \OCA\Zenodo\Model\DepositionFile;
use \OCA\Zenodo\Db\DepositionFilesMapper;
use \OCA\Zenodo\Db\DepositionFiles;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class ZenodoController extends Controller {


	private $userId;
	private $userManager;
	private $configService;
	private $apiService;
	private $depositionFilesMapper;
	private $miscService;

	public function __construct(
		$appName, IRequest $request, $userId, $userManager, ConfigService $configService,
		ApiService $apiService,
		DepositionFilesMapper $depositionFilesMapper,
		MiscService $miscService
	) {
		parent::__construct($appName, $request);
		$this->userId = $userId;
		$this->userManager = $userManager;
		$this->configService = $configService;
		$this->apiService = $apiService;
		$this->depositionFilesMapper = $depositionFilesMapper;
		$this->miscService = $miscService;
	}

	//
	// Admin
	//

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function dialogZenodo($type) {
		switch ($type) {
			case 'NewDeposition':
				return new TemplateResponse($this->appName, 'dialog.newdeposition', [], 'blank');

			case 'AddFile':
				return new TemplateResponse($this->appName, 'dialog.addfile', [], 'blank');
		}

	}


	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function getUnsubmittedDepositionsFromZenodo() {

		$iError = new iError();
		$success = false;
		$data = array();

		if ($this->apiService->init(false, $iError)) {

			$depositions = $this->apiService->list_deposition($iError);
			foreach ($depositions as $entry) {
				if ($entry->state === 'unsubmitted') {
					$more = $this->depositionFilesMapper->findDeposit($entry->id);
					if ($more !== null && $more->getUserId() === $this->userId) {
						$data[] = array(
							'title'      => '(sandbox) ' . $entry->title,
							'production' => 'false',
							'depositid'  => $entry->id
						);
					}
				}
			}

			$success = true;
		}

		if ($this->apiService->init(true, $iError)) {

			$depositions = $this->apiService->list_deposition($iError);
			foreach ($depositions as $entry) {
				if ($entry->state === 'unsubmitted') {
					$more = $this->depositionFilesMapper->findDeposit($entry->id);
					if ($more !== null && $more->getUserId() === $this->userId) {
						$data[] = array(
							'title'      => $entry->title,
							'production' => 'true',
							'depositid'  => $entry->id
						);
					}
				}
			}

			$success = true;
		}

		$response = array(
			'error'   => $iError->toArray(),
			'success' => $success,
			'data'    => $data
		);

		return $response;
	}


	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function publishToZenodo($fileid, $metadata, $production) {

		$iError = new iError();
		$published = false;
		if ($this->apiService->init(($production === 'true') ? true : false, $iError)
			&& ($deposition =
				$this->apiService->create_deposition(array('metadata' => $metadata), $iError))
			&& $this->apiService->upload_file($deposition->id, $fileid, $iError)
		) {

			$item = new DepositionFile();
			$item->setFileId($fileid);
			$item->setUserId($this->userId);
			$item->setType((($production === 'true') ? 'prod' : 'sandbox'));
			$item->setDepositId($deposition->id);
			$this->depositionFilesMapper->deleteFile(new DepositionFiles($item), false);
			$this->depositionFilesMapper->insert(new DepositionFiles($item));

			//DepositionFilesMapper::insertDeposition($result);


			$published = true;
		}

		$response = array(
			'error'     => $iError->toArray(),
			'published' => $published
		);

		return $response;
	}


	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function uploadToZenodo($depositid, $fileid, $production) {

		$iError = new iError();
		$published = false;

		$more = $this->depositionFilesMapper->findDeposit($depositid);
		if ($more === null || $more->getUserId() !== $this->userId) {
			$iError->setMessage("This is not your deposition");
		} else {

			if ($this->apiService->init(($production === 'true') ? true : false, $iError)
				&& $this->apiService->upload_file($depositid, $fileid, $iError)
			) {
				$item = new DepositionFile();
				$item->setFileId($fileid);
				$item->setUserId($this->userId);
				$item->setType((($production === 'true') ? 'prod' : 'sandbox'));
				$item->setDepositId($depositid);
				$this->depositionFilesMapper->deleteFile(new DepositionFiles($item), false);
				$this->depositionFilesMapper->insert(new DepositionFiles($item));

				$published = true;
			}
		}
		$response = array(
			'error'     => $iError->toArray(),
			'published' => $published
		);

		return $response;
	}


	/**
	 * @NoAdminRequired
	 */
	public function getZenodoDeposit($fileid, $filename) {
		$depositFile = $this->depositionFilesMapper->findfile($fileid);
		$response = array(
			'fileid'    => $fileid,
			'filename'  => $filename,
			'type'      => (($depositFile === null) ? '' : $depositFile->getType()),
			'depositid' => (($depositFile === null) ? 0 : $depositFile->getDepositId())
		);

		return $response;
	}


	/**
	 * @NoAdminRequired
	 */
	public function getLocalCreator($username) {

		if ($username === '_self') {
			$username = $this->userId;
		}

		$orcid = '';
		$realname = '';

		$user = $this->userManager->get($username);
		if ($user != null) {

			$realname = $user->getDisplayName();

			if (\OCP\App::isEnabled('orcid')) {
				$orcid = \OCA\Orcid\Service\ApiService::getUserOrcid($username);
			}
		}

		$response = array(
			'realname' => $realname,
			'orcid'    => $orcid
		);

		return $response;
	}
}



