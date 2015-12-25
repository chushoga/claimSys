<html lang="ja">
	<head>
		
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1, minimum-scale=1, width=device-width">
		<title>Tform - 水まわり - FLN72-5801</title>
		

		
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
 
		<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
		
		
		<!--<script type="text/javascript" src="js/jquery-1.10.2.js"></script>-->
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		
				
		<script type="text/javascript">
			$(document).ready(function(){
				// get data from database
				function showComment(){
					$.ajax({
						type: "post",
						url: "process.php",
						data: "action=showcomment",
						success: function(data){
							$("#comment").html(data);
						}
					});
				}
				
				showComment();
				
				// send data to database
				$("#button").click(function(){
				
					var damageId = $("#damageId_11").val();
					var modelNo = $("#modelNo_11").val();

					$.ajax({
						type: "post",
						url: "process.php",
						data:"damageId_11="+damageId+"&modelNo_11="+modelNo+"&action=addcomment",
						success: function(data){
				showComment();
						}
					});
				});
				
			});

		</script>

		
	</head>
	<body>

		<?php 
		/*
		$refering_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		
		echo "[ URL FROM: ".$refering_url." ]<br>";
		*/
		?>
		
		<form>
			name: <input type='text' name='damageId_11' id='damageId_11'>
			<br>
			message: <input type='text' name='modelNo_11' id='modelNo_11'>
			<br>
			<input type='button' value='SEND COMMENT' id='button'>
			
			<div id='info'></div>
			
			<ul id="comment"></ul>
		</form>

	</body>
</html>