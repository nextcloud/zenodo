$(document).ready(
		function() {

			var zenodoSettings = {

				init : function() {
					zenodoSettings.getInfo();
				},

				getInfo : function() {
					$.post(OC.filePath('zenodo', 'ajax/settings',
							'getZenodoInfo.php'), {}, zenodoSettings.display);
				},

				submit : function() {
					var data = {
						token_sandbox : $('#sandboxtoken').val(),
						token_production : $('#productiontoken').val(),
					}
					$.post(OC.filePath('zenodo', 'ajax/settings',
							'setZenodoInfo.php'), data, zenodoSettings.display)
				},

				display : function(response) {
					if (response == null)
						return;
					$('#sandboxtoken').val(response.tokenSandbox)
					$('#productiontoken').val(response.tokenProduction)
				}

			};

			$('#tokensubmit').mousedown(function() {
				zenodoSettings.submit();
			});

			zenodoSettings.init();
		});
