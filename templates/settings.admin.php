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

script('zenodo', 'admin');
style('zenodo', 'admin');

?>

<fieldset id="zenodoAdminSettings" class="section">
	<h2>
		<img src="/apps/zenodo/img/zenodo.svg"
			 style='vertical-align: baseline; margin-right: 25px;'>Research.
		Shared.
	</h2>
	<table style="width: 650px;">
		<tr class="zenodo_admin_head">
			<td class="zenodo_admin_head" colspan="2">Zenodo Tokens</td>
		</tr>

		<tr>
			<td class="zenodo_admin_left">Sandbox Token:</td>
			<td><input type='text' style="width: 300px" name='sandboxtoken'
					   id='sandboxtoken' original-title=''
					   title='Access token for sandbox environment'></td>
		</tr>
		<tr>
			<td class="zenodo_admin_left">Production Token:</td>
			<td><input type='text' name='productiontoken' style="width: 300px"
					   id='productiontoken' original-title=''
					   title='Access token for production environment'></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' value='Store Zenodo Credentials'
					   style="width: 250px" original-title='' style="width: 300px"
					   id='tokensubmit' name='tokensubmit' title='Store Tokens'></input></td>
		</tr>
	</table>
	<div id='clientstatus' style="font-size: .8em;"></div>