<?php require_once '/master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>

<?php include_once '/master/metaTags.php'; ?>

<title><?php echo $title;?></title>
<?php
include_once '/master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {} );


</script>
<style type="text/css">
	td {
		padding: 0px;
	}
</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</head>
<body>
<!-- PAGE CONTENTS START HERE -->
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
	
	$recMasterId = '20'; // DONT NEED
	$totalTableAmount = 0;// total amount
	
	$data = array();
		
	$headerStyle = "header";
	$headerAlignment = "left";
	$bodyStyle = "subheader";
	$bodyAlignment = "center";
	$headerTitle = array(
		array("text" => "TAIYO KANAMONO JAPAN [MAKER] DATE....", "style" => $headerStyle, "alignment" => $headerAlignment, "colSpan" => "10"),
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
		array("text" => "DAMAGE_ID", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "MODEL", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "SPEC", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "GUARANTEE_No", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "INVOICE_No", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "DATE", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "INVOICE VALUE", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "ORDER_No", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "REFERENCE", "style" => $headerStyle, "alignment" => $bodyAlignment),
		array("text" => "DAMAGE_SIZE", "style" => $headerStyle, "alignment" => $bodyAlignment)
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
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => toCurrencyAmount($lastKnownCurrency, $totalTableAmount), "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment),
			array("text" => "", "style" => $bodyStyle, "alignment" => $bodyAlignment)
		);
	$data[] = $varTotalAmount;
	
	/*
	// DONT NEED BUT USED FOR SHOWING CLEAN ARRAY
	echo "<pre>";
		print_r($data);
	echo "</pre>";
	echo json_encode($data);
	*/
	
	
	?>


<br><br><hr><br><br>
	<?php 
	$master_pendingNumber = 0;
	echo "<form method='post' action='exe/changeRecordStatus.php'>
							      <input type='hidden' name='cid' value='1'>";
							if($master_pendingNumber == 0){
								echo "<input type='radio' name='gender' value='test1' >PENDING1";
								echo "<input type='radio' name='gender' value='test2'>COMPLETE1";
							} else {
								echo "<input type='radio' name='gender' value='0' >PENDING2";
								echo "<input type='radio' name='gender' value='1'>COMPLETE2";
								}
							echo "</select>";
							
							echo "</form>
	?>
<br><br><hr><br><br>
<div id='contents'></div>
<button id='addBtn'>ADD DATA HERE</button>
<br><br>

	
<script type="text/javascript">
	$(document).ready( function() {
		$("#addBtn").click(function(){
			
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
			pdfMake.createPdf(dd).download('testname.pdf');

		}); // end of click function
	});

</script>
<!-- PAGE CONTENTS END HERE -->

</body>
</html>