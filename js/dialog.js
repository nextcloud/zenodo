/*
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


var zenodoDialog = {

	currentCreators: [],

	init: function () {

		$('#zendialog_publicationtype').hide();
		$('#zendialog_imagetype').hide();

		$('#zendialog_uploadtype').change(function () {
			if ($('#zendialog_uploadtype option:selected').val() == 'publication')
				$('#zendialog_imagetype').fadeOut(200, function () {
					$('#zendialog_publicationtype').fadeIn(200);
				});
			else
				$('#zendialog_publicationtype').fadeOut(200);

			if ($('#zendialog_uploadtype option:selected').val() == 'image')
				$('#zendialog_publicationtype').fadeOut(200, function () {
					$('#zendialog_imagetype').fadeIn(200);
				});
			else
				$('#zendialog_imagetype').fadeOut(200);
		});

		$('#zendialog_publicationdate').datepicker({
			dateFormat: "yy-mm-dd",
			minDate: "-20Y",
			maxDate: "+20Y"
		});
		$('#zendialog_embargodate').datepicker({
			dateFormat: "yy-mm-dd",
			minDate: "-20Y",
			maxDate: "+20Y"
		});

		$('#zendialog_license').hide();
		$('#zendialog_display_embargodate').hide();
		$('#zendialog_display_accesscondition').hide();
		$('#zendialog_creator_search_result').hide();
		$('#zendialog_creator_syntax_error').hide();

		$('#zendialog_accessright').change(function () {
			if ($('#zendialog_accessright option:selected').val() == 'open' ||
				$('#zendialog_accessright option:selected').val() == 'embargoed')
				$('#zendialog_license').fadeIn(200);
			else
				$('#zendialog_license').fadeOut(200);

			if ($('#zendialog_accessright option:selected').val() == 'embargoed')
				$('#zendialog_display_accesscondition').fadeOut(200, function () {
					$('#zendialog_display_embargodate').fadeIn(200);
				});
			else
				$('#zendialog_display_embargodate').fadeOut(200);

			if ($('#zendialog_accessright option:selected').val() == 'restricted')
				$('#zendialog_display_embargodate').fadeOut(200, function () {
					$('#zendialog_display_accesscondition').fadeIn(200);
				})
			else
				$('#zendialog_display_accesscondition').fadeOut(200);
		});

		$('#zendialog_sub').on('click', function () {
			zenodoDialog.localCreator('_self');
		});

		$('#zendialog_creator_search').on('input propertychange paste focus', function () {
			if ($('#zendialog_creator_search').val().trim() == '')
				zenodoDialog.searchCreatorResult(null);
			else
				$.get(OC.linkToOCS('apps/files_sharing/api/v1') + 'sharees',
					{
						format: 'json',
						search: $('#zendialog_creator_search').val().trim(),
						perPage: 200,
						itemType: 'principals'
					}, zenodoDialog.searchCreatorResult);
		}).blur(function () {
			$('#zendialog_creator_search_result').fadeOut(400);
		});


		$('#zendialog_create_add').css('background-image',
			'url(' + OC.imagePath('core', 'actions/add') + ')');
		$('#zendialog_create_add').on('click', function () {

			if ($('#zendialog_creator_realname').val().indexOf(',') > -1) {
				$('#zendialog_creator_syntax_error').fadeOut(300);
				zenodoDialog.addCreator($('#zendialog_creator_realname').val(),
					$('#zendialog_creator_orcid').val());
			} else {
				$('#zendialog_creator_syntax_error').fadeIn(300);
			}

		})
	},


	searchCreatorResult: function (response) {
		if (response == null || response.ocs.data.users == 0)
			$('#zendialog_creator_search_result').fadeOut(300);

		else {
			$('#zendialog_creator_search_result').empty();
			$.each(response.ocs.data.users, function (index, value) {
				$('#zendialog_creator_search_result').append(
					'<div class="zendialog_result" searchresult="' + value.value.shareWith +
					'">' + value.label + '   (' +
					value.value.shareWith + ')</div>');
			});

			$('DIV.zendialog_result').on('click', function () {
				zenodoDialog.localCreator($(this).attr('searchresult'));
			});
			$('#zendialog_creator_search_result').fadeIn(300);
		}
	},


	localCreator: function (username) {
		var data = {username: username};
		$.post(OC.filePath('zenodo', 'ajax',
			'getLocalCreator.php'), data, zenodoDialog.displayLocalCreator);
	},


	displayLocalCreator: function (response) {
		$('#zendialog_creator_realname').val(response.realname);
		$('#zendialog_creator_orcid').val(response.orcid);
	},


	addCreator: function (realname, orcid) {
		if (orcid != '')
			orcid = ' - ' + orcid;

		for (i = 0; i < zenodoDialog.currentCreators.length; i++) {
			if (zenodoDialog.currentCreators[i].realname == realname)
				return;
		}

		zenodoDialog.currentCreators.push({
			realname: realname,
			orcid: orcid
		});
		$('#zendialog_creators_list').append(
			'<div>' + realname + orcid + '</div>');
	},


	metadata: function () {
		var creators = [{name: $('#zendialog_creators').val()}];

		var data = {
			upload_type: $('#zendialog_uploadtype option:selected').val(),
			publication_type: $('#zendialog_publicationtype option:selected').val(),
			image_type: $('#zendialog_imagetype option:selected').val(),
			publication_date: $('#zendialog_publicationdate').val(),
			title: $('#zendialog_title').val(),
			creators: creators,
			description: $('#zendialog_description').val(),
			access_right: $('#zendialog_accessright option:selected').val(),
			embargo_date: $('#zendialog_embargodate').val(),
			access_conditions: $('#zendialog_accessconditions').val(),
			license: $('#zendialog_license option:selected').val()
		}

		return data;
	}

};

