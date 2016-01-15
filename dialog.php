
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
									$conditionIcon = "fa fa-clock-o";
									$conditionText = "PENDING...";
									break;
								case "1": 
									$conditionColor = "color: #04D61D;";
									$conditionIcon = "fa fa-check-square-o";
									$conditionText = "COMPLETE";
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
							<div style='width: 60px; height: 70px; float: left; text-align: center;'>
							
							<a href='#' id='logout' class='btnSmall' data-tooltip='LOGOUT' style='font-size: 18px;'>
								<span class='btn fa-stack fa-lg' style='margin-left: 3px;'>
									<i class='fa fa-square fa-stack-2x' ></i>
									<i class='fa fa-power-off fa-stack-1x fa-inverse btnSmallText' ></i>
								</span>
							</a>
							<br>
							<span style='text-align: center; font-size: 16px'>LOGOUT</span>
							</div>
						</a>
						";
					
					$result = mysql_query("SELECT * FROM `users`");
					while($row = mysql_fetch_assoc($result)){
						$userId = $row['id'];
						$userName = $row['userName'];
						
						echo "
						<a href='#'>
							<div style='width: 60px; height: 70px; float: left; text-align: center;'>
							
							<a href='#' id='' class='userNameChoice btnSmall' data-tooltip='$userName' style='font-size: 18px;' >
								<span class='btn fa-stack fa-lg' style='margin-left: 3px;'>
									<i class='fa fa-square fa-stack-2x' ></i>
									<i class='fa fa-user fa-stack-1x fa-inverse btnSmallText' ></i>
								</span>
							</a>
							<br>
							<span style='text-align: center; font-size: 18px'>$userName</span>
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
			
			<!-- MASTER OPTIONS -->
				<div id="dialogMasterOptions" class='customScrollbar' title="MASTER Options" style='font-family: monospace; font-size: 13px;'>
					<?php
					echo "<div class='' style='overflow: hidden;'>";
				
							echo "<form method='post' action='exe/changeRecordStatus.php' style=''>
								<input type='hidden' name='cid' value='$recMasterId'>
								<input type='hidden' name='editedBy' value='$recMasterEditedBy'>";
							
							if($master_pendingNumber == 0){
								echo "<input type='radio' name='status' value='0' checked > PENDING | ";
								echo "<input type='radio' name='status' value='1'> <span style='margin-right: 5px;'>COMPLETE </span>";
							} else {
								echo "<input type='radio' name='status' value='0' > PENDING | ";
								echo "<input type='radio' name='status' value='1' checked> <span style='margin-right: 5px;'>COMPLETE </span>";
								}
							echo "</select>";
							echo "<input type='submit' value='update status' style='margin-right: 5px;'>";
							echo "</form>";
					echo "<br><hr><br>";
					echo "
							<a href='#' id='removeCid' class='btnSmall' style='display: block; float: left;' data-tooltip='DELETE RECORD!'>
								<span class='btn fa-stack fa-lg' style='color: #BF2C2C'>
									<i class='fa fa-square fa-stack-2x'></i>
									<i class='fa fa-trash fa-stack-1x fa-inverse btnSmallText'></i>
								</span>
							<span style='font-size: 12px;'>DELETE RECORD AND ALL IMAGES/FILES</span></a> ";
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
								
							}); // END OF download table CLICK
															
								
					}); // END OF DOC READY FUNCTION
					</script>
					
			</div> <!-- TABLE FORMAT FINISHED -->