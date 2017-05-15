<!DOCTYPE html>
<html>
<head>
	<title>Register</title>

	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<?php 
	// Retrive the Request Data
	$reqRaw = file_get_contents('php://input');
	if($reqRaw !=== false){
		// Convert Request JSON data to associative Object
		$reqJson = json_decode($reqRaw, true);

		// Extract Username from JSON Request
		$username = $reqJson["username"];
		$password = $reqJson["password"];
		$mail = $reqJson["email"];

		require_once('../../commons/db.php');
		new_user($username,$password,$mail);
		echo '{';
		echo '   "message":"Welcome '.$username.'!"';
		echo '}';	
	}
?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>