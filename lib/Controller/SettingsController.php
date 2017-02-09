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
namespace OCA\Zenodo\Controller;

use \OCA\Zenodo\Service\ConfigService;
use OCA\Zenodo\Service\MiscService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use Punic\Misc;

class SettingsController extends Controller {

	private $configService;

	private $miscService;

	public function __construct(
		$appName, IRequest $request, ConfigService $configService, MiscService $miscService
	) {
		parent::__construct($appName, $request);
		$this->configService = $configService;
		$this->miscService = $miscService;
	}

	//
	// Admin
	//

	/**
	 * @NoCSRFRequired
	 */
	public function admin() {
		return new TemplateResponse($this->appName, 'settings.admin', [], 'blank');
	}

	public function getZenodoInfo() {
		$params = [
			'tokenSandbox'    => $this->configService->getAppValue(ConfigService::TOKEN_SANDBOX),
			'tokenProduction' => $this->configService->getAppValue(ConfigService::TOKEN_PRODUCTION)
		];

		return $params;
	}

	public function setZenodoInfo($token_sandbox, $token_production) {
		$this->configService->setAppValue(ConfigService::TOKEN_SANDBOX, $token_sandbox);
		$this->configService->setAppValue(ConfigService::TOKEN_PRODUCTION, $token_production);

		return $this->getZenodoInfo();
	}
}