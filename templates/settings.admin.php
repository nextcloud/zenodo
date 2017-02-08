<?php
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