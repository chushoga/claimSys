<?php //home connect
	require_once("../master/dbConnect.php");
	$path = "/claimSys";


function debugger(){
	
// ---------------------------------------
// ----- DEBUGGING for ajax to a txt file
// ---------------------------------------
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

	$action = $_POST["action"];

	if($action == "editFiles"){
		
		$cid = $_POST['cid'];
		$recId = $_POST['recordBlockId']; // record block id No.
		
		
		//$show = mysql_query("SELECT * FROM `records` ORDER BY `id` desc");
		
		//while($row = mysql_fetch_array($show)){
			//echo "<li><b>".$row['id_dmg']."</b> : ".$row['modelNo']."</li>";
			
			// GET ALL IMAGES IN DIRECTORY AND DISPLAY THEM
		
			$fileLoc = "../recordFiles/".$cid."/".$recId."/";
		
			$filesImages = glob($fileLoc.'*.{JPG,jpg,png,gif}', GLOB_BRACE);

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
			
		
	} else if($action == "addcomment"){
		
//		$name = $_POST['damageId_11'];
//		$message = $_POST['modelNo_11'];
		
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


		
		//$records_id_recordMaster = $_POST['id_recordMaster'.$recId];
/*
		$query = mysql_query("INSERT INTO `records`(
											id_dmg,
											modelNo,
											tformNo,
											orderNo,
											spec,
											invoiceNo,
											invoiceDate,
											invoiceGntNo,
											currency,
											invoiceValue,
											damageType,
											damageSize,
											damageMemoEn,
											damageMemoJp,
											flagPending
											)
											VALUES(
											'$damageId',
											'$modelNo',
											'$records_tformNo',
											'$records_orderNo',
											'$records_spec',
											'$records_invoiceNo',
											'$records_invoiceDate',
											'$records_invoiceGntNo',
											'$records_currency',
											'$records_invoiceValue',
											'$records_damageType',
											'$records_damageSize',
											'$records_damageMemo_EN',
											'$records_damageMemo_JP',
											'$records_flgPending'
											)
		");
*/
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
