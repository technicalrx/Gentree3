<?php
session_start();
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();

if(isset($_POST['username']))//If a username has been submitted 
{
	$username = mysql_real_escape_string($_POST['username']);//Some clean up :)

	$check_for_username = mysql_query("SELECT userid FROM user_detail WHERE username='$username'");
	//Query to check if username is available or not 

		if(mysql_num_rows($check_for_username))
		{
			echo '1';//If there is a  record match in the Database - Not Available
		}
		else
		{
			echo '0';//No Record Found - Username is available 
		}

}

if(isset($_POST['email']))//If a username has been submitted 
{
$email = mysql_real_escape_string($_POST['email']);//Some clean up :)

	$check_for_mail = mysql_query("SELECT email FROM user_detail WHERE email='$email'");
	//Query to check if username is available or not 

	if(mysql_num_rows($check_for_mail))
	{
		echo '1';//If there is a  record match in the Database - Not Available
	}
	else
	{
		echo '0';//No Record Found - Username is available 
	}

}

if(isset($_POST['coupon']))
{
	$coupon = mysql_real_escape_string($_POST['coupon']);//Some clean up :)
   // $coupon="simsam";
	$check_for_coupon = mysql_query("SELECT * FROM coupon_code WHERE coupon_code='$coupon'");
	//Query to check if username is available or not 

	if(mysql_num_rows($check_for_coupon)>0)
	{
	  $row = mysql_fetch_array($check_for_coupon); 
	  $edate=$row['expiry_date'];
	  $expiry=strtotime($edate);
	  $today=date('Y-m-d');
	  $today=strtotime($today);
	  if($expiry >$today)
	  echo '0';	
	  else 
	  echo '1';
	  $_SESSION['pay']=false;
	}
	else
	{
		echo '1';//code is not present
		$_SESSION['pay']=true;
	}

}

?>