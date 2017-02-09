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
			<td class="zendialog_left">Creators:</td>
			<td><input type="text" id="zendialog_creators" style="width: 400px"></td>
		</tr>

		<tr>
			<td class="zendialog_left">Description:</td>
			<td><input type="text" id="zendialog_description" style="width: 400px"></td>
		</tr>

		<tr>
			<td style="height: 35px;">&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td class="zendialog_left">Access right:</td>
			<td>
				<select id="zendialog_accessright">
					<option value="open">Open</option>
					<option value="embargoed">Embargoed</option>
					<option value="restricted">Restricted</option>
					<option value="closed">Closed</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="zendialog_left">License:</td>
			<td><select id="zendialog_license">
					<option value="Open Access">Open Access</option>
					<option value="Creative Commons">Creative Commons</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="zendialog_left">Embargo date:</td>
			<td><input type="date" id="zendialog_embargodate">
			</td>
		</tr>
		<tr>
			<td class="zendialog_left">Access Conditions:</td>
			<td>
			</td>
		</tr>

	</table>


</div>