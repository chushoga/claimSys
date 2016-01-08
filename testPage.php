<?php require_once '/master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>

<?php include_once '/master/metaTags.php'; ?>

<title><?php echo $title;?></title>
<?php
include_once '/master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {	
	
	
	//var json_string = <? echo $json_encode($data) ?>;
	//var arr_from_json = JSON.parse( json_string );
	
	//alert("test");
	
	} );


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
	$data = array();
	
	// { text: 'Defective Finish on overflow hole rim', style: 'td', alignment: 'center'}
	$style = "tdStyle";
	$alignment = "center";
	
	$headerTitle = array(
		array("text" => "Taiyo Kanamono", "style" => $style, "alignment" => $alignment, "colSpan" => "2"),
		array("text" => "")
	);
	
	$headerTh = array(
		array("text" => "DamageID"),
		array("text" => "Cost")
		);
	
	$data[] = $headerTitle;
	$data[] = $headerTh;
	
	for($i = 0; $i < 2; $i++){
			$var = array(
				array("text" => "textFIRST", "style" => $style, "alignment" => $alignment),
				array("text" => "textSECOND", "style" => $style, "alignment" => $alignment)
				);
			$data[] = $var;
	}
	
	
	echo "<pre>";
		print_r($data);
	echo "</pre>";
	
	echo json_encode($data);
	
	$dataString = json_encode($data);
	?>


<br><br><hr><br><br>
<br><br><hr><br><br>
	
<button id='addBtn'>ADD DATA HERE</button>
	<br><br>
<div id='contents'></div>
	
	<script type="text/javascript">
		$(document).ready( function() {
				/*
			var obj = jQuery.parseJSON( '<?php echo json_encode($data) ?>' );
			//alert( obj[0].text === "texthere_0" );
			
			var i = 1;
			$.each( obj, function( key, value ) {
			//  alert( key + ": " + value );
				
				//$("#contents").append( obj[i].text === "texthere_0");

				$("#contents").append(  obj[i].text + " | " +  obj[i].style + " | " +  obj[i].alignment +"<br>");
				i++;
			});
			
			$("#contents").append( obj[0].text === "texthere_0");
			
			$("#addBtn").click(function(){
				
				$("#contents").append("[test "+ data[0] +" ] <br> ");
			});
		
		} );
*/
						
							$("#addBtn").click(function(){
					
								var headerTitle = { text: 'TAIYO KANAMONO JAPAN ', colSpan: 2, style: 'th', alignment: 'left'};
								var externalDataRetrievedFromServer = [
									{ name: 'Bartek', age: 34, style: 'header'  },
									{ name: 'John', age: 27,  style: 'header' },
									{ name: 'Elizabeth', age: 30,  style: 'header' }
								];

								var testexternalDataRetrievedFromServer = jQuery.parseJSON( '<?php echo json_encode($data) ?>' );
								//alert testexternalDataRetrievedFromServer;
								$.each(testexternalDataRetrievedFromServer, function(key, value) {
									//console.log('stuff : ' + key + ", " + value);
									$("#contents").append("| value0: " + value[0].text + " - value1: " + value[1].text + "<br>");
								});

								function buildTableBody(data, columns) {
									var body = [];

									body.push(columns);

									data.forEach(function(row) {
										var dataRow = [];

										columns.forEach(function(column) {
											dataRow.push(row[column].toString());
										})

										body.push(dataRow);
									});
									return body;
								}

								function table(data, columns) {

									return {
										table: {
											headerRows: 2,
											body: buildTableBody(data, columns)
										}
									};

								}

								var dd = {
									//page size
									pageSize: 'A4',

									// default we use portrait, you can change it to landscape
									pageOrientation: 'landscape',

									content: [

										table(externalDataRetrievedFromServer, ['name', 'text'])
									],
									styles: {
											header: {
												fontSize: 5,
												bold: true
											},
											subheader: {
												fontSize: 5,
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