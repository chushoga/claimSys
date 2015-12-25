<?php

	require_once("../master/dbConnect.php"); //DB connect

	// record ID
	if(isset($_POST["cid"])){
		$cid = $_POST["cid"];
	} else {
		$cid = "";
	}

	// record block ID
	if(isset($_POST["rid"])){
		$rid = $_POST["rid"];
	} else {
		$rid = "";
	}

	if($rid == "" || $cid == ""){
		
	} else {
		
		$query = mysql_query("DELETE FROM `records` WHERE `id` = '$rid'");
		
		if($query){
			echo "SUCCESS!!!!";
			
			// remove directory
			$dir = '..' . DIRECTORY_SEPARATOR . 'recordFiles'. DIRECTORY_SEPARATOR . $cid . DIRECTORY_SEPARATOR . $rid;
			$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($it,
						 RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file) {
				if ($file->isDir()){
					rmdir($file->getRealPath());
				} else {
					unlink($file->getRealPath());
				}
			}
			rmdir($dir);
			
		} else {
			echo "ERROR!";
		}
		
		
		
	}

	
?>

