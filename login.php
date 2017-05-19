<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-18
 * Time: 13:35
 */
require_once ('../../commons/db.php');

// Retrive the Request Data
$reqRaw = file_get_contents('php://input');

// Convert Request JSON data to associative Object
$reqJson = json_decode($reqRaw, true);
if(isset($reqJson)) {
// Extract Username from JSON Request
    $username = $reqJson["username"];
    $password = $reqJson["password"];
    if(validate_user($username,$password)){
        echo '{';
        echo '   "status":"valid"';
        echo '}';
    }else{
        echo '{';
        echo '   "status":"invalid"';
        echo '}';
    }
}else{
    print("<h1>Oops !</h1><br>Looks like you got somewhere you didn't meant to. <a href='/index.php'>Go back</a> ");
}
?>