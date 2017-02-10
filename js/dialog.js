var zenodoDialog = {

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