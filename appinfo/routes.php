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

return [
	'routes' => [
		[
			'name' => 'settings#getZenodoInfo',
			'url'  => 'ajax/settings/getZenodoInfo.php',
			'verb' => 'POST'
		],
		[
			'name' => 'settings#setZenodoInfo',
			'url'  => 'ajax/settings/setZenodoInfo.php',
			'verb' => 'POST'
		],
		[
			'name' => 'Zenodo#publishToZenodo',
			'url'  => 'ajax/publishToZenodo.php',
			'verb' => 'POST'
		],
		[
			'name' => 'Zenodo#getZenodoDeposit',
			'url'  => 'ajax/getZenodoDeposit.php',
			'verb' => 'POST'
		],
		[
			'name' => 'Zenodo#dialogZenodo',
			'url'  => 'ajax/getZenodoDialog.php',
			'verb' => 'GET'
		],
		[
			'name' => 'Zenodo#getLocalCreator',
			'url'  => 'ajax/getLocalCreator.php',
			'verb' => 'POST'
		]

	]
];


