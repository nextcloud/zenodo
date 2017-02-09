<?php

/**
 * Zenodo - based on files_zenodo from Lars Naesbye Christensen
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Lars Naesbye Christensen, DeIC
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
 *
 */
namespace OCA\Zenodo\Service;

use \OCA\Zenodo\Service\ConfigService;
use OCA\Zenodo\Service\MiscService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class ApiService {

	const ZENODO_DOMAIN_SANDBOX = 'https://sandbox.zenodo.org/';
	const ZENODO_DOMAIN_PRODUCTION = 'https://zenodo.org/';

	const ZENODO_API_DEPOSITIONS_CREATE = 'api/deposit/depositions';
	const ZENODO_API_DEPOSITIONS_FILES_UPLOAD = 'api/deposit/depositions/%ID%/files';

	private $configService;
	private $miscService;

	private $production = false;
	private $token = '';

	public function __construct(ConfigService $configService, MiscService $miscService) {
		$this->configService = $configService;
		$this->miscService = $miscService;
	}


	public function init($production) {

		$this->production = $production;

		$this->initToken();
		if ($this->token === '') {
			return false;
		}

		return true;
	}

	public function configured() {
		if ($this->token === '') {
			return false;
		}

		return true;
	}

	private function initToken() {
		if ($this->production) {
			$this->token =
				$this->configService->getAppValue(ConfigService::ZENODO_TOKEN_PRODUCTION);
		} else {
			$this->token = $this->configService->getAppValue(ConfigService::ZENODO_TOKEN_SANDBOX);
		}
	}


	public static function generateUrl($from, $production) {

		$url = '';

		return $url;
	}

	public function create_deposition($metadata) {

		if (!$this->configured) {
			return false;
		}

		return true;
	}

}