<?php
//home connect
require_once("../master/dbConnect.php");
$path = "/claimSys";


$cid = $_POST['cid'];
$status = $_POST['status'];
$editedBy = $_POST['editedBy'];

$modified = date("Y-m-d");


	$query = mysql_query("UPDATE `recordmaster` SET
											`status` = '$status',
											`editedBy` = '$editedBy',
											`modified` = '$modified'
										WHERE
											`id` = '$cid'
		");

		if(!$query){
			die('Invalid query: ' . mysql_error());
		} else {
			echo "UPDATED!";
		}

header("location: ../index.php?message=success&cid=$cid");
?>