<?php 
//MESSAGE FUNCTIONS: pass the type of message and what message you want. -----------------------------------

function message($type,$message){

	switch ($type){
		case "error":
			echo "<div class='error'><i class='fa fa-times-circle'></i> error MESSAGE!! $message</div>";
			break;
		case "success":
			echo "<div class='success'><i class='fa fa-check-circle'></i> success $message</div>";
			break;
		case "warning":
			echo "<div class='warning'><i class='fa fa-warning'></i> warning <span style='color: red;'> $message </span></div>";
			break;
		case "info":
			echo "<div class='info'><i class='fa fa-info-circle'></i> info $message</div>";
	    break;
	    case "required":
	        echo "<div class='required'><i class='fa fa-asterisk'></i> required</div>";
	    break;	        
	    default:
	        echo "No Error Message";
    }

}
//MESSAGE FUNCTIONS: END-------------------------------------------------------------------------------------
?>