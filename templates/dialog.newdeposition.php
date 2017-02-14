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

?>
<div id="zendialog_content">

	<table>
		<tr>
			<td class="zendialog_left">Upload type:</td>
			<td>

				<select
						id="zendialog_uploadtype">
					<option value=""></option>
					<option value="publication">Publication</option>
					<option value="poster">Poster</option>
					<option value="presentation">Presentation</option>
					<option value="dataset">Dataset</option>
					<option value="image">Image</option>
					<option value="video">Video/Audio</option>
					<option value="software">Software</option>
					<option value="lesson">Lesson</option>
				</select>

				<select id="zendialog_publicationtype">
					<option value="book">Book</option>
					<option value="section">Book Section</option>
					<option value="conferencepaper">Conference paper</option>
					<option value="article">Journal Article</option>
					<option value="patent">Patent</option>
					<option value="preprint">Preprint</option>
					<option value="deliverable">Project deliverable</option>
					<option value="milestone">Project milestone</option>
					<option value="proposal">Proposal</option>
					<option value="report">Report</option>
					<option value="softwaredocumentation">Software documentation</option>
					<option value="thesis">Thesis</option>
					<option value="technicalnote">Technical note</option>
					<option value="workingpaper">Working paper</option>
					<option value="other">Other</option>
				</select>
				<select id="zendialog_imagetype">
					<option value="figure">Figure</option>
					<option value="plot">Plot</option>
					<option value="drawing">Drawing</option>
					<option value="diagram">Diagram</option>
					<option value="photo">Photo</option>
					<option value="other">Other</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="zendialog_left">Publication date:</td>
			<td><input type="date" id="zendialog_publicationdate"></td>
		</tr>

		<tr>
			<td class="zendialog_left">Title:</td>
			<td><input type="text" id="zendialog_title" style="width: 400px"></td>
		</tr>

		<tr>
			<td class="zendialog_left" style="vertical-align: top; padding-top: 10px;">Description:
			</td>
			<td><textarea id="zendialog_description" style="width: 400px; height: 60px;"></textarea>
			</td>
		</tr>

		<tr>
			<td class="zendialog_left zendialog_creator_left">
				Creators:<br/>
				<span class="zendialog_sub" id="zendialog_sub">add yourself as creator</span><br/>
				<input type="text" id="zendialog_creator_search" style="width: 170px"
					   placeholder="or search in Nextcloud"/>
				<div id="zendialog_creator_search_result"></div>
			</td>
			<td class="zendialog_creator">
				<div><input type="text" id="zendialog_creator_realname" placeholder="Lastname, Firstname" style="width: 244px">
					<input type="text" id="zendialog_creator_orcid" placeholder="ORCID" style="width: 150px">
					<div id="zendialog_create_add"></div>
				</div>
				<div id="zendialog_creator_syntax_error">Name of creator must be in the format <b>Family
						name, Given names</b></div>
				<div id="zendialog_creators_list"></div>
			</td>
		</tr>

		<tr>
			<td></td>
			<td>
				<div id="zendialog_creators_list"></div>
			</td>
		</tr>
		<tr>
			<td style="height: 35px;">&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td class="zendialog_left">Access right:</td>
			<td>
				<select id="zendialog_accessright">
					<option value=""></option>
					<option value="open">Open</option>
					<option value="embargoed">Embargoed</option>
					<option value="restricted">Restricted</option>
					<option value="closed">Closed</option>
				</select>

				<select id="zendialog_license">
					<option value="">Choose a License</option>
					<option value="CC-BY-4.0">Creative Commons Attribution 4.0</option>
					<option value="CC-BY-SA-4.0">Creative Commons Attribution-ShareAlike 4.0
					</option>
					<option value="CC-BY-NC-4.0">Creative Commons Attribution-NonCommercial 4.0
					</option>
				</select>
			</td>
		</tr>
		<tr id="zendialog_display_embargodate">
			<td class="zendialog_left">Embargo date:</td>
			<td><input type="date" id="zendialog_embargodate">
			</td>
		</tr>
		<tr id="zendialog_display_accesscondition">
			<td class="zendialog_left">Access Conditions:</td>
			<td><textarea></textarea>
			</td>
		</tr>

	</table>


</div>