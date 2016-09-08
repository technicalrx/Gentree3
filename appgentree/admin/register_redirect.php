<?php
require ("../classes.php");
require("../teacher/recptcha.php");

   $secret = "6LdluR8TAAAAAK_B00tnGW9jMZaQ-dqTuSxFAQ9b";
  
  // empty response
  $response = null;
  
  // check secret key
  $reCaptcha = new ReCaptcha($secret);


  if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
    
      $_SERVER["REMOTE_ADDR"],
      $_POST["g-recaptcha-response"]
    );
    
  }



$firstname=$_POST['fname'];
$lastname=$_POST['lname'];
$email=$_POST['email'];
$password=$_POST['password1'];

$id=$_GET['teacherid']; 
 if ($response != null && $response->success)
  {
		$eid = $db->get_results("select * from ".TABLE_TEACHER." where teacher_email = '".strtolower($_POST['email'])."'");
		if(count($eid)>0)
		{
			redirct("../register?emailalredy=1");
		}	
		else
		{	
		$data = array(
				
					"firstname" 			=>	$firstname,  
					"lastname" 				=>	$lastname,
					"teacher_email" 		=>	$email,
					"teacher_password" 		=>	md5(SALT.$password),
					"teacher_username" 			=>	RandomString($firstname,$lastname),
			);
			$table = TABLE_TEACHER;
			$db->insert($table, $data);
			$insert_id = $db->insert_id;
			$_SESSION['admin_panel'] = $insert_id;

			redirct("/admin/dashboard.php");
		}
}
else
{
   redirect("/teacher/register.php?error=2");
}	
?>