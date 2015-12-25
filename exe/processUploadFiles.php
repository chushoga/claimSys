<?php
$ds = DIRECTORY_SEPARATOR;
$cid = $_POST["cid"];
//$cid = "18";
$rid = $_POST["rid"];
//$rid='206';

$storeFolder = "../recordFiles/".$cid."/".$rid;
//$storeFolder = 'uploads'.$cid;   //2

if (!empty($_FILES)) {
     
	if (!file_exists('../recordFiles/'.$cid."/".$rid)) {
		mkdir('../recordFiles/'.$cid."/".$rid, 0777, true);
	}
	
    $tempFile = $_FILES['file']['tmp_name'];
	
	// remove all whitespace in the file name
	$cleanedFileName =  $_FILES['file']['name'];
	$cleanedFileName = preg_replace('/\s+/', '', $cleanedFileName);
	
      
    $targetPath = dirname( __FILE__ ).$ds.$storeFolder.$ds;
     
    $targetFile =  $targetPath.$cleanedFileName;
 
    move_uploaded_file($tempFile,$targetFile);
    	
}


// ---------------------------------------
// ----- DEBUGGING for ajax to a txt file
// ---------------------------------------
function debugger($string){
	
// the name of the file you're writing to
$myFile = "data.txt";

// opens the file for appending (file must already exist)
$fh = fopen($myFile, 'a');

// Makes a CSV list of your post data
/* $comma_delmited_list = implode(",", $_POST) . "\n";

foreach($_POST as $file => $files){
	//fwrite($fh, $file.'='.$files.', ');
}
*/
	
// Write to the file
fwrite($fh, $string);

// You're done
fclose($fh);

}

?>
