<div id="header">
<?php 

// SET REQUIRED FILES
    require_once 'functions/generalFunctions.php';
// -------------------
// GET MESSAGES
    if(isset($_GET['message'])) {    
        $message = $_GET['message'];
    }else{
	    $message = "";
    }
    if(isset($_GET['info'])) {   
        $info = $_GET['info'];
    }else{
		$info = "";
    }
    if (isset($_GET['message']) && isset($_GET['info'])){
        message($message, $info);
    } else if(isset($_GET['message'])) {
        message($message, "");
    }
// -------------------

?>
</div>