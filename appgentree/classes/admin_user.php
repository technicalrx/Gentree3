<?php

/**

 * for admin panel functions

 */



class admin_user {
	
	//For checking if admin mail is exists or not
	public function check_admin_mail($mail)
	{
		global $db;
		$mail = $db->get_results("select * from ".TABLE_TEACHER." where teacher_email = '".$mail."'");
		if(count($mail) > 0)
			return true;
		else
			return false;
	}
	
	//Send mail with new password
	public function forgot_mail($mail)
	{
		global $db;
		if(!$this->check_admin_mail($mail))
		{
			return false;
		}
		else{
			$mail = $db->get_results("select * from ".TABLE_TEACHER." where teacher_email = '".$mail."'");
			
			$newpass = generateRandomString(10);
			
			$db->get_results("Update ".TABLE_TEACHER." set teacher_password = '".md5(SALT.$newpass)."' where teacher_email = '".$mail[0]->teacher_email."'");
			
			$subject = 'Your New '.SITE_TITLE.' Admin Panel Password';
			$recevername = $fromname = $toname = SITE_TITLE.' Administrator';
			$tomail = $fromail = $mail[0]->teacher_email;
			
			$message = 'Dear '.$recevername. ' <br>
				Your New Admin Panel Password is : '.$newpass.' <br>
				Please Chaneafter Login to Admin Panel.
			';
			
			mailformat($subject, $recevername, $message, $tomail, $toname, $fromail, $fromname);
			return true;
		}
	}
	
	//for admin login
	public function login($username, $password)
	{
		global $db;
		$mail = $db->get_results("select * from ".TABLE_TEACHER." where teacher_email = '".$username."' and teacher_password = '".md5(SALT.$password)."'");
		if(count($mail) == 0)
		{
			return false;
		}
		else
		{
			$_SESSION['admin_panel'] = $mail[0]->teacher_id;
			return true;
		}
	}
	
	//Check if admin is login or not
	public function check_login()
	{
		if(isset($_SESSION['admin_panel']))
			return true;
		else
			return false;
	}
	
	//Admin panel logout
	public function logout()
	{
		unset($_SESSION['admin_panel']);
	}
}