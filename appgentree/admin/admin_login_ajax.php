<?php
require ("../classes.php");

//sending mail for forgot password

if($_GET['action'] == "forgot_password" && $_SERVER['REQUEST_METHOD'] == "POST")
{
	if(!$administrator_user->forgot_mail(sqlinj($_POST['email'])))
	{
		$ar = array("Result"=>0, "Message"=>"The Email is Not Exists");
		echo json_encode($ar);
	}
	else
	{
		$ar = array("Result"=>1, "Message"=>"Your New Password is Sent to your Mail Account.. Please Check Your Mail Account!!");
		echo json_encode($ar);
	}
}


//check the login detail and set the session
if($_GET['action'] == "login" && $_SERVER['REQUEST_METHOD'] == "POST")
{
	if(!$administrator_user->login(sqlinj($_POST['username']), sqlinj($_POST['password'])))
	{
		$ar = array("Result"=>0, "Message"=>"The password is not recognized.<br>Please try again.");
		echo json_encode($ar);
	}
	else
	{
		$ar = array("Result"=>1, "Message"=>"LoggedIn Successfully");
		echo json_encode($ar);
	}
}
?>