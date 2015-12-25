<?php require_once '/master/head.php';?>
	<!DOCTYPE HTML>
	<html lang="jp">

	<head>

		<?php include_once '/master/metaTags.php'; ?>

			<title>
				<?php echo $title;?>
			</title>
			<?php
include_once '/master/config.php'; ?>
				<script type="text/javascript">
					$(document).ready(function() {

						// dialogue boxes

						$(function() {
							var dialogNewClaim;
							var dialogListRecords;
							var dialogUsers;
							var dialogEditFiles;

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
								modal: true
							});
							dialogEditFiles = $("#dialogEditFiles").dialog({
								autoOpen: false,
								modal: true
							});

							$("#addNewClaimBtn").click(function() {
								dialogNewClaim.dialog("open");
							}); // create new claim
							$("#listRecordsBtn").click(function() {
								dialogListRecords.dialog("open");
							}); // list records
							$("#dialogUsersBtn").click(function() {
								dialogUsers.dialog("open");
							}); // select users

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
						});

						// save images to pdf
						$('#downloadPdfBtn').click(function() {
							alert("SAVE FUNCTION");
						});

						//change input to uppercase
						$('#makerName').keyup(function() {
							this.value = this.value.toUpperCase();
						});

						// ---------------

						// reload page button
						$('.refreshBtn').click(function() {
							location.reload();
						});

						//BUTTON CLICK CODE
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

						var counter = 1;

						function addRecord() {

							var obj = "<a href='' class='refreshBtn'> <span style='display: block; width: 100%; height: 75px; background-color: #CCC; text-align: center; font-size: 16px; line-height: 75px; border-top: 1px solid black;'>[ " + counter + " ] CLICK <i class='fa fa-refresh' style='font-size: 16px; color: #292929; background-color: white; padding: 4px; border-radius: 5px;'></i> or HERE to RELOAD to start editing record block </span></a>";

							$(".additionalRecords").append(obj);
							counter++;
						}

						// ----------------------------------------------------------------------------------------------------------------
						// Delete record block and folder with images and files inside
						// ----------------------------------------------------------------------------------------------------------------

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

											$("#recId_" + rid).remove(); // remove the record block from view
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

						// ----------------------------------------------------------------------------------------------------------------

						// ----------------------------------------------------------------------------------------------------------------
						// Delete record and folder with images and files inside
						// ----------------------------------------------------------------------------------------------------------------

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

						// ----------------------------------------------------------------------------------------------------------------

						// change color if not saved
						$('[type=text]').on("input", function() {
							$('#recordHeaderTop').css("background", "red");
						});
						$('select').on("change", function() {
							$('#recordHeaderTop').css("background", "red");
						});


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

						// Button tooltip
						$(".btnLarge").hover(function() {
							$("#messageBox").toggle(); // toggle message box
							$("#messageBox").text(""); // reset the text
							$("#messageBox").text($(this).attr('data-tooltip')); // add the info of from the title
						});

						// scrollbar initalization
						$(".customScrollbar").mCustomScrollbar({
							theme: "dark-thin"
						});

						// loading screen
						$('#loading').delay(300).fadeOut(300);

						// keyboard shortcuts
						/*
						$.key('ctrl+s', function(){
							$("#messageBox").toggle(); // toggle message box
							$("#messageBox").text(""); // reset the text
							$("#messageBox").text("SAVED!!"); // add the info of from the title
						});
						*/

						// prevent save button from opening dialogue box in chrome
						$(document).bind('keydown', function(e) {
							if (e.ctrlKey && (e.which == 83)) {
								e.preventDefault();
								//alert('Ctrl+S');
								return false;
							}
						});

						// Choose User
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

								// Close Window
								$("#dialogUsers").dialog('close');
							} else {
								document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
							}

						});
						// check if user is set or not
						// Check browser support
						var start = function() {
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

							// Close Window
							$("#dialogUsers").dialog('close');

							$(location).attr('href', 'index.php');
						});

						// calculate total value
						var calculateTotalValue = function() {
							var totalSum = 0;

							$('.price').each(function() {
								totalSum += Number($(this).val());
							});

							$('#totalPrice').text(totalSum);

						}

						$('.price').bind("change keyup keydown paste", function() {
							calculateTotalValue();
						});


						// update the user name display in the top right header
						var update = function() {
							if (localStorage.getItem("userName") == null) {
								$('#userNameShow').text("LOGIN!!");
							} else {
								$('#userNameShow').text(localStorage.getItem("userName"));
							}

							calculateTotalValue(); // calcualte total value
						}

						start();
						update();
						
										
					});
				</script>


	</head>

	<body>
		<div id='wrapper'>
			<?php require_once '/header.php';?>

				<!-- LOADING BLOCK -->
				<div id='loading'>
					<div id='loadingInner'>
						<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
					</div>
				</div>
				<!-- ------------- -->

				<div class='contents'>
					<!-- PAGE CONTENTS START HERE -->
					<div class='preview-pane'></div>
					<?php 
			/* VARIABLES HERE */
			if(isset($_GET['cid'])){
				//$currentRecordId = $_GET['cid'];
				$recMasterId = $_GET['cid'];
				echo "<input id='cidHidden' value='$recMasterId'>";
			} else {
				//$currentRecordId = "";
				$recMasterId = "";
				echo "<input id='cidHidden' value=''>";
			}
			
		
			?>

						<div id='outterBox'>

							<div id='mainWindow'>
								<!-- NAVI -->
								<div id='mainWindowNavi'>
									<!-- message Box -->
									<div id='messageBox' style='display: none;'></div>
									<div id='infoBox' style='display: none;'></div>

									<span style='display: block; float: left;'>
							<!--
							<button class='btn btnLarge btnCol01 btnSave'>
								<i class="fa fa-pie-chart"></i>
							</button>
