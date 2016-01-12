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
							var dialogTableView;
							var dialogDownloadOptions;

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
							
							// save images to pdf
							$('#downloadBtn').click(function() {
									dialogDownloadOptions.dialog("open");
								/*
									var doc = new jsPDF();
									doc.text(20, 20, 'Hello world!');
									doc.text(20, 30, 'This is client-side Javascript, pumping out a PDF.');
									doc.addPage();
									doc.text(20, 20, 'Do you like that?');

									doc.save('Test.pdf');
								*/
							});
							
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
										<a href='#' id='' class='btnLarge' style='float: left;' data-tooltip='View Stats'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-pie-chart fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>

										<!-- DOWNLOAD -->
										<a href='#' id='downloadBtn' class='btnLarge' style='float: left;' data-tooltip='Download PDF, EXEL, ZIP all'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-cloud-download fa-stack-1x fa-inverse btnLargeText"></i>
								</span>
										</a>

										<!-- TABLE VIEW -->
										<a href='#' id='dialogTableViewBtn' class='btnLarge' style='float: left;' data-tooltip='Settings'>
											<span class="btn fa-stack fa-lg" style=''>
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-table fa-stack-1x fa-inverse btnLargeText"></i>
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
								$modified = $rowMaster['modified'];
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
								
									echo "
									<div class='recordWrapper' id='recId_".$records_id."'>
										<div class='recordHeader'><span style='margin-left: 5px;'>[ $records_id ]PENDING...</span>
										
											<span style='float: right; margin-right: 5px;'>
												<a href='#' class='removeRecord' id='$records_id'> DELETE <i class='fa fa-trash-o'></i></a>
											</span>
											
											<span style='float: right; margin-right: 10px;'>
												<a href='#' class='pdfDownload' id='downloadPdfBtn$records_id'>PDF <i class='fa fa-save'></i></a> | 
											</span>
											
										</div>
										
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
														<th>Damage Size (mm):</th>
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
									// JAVASCRIPT
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
									
									/*
									
									$('#downloadPdfBtn111<?php echo $records_id; ?>').click(function() {
										
										// Because of security restrictions, getImageFromUrl will
										// not load images from other domains.  Chrome has added
										// security restrictions that prevent it from loading images
										// when running local files.  Run with: chromium --allow-file-access-from-files --allow-file-access
										// to temporarily get around this issue.
										var getImageFromUrl = function(url, callback) {


											var img = new Image, data, ret={data: null, pending: true};

											img.onError = function() {
												throw new Error('Cannot load image: "'+url+'"');
											}
											img.onload = function() {
												var canvas = document.createElement('canvas');
												document.body.appendChild(canvas);
												canvas.width = img.width;
												canvas.height = img.height;

												var ctx = canvas.getContext('2d');
												ctx.drawImage(img, 0, 0);
												// Grab the image as a jpeg encoded in base64, but only the data
												data = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
												// Convert the data to binary form
												data = atob(data)
												document.body.removeChild(canvas);

												ret['data'] = data;
												ret['pending'] = false;
												if (typeof callback === 'function') {
													callback(data);
												}
											}
											img.src = url;

											return ret;
										}

										// Since images are loaded asyncronously, we must wait to create
										// the pdf until we actually have the image data.
										// If we already had the jpeg image binary data loaded into
										// a string, we create the pdf without delay.
										var createPDF = function(imgData) {
											
											var recordBlockId = "<?php echo $records_id;?>";

											var damageId = "<?php echo $records_id_dmg;?>";
											var modelNo = "<?php echo $records_modelNo;?>";
											var headerMemo = damageId + " [ " + modelNo + " ]";

											var imgWidth = 450;
											var imgHeight = 338.8235294117647;
											
											var img1X = 60;
											var img1Y = 50;
											
											var img2X = 60;
											var img2Y = 100+imgHeight;

											var doc = new jsPDF("p", "pt", "a4");

											doc.text(180, 30, headerMemo); // add the header title

											doc.addImage(imgData, 'JPEG', img1X, img1Y, imgWidth, imgHeight); // first image

											doc.addImage(imgData, 'JPEG', img2X, img2Y, imgWidth, imgHeight); // second image
											//doc.addImage(imgData, 'JPEG', 70, 10, 100, 120);
											
											doc.addPage();
											doc.text(180, 30, headerMemo);
											doc.text(30, 60, 'Do you like that?');
											
											
											// Output as Data URI
											doc.output('datauri');

										}

										getImageFromUrl('recordFiles/20/507/IMG_1623.jpg', createPDF);
										getImageFromUrl('recordFiles/20/507/IMG_1624.jpg', createPDF);
									});
									*/

									// -------------------------------------------------------------------------------
									
									/*
									// save images to pdf
										$('#downloadPdfBtn1111<?php echo $records_id; ?>').click(function() {
											
											var recordBlockId = "<?php echo $records_id;?>";
											var cid = "&cid=" + <?php echo $recMasterId;?>;
											
											var damageId = "<?php echo $records_id_dmg;?>";
											var modelNo = "<?php echo $records_modelNo;?>";
											//var tformNo = "<?php echo $records_tformNo;?>";
											
											var headerMemo = damageId + " [ " + modelNo + " ]";

												var doc = new jsPDF();
											
												doc.text(70, 15, headerMemo);
												doc.addPage();
												doc.text(20, 20, headerMemo);
												doc.text(30, 30, 'Do you like that?');

												doc.save(recordBlockId+'.pdf');
	
										});
										*/
								// *************************************************************************************************************
									
									
									$('#downloadPdfBtn<?php echo $records_id; ?>').click(function() {
										
										
										var recordBlockId = "<?php echo $records_id;?>";
										var cid = <?php echo $recMasterId;?>;

										var damageId = "<?php echo $records_id_dmg;?>";
										if (damageId == "" || damageId == " "){
											damageId = "unknown";
										}
										var modelNo = "<?php echo $records_modelNo;?>";
										var headerMemo = damageId + " [ " + modelNo + " ]";
										
										var canvas;
										
										var markers = []; // image data
										var markersCounter = 0;
										
										var sources = {};
										
										var baseImage = 'img/base.jpg';
										
										sources['base_image'] = baseImage;
										<?php
								
											$fileLoc = 'recordFiles/'.$recMasterId.'/'.$records_id.'/';
											$filesImages = glob($fileLoc.'*.{JPG,jpg,jpeg,JPEG,png,gif}', GLOB_BRACE);
											
											foreach($filesImages as $file => $value) {
										 ?>
											var k = "<?php echo $file; ?>";
											var value = "<?php echo $value;?>";
											
										markers[k] = "";
										markersCounter++;
										
											sources['customkey'+k] = value;
											//console.log(k + " | " + value );
											
										<?php
											}
										?>
										//console.warn(markers[2]);
										//console.log(sources);
										
										/*
										var sources = {
											
											cloud_Image: 'recordFiles/20/548/IMG_1813.jpg',
											cloud_Image2: 'recordFiles/20/548/IMG_1816.jpg',
											database_Image:'recordFiles/20/548/IMG_1814.jpg',
											base_image: 'img/base.jpg'
										};
										*/
										

										function loadImages(sources, callback) {
												
											var images = {};
											var loadedImages = 0;
											var numImages = 0;
											// get num of sources
											for(var src in sources) {
												numImages++;
											}
											for(var src in sources) {
												images[src] = new Image();
												images[src].onload = function() {
													if(++loadedImages >= numImages) {
														callback(images);
													}
												};
												images[src].src = sources[src];
											}
											
										}

										function savePDF(){
											
											function ratio(w, maxW){
												var rat = "";
												var w, h;
																								
												rat = maxW / w;
												return rat;
											}
											
											
											// set the default value for the image data named here makers[]
											for (k = 0; k < markersCounter; k++){
												markers[k] = "";
											}
										
																					
											//load all the images first, then combine them in the callback
											loadImages(sources, function(images) {
												
												//create a canvas
												canvas = document.createElement('canvas');
												document.body.appendChild(canvas);
												canvas.width = 1260;
												canvas.height = 1782;
												
												var maxWidth = 950;
												

											   //add the images
												base_image = new Image();
												base_image.src = 'img/base.jpg';
												context = canvas.getContext('2d');
												
												var ratioSize = ratio(images.customkey0.width, maxWidth);
												var aspectRatio = images.customkey0.width / images.customkey0.height;
												var paddingTop = 150; // set padding top
												
												// set padding bottom
												// set padding left/right
												
												var totalImageCount = 0;
												var numCounter = 0; // total number of records
												var newPageCounter = 0; // if counter hits 2 add new page and then reset.
												var totalPages = 0; // all pages printed
												var newPage = false; // true/false switch if adding a new page or not.
												
												// -------------------------------------------------------------------
												// ------ START OF LOOP ----------------------------------------------
												// -------------------------------------------------------------------
												
												// get and set the total amount of images
												for(var src in sources) {
													if(src != 'base_image'){ 
														totalImageCount++;
													}
												}
												//console.info("total image count: " + totalImageCount)
												//---------------------------------------------------------------------------
												
												// SET UP IMAGES
												
												
												// PRINT IMAGES IN ORDER
												
												
												//console.error("---------------------- header -------------------");
												//context.drawImage(images.base_image,0,0, 1260, 1782); // draw base underlaying image, in this case white streched to each corner.
												for(var src in sources) {
													
													if(src != 'base_image'){
														
														if (newPageCounter == 2){
															newPage = true;
														}
																												
														if (newPage == true){
															//console.info("*** pageBreak ***");  // add a new page
															//console.error("---------------------- header -------------------");
															context.drawImage(images.base_image,0,0, 1260, 1782); // draw base underlaying image, in this case white streched to each corner.
															newPageCounter = 0;
															newPage = false;
															//console.warn("3convert drawn images and add to markers["+totalPages+"]");
															totalPages++;
														}
														
														if (newPageCounter == 0) {
															//console.info("src: " + src + " | " + sources['customkey'+numCounter] + " | Current Count = " + newPageCounter); // add the images
															context.drawImage(images.base_image,0,0, 1260, 1782); // draw base underlaying image, in this case white streched to each corner.
															context.drawImage(images[src], 175, paddingTop, images[src].width * ratioSize, (images[src].width*ratioSize)/aspectRatio);
															//console.error("---------------------- header -------------------");
															//console.log(sources['customkey'+numCounter] + " | " + numCounter + " of " + totalImageCount);
															//console.info("print image " + numCounter);
															// check if this is last image on the page
															
															if (numCounter == totalImageCount - 1){
																
																//console.warn("1 convert drawn images and add to markers["+totalPages+"]");
																markers[totalPages] = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
																// Convert the data to binary form
																markers[totalPages] = atob(markers[totalPages]);
																
															}
														}
														if (newPageCounter == 1) {
															//console.info("nextImage");
															//console.info("src: " + src + " | " + sources['customkey'+numCounter] + " | Current Count = " + newPageCounter); // add the images
															context.drawImage(images[src], 175, 950, 950, 950/aspectRatio);
															//console.log(sources['customkey'+numCounter]);
															//console.info("print image " + numCounter);
															
															//console.warn("2 convert drawn images and add to markers["+totalPages+"]");
															markers[totalPages] = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
															// Convert the data to binary form
															markers[totalPages] = atob(markers[totalPages]);
														}
														/*
														markers[numCounter] = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
														// Convert the data to binary form
														markers[numCounter] = atob(markers[numCounter]);
														*/
														numCounter++;
														newPageCounter++;
													}
												}
												
												//and lose the canvas when you're done
												document.body.removeChild(canvas);
												
												//  ADD CREATED CANVAS plus add headers and page breaks.
												var doc = new jsPDF(); // create new jsPDF document variable
												
												for(var i = 0; i < totalPages+1; i++){
													//console.info(i + " of " + totalPages);
													
													// check if last in total pages
													if (i == totalPages){
													doc.addImage(markers[i], 'JPEG', 0, 0, 210, 297); // console.log("markers[" + i + "] add page: " + i);
													doc.text(70, 15, headerMemo); //console.error("---- HEADER ----");
														} else {
													doc.addImage(markers[i], 'JPEG', 0, 0, 210, 297); //console.log("markers[" + i + "] add page: " + i);
													doc.text(70, 15, headerMemo);  //console.error("---- HEADER ----");
															 
												    doc.addPage(); //console.log("PAGE BREAK ----->");
													}
													
												}
												
												doc.save(damageId+'.pdf');  //console.error("MAKE DOCUMENT!");
												
												// -------------------------------------------------------------------
												// ------ END LOOP HERE ----------------------------------------------
												// -------------------------------------------------------------------
												
												//console.warn("total images: " + numCounter + " | page count: " + totalPages);
												
												
												/*
												context.drawImage(images.base_image,0,0, 1260, 1782); // draw base underlaying image, in this case white streched to each corner.
												
												context.drawImage(images.customkey0, 175, paddingTop, images.customkey0.width * ratioSize, (images.customkey0.width*ratioSize)/aspectRatio);
												context.drawImage(images.customkey1, 175, 950, 950, 950/aspectRatio);

												//now grab the one image data for jspdf
												//imgData = canvas.toDataURL('data:image/jpeg');
											
												imgData = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
												// Convert the data to binary form
												imgData = atob(imgData);
												
												// -------------------------------------------------
												// second loop for second page
												context.drawImage(images.base_image,0,0, 1260, 1782); // draw base underlaying image, in this case white streched to each corner.
												
												context.drawImage(images.customkey2, 175, paddingTop, images.customkey2.width * ratioSize, (images.customkey2.width*ratioSize)/aspectRatio);
												context.drawImage(images.customkey3, 175, 950, 950, 950/aspectRatio);
												
												markers[2] = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
												// Convert the data to binary form
												markers[2] = atob(markers[2]);
												
												//--------------------------------------------------
												
												//and lose the canvas when you're done
												document.body.removeChild(canvas);
										
											
											var doc = new jsPDF();
												
												doc.addImage(imgData, 'JPEG', 0, 0, 210, 297); // adds the image up top
												
												doc.text(70, 15, headerMemo);
											
											    doc.addPage();
											
												doc.addImage(markers[2], 'JPEG', 0, 0, 210, 297); // adds the image up top
											
												doc.text(70, 15, headerMemo);
																						
											doc.save(damageId+'.pdf');
*/
											});
											
											
										}
										
										savePDF();
										
										
										
										
									});
								
								</script>
								<?php
								
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
				<div id="dialogListRecords" class='customScrollbar' title="All Records List" style=''>
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
					echo "</div>";
					?>
				</div>
			
				<!-- DOWNLOAD OPTIONS -->
				<div id="dialogDownloadOptions" class='customScrollbar' title="Table View With Download Options" style='font-family: monospace; font-size: 13px;'>
					<?php
					echo "<div class='downloadOptionsBlock' style='overflow: hidden;'>";
					
						echo "<div class='optionsBoxWrapper'>";
							echo "
								<a href='#' id='dialogPdfDownloadBtn' class='btnXLarge' style='float: left;' data-tooltip='Download Options'>
									<span class='btn fa-stack fa-lg' style=''>
										<i class='fa fa-cloud fa-stack-2x'></i>
										<i class='fa fa-file-pdf-o fa-stack-1x fa-inverse btnXLargeText'></i>
									</span>
								</a>";
							echo "<h1>PDF DOWNLOAD</h1>";
						echo "</div><br>";
						echo "<div class='optionsBoxWrapper'>";
							echo "
								<a href='#' id='dialogExportBtn' class='btnXLarge' style='float: left;' data-tooltip='Download Options'>
									<span class='btn fa-stack fa-lg' style=''>
										<i class='fa fa-cloud fa-stack-2x'></i>
										<i class='fa fa-file-excel-o fa-stack-1x fa-inverse btnXLargeText'></i>
									</span>
								</a>";
							echo "<h1>EXCEL DOWNLOAD</h1>";
						echo "</div><br>";
						echo "<div class='optionsBoxWrapper'>";
							echo "
								<a href='#' id='dialogZipDownloadBtn' class='btnXLarge' style='float: left;' data-tooltip='Download Options'>
									<span class='btn fa-stack fa-lg' style=''>
										<i class='fa fa-cloud fa-stack-2x'></i>
										<i class='fa fa-file-archive-o fa-stack-1x fa-inverse btnXLargeText'></i>
									</span>
								</a>
							";
							echo "<h1>ZIP DOWNLOAD</h1>";
						echo "</div>";
					echo "</div>";
					?>
				</div>
			
			<!-- TABLE FORMAT -->
				<div id="dialogTableView" class='customScrollbar' title="Table View With Download Options" style='font-family: monospace; font-size: 13px;'>
					<?php
					echo "<div class='dialogExportExcel' style=''>";
					echo "<div id='saveWrapper'>";
					echo "<table id='customers' style='width: 100%; border: 1px solid black; margin: calc(100% - 10px;); text-align: center;'>";
					echo "<thead>";
					echo "<tr><th colspan='10' style='text-align: left; border: 1px solid black;'>TAIYO KANAMONO JAPAN [ $recMasterMakerName ] $recMasterDate</th></tr>";
					echo "<th style='border: 1px solid black;'>DAMAGE ID</th>";
					echo "<th style='border: 1px solid black;'>MODEL</th>";
					echo "<th style='border: 1px solid black;'>SPEC</th>";
					echo "<th style='border: 1px solid black;'>GUARANTEE No.</th>";
					echo "<th style='border: 1px solid black;'>INVOICE No.</th>";
					echo "<th style='border: 1px solid black;'>DATE</th>";
					echo "<th style='border: 1px solid black;'>INVOICE VALUE</th>";
					echo "<th style='border: 1px solid black;'>ORDER No.</th>";
					echo "<th style='border: 1px solid black;'>REFERENCE</th>";
					echo "<th style='border: 1px solid black;'>DAMAGE SIZE</th>";
					echo "</thead>";
					echo "<tbody>";
					
					/* QUERY THE TABLE AND GET THE LOOP INFO */
					
					$totalCost = 0; // add the total cost in the loop
					$pdfExportArray = array();
					
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
								
								$pdfExportArray[] = array('name' => $records_id_dmg, 'age' => $records_modelNo); // push data to array to use for pdf export
								$totalCost += $records_invoiceValue; // set total cost
								
								
								$damSize = "";
								// check if size is zero
								if ($rowMain['damageSize'] == "0"){
									$damSize = "";
								} else {
									$damSize = $rowMain['damageSize']."mm";
								}
								
								switch($records_invoiceCurrency){
								case "0":
									$curr = "€";
									break;
								case "1": 
									$curr = "$";
									break;
								case "2": 
									$curr = "円";
									break;
								default:
									$curr = "";
							}
					
						echo "<tr>";
						echo "<td style='border: 1px solid black;'>".$rowMain['id_dmg']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['modelNo']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['spec']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['invoiceGntNo']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['invoiceNo']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['invoiceDate']."</td>";
						echo "<td style='border: 1px solid black; text-align: right;'>".$curr." ".number_format($rowMain['invoiceValue'], 2, '.',',')."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['orderNo']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$rowMain['damageMemoEn']."</td>";
						echo "<td style='text-align: center; border: 1px solid black;'>".$damSize."</td>";
						echo "</tr>";
					}
					echo "<tr><th colspan='6' style='text-align: right;'>TOTAL</th>
					          <th style='text-align: right; border: 1px solid black;'>".$curr." ".number_format($totalCost, 2, '.',',')."</th>
							  <th colspan='3'></th>
							  </tr>";
					echo "</tbody>";
					echo "</table>";
					echo "</div>"; // save wrapper finished
					//$pdfExportArray =  //test
					//echo $pdfExportArray;
					?>
					<br>
						<button id='downloadTablePdfBtn'>PDF DOWNLOAD <i style='color: crimson;' class="fa fa-file-pdf-o"></i></button>
						<a download="<?php echo $currentMakerName." ".$currentClaimDate;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $currentClaimDate;?>');"><button>EXCEL DOWNLOAD <i style='color: green;' class="fa fa-file-excel-o"></i></button></a>
			
					<!-- DOWNLOAD PDF SCRIPT -->
					
					<?php 
					
					/* CURRENCY CONVERTER SUPPORT for EUR, USD, YEN*/
						function toCurrencyAmount($currency, $amount){
							switch($currency){
								case "0":
									$curr = "€";
									$amount = number_format($amount, 2, '.', ',');
									break;
								case "1": 
									$curr = "$";
									$amount = number_format($amount, 2, '.', ',');
									break;
								case "2": 
									$curr = "YEN ";
									$amount = number_format($amount, 2, '.', ',');
									break;
								default:
									$curr = "";
									$amount = "";
							}
							return $curr.$amount;
						}

						$totalTableAmount = 0;// total amount

						$data = array();

						$headerStyle = "header";
						$headerAlignment = "left";
						$bodyStyle = "subheader";
						$bodyAlignment = "center";
						$headerTitle = array(
							array("text" => "TAIYO KANAMONO JAPAN [$currentMakerName] $currentClaimDate", "style" => $headerStyle, "alignment" => $headerAlignment, "colSpan" => "10"),
							array("text" => ""),
							array("text" => ""),
							array("text" => ""),
							array("text" => ""),
							array("text" => ""),
							array("text" => ""),
							array("text" => ""),
							array("text" => ""),
							array("text" => "")
						);

						$headerTh = array(
							array("text" => "DAMAGE ID", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "MODEL", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "SPEC", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "GUARANTEE No.", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "INVOICE No.", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "DATE", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "INVOICE VALUE", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "ORDER No.", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "REFERENCE", "style" => $headerStyle, "alignment" => $bodyAlignment),
							array("text" => "DAMAGE SIZE", "style" => $headerStyle, "alignment" => $bodyAlignment)
							);

						$data[] = $headerTitle;
						$data[] = $headerTh;

						$resultMain = mysql_query("SELECT * FROM `records` WHERE `id_recordMaster` = '$recMasterId'");
						while($rowMain = mysql_fetch_assoc($resultMain)){

							$damSize = "";

							// check if size is zero
							if ($rowMain['damageSize'] == "0"){
								$damSize = "";
							} else {
								$damSize = $rowMain['damageSize']."mm";
							}

							$curr = toCurrencyAmount($rowMain['currency'], $rowMain['invoiceValue']);
							$lastKnownCurrency = $rowMain['currency'];

							$var = array(
								array("text" => $rowMain['id_dmg'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['modelNo'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['spec'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['invoiceGntNo'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['invoiceNo'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['invoiceDate'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $curr, "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['orderNo'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $rowMain['damageMemoEn'], "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => $damSize, "style" => $bodyStyle, "alignment" => $bodyAlignment)
							);

							$data[] = $var; // input the data from the loop into the data array

							$totalTableAmount += $rowMain['invoiceValue']; // add up the amount
						}
						 // after loop is finished addd the total amount to data
						$varTotalAmount = array(
								array("text" => "TOTAL", "style" => $bodyStyle, "alignment" => "right", "colSpan"=> "6"),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => toCurrencyAmount($lastKnownCurrency, $totalTableAmount), "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment, "colSpan"=> "3"),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
								array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment)
							);
						$data[] = $varTotalAmount;
					
					?>
					
					<script type="text/javascript">
						$(document).ready(function(){
							
							$('#downloadTablePdfBtn').click(function() {
						
								var headerTitle = { text: 'TAIYO KANAMONO JAPAN ', colSpan: 2, style: 'th', alignment: 'left'};
			
								var externalDataRetrievedFromServer = jQuery.parseJSON( '<?php echo json_encode($data) ?>' ); // parse the JSON data and put into object properties

								var dd = {
									//page size
									pageSize: 'A4',

									// default we use portrait, you can change it to landscape
									pageOrientation: 'landscape',

									// [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
									pageMargins: [ 20, 30, 20, 30 ],

									content: [ {
										table: { 
											widths: [ 'auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto' ],
											headerRows: 2,
											body: externalDataRetrievedFromServer
										}

									}],
									styles: {
											header: {
												fontSize: 9,
												bold: true
											},
											subheader: {
												fontSize: 9,
												bold: false
											}
										}
								}

								// download the PDF (temporarily Chrome-only)
								pdfMake.createPdf(dd).download('TAIYO KANAMONO JAPAN <?php echo $currentClaimDate;?>.pdf');
								
							}); // END OF test CLICK
															
								
					}); // END OF DOC READY FUNCTION
					</script>
					
			</div> <!-- TABLE FORMAT FINISHED -->
			
			
					
				</div> <!-- WRAPPER FINISHED -->

				<!-- DIALOGE BOXES END HERE -->

				<!-- PAGE CONTENTS END HERE -->
		</div>
		<?php require_once '/master/footer.php';?>
			<script>
			</script>
	</body>

	</html>