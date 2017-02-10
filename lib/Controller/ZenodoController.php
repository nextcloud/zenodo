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
use OCA\Zenodo\Service\MiscService;
use OCA\Zenodo\Service\ApiService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class ZenodoController extends Controller {

	private $configService;
	private $apiService;
	private $miscService;

	public function __construct(
		$appName, IRequest $request, ConfigService $configService, ApiService $apiService,
		MiscService $miscService
	) {
		parent::__construct($appName, $request);
		$this->configService = $configService;
		$this->apiService = $apiService;
		$this->miscService = $miscService;
	}

	//
	// Admin
	//

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function dialogZenodo() {
		return new TemplateResponse($this->appName, 'dialog', [], 'blank');
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
			$published = true;
		}

		$response = array(
			'error'     => $iError->toArray(),
			'published' => $published
		);

		return $response;
	}
}