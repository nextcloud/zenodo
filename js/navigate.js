$(document).ready(function () {

	var zenodoActions = {

		init: function () {

			// add a div to the <body>
			if (!$('#zenodo_dialog').length)
				$('body').append('<div id="zenodo_dialog" title="Zenodo"></div>');

			OCA.Files.fileActions.registerAction({
				name: 'zenodo',
				displayName: t('zenodo', 'Zenodo'),
				mime: 'all',
				permissions: OC.PERMISSION_READ,
				type: OCA.Files.FileActions.TYPE_DROPDOWN,
				iconClass: 'icon-zenodo',
				actionHandler: function (filename, context) {
					zenodoActions.showPopup(filename, context);
				}
			});


		},

		showPopup: function (filename, context) {

			if ($('#zenodo_dialog_buttons').length)
				$('#zenodo_dialog_buttons').remove();

			$.get(OC.filePath('zenodo', 'ajax',
				'getZenodoDialog.php'), {}, zenodoActions.fillPopup);

			$('#zenodo_dialog').attr('title', 'Zenodo - ' + filename);
			$('#zenodo_dialog').dialog();
			$('#zenodo_dialog').parent().css('width', '600px').css('height', '400px');

			$('#zenodo_dialog').parent().css('box-shadow', '0px 0px 0px #5151514D');
			$('#zenodo_dialog').parent().css('moz-box-shadow', '0px 0px 0px #5151514D');
			$('#zenodo_dialog').parent().css('-webkit-box-shadow', '0px 0px 0px #5151514D');

			// uncomment this line if you want to remove the shadow animation
			// $('#zenodo_dialog').parent().addClass('zenodo_dialog_shadow');
		},

		fillPopup: function (response) {
			$('#zenodo_dialog').html(response);


			setTimeout(function () {
				$('#zenodo_dialog').parent().append('<div id="zenodo_dialog_buttons"></div>');
				$('#zenodo_dialog_buttons').hide();
				$('#zenodo_dialog_buttons').append(
					'<div id="zenodo_dialog_close" class="zenodo_dialog_button">Close</div>').append(
					'<div id="zenodo_dialog_send" class="zenodo_dialog_button">Send</div>').fadeIn(
					400);

				$('#zenodo_dialog_close').on('mousedown', function () {
					$('#zenodo_dialog').dialog('close');
				});
				$('#zenodo_dialog').parent().animate(
					{boxShadow: "3px 3px 5px rgba(81, 81, 81, 0.40)"});

			}, 1000);
		}


	};

	zenodoActions.init();
});
//
//function zenodo_send(metadata) {
//  // var dir = context.dir || context.fileList.getCurrentDirectory();
//  $.ajax(OC.linkTo('zenodo', 'ajax/send.php'), {
//    type : 'POST',
//    data : {
//      // filename: filename,
//      // dir: dir,
//      metadata : metadata
//    },
//    dataType : 'json',
//    success : function(s) {
//      alert(JSON.stringify(s));
//
//    },
//    error : function(s) {
//      alert('Error: ' + JSON.stringify(s));
//    }
//  });
//}
//
//function buildmetadata() {
//  var metadata = new Array();
//  metadata['upload_type'] = document.getElementById("uploadtype").options[document
//      .getElementById("uploadtype").selectedIndex].text;
//  metadata['publication_type'] = document.getElementById("publicationtype").options[document
//      .getElementById("publicationtype").selectedIndex].text;
//  metadata['image_type'] = document.getElementById("imagetype").options[document
//      .getElementById("imagetype").selectedIndex].text;
//  metadata['publication_date'] = document.getElementById("publicationdate").value;
//  metadata['title'] = document.getElementById("title").value;
//  metadata['creators'] = document.getElementById("creators").value; // FIXME:
//  // parse
//  // comma-separated
//  // into
//  // Array
//  metadata['description'] = document.getElementById("description").value;
//  metadata['access_right'] = document.getElementById("accessright").options[document
//      .getElementById("accessright").selectedIndex].text;
//  metadata['license'] = document.getElementById("license").options[document
//      .getElementById("license").selectedIndex].text;
//  metadata['embargo_date'] = document.getElementById("embargodate").value;
//  metadata['access_conditions'] = document.getElementById("accessconditions").value;
//  metadata['doi'] = "false";
//  metadata['prereserve_doi'] = "false";
//
//  // fields not required, postponed
//  /*
//   * metadata['keywords'] = new Array("key1","key2"); metadata['notes'] =
//   * "value12"; metadata['related_identifiers'] = new Array("id1","id2");
//   * metadata['contributors'] = new Array("cont1","cont2");
//   * metadata['references'] = new Array("ref1","ref2");
//   * metadata['communities'] = new Array("com1","com2"); metadata['grants'] =
//   * new Array("grant1","grant2"); metadata['journal_title'] = "value13";
//   * metadata['journal_volume'] = "value14"; metadata['journal_issue'] =
//   * "value15"; metadata['journal_pages'] = "value16";
//   * metadata['conference_title'] = "value17"; metadata['conference_acronym'] =
//   * "value18"; metadata['conference_dates'] = "value19";
//   * metadata['conference_place'] = "value20"; metadata['conference_url'] =
//   * "value21"; metadata['conference_session'] = "value22";
//   * metadata['conference_session_part'] = "value23";
//   * metadata['imprint_publisher'] = "value24"; metadata['imprint_isbn'] =
//   * "value25"; metadata['imprint_place'] = "value26";
//   * metadata['partof_title'] = "value27"; metadata['partof_pages'] =
//   * "value28"; metadata['thesis_supervisors'] = new Array("sup1","sup2");
//   * metadata['thesis_university'] = "value29"; metadata['subjects'] = new
//   * Array("sub1","sub2");
//   */
//  return metadata;
//}
//
//function publish() {
//  zenodo_send(buildmetadata());
//}
//
//$(document)
//    .ready(
//        function() {
//          if (typeof FileActions !== 'undefined') {
//            // Register our function with ownCloud - files, not
//            // folders
//            FileActions
//                .register(
//                    'file',
//                    t('zenodo', 'Zenodo'),
//                    OC.PERMISSION_READ,
//                    OC.imagePath('zenodo', 'zenodo_z'),
//                    function(filename, context) {
//                      // if (scanFiles.scanning) {
//                      // return;
//                      // }
//                      if ($('#dropdown').length == 0) {
//                        var tr = FileList
//                            .findFileEl(filename);
//                        var itemSource = $(tr).data(
//                            'id');
//                        var html = '<div id="dropdown" class="drop" data-item-type="file"
// data-item-source="'  + itemSource  + '">'  + '<form action="JavaScript:publish()"
// id="zenodoform"> <b>Upload type:</b><br><select id="uploadtype">'  + '<option
// value="publication">Publication</option><option value="poster">Poster</option>'  + '<option
// value="presentation">Presentation</option><option value="dataset">Dataset</option>'  + '<option
// value="image">Image</option><option value="video">Video/Audio</option>'  + '<option
// value="software">Software</option></select>&nbsp;<select id="publicationtype">'  + '<option
// value="book">Book</option><option value="section">Section</option>'  + '<option
// value="conferencepaper">Conference paper</option><option value="article">Article</option>'  +
// '<option value="patent">Patent</option><option value="preprint">Preprint</option>'  + '<option
// value="report">Report</option><option value="softwaredocumentation">Software
// documentation</option>'  + '<option value="thesis">Thesis</option><option
// value="technicalnote">Technical note</option>'  + '<option value="workingpaper">Working
// paper</option><option value="other">Other</option></select>&nbsp;'  + '<select
// id="imagetype"><option value="figure">Figure</option><option value="plot">Plot</option>'  +
// '<option value="drawing">Drawing</option><option value="diagram">Diagram</option>'  + '<option
// value="photo">Photo</option><option value="other">Other</option></select>'  +
// '<br><b>Publication date:</b><br><input type="date" id="publicationdate"><br><b>Title:</b>'  +
// '<br><input type="text" id="title"><br><b>Creators:</b><br><input type="text"
// id="creators"><br><b>Description:</b>'  + '<br><input type="text" id="description"><br><b>Access
// right:</b> <select id="accessright">'  + '<option value="open">Open</option><option
// value="embargoed">Embargoed</option>'  + '<option value="restricted">Restricted</option><option
// value="closed">Closed</option></select>'  + '<b>License:</b> <select id="license"><option
// value="Open Access">Open Access</option>'  + '<option value="Creative Commons">Creative
// Commons</option></select>'  + '<br><b>Embargo date:</b><br><input type="date"
// id="embargodate"><br><b>Access Conditions:</b><br>'  + '<input type="text"
// id="accessconditions"><br><input type=submit value="Publish (sandbox)" id="sandbox_publish">'  +
// '<input type=submit value="Publish (production)" id="production_publish"
// disabled></div></form>';   $(html).appendTo(  $(tr).find(  'td.filename'));
// $(tr).addClass('mouseOver');  } else {  $("#dropdown").slideUp(200,  function() {
// $(this).remove();  });  $('tr')  .removeClass(  'mouseOver');  }  });  }   // Add action to top
// bar (visible when files are selected)  /*  * if(!$('.nav-sidebar li[data-id="sharing_in"]  *
// a.active').length && !$('.nav-sidebar li[data-id="trash"]  * a.active').length && (typeof
// OCA.Files !== 'undefined' &&  * OCA.Files.FileList.prototype.getGetParam('view')!='trashbin')){
// * $('#headerName .selectedActions').prepend( '<a  * class="zenodo btn btn-xs btn-default"
// id="zenodo"  * href=""><i class="icon icon-zenodo"></i>' + t('zenodo', '  * Publish') +
// '</a>&nbsp;'); }  */  });