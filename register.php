<?php
	// Retrive the Request Data
	$reqRaw = file_get_contents('php://input');
	if($reqRaw !== false){
		// Convert Request JSON data to associative Object
		$reqJson = json_decode($reqRaw, true);

		// Extract Username from JSON Request
		$username = $reqJson["username"];
		$password = $reqJson["password"];
		$mail = $reqJson["email"];

		require_once('../../commons/db.php');
		if(new_user($username,$password,$mail)) {
            echo '{';
            echo '   "status":"valid"';
            echo '}';
        }else{
            echo '{';
            echo '   "status":"invalid"';
            echo '}';
        }
	}
?>
