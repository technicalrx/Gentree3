<?php
//IMPORTANTE
header("Access-Control-Allow-Origin: *");
   // include db connect class
require_once 'db_connect.php';
 

// array for JSON response
$response;

// connecting to db
$db = new DB_CONNECT();

$name=$_POST['name'];
$dob=$_POST['dob'];
$result = mysql_query("SELECT * FROM iLSO_user WHERE user_name='$name' AND user_dob='$dob'") or die(mysql_error());
if (mysql_num_rows($result) > 0) 
{
	$response="success";
}
else
{
	$response="fail";
}
echo $response;
?>