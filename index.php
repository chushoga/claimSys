<?php require_once '/master/head.php';?>
	<!DOCTYPE HTML>
	<html lang="jp" ng-app>

	<head>

		<?php include_once '/master/metaTags.php'; ?>

			<title>
				<?php echo $title;?>
			</title>
			<?php
include_once '/master/config.php'; ?>
				


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
<?php
											if($recMasterId == ""){
											} else {
												echo"
										<!-- STATS -->
										<a href='#' id='' class='btnLarge' style='float: left;' data-tooltip='View Stats'>
											<span class='btn fa-stack fa-lg' style=''>
												<i class='fa fa-square fa-stack-2x'></i>
												<i class='fa fa-pie-chart fa-stack-1x fa-inverse btnLargeText'></i>
											</span>
										</a>

										<!-- DOWNLOAD -->
										<a href='#' id='downloadBtn' class='btnLarge' style='float: left;' data-tooltip='Download PDF, EXEL, ZIP all'>
											<span class='btn fa-stack fa-lg' style=''>
												<i class='fa fa-square fa-stack-2x'></i>
												<i class='fa fa-cloud-download fa-stack-1x fa-inverse btnLargeText'></i>
											</span>
										</a>

										<!-- TABLE VIEW -->
										<a href='#' id='dialogTableViewBtn' class='btnLarge' style='float: left;' data-tooltip='Settings'>
											<span class='btn fa-stack fa-lg' style=''>
												<i class='fa fa-square fa-stack-2x'></i>
												<i class='fa fa-table fa-stack-1x fa-inverse btnLargeText'></i>
											</span>
										</a>
										";
											}
?>
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
								$master_pending = $rowMaster['status'];
								$master_pendingNumber = $rowMaster['status'];
								
								$master_pending = ""; // pending, accepted, rejected, photo requested
								
								switch($rowMaster['status']){
									case 0:
										$master_pending = "PENDING <i class='fa fa-clock-o' style=''></i>";
										break;
									case 1:
										$master_pending = "COMPLETE <i class='fa fa-check' style=''></i>";
										break;
								}
							}
							
								echo "
								<a href='#' id='dialogMasterOptionsBtn' class='btnSmall' style='display: block; float: right; font-size: 9px; line-height: 21px; margin-right: 7px;' data-tooltip='Master Options'>
									<span class='btn fa-stack fa-lg' style='color: #303030'>
										<i class='fa fa-circle fa-stack-2x'></i>
										<i class='fa fa-wrench fa-stack-1x fa-inverse btnSmallText'></i>
									</span>
								</a>
							";
							
							echo "<div id='recordHeaderTop' style=''><span style='margin-left: 5px; float: left;'>TAIYO KANAMONO JAPAN [ $recMasterMakerName ] $recMasterDate ($master_pending) </span> ";
							
							
							echo "<span id='userNameShow' style='float: right; margin-right: 10px;'></span></div>";

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
								
									// check if there is D- is set or not
									if($records_id_dmg == ""){
										$records_id_dmg = "D-";
									} else {
										$records_id_dmg = $records_id_dmg;
									}
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
														<td><input type='text' id='invoiceDate_$records_id' class='datepicker' value='$records_invoiceDate' name='invoiceDate_$records_id'></td>
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
							/* CURRENCY CONVERTER SUPPORT for EUR, USD, YEN*/
						function toCurrencyAmountTotal($currency, $amount){
							switch($currency){
								case "0":
									$curr = "€";
									if($amount == 0){
										$amount = "";
									} else {
										$amount = number_format($amount, 2, '.', ',');
									}
									break;
								case "1": 
									$curr = "$";
									if($amount == 0){
										$amount = "";
									} else {
										$amount = number_format($amount, 2, '.', ',');
									}
									break;
								case "2": 
									$curr = "￥";
									if($amount == 0){
										$amount = "";
									} else {
										$amount = number_format($amount, 2, '.', ',');
									}
									break;
								default:
									$curr = "";
									$amount = "";
							}
							return $curr.$amount;
						}
							
							echo "
								<a href='#' class='ttips' data-tooltip='Refresh for the best accurate results' style='color: #3D3D3D;'><i class='fa fa-exclamation-triangle'></i></a> 
								total [".toCurrencyAmountTotal($records_invoiceCurrency, 0)."<span id='totalPrice'></span>] | accepted [".toCurrencyAmountTotal($records_invoiceCurrency, $acceptedValue)."] | rejected [".toCurrencyAmountTotal($records_invoiceCurrency, $rejectedValue)."] | totalpending [".toCurrencyAmountTotal($records_invoiceCurrency, $pendingValue)."] 
								| LAST EDITED BY: $recMasterEditedBy ON: $modified 
							";
						}
						?>
							</div>
						</div>
				</div>

			
				<!-- //////////////////////// -->
				<!-- DIALOGE BOXES START HERE -->
				<!-- //////////////////////// -->
				<?php include_once("dialog.php"); ?>
				<!-- DIALOGE BOXES END HERE -->
				
				<!-- //////////////////////// -->
					
				</div> <!-- WRAPPER FINISHED -->

				

				<!-- PAGE CONTENTS END HERE -->
		</div>
		<?php require_once '/master/footer.php';?>
			<script>
			</script>
	</body>

	</html>