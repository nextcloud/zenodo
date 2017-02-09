var zenodoDialog = {

	init: function () {

		$('#zendialog_publicationtype').hide();
		$('#zendialog_imagetype').hide();

		$('#zendialog_uploadtype').change(function () {
			if ($('#zendialog_uploadtype option:selected').val() == "publication")
				$('#zendialog_imagetype').fadeOut(200, function () {
					$('#zendialog_publicationtype').fadeIn(200);
				});
			else
				$('#zendialog_publicationtype').fadeOut(200);

			if ($('#zendialog_uploadtype option:selected').val() == "image")
				$('#zendialog_publicationtype').fadeOut(200, function () {
					$('#zendialog_imagetype').fadeIn(200);
				});
			else
				$('#zendialog_imagetype').fadeOut(200);
		});

		$('#zendialog_publicationdate').datepicker({ minDate: "-20Y", maxDate: "+20Y" });
		$('#zendialog_embargodate').datepicker({ minDate: "-20Y", maxDate: "+20Y" });
	},

	metadata: function () {
		var data = {
			upload_type: $('#zendialog_uploadtype option:selected').val(),
			publication_type: $('#zendialog_publicationtype option:selected').val(),
			image_type: $('#zendialog_imagetype option:selected').val(),
			publication_date: $('#zendialog_publicationdate').val(),
			title: $('#zendialog_title').val(),
			creators: $('#zendialog_creators').val().split(','),
			description: $('#zendialog_description').val(),
			access_right: $('#zendialog_accessright option:selected').val(),
			embargo_date: $('#zendialog_embargodate').val(),
			access_conditions: $('#zendialog_accessconditions').val(),
			license: $('#zendialog_license option:selected').val(),
			doi: false,
			prereserve_doi: false
		}

		return data;
	}

};