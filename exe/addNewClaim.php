<?php date_default_timezone_set('Asia/Tokyo'); 
require_once '../master/dbconnect.php';

//variables
$makerName = $_POST['makerName'];
$date = $_POST['date'];

$sqlID = "INSERT INTO `recordmaster`(
								`makerName`,
								`date`
								)
							VALUES(
								'$makerName',
								'$date'
							)";

echo $sqlID;
$resID = mysql_query($sqlID);
$lastId = mysql_insert_id();
header("location: ../index.php?message=success&cid=$lastId");

?>