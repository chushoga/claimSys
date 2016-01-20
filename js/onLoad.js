$(document).ready(function() {

	/* ******************************************************
	** DIALOG BOXES **
	** for popup boxes
	****************************************************** */
	$(function() {
		var dialogNewClaim;
		var dialogListRecords;
		var dialogUsers;
		var dialogEditFiles;
		var dialogTableView;
		var dialogDownloadOptions;
		var dialogMasterOptions;

		dialogNewClaim = $("#dialogNewClaim").dialog({
			autoOpen: false,
			modal: true
		});
		dialogListRecords = $("#dialogListRecords").dialog({
			autoOpen: false,
			modal: true,
			height: 400
		});
		dialogUsers = $("#dialogUsers").dialog({
			autoOpen: false,
			modal: true,
			width: 330
		});
		dialogEditFiles = $("#dialogEditFiles").dialog({
			autoOpen: false,
			modal: true
		});
		dialogTableView = $("#dialogTableView").dialog({
			autoOpen: false,
			modal: true,
			width: 1200
		});
		dialogDownloadOptions = $("#dialogDownloadOptions").dialog({
			autoOpen: false,
			modal: true,
			height: 340
		});
		dialogMasterOptions = $("#dialogMasterOptions").dialog({
			autoOpen: false,
			modal: true,
			width: 340
		});



		// create new claim
		$("#addNewClaimBtn").click(function() {
			dialogNewClaim.dialog("open");
		});

		// list records
		$("#listRecordsBtn").click(function() {
			dialogListRecords.dialog("open");
		});

		// select users
		$("#dialogUsersBtn").click(function() {
			dialogUsers.dialog("open");
		});

		// open table view
		$("#dialogTableViewBtn").click(function() {
			dialogTableView.dialog("open");
		});

		// edit files dialogue box


		$(".dialogEditFilesBtn").click(function() {

			dialogEditFiles.dialog("open"); // open the dialog box

			// load files depending on block clicked
			var cid = $("#cidHidden").val();
			var rid = $(this).attr('data-editFileId');


			$.ajax({
				type: "post",
				url: "exe/process.php",
				data: "action=editFiles&cid=" + cid + "&rid=" + rid,
				success: function(data) {
					$("#dialogEditFiles").html(data);
				}
			});

		});

		// open table view
		$("#dialogMasterOptionsBtn").click(function() {
			dialogMasterOptions.dialog("open");
		});

		// save images to pdf
		$('#downloadBtn').click(function() {
				dialogDownloadOptions.dialog("open");

		});

	});

	/* ******************************************************
	** CHANGE TO UPPERCASE **
	** change maker name input to uppercase automatically
	** when making a new record and inputing name name
	****************************************************** */
	$('#makerName').keyup(function() {
		this.value = this.value.toUpperCase();
	});

	/* ******************************************************
	** [onClick] RELOAD PAGE **
	** on click reload the page (same as pressing the F5 key)
	****************************************************** */
	$('.refreshBtn').click(function() {
		location.reload();
	});

	/* ******************************************************
	** [onClick] ADD RECORD ROW BUTTON **
	** on click add a new row to the current record must and
	** reload the page to get input boxes
	****************************************************** */
	$('.addRecord').click(function() {
		addRecord();

		var cid = $("#cidHidden").val();
		$.ajax({
			type: "post",
			url: "exe/processAddRecordBlock.php",
			data: "cid=" + cid,
			success: function(data) {
				$("#infoBox").fadeIn(); // toggle message box
				$("#infoBox").text(""); // reset the text
				$("#infoBox").text("Item Added!!").delay(4000).fadeOut(); // add the info of from the title
			}
		});
	});

	// addRecord function start
	var counter = 1;

	function addRecord() {

		var obj = "<a href='' class='refreshBtn'> <span style='display: block; width: 100%; height: 75px; background-color: #CCC; text-align: center; font-size: 16px; line-height: 75px; border-top: 1px solid black;'>[ " + counter + " ] CLICK <i class='fa fa-refresh' style='font-size: 16px; color: #292929; background-color: white; padding: 4px; border-radius: 5px;'></i> or HERE to RELOAD to start editing record block </span></a>";

		$(".additionalRecords").append(obj);
		counter++;
	}
	// addRecord close

	/* ******************************************************
	** [onClick] DELETE RECORD mainBLOCK **
	** on click Delete record main record and folder with images
	** and files inside (remove CID)
	****************************************************** */
	$(document).on('click', "#removeCid", function() {
		var cid = $("#cidHidden").val();

		$('<div></div>').appendTo('body')
			.html('<div><h6 style="color: red;"><i class="fa fa-exclamation-triangle"></i> Delete this claim [ ' + cid + ' ] and all its images, records and files?</h6></div>')
			.dialog({
				modal: true,
				title: 'Delete Record Block',
				zIndex: 10000,
				autoOpen: true,
				width: 'auto',
				resizable: false,
				buttons: {
					Yes: function() {
						$(this).dialog("close");
						$(location).attr('href', 'exe/processRemoveRecord.php?cid=' + cid)
					},
					No: function() {
						$(this).dialog("close");
					}
				},
				close: function(event, ui) {
					$(this).remove();
				}
			});
	});

	/* ******************************************************
	** [onClick] DELETE RECORD sub-BLOCK **
	** on click Delete record sub-block and folder with images
	** and files inside (remove RID)
	****************************************************** */
	$(document).on('click', ".removeRecord", function() {
		var rid = this.id;
		var cid = $("#cidHidden").val();

		$('<div></div>').appendTo('body')
			.html('<div><h6 style="color: red;"><i class="fa fa-exclamation-triangle"></i> Delete block ID: ' + rid + ' and all its images and files?</h6></div>')
			.dialog({
				modal: true,
				title: 'Delete Record Block',
				zIndex: 10000,
				autoOpen: true,
				width: 'auto',
				resizable: false,
				buttons: {
					Yes: function() {
						// $(obj).removeAttr('onclick');
						// $(obj).parents('.Parent').remove();

						$(this).dialog("close");

						//var rid = $("#cidHidden").val();
						$.ajax({
							type: "post",
							url: "exe/processRemoveRecordBlock.php",
							data: "cid=" + cid + "&rid=" + rid,
							success: function(data) {
								$("#infoBox").fadeIn(); // toggle message box
								$("#infoBox").text(""); // reset the text
								$("#infoBox").text("Record block " + rid + " Removed!!").delay(4000).fadeOut(); // add the info of from the title
							}
						});
						$("#recId_" + rid).slideUp(300, function(){$("#recId_" + rid).remove(); });
						//$("#recId_" + rid).remove(); // remove the record block from view
					},
					No: function() {
						$(this).dialog("close");
					}
				},
				close: function(event, ui) {
					$(this).remove();
				}
			});

	});

	/* ******************************************************
	** [onInput type=text] NOT SAVED COLOR CHANGE **
	** on data input change, change the color to red
	** so that the user can tell if the record needs to be
	** or is saved.
	****************************************************** */
	$('[type=text]').on("input", function() {
		$('#recordHeaderTop').css("background", "red");
	});

	/* ******************************************************
	** [onChange .datepicker] NOT SAVED COLOR CHANGE **
	** on datepicker input change, change the color to red
	** so that the user can tell if the record needs to be
	** or is saved.
	****************************************************** */
	$( ".datepicker" ).change(function() {
	  $('#recordHeaderTop').css("background", "red");
	});

	/* ******************************************************
	** [onChange type=select] NOT SAVED COLOR CHANGE **
	** on data input change, change the color to red
	** so that the user can tell if the record needs to be
	** or is saved.
	****************************************************** */
	$('select').on("change", function() {
		$('#recordHeaderTop').css("background", "red");
	});

	/* ******************************************************
	** FANCYBOX LIGHTBOX GALLERY OPTIONS **
	** options to set up lightbox gallery
	****************************************************** */
	// Fancybox lightbox gallery
	$(".fancybox").fancybox({
		prevEffect: 'none',
		nextEffect: 'none',
		closeBtn: false,
		helpers: {
			title: {
				type: 'inside'
			}
		}
	});

	/* ******************************************************
	** TOOLTIPS **
	** view tooltips on hover in the #messageBox (large BTN)
	****************************************************** */
	$(".btnLarge").hover(function() {
		$("#messageBox").toggle(); // toggle message box
		$("#messageBox").text(""); // reset the text
		$("#messageBox").text($(this).attr('data-tooltip')); // add the info of from the title
	});

	/* ******************************************************
	** TOOLTIPS **
	** view tooltips on hover in the #messageBox (small BTN)
	****************************************************** */
	$(".btnSmall").hover(function() {
		$("#messageBox").toggle(); // toggle message box
		$("#messageBox").text(""); // reset the text
		$("#messageBox").text($(this).attr('data-tooltip')); // add the info of from the title
	});

	/* ******************************************************
	** ToolTips **
	** view tooltips on hover in the #messageBox (small BTN)
	****************************************************** */
	$(".ttips").hover(function() {
		$("#messageBox").toggle(); // toggle message box
		$("#messageBox").text(""); // reset the text
		$("#messageBox").text($(this).attr('data-tooltip')); // add the info of from the title
	});


	/* ******************************************************
	** SCROLLBAR **
	** scrollbar initalization set theme here
	****************************************************** */
	$(".customScrollbar").mCustomScrollbar({
		theme: "dark-thin"
	});

	/* ******************************************************
	** LOADING SCREEN **
	** set the loading screen delay and fadeout
	****************************************************** */
	$('#loading').delay(300).fadeOut(300);

	/* ******************************************************
	** DEFAULT SAVE KEY PREVENTION **
	** Prevent default save button from triggering
	****************************************************** */
	$(document).bind('keydown', function(e) {
		if (e.ctrlKey && (e.which == 83)) {
			e.preventDefault();
			//alert('Ctrl+S');
			return false;
		}
	});

	/* ******************************************************
	** CHOOSE USER **
	** Choose or change the user from the list
	** Keeps the choice in cache for next time.
	** Changes made during the session are marked change-by
	** the current user.
	****************************************************** */
	// Choose User start
	$(".userNameChoice").click(function() {
		var userName = $(this).attr('data-tooltip');

		// Check browser support
		if (typeof(Storage) !== "undefined") {
			// Store
			localStorage.setItem("userName", userName);
			// Retrieve
			//alert(localStorage.getItem("userName"));

			// SET #userNameShow
			var userNameShow = function() {
				$('#userNameShow').text(localStorage.getItem("userName"));
			}

			userNameShow();

			// remove Window
			$("#dialogUsers").dialog('close');
		} else {
			document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
		}

	});

	// check if user is set or not
	// Check browser support
	var startUserCheck = function() {
		var dialogUsers = $("#dialogUsers").dialog({
			autoOpen: false,
			modal: true
		});

		if (typeof(Storage) !== "undefined") {

			if (localStorage.getItem("userName") == null) {
				dialogUsers.dialog("open");
			} else {
				//alert(localStorage.getItem("userName"));
			}
		} else {
			document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
		}
	}

	// logout
	$("#logout").click(function() {
		localStorage.removeItem("userName");

		// remove Window
		$("#dialogUsers").dialog('close');

		$(location).attr('href', 'index.php');
	});

	// calculate total value
	var calculateTotalValue = function() {
		var totalSum = 0;

		$('.price').each(function() {
			totalSum += Number($(this).val());
		});

		$('#totalPrice').text(totalSum.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	}

	// update the user name display in the top right header
	var updateUserName = function() {
		if (localStorage.getItem("userName") == null) {
			$('#userNameShow').text("LOGIN!!");
		} else {
			$('#userNameShow').text(localStorage.getItem("userName"));
		}

		calculateTotalValue(); // calcualte total value
	}

	startUserCheck();
	updateUserName();
	// Choose User close

	/* ******************************************************
	** UPDATE TOTAL PRICE **
	** update the total price on .price change
	****************************************************** */
	$('.price').bind("change keyup keydown paste", function() {
		calculateTotalValue();
	});

	/* ******************************************************
	** DATEPICKER SETTINGS **
	** set the loading screen delay and fadeout
	****************************************************** */
	$(function() {
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});

});
				