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

$(document).ready(function () {

	var zenodoActions = {


		init: function () {

			var self = this;
			self.currentFileId = '';
			self.published = false;

			// add a div to the <body>
			if (!$('#zenodo_dialog').length)
				$('body').append('<div id="zenodo_dialog" title="Zenodo"></div>');

			OCA.Files.fileActions.registerAction({
				name: 'zenodo_newdepo',
				displayName: t('zenodo', 'Create a new deposition'),
				mime: 'all',
				permissions: OC.PERMISSION_READ,
				type: OCA.Files.FileActions.TYPE_DROPDOWN,
				iconClass: 'icon-zenodo',
				actionHandler: function (filename, context) {
					zenodo_newdepo
					zenodoActions.NewDeposition.detectPopup(filename, context);
				}
			});

			OCA.Files.fileActions.registerAction({
				name: 'zenodo_addfile',
				displayName: t('zenodo', 'Add this file to a deposition'),
				mime: 'all',
				permissions: OC.PERMISSION_READ,
				type: OCA.Files.FileActions.TYPE_DROPDOWN,
				iconClass: 'icon-zenodo',
				actionHandler: function (filename, context) {
					zenodoActions.AddFile.detectPopup(filename, context);
				}
			});

		},


		NewDeposition: {

			currentFileId: '',

			detectPopup: function (filename, context) {
				var fileid = context.fileList.getModelForFile(filename).get('id');
				var data = {
					fileid: fileid,
					filename: filename
				};

				$.post(OC.filePath('zenodo', 'ajax',
					'getZenodoDeposit.php'), data, zenodoActions.NewDeposition.detectPopupResult);
			},


			detectPopupResult: function (response) {
				if (response == null)
					return;

				if (response.depositid == 0)
					zenodoActions.NewDeposition.showPopup(response.fileid, response.filename);
				else
					window.alert("File was already uploaded to Zenodo");
			},


			showPopup: function (fileid, filename) {

				if ($('#zenodo_end').length)
					$('#zenodo_end').remove();

				if ($('#zenodo_error').length)
					$('#zenodo_error').remove();

				if ($('#zenodo_dialog_buttons').length)
					$('#zenodo_dialog_buttons').remove();

				self.currentFileId = fileid;
				self.published = false;

				$.get(OC.filePath('zenodo', 'ajax',
					'getZenodoDialog.php'), {type: 'NewDeposition'},
					zenodoActions.NewDeposition.fillPopup
				);

				$('#zenodo_dialog').attr('title', 'Zenodo - New Deposition - ' + filename);
				$('#zenodo_dialog').dialog();
				$('#zenodo_dialog').css('width', '700px').css('height', '600px');
				$('#zenodo_dialog').parent().css('width', '700px').css('height', '600px').css('top',
					'100px').css('z-index', '9999');

				$('#zenodo_dialog').parent().css('box-shadow', '0px 0px 0px #5151514D');
				$('#zenodo_dialog').parent().css('moz-box-shadow', '0px 0px 0px #5151514D');
				$('#zenodo_dialog').parent().css('-webkit-box-shadow', '0px 0px 0px #5151514D');

				// uncomment this line if you want to remove the shadow animation
				// $('#zenodo_dialog').parent().addClass('zenodo_dialog_shadow');
			},


			fillPopup: function (response) {

				if (self.published)
					return;

				$('#zenodo_dialog').html(response);

				zenodoActions.NewDeposition.initDialog();

				setTimeout(function () {
					$('#zenodo_dialog').parent().append('<div id="zenodo_dialog_buttons"></div>');
					$('#zenodo_dialog_buttons').hide();
					$('#zenodo_dialog_buttons').append(
						'<div id="zenodo_dialog_close" class="zenodo_dialog_button">Close</div>').append(
						'<div id="zenodo_dialog_sandbox" class="zenodo_dialog_button">Publish (sandbox)</div>')
						.append(
							'<div id="zenodo_dialog_production" class="zenodo_dialog_button">Publish (production)</div>').fadeIn(
						400);

					zenodoActions.NewDeposition.enableButtons(true);

					$('#zenodo_dialog').parent().animate(
						{boxShadow: "3px 3px 5px rgba(81, 81, 81, 0.40)"});

				}, 500);
			},


			enableButtons: function (enabled) {

				if (self.published)
					return;

				if (enabled) {

					$('#zenodo_dialog_buttons').fadeTo(200, 1);

					$('#zenodo_dialog_close').on('click', function () {
						zenodoActions.NewDeposition.enableButtons(false);
						$('#zenodo_dialog').dialog('close');
					});
					$('#zenodo_dialog_sandbox').on('click', function () {
						zenodoActions.NewDeposition.enableButtons(false);
						zenodoActions.NewDeposition.publish(false);
					});
					$('#zenodo_dialog_production').on('click', function () {
						zenodoActions.NewDeposition.enableButtons(false);
						zenodoActions.NewDeposition.publish(true);
					});

				} else {
					$('#zenodo_dialog_buttons').fadeTo(200, 0.3);
					$('#zenodo_dialog_buttons').children().off('click');
				}

			},


			initDialog: function () {

				if (self.published)
					return;

				zenodoDialog.init();
			},


			publish: function (prod) {

				if (self.published)
					return;

				if ($('#zenodo_error').length)
					$('#zenodo_error').remove();

				var data = {
					fileid: self.currentFileId,
					metadata: zenodoDialog.metadata(),
					production: prod
				};

				$.post(OC.filePath('zenodo', 'ajax',
					'publishToZenodo.php'), data, zenodoActions.NewDeposition.result);
			},


			result: function (response) {
				//	window.alert("response: " + response);
				if (response.published) {
					zenodoActions.NewDeposition.enableButtons(true);

					self.published = true;
					$('#zenodo_dialog_sandbox').fadeTo(200, 0.3);
					$('#zenodo_dialog_sandbox').off('click');
					$('#zenodo_dialog_production').fadeTo(200, 0.3);
					$('#zenodo_dialog_production').off('click');

					$('#zendialog_content').fadeOut(400, function () {
						$('#zenodo_dialog').append(
							'<div id="zenodo_end">Your file has been published to Zenodo.org</div>');
					});
				}
				else {
					zenodoActions.NewDeposition.enableButtons(true);
					$('#zenodo_dialog').prepend('<div id="zenodo_error"></div>');
					var i = 0;
					try {
						response.error.messages.forEach(function (item) {
							$('#zenodo_error').append(item + '<br />');
							if (i++ >= 3)
								throw BreakException;
						});
					} catch (e) {
					}
				}

			}
		},


		AddFile: {

			detectPopup: function (filename, context) {
				var fileid = context.fileList.getModelForFile(filename).get('id');
				var data = {
					fileid: fileid,
					filename: filename
				};

				$.post(OC.filePath('zenodo', 'ajax',
					'getZenodoDeposit.php'), data, zenodoActions.AddFile.detectPopupResult);
			},


			detectPopupResult: function (response) {
				if (response == null)
					return;

				if (response.depositid == 0)
					zenodoActions.AddFile.showPopup(response.fileid, response.filename);
				else
					window.alert("File was already uploaded to Zenodo");
			},


			showPopup: function (fileid, filename) {

				if ($('#zenodo_end').length)
					$('#zenodo_end').remove();

				if ($('#zenodo_error').length)
					$('#zenodo_error').remove();

				if ($('#zenodo_dialog_buttons').length)
					$('#zenodo_dialog_buttons').remove();

				$('#zendialog_deposition').html('');

				$.get(OC.filePath('zenodo', 'ajax',
					'getZenodoDialog.php'), {type: 'AddFile'}, zenodoActions.AddFile.fillPopup
				);

				//
				$('#zenodo_dialog').attr('title', 'Zenodo - Add File - ' + filename);
				$('#zenodo_dialog').dialog();
				$('#zenodo_dialog').css('width', '850px').css('height', '300px');
				$('#zenodo_dialog').parent().css('width', '850px').css('height',
					'300px').css('top', '150px').css('z-index', '9999');
				$('#zenodo_dialog').parent().css('box-shadow', '0px 0px 0px #5151514D');
				$('#zenodo_dialog').parent().css('moz-box-shadow', '0px 0px 0px #5151514D');
				$('#zenodo_dialog').parent().css('-webkit-box-shadow', '0px 0px 0px #5151514D');

				// uncomment this line if you want to remove the shadow animation
				// $('#zenodo_dialog').parent().addClass('zenodo_dialog_shadow');
			},


			enableButtons: function (enabled) {

				if (self.published)
					return;

				if (enabled) {

					$('#zenodo_dialog_buttons').fadeTo(200, 1);

					$('#zenodo_dialog_close').on('click', function () {
						zenodoActions.AddFile.enableButtons(false);
						$('#zenodo_dialog').dialog('close');
					});
					$('#zenodo_dialog_upload').on('click', function () {
						zenodoActions.AddFile.enableButtons(false);
						zenodoActions.AddFile.publish(false);
					});

				} else {
					$('#zenodo_dialog_buttons').fadeTo(200, 0.3);
					$('#zenodo_dialog_buttons').children().off('click');
				}

			},


			fillPopup: function (response) {

				$.post(OC.filePath('zenodo', 'ajax',
					'getDepositionsFromZenodo.php'), {}, zenodoActions.AddFile.initDialog
				);


				if (self.published)
					return;

				$('#zenodo_dialog').html(response);


				setTimeout(function () {
					$('#zenodo_dialog').parent().append('<div id="zenodo_dialog_buttons"></div>');
					$('#zenodo_dialog_buttons').hide();
					$('#zenodo_dialog_buttons').append(
						'<div id="zenodo_dialog_close" class="zenodo_dialog_button_50">Close</div>').append(
						'<div id="zenodo_dialog_upload" class="zenodo_dialog_button_50">Publish</div>').fadeIn(
						400);
					zenodoActions.AddFile.enableButtons(true);
					$('#zenodo_dialog').parent().animate({
						boxShadow: "3px 3px 5px rgba(81, 81, 81, 0.40)"
					});
				}, 500);
			},

			initDialog: function (response) {
				//window.alert('ok');

				$('#zendialog_deposition').append($('<option>', {
					value: 0,
					text: ''
				}));

				response.data.forEach(function (item) {

//					console.log('item:' + item.title);

					$('#zendialog_deposition').append($('<option>', {
						value: item.depositid,
						text: item.title
					}));
				});

			}

		}

	}

	zenodoActions.init();

});


