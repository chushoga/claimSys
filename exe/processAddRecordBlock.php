<?php 

	require_once("../master/dbConnect.php"); //DB connect

	if(isset($_POST["cid"])){
		$cid = $_POST["cid"];
	} else {
		$cid = "";
	}

	if($cid == ""){
		
	} else {
	
		
		$query = mysql_query("INSERT INTO `records`(
											`id_recordMaster`
											)
											VALUES(
											'$cid'
											)
		");
		
		
		if($query){
			echo "SUCCESS!!!!";
			if (!file_exists('../recordFiles/'.$cid."/".mysql_insert_id())) {
				mkdir('../recordFiles/'.$cid."/".mysql_insert_id(), 0777, true);
			}
		} else {
			echo "ERROR!";
		}
	}
	

?>
