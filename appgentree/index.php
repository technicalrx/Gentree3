<?php
require('classes.php');
$pages = get_url_params();
/*******************************************************************************
* Gentree Routing File for Teacher                                             *
*                                                                              *
* Author:  SimSam                                                              *
*******************************************************************************/
?>
<?php 

// include ("php/header.php"); 

// // Page routing for teacher
// switch($pages['page'])
// {
// 	case 'login': 
// 	     include("php/login.php"); 
// 	     break;

// 	case 'register': 
// 	     include("php/register.php"); 
// 	     break;

// 	case 'home': 
// 	     include("php/home.php");
// 	     break; 

// 	case '': 
// 	     include("php/home.php");
// 	     break;

// 	default : 
// 		 include("php/404.php");
// 		 break;
// }

include ("parent/header.php"); 

// Page routing for Parent
switch($pages['page'])
{
	case 'login': 
	     include("parent/login.php"); 
	     break;

	case 'signup': 
	     include("parent/signup.php"); 
	     break;

	case 'signup_purchase':
		  include("parent/signup_purchase.php"); 
		  break;

	case 'step2': 
	     include("parent/step2.php");
	     break; 

	case 'step3': 
	     include("parent/step3.php");
	     break;     

	case 'edit-profile': 
	     include("parent/edit-profile.php");
	     break;

	case 'view-report-listing': 
	     include("parent/view-report-listing.php");
	     break;
	 
	case 'report': 
	     include("parent/report.php");
	     break;

	case 'repurchase': 
	     include("parent/repurchase.php");
	     break;
	         
	case 'repurchase_payment_summary': 
	     include("parent/repurchase_payment_summary.php");
	     break;

	case 'change-password-bymail': 
	     include("parent/change-password-bymail.php");
	     break;

	case 'logout': 
	     include("parent/logout.php");
	     break;

	case 'spanish-app':
		 include("parent/spanish-app.php");
		 break;         

	case 'home': 
	     include("parent/index.php");
	     break;

	case '': 
	     include("parent/index.php");
	     break;     

	default : 
		 include("parent/404.php");
		 break;
}

include ("parent/footer.php"); 

?>