-->	
							<a href='#' id='addNewClaimBtn' class='btnLarge' style='float: left;' data-tooltip='Add New Claim'>
								<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-pencil fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
									</a>
									<a href='#' id='listRecordsBtn' class='btnLarge' style='float: left;' data-tooltip='Choose Record'>
										<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-folder-open fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
									</a>


									</span>
									<?php 
							if($recMasterId == ""){
							} else {
							echo "<span style='display: block; float: left;'>
								
								<a href='#' id='refreshBtn' class='refreshBtn btnLarge' style='float: left;' data-tooltip='Refresh'>
									<span class='btn fa-stack fa-lg' style=''>
										<i class='fa fa-square fa-stack-2x'></i>
										<i class='fa fa-refresh fa-stack-1x fa-inverse btnLargeText'></i>
									</span>
								</a>
								
								<a href='#' id='saveBtn' class='btnLarge' style='float: left;' data-tooltip='Save Record (ctrl+s)'>
									<span class='btn fa-stack fa-lg' style=''>
										<i class='fa fa-square fa-stack-2x'></i>
										<i class='fa fa-save fa-stack-1x fa-inverse btnLargeText' style=''></i>
									</span>
								</a>
						
								<a href='#' class='btnLarge addRecord' style='float: left;' data-tooltip='Add Item'>
									<span class='btn fa-stack fa-lg' style=''>
										<i class='fa fa-square fa-stack-2x'></i>
										<i class='fa fa-plus fa-stack-1x fa-inverse btnLargeText' style=''></i>
									</span>
								</a>
								";
						
						echo "</span>";
								}
						?>
										<span style='display: block; float: right; margin-right: 5px;'>
							
							<!-- SEARCH -->
							<a href='#' class='btnLarge' style='float: left;' data-tooltip='Search'>
								<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-search fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>

										<!-- STATS -->
										<a href='#' class='btnLarge' style='float: left;' data-tooltip='View Stats'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-pie-chart fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>

										<!-- DOWNLOAD -->
										<a href='#' id='downloadPdfBtn' class='btnLarge' style='float: left;' data-tooltip='Download PDF, EXEL, PRINT'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-cloud-download fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>

										<!-- SETTINGS -->
										<a href='#' class='btnLarge' style='float: left;' data-tooltip='Settings'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-wrench fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>

										<!-- USERS -->
										<a href='#' id='dialogUsersBtn' class='btnLarge' style='float: left;' data-tooltip='Select Users'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-users fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>
										</span>

								</div>

								<?php 
					
						
						if($recMasterId == ""){
							echo "<div id='recordHeaderTop' style='text-align: center;'>CLICK ";
							echo "<i class='fa fa-folder-open' style='font-size: 16px; color: #292929; background-color: white; padding: 4px; border-radius: 18px;'></i>";
							echo " TO CHOOSE A RECORD<span id='userNameShow' style='float: right; margin-right: 10px;'></span>";
							
						} else {
							
							// QUERY THE MAIN BODY RECORD
							$resultMaster = mysql_query("SELECT * FROM `recordMaster` WHERE `id` = '$recMasterId'");
							while($rowMaster = mysql_fetch_assoc($resultMaster)){
								$recMasterMakerName = $rowMaster['makerName'];
								$recMasterDate = $rowMaster['date'];
								$recMasterEditedBy = $rowMaster['editedBy'];
								$modified = $rowMaster['date'];
							}
							
							echo "<div id='recordHeaderTop' style=''><span style='margin-left: 5px;'>TAIYO KANAMONO JAPAN [ $recMasterMakerName ] $recMasterDate PENDING... <i class='fa fa-hourglass-half' style=''></i></span><span id='userNameShow' style='float: right; margin-right: 10px;'></span></div>";

							echo "<div id='mainWindowBody' class='customScrollbar'>";
							//echo "<form>";
							
							// TOTAL VALUE
							$totValue = 0;
							$acceptedValue = 0;
							$rejectedValue = 0;
							$pendingValue = 0;
							
							$resultMain = mysql_query("SELECT * FROM `records` WHERE `id_recordMaster` = '$recMasterId'");
							while($rowMain = mysql_fetch_assoc($resultMain)){
								//set variables for the blocks here.
								$records_id = $rowMain['id'];
								$records_id_recordMaster = $rowMain['id_recordMaster'];
								$records_id_dmg = $rowMain['id_dmg'];
								$records_modelNo = $rowMain['modelNo'];
								$records_tformNo = $rowMain['tformNo'];
								$records_orderNo = $rowMain['orderNo'];
								$records_spec = $rowMain['spec'];
								$records_invoiceNo = $rowMain['invoiceNo'];
								$records_invoiceDate = $rowMain['invoiceDate'];
								$records_invoiceGntNo = $rowMain['invoiceGntNo'];
								$records_invoiceCurrency = $rowMain['currency'];
								$records_invoiceValue = $rowMain['invoiceValue'];
								$records_damageType = $rowMain['damageType'];
								$records_damageSize = $rowMain['damageSize'];
								$records_damageMemo_EN = $rowMain['damageMemoEn'];
								$records_damageMemo_JP = $rowMain['damageMemoJp'];
								$records_flgPending = $rowMain['flgPending'];
								
								$pending = ""; // pending, accepted, rejected, photo requested
								
								switch($records_flgPending){
									case 0:
										$pending = "pending";
										$pendingValue += $records_invoiceValue;
										break;
									case 1:
										$pending = "accepted";
										$acceptedValue += $records_invoiceValue;
										break;
									case 2:
										$pending = "rejected";
										$rejectedValue += $records_invoiceValue;
										break;
									case 3:
										$pending = "image requested";
										$pendingValue += $records_invoiceValue;
										break;
									default:
										$pending = "";
										break;
								}
								
								// *************************************************************************************************************
								echo "<input type='hidden' name='recordBlockId_$records_id' id='recordBlockId_$records_id' value='$records_id'>";
								// *************************************************************************************************************
								
								?>
									<script type="text/javascript">
											
										// get data from database
										// WORK ON GETTING THIS WORKING WITH THE IMAGES BEING UPDATED AFTER UPLOAD!!

										function refreshImageBlock_<?php echo $records_id; ?>() {

											var recordBlockId = "<?php echo $records_id;?>";
											var cid = "&cid=" + <?php echo $recMasterId;?>;

											$.ajax({
												type: "post",
												url: "exe/process.php",
												data: "action=refreshImageBlock" + "&recordBlockId=" + recordBlockId + cid,
												success: function(data) {
													$("#recordImages_" + <?php echo $records_id; ?>).html(data);
													//alert("error");
												},
												error: function(err) {
													alert("error");
												}
											});
										}

										function refreshFilesBlock_<?php echo $records_id; ?>() {

											var recordBlockId = "<?php echo $records_id;?>";
											var cid = "&cid=" + <?php echo $recMasterId;?>;

											$.ajax({
												type: "post",
												url: "exe/process.php",
												data: "action=refreshFilesBlock" + "&recordBlockId=" + recordBlockId + cid,
												success: function(data) {
													$("#recordFiles_" + <?php echo $records_id; ?>).html(data);
												},
												error: function(err) {
													alert("error");
												}
											});

										}


										//showComment();

										// send data to database

										//$('[type=text]').change(function(){

										var saveMe_<?php echo $records_id; ?> = function() {

											var recordBlockId = "<?php echo $records_id;?>";
											var dropzoneId = "#dropzone_" + recordBlockId


											var damageId = "damageId_" + recordBlockId + "=" + $("#damageId_" + recordBlockId).val();
											var modelNo = "&modelNo_" + recordBlockId + "=" + $("#modelNo_" + recordBlockId).val();
											var tformNo = "&tformNo_" + recordBlockId + "=" + $("#tformNo_" + recordBlockId).val();
											var orderNo = "&orderNo_" + recordBlockId + "=" + $("#orderNo_" + recordBlockId).val();

											var spec = "&spec_" + recordBlockId + "=" + $("#spec_" + recordBlockId).val();
											var invoiceNo = "&invoiceNo_" + recordBlockId + "=" + $("#invoiceNo_" + recordBlockId).val();
											var invoiceDate = "&invoiceDate_" + recordBlockId + "=" + $("#invoiceDate_" + recordBlockId).val();
											var invoiceGntNo = "&invoiceGntNo_" + recordBlockId + "=" + $("#invoiceGntNo_" + recordBlockId).val();
											var currency = "&currency_" + recordBlockId + "=" + $("#currency_" + recordBlockId).val();
											var invoiceValue = "&invoiceValue_" + recordBlockId + "=" + $("#invoiceValue_" + recordBlockId).val();

											var damageType = "&damageType_" + recordBlockId + "=" + $("#damageType_" + recordBlockId).val();
											var damageSize = "&damageSize_" + recordBlockId + "=" + $("#damageSize_" + recordBlockId).val();
											var damageMemoEn = "&damageMemoEn_" + recordBlockId + "=" + $("#damageMemoEn_" + recordBlockId).val();
											var damageMemoJp = "&damageMemoJp_" + recordBlockId + "=" + $("#damageMemoJp_" + recordBlockId).val();
											var flgPending = "&flgPending_" + recordBlockId + "=" + $("#flgPending_" + recordBlockId).val();

											var editedBy = "&editedBy_" + recordBlockId + "=" + localStorage.getItem("userName");
											var cid = "&cid=" + <?php echo $recMasterId;?>;

											//alert ("damageId: " + damageId + " - " + "modelNo: " + modelNo + "recordBlockId: " + recordBlockId);

											$.ajax({
												type: "post",
												url: "exe/process.php",
												data: damageId + modelNo + tformNo + orderNo + spec + invoiceNo + invoiceDate + invoiceGntNo + currency + invoiceValue + damageType + damageSize + damageMemoEn + damageMemoJp + flgPending + editedBy + cid + "&action=addcomment" + "&recordBlockId=" + recordBlockId,
												success: function(data) {
													refreshImageBlock_<?php echo $records_id; ?>();
													refreshFilesBlock_<?php echo $records_id; ?>();
												}
											});

											// change saved color back to normal
											$('#recordHeaderTop').css("background", "green");

										}

										$("#saveBtn").click(function(){
											saveMe_<?php echo $records_id; ?>();
										}); // on click of the save button save the block

										// on save keybind of save button run the save me function
										$(document).bind('keydown', function(e) {
											if (e.ctrlKey && (e.which == 83)) {
												saveMe_<?php echo $records_id; ?>(); // run the save function
											}
										});

										Dropzone.options.myAwesomeDropzone<?php echo $records_id; ?> = {
											maxFiles: 50,
											accept: function(file, done) {
												console.log("uploaded");
												done();
											},
											init: function() {
												this.on("maxfilesexceeded", function(file) {
														alert("No more files please!");
													}),

													this.on("complete", function(file) {
														this.removeFile(file); // remove thumbnails after upload

														saveMe_<?php echo $records_id; ?>(); // run the save function

													});

											}
										};
									</script>
									<?php
								
								// *************************************************************************************************************
								
									echo "
									<div class='recordWrapper' id='recId_".$records_id."'>
										<div class='recordHeader'><span style='margin-left: 5px;'>[ $records_id ]PENDING...</span><span style='float: right; margin-right: 5px;'>
										<a href='#' class='removeRecord' id='$records_id'> DELETE <i class='fa fa-trash-o'></i></a>
										</span></div>
										
										<div id='recordImages_".$records_id."' class='recordImages customScrollbar'>";
								
								// GET ALL IMAGES IN DIRECTORY AND DISPLAY THEM
									$fileLoc = "recordFiles/".$recMasterId."/".$records_id."/";
									$filesImages = glob($fileLoc.'*.{JPG,jpg,jpeg,JPEG,png,gif}', GLOB_BRACE);
								
									foreach($filesImages as $file) {
									  echo "<a class='fancybox' rel='group_$records_id' href='$file' title='".substr($file, strrpos($file, '/') + 1)."'> <img src='$file' style='width: 100px; height: 100px; float: left;'></a>";
									}
								
								echo "</div>";
								
								echo "<div class='recordOtherFilesBox customScrollbar' style=''>";
								echo "<div style='width: 100%; height; 20px; background-color: skyblue;text-align: center; margin-bottom: 5px;'>PDF and other files
									
									<span class='editFileCog dialogEditFilesBtn' data-editFileId='$records_id' style=''>
										<i class='fa fa-cog'></i>
									</span>
								</div>";
								echo "<div id='recordFiles_".$records_id."'>";
								// GET ALL OTHER FILES (pdf,dxf etc) IN DIRECTORY AND DISPLAY THEM
								// PFD
									$filesPdf = glob($fileLoc.'*.{pdf,PDF}', GLOB_BRACE);

										foreach($filesPdf as $file) {
											echo "<a href='$file' style='text-align: center;'><i class='fa fa-file-pdf-o' style='color: crimson;'></i> ".substr($file, strrpos($file, '/') + 1)."</a><br>";
										}
								// EXCEL
									$filesExcel = glob($fileLoc.'*.{xlsx,xls,csv}', GLOB_BRACE);

										foreach($filesExcel as $file) {
											echo "<a href='$file' style='text-align: center;'><i class='fa fa-file-excel-o' style='color: green;'></i> ".substr($file, strrpos($file, '/') + 1)."</a><br>";
										}
								// CAD
									$filesCad = glob($fileLoc.'*.{dxf,dwg,obj,3ds}', GLOB_BRACE);

									foreach($filesCad as $file) {
										echo "<a href='$file' style='text-align: center;'><i class='fa fa-file' style='color: #0E9DEB;'></i> ".substr($file, strrpos($file, '/') + 1)."</a><br>";
									}
								// OTHER
									$filesOther = glob($fileLoc.'*.{ai,psd,eps,txt,doc,docx}', GLOB_BRACE);

									foreach($filesOther as $file) {
										echo "<a href='$file' style='text-align: center;'><i class='fa fa-file-o' style='color: grey;'></i> ".substr($file, strrpos($file, '/') + 1)."</a><br>";
									}
								echo "</div>";
								echo "</div>";
							
								echo "<div class='recordImagesUploadBox' style='width: 16.666665%; height: 100px; overflow: hidden; float: right; background: red;'>
										<form action='exe/processUploadFiles.php' class='dropzone' id='my-awesome-dropzone$records_id'>
											<input type='hidden' name='cid' value='$recMasterId'>
											<input type='hidden' name='rid' value='$records_id'>
										</form>
									</div>";
								
								
									echo "<div class='clear'></div>";
									echo "
										<div class='recordBody'>
											<div class='recordBodyBox'>
												<table>
													<tr>
														<th>DamageID:</th>
														<td><input type='text' id='damageId_$records_id' name='damageId_$records_id' value='$records_id_dmg'></td>
													</tr>
													<tr>
														<th>Model No.</th>
														<td><input type='text' id='modelNo_$records_id' name='modelNo_$records_id' value='$records_modelNo'></td>
													</tr>
													<tr>
														<th>Tform No.</th>
														<td><input type='text' id='tformNo_$records_id' value='$records_tformNo' name='tformNo_$records_id'></td>
													</tr>
													<tr>
														<th>Spec:</th>
														<td><input type='text' id='spec_$records_id' value='$records_spec' name='spec_$records_id'></td>
													</tr>
													<tr>
														<th>Order No.</th>
														<td><input type='text' id='orderNo_$records_id' value='$records_orderNo' name='orderNo_$records_id'></td>
													</tr>
												</table>
											</div>
											<div class='recordBodyBox'>
												<table>
													<tr>
														<th>Invoice No.</th>
														<td><input type='text' id='invoiceNo_$records_id'  value='$records_invoiceNo' name='invoiceNo_$records_id'></td>
													</tr>
													<tr>
														<th>Gaurentee No.</th>
														<td><input type='text' id='invoiceGntNo_$records_id' value='$records_invoiceGntNo' name='invoiceGntNo_$records_id'></td>
													</tr>
													<tr>
														<th>Invoice Date:</th>
														<td><input type='date' id='invoiceDate_$records_id' value='$records_invoiceDate' name='invoiceDate_$records_id'></td>
													</tr>
													<tr>
														<th>Invoice Currency:</th>
														<td>";
														//echo "<input type='text' id='currency_$records_id' value='$records_invoiceCurrency' name='currency_$records_id'>";
														
														
														echo "<select id='currency_$records_id' name='currency_$records_id'>";
														$currencyType = array('EUR','USD','YEN');
														foreach($currencyType as $key => $value){
															if($key == $records_invoiceCurrency){
																	echo "<option selected='selected' value='$key'>$value</option>";
																} else {
																	echo "<option value='$key'>$value</option>";
															}
														}
														echo "</select>";
														
														echo "</td>
													</tr>
													<tr>
														<th>Invoice Value:</th>
														<td><input type='text' id='invoiceValue_$records_id' class='price' value='$records_invoiceValue' name='invoiceValue_$records_id'></td>
													</tr>
												</table>
											</div>
											<div class='recordBodyBox'>
												<table>
													<tr>
														<th>Damage Type:</th>
														<td>";
														echo "<select id='damageType_$records_id' name='damageType_$records_id'>";
														$damageType = array('割れ','凸','凹み','仕上不良','違う所品','その他');
														foreach($damageType as $key => $value){
															if($key == $records_damageType){
																	echo "<option selected='selected' value='$key'>$value</option>";
																} else {
																	echo "<option value='$key'>$value</option>";
															}
														}
														echo "</select>";
																echo "
														</td>
													</tr>
													<tr>
														<th>Damage Size:</th>
														<td><input type='number' min='0' step='1' id='damageSize_$records_id' value='$records_damageSize' name='damageSize_$records_id'></td>
													</tr>
													<tr>
														<th>Damage memo EN:</th>
														<td><input type='text' id='damageMemoEn_$records_id' value='$records_damageMemo_EN' name='damageMemoEn_$records_id'></td>
													</tr>
													<tr>
														<th>Damage memo JP:</th>
														<td><input type='text' id='damageMemoJp_$records_id' value='$records_damageMemo_JP' name='damageMemoJp_$records_id'></td>
													</tr>
												
													<tr>
														<th>Status:</th>
														<td>";
														
														echo "<select id='flgPending_$records_id' name='flgPending_$records_id'>";
								
														$acceptedRejected = array('PENDING','ACCEPTED','REJECTED','IMAGE REQUESTED');
														foreach($acceptedRejected as $key => $value){
															if ($key == $records_flgPending){
																echo "<option selected='selected' value='$key'>$value</option>";
															} else {
																echo "<option value='$key'>$value</option>";
															}
														}
																
														echo "</select>
														</td>
													</tr>
												</table>
											</div>
											<div class='clear'></div>
										</div>
										<div class='recordSpacer'></div><!-- RECORD SPACER -->
									</div>
									";
									echo "";
									
								
								// *************************************************************************************************************
								
							}
							
							}
						
							?>

										<!-- ADD THE ADDITIONAL RECORDS HERE -->

										<div class='additionalRecords'></div>

										<!-- ******************************* -->
										<!--</form>-->
							</div>
							<!-- mainWindowBody END -->

							<div class='clear'></div>

							<div id='bottomInfoBar'>
								<?php
						
						if($recMasterId == ""){
							
						} else {
							echo "<a href='#' id='removeCid' class='btnSmall' style='display: block; float: left;'>
									<span class='btn fa-stack fa-lg' style='color: #BF2C2C'>
										<i class='fa fa-square fa-stack-2x'></i>
										<i class='fa fa-trash fa-stack-1x fa-inverse btnSmallText'></i>
									</span>
								</a>
								total [<span id='totalPrice'></span>] | accepted [€$acceptedValue] | rejected [€$rejectedValue] | totalpending [€$pendingValue] | LAST EDITED BY: $recMasterEditedBy ON: $modified 
							";
						}
						?>
							</div>
						</div>
				</div>

				<!-- DIALOGE BOXES START HERE -->

				<!-- NEW CLAIM -->
				<div id="dialogNewClaim" title="New Claim Creation" style='font-family: monospace; font-size: 13px;'>
					<form method='post' action='exe/addNewClaim.php'>
						<table id='addNewClaimPopup'>
							<tr>
								<th>
									MAKER NAME:
								</th>
								<td>
									<input type='text' name='makerName' placeholder='MakerNameHere' id='makerName'>
								</td>
							</tr>
							<tr>
								<th>
									DATE:
								</th>
								<td>
									<input type='date' name='date'>
								</td>
							</tr>
							<tr>
								<th colspan='2' style=''>
									<input type='submit' value='ADD NEW RECORD' style='font-family: monospace; padding-top: 5px; padding-bottom: 5px;'>
								</th>
							</tr>
						</table>
					</form>
				</div>

				<!-- LIST RECORDS -->
				<div id="dialogListRecords" class='customScrollbar' title="All Records List" style='font-family: monospace; font-size: 13px;'>
					<?php
						$conditionColor = "";
						$conditionIcon = "";
						$conditionText = "";
						$condition = "";
				
						$result = mysql_query("SELECT * FROM `recordmaster`");
						while($row = mysql_fetch_assoc($result)){
							$recId = $row['id'];
							$currentMakerName = $row['makerName'];
							$currentClaimDate = $row['date'];
							$condition = $row['status'];
							
							switch($condition){
								case "0":
									$conditionColor = "color: #EFF545;";
									$conditionIcon = "fa fa-hourglass-end";
									$conditionText = "PENDING...";
									break;
								case "1": 
									$conditionColor = "color: #04D61D;";
									$conditionIcon = "fa fa-check-square-o";
									$conditionText = "COMPLEATE";
									break;
								default:
									$conditionColor = "color: #CCCCCC;";
									$conditionIcon = "fa fa-question-circle";
									$conditionText = "UNKNOWN";
							}
							
							echo "
							<a href='index.php?cid=$recId'>
							<div class='recordBlock' style='overflow: hidden;'>
								<i class='$conditionIcon' style='$conditionColor'></i> 
								 $currentMakerName $currentClaimDate $conditionText
							</div>
							</a>
							";
							
						}
					?>
				</div>
				<!-- USERS -->
				<div id="dialogUsers" class='customScrollbar' title="Choose User" style='font-family: monospace; font-size: 13px;'>
					<?php
					echo "<div class='userBlock' style='overflow: hidden;'>";
					
					echo "
						<a href='#'>
							<div style='width: 50px; height: 50px; float: left; text-align: center;'>
							
							<a href='#' id='logout' class='btnSmall' data-tooltip='logout' >
								<span class='btn fa-stack fa-lg' >
									<i class='fa fa-square fa-stack-2x' ></i>
									<i class='fa fa-power-off fa-stack-1x fa-inverse btnSmallText' ></i>
								</span>
							</a>
							<br>
							LOGOUT
							</div>
						</a>
						";
					
					$result = mysql_query("SELECT * FROM `users`");
					while($row = mysql_fetch_assoc($result)){
						$userId = $row['id'];
						$userName = $row['userName'];
						
						echo "
						<a href='#'>
							<div style='width: 50px; height: 50px; float: left; text-align: center;'>
							
							<a href='#' id='' class='userNameChoice btnSmall' data-tooltip='$userName' >
								<span class='btn fa-stack fa-lg' >
									<i class='fa fa-square fa-stack-2x' ></i>
									<i class='fa fa-user fa-stack-1x fa-inverse btnSmallText' ></i>
								</span>
							</a>
							<br>
							$userName
							</div>
						</a>
						";

					}
					echo "<div class='clear'></div>";
					echo "</div>";
					?>
				</div>

				<!-- EDIT FILES -->
				<div id="dialogEditFiles" class='customScrollbar' title="Edit Files" style='font-family: monospace; font-size: 13px;'>
					<?php
					echo "<div class='editFilesBlock' style='overflow: hidden;'>";
					
					echo "test";
	
					
					echo "</div>";
					?>
				</div>

				<!-- DIALOGE BOXES END HERE -->

				<!-- PAGE CONTENTS END HERE -->
		</div>
		<?php require_once '/master/footer.php';?>
			<script>
			</script>
	</body>

	</html>