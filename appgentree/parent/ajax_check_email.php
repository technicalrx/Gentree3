<?php
require('../classes.php');
/*******************************************************************************
* File Name        : ajax_check_email.php                                                     
* File Description : using this code check email is present in database in signup process                                                               
* Author           : SimSam                                                              
*******************************************************************************/
if(isset($_POST['search']))
{
    $check=$db->get_results("SELECT * FROM ".TABLE_PARENT." WHERE user_email='".$_GET['email']."'");
    if(count($check)>0)
	    echo '1';
	else
		echo '0';
}
else
{
	echo '0';
}
?>