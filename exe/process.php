<?php //home connect
	require_once("../master/dbConnect.php");
	$path = "/claimSys";

// ---------------------------------------
// ----- DEBUGGING for ajax to a txt file
// ---------------------------------------
function debugger(){
	
// the name of the file you're writing to
$myFile = "data.txt";

// opens the file for appending (file must already exist)
$fh = fopen($myFile, 'a');

// Makes a CSV list of your post data
$comma_delmited_list = implode(",", $_POST) . "\n";

foreach($_POST as $file => $files){
	//fwrite($fh, $file.'='.$files.', ');
}

// Write to the file
fwrite($fh, $comma_delmited_list);

// You're done
fclose($fh);

}

// ---------------------------------------
// RENAME FILE IF NOT EXSISTS FUNCTION
// ---------------------------------------

function rename_if_free($fileNew, $fileOld) {
	if (file_exists($fileNew)) return false;
	else {
		
		// remove all whitespace in the file name
		$cleanedFileName =  $fileNew;
		$cleanedFileName = preg_replace('/\s+/', '', $cleanedFileName);
		
		rename($fileOld, $cleanedFileName);
		//echo $fileOld." --> ".$fileNew."<br>";
		return true;
	}
}

	$action = $_POST["action"];

	if($action == "refreshImageBlock"){
		
		$cid = $_POST['cid'];
		$recId = $_POST['recordBlockId']; // record block id No.
		
		
		//$show = mysql_query("SELECT * FROM `records` ORDER BY `id` desc");
		
		//while($row = mysql_fetch_array($show)){
			//echo "<li><b>".$row['id_dmg']."</b> : ".$row['modelNo']."</li>";
			
			// GET ALL IMAGES IN DIRECTORY AND DISPLAY THEM
		
			$fileLoc = "../recordFiles/".$cid."/".$recId."/";
		
			$filesImages = glob($fileLoc.'*.{JPG,jpg,jpeg,JPEG,png,gif}', GLOB_BRACE);

			foreach($filesImages as $file) {
			 echo "<a class='fancybox' rel='group_$recId' href='claimsys/$file' title='".substr($file, strrpos($file, '/') + 1)."'> <img src='claimsys/$file' style='width: 100px; height: 100px; float: left;'></a>";
			}
			
			
		//}
	} else if($action == "refreshFilesBlock"){
		
		$cid = $_POST['cid'];
		$recId = $_POST['recordBlockId']; // record block id No.
		
		$fileLoc = "../recordFiles/".$cid."/".$recId."/";
			
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
			
		
	} else if($action == "editFiles"){
		
		$cid = $_POST['cid'];
		$recId = $_POST['rid']; // record block id No.
		
		$fileLoc = "../recordFiles/".$cid."/".$recId."/";
			
		// GET ALL FILES (pdf,dxf etc) IN DIRECTORY AND PREPARE FOR RENAMING
		?>
	<script>
		//FORM prevent default of enter key on form
		$('.renameForm').bind("keyup keypress", function(e) {
			var code = e.keyCode || e.which;
			if (code == 13) {
				e.preventDefault();
				return false;
			}
		});
	</script>
	<?php
			$filesPdf = glob($fileLoc.'*.*', GLOB_BRACE);
				echo "<form method='post' action='exe/process.php' class='renameForm' style='font-family: monospace;'>";
					echo "<input type='hidden' name='cid' value='$cid'>";
					echo "<input type='hidden' name='rid' value='$recId'>";
					echo "<input type='hidden' name='action' value='renameFiles'>";
					foreach($filesPdf as $file) {
						$x = substr($file, strrpos($file, '/') + 1);
						$i = preg_replace('/\\.[^.\\s]{3,4}$/', '', $x);
						echo "<i class='fa fa-file-o' style='color: crimson;'></i>
							<input style='border-top: none; border-left: none; border-right: none;' name='".$x."' value='".$x."'>";
						echo "<input type='checkbox' name='$x' value='delete'> <i style='color: crimson;' class='fa fa-trash'></i> DEL";
						echo "<br>";
					}
				echo "<input type='submit' value='RENAME/DELETE' style='margin-top:10px; text-align: center;'>";
				echo "</form>";
				echo "
					<br><hr><br>
					<span style='float: right; margin-right: 5px;'>
						<a href='#' class='removeRecord' id='$recId'> DELETE <i class='fa fa-trash-o'></i></a>
					</span>

					<span style='float: right; margin-right: 10px;'>
						<a href='#' class='pdfDownload' id='downloadPdfBtn$recId'>PDF <i class='fa fa-save'></i></a> | 
					</span>
					";
	} else if($action == "renameFiles"){
		
		$cid = $_POST['cid'];
		$recId = $_POST['rid']; // record block id No.
		
		//print_r($_POST);
		foreach ($_POST as $key => $value){
		
			
			if ($key != "cid" && $key != "rid" && $key != "action") {
				
				if ($value == "delete") {
					
					/******************/
					/* DELETE FUNCTION*/
					/******************/
					$needle   = '_'; // search for this string and replace
					$pos      = strripos($key, $needle); // find the postion of the last occurence.
					$newKey = substr_replace($key, '.', $pos, 1); // rename the previous key;
					$fileToDelete = "../recordFiles/".$cid."/".$recId."/".$newKey;
					
					//echo "key: ".$newKey." | value: ".$value;
					//echo "<span style='color: red; font-weight: strong; font-family: monospace;'> DELETE function!!!</span>";
					
					if(!unlink($fileToDelete)){
						//echo ("ERROR DELETING");
					} else {
						//echo ("DELETE SUCCESSFUL");
					}
					/******************/
										
				} else if ($value != $key && $value != 'delete'){
					
					/*******************/
					/* RENAME FUNCTION */
					/*******************/
					
						$needle   = '_'; // search for this string and replace

						$pos      = strripos($key, $needle); // find the postion of the last occurence.

						if ($pos === false) {
							
							echo "Sorry, we did not find ($needle) in ($key)"; // do nothing if not found
							
						} else {
							
							
						$newKey = substr_replace($key, '.', $pos, 1); // rename the previous key;

						// if the key and the value are different then rename to the new name, else do nothing
						if($newKey != $value) {

							// rename function
							echo "key: ".$newKey." | value: ".$value;
							echo "<span style='color: red; font-weight: strong; font-family: monospace;'> RENAME function!!!</span><br>";


							$fileOld = "../recordFiles/".$cid."/".$recId."/".$newKey;
							$fileNew = "../recordFiles/".$cid."/".$recId."/".$value;

							rename_if_free($fileNew, $fileOld);

						}
					}
				}
			}
		}
		
		header('location: ../index.php?cid='.$cid); // go back to index.
		
	} else if($action == "addcomment"){
		//debugger();
		$recId = $_POST['recordBlockId']; // record block id No.
		$damageId =  $_POST['damageId_'.$recId];
		$modelNo = $_POST['modelNo_'.$recId];
		$records_tformNo = $_POST['tformNo_'.$recId];
		$records_orderNo = $_POST['orderNo_'.$recId];
		$records_spec = $_POST['spec_'.$recId];
		$records_invoiceNo = $_POST['invoiceNo_'.$recId];
		$records_invoiceDate = $_POST['invoiceDate_'.$recId];
		$records_invoiceGntNo = $_POST['invoiceGntNo_'.$recId];
	
		$records_currency = $_POST['currency_'.$recId];
		$records_invoiceValue = $_POST['invoiceValue_'.$recId];
		$records_damageType = $_POST['damageType_'.$recId];
		$records_damageSize = $_POST['damageSize_'.$recId];
		$records_damageMemo_EN = $_POST['damageMemoEn_'.$recId];
		$records_damageMemo_JP = $_POST['damageMemoJp_'.$recId];
		$records_flgPending = $_POST['flgPending_'.$recId];
		
		$records_editedBy = $_POST['editedBy_'.$recId];
		$cid = $_POST['cid'];
		
		$modified = date("Y-m-d");

		$query = mysql_query("UPDATE `recordmaster` SET
											`editedBy` = '$records_editedBy',
											`modified` = '$modified'
										WHERE
											`id` = '$cid'
		");
		
		$query = mysql_query("UPDATE `records` SET
											`id_dmg` = '$damageId',
											`modelNo` = '$modelNo',
											`tformNo` = '$records_tformNo',
											`orderNo` = '$records_orderNo',
											`spec` = '$records_spec',
											`invoiceNo` = '$records_invoiceNo',
											`invoiceDate` = '$records_invoiceDate',
											`invoiceGntNo` = '$records_invoiceGntNo',
											`currency` = '$records_currency',
											`invoiceValue` = '$records_invoiceValue',
											`damageType` = '$records_damageType',
											`damageSize` = '$records_damageSize',
											`damageMemoEn` = '$records_damageMemo_EN',
											`damageMemoJp` = '$records_damageMemo_JP',
											`flgPending` = '$records_flgPending'
										WHERE
											`id` = '$recId'
		");

		if($query){
			echo "YOUR COMMENT HAS BEEN SENT";
		} else {
			echo "ERROR";
		}
	}
?>