<?php

	require_once("../master/dbConnect.php"); //DB connect

	// record ID
	if(isset($_GET["cid"])){
		$cid = $_GET["cid"];
	} else {
		$cid = "";
	}

	

	if($cid == ""){

		} else {
		
			$query = mysql_query("DELETE FROM `records` WHERE `id_recordMaster` = '$cid'");
			$query2 = mysql_query("DELETE FROM `recordmaster` WHERE `id` = '$cid'");
		
			if($query){
				
			// remove directory
					$dir = '..' . DIRECTORY_SEPARATOR . 'recordFiles'. DIRECTORY_SEPARATOR . $cid;
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
				
				header('location: ../index.php?message=deleted');
			} else {
				header('location: ../index.php?message=error');
			}
	}
?>