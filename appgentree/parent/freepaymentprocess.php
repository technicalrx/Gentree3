<?php
require('../classes.php');
require_once('../mail/class.phpmailer.php');
/*
   ******************************************************************************
* File Name        : freepaymentprocess.php                                                     
* File Description : When amount zero using this file mail sent to user.                                                               
* Author           : SimSam                                                              
******************************************************************************
*/

// Mail 
define('GUSER', 'poojaarya627@gmail.com'); // GMail username
define('GPWD', 'Simsamvikrant11'); // GMail password

// User Detail 

 $user_id=$_GET['userid'];
 $userdetail=$db->get_results("select * from ".TABLE_PARENT." where md5(user_id)='".$user_id."'");
 $childetail=$db->get_results("select * from ".TABLE_CHILD." where md5(parent_id)='".$user_id."'");
 $childstr='';
 foreach ($childetail as $ch) {
     $childstr=$childstr.'<p 
     style="font-size:13px;color:#666666;padding:10px 10px;
     background-color:#fafafa;border:1px solid #dddddd;margin-top:0px">
     Child ID for '.ucfirst($ch->child_firstname).' '.ucfirst($ch->child_lastname).' : <b>'.$ch->child_username.'</b></p>';
 }

function smtpmailer($to, $from, $from_name, $subject, $body) { 
global $error;
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "localhost";
$mail->Username = GUSER;
$mail->Password = GPWD;          
$mail->SetFrom($from, $from_name);
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($to);
$mail->IsHTML(true);
if(!$mail->Send()) {
    $error = 'Mail error: '.$mail->ErrorInfo; 
    return false;
  } else {
    $error = 'Message sent!';
    return true;
  }
}

 // Mail to user
        $to=$userdetail[0]->user_email;
        $subject="IMPORTANT: Assessment Access Information";
        $message='
        <div dir="ltr" style="border:1px solid #f0f0f0;max-width:650px;font-family:Arial,sans-serif;color:#000000;margin:0 auto;">
            <div style="background-color:#f5f5f5;padding:10px 12px">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tbody>
                        <tr>
                            <td style="width:50%">
                                <span style="font:20px/24px arial">
                                    <a style="color:#777777;text-decoration:none" href="'.SITE_URL.'" target="_blank">GenTree Discover
                                    </a>
                                </span>
                            </td>

                            <td style="width:50%">
                                <span style="float:right;">
                                    <a href="'.SITE_URL.'" target="_blank" ><img style="border:0;vertical-align:middle;padding-left:10px;height:43px;width:150px;" src="'.SITE_URL.'parent/images/gentree-discover-small.png"
                                        alt="GenTree Discover" class="CToWUd">
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin:30px 30px 30px 30px;line-height:21px">
                <div style="font-size:14px;color:#333;">
                    <strong>Dear '.ucfirst($userdetail[0]->user_firstname).' '.ucfirst($userdetail[0]->user_lastname).',</strong>
                    <br>
                    Thank you for purchasing the GenTree Discover assessment. The link and activation codes to your child’s individual assessment are as follows: 
                </div>
                <br>
                <!-- <div style="font-size:14px;color:#333">
                    <a href="'.SITE_URL.'parent/login.php">LOG IN at GenTree Discover</a>
                </div>
                <br> -->
                <div style="font-size:14px;color:#333">
                    <a href="'.SITE_URL.'parentgentreeapp/">Link to the assessment</a>
                </div>
                <br>
                <div style="font-size:14px;color:#333;display:flex;">
                    <div style="width:50%;text-align:center;">
                        <strong><p style="font-size: 13px;color: #666666;padding: 10px 10px;background-color: #fafafa;border: 1px solid #dddddd;margin-top: 0px;">Parent/Teacher ID: '.$userdetail[0]->username.'</p></strong>
                    </div>
                    <div style="width:50%;text-align:center;">
                        <strong>'.$childstr.'</strong>
                    </div>
                </div>
                <br>
                <div style="font-size:14px;color:#333;">
                    IMPORTANT: Your codes will expire 7 days from today. A new purchase will be required to reactivate the assessment.
                </div>
                <br>
                <div style="font-size:14px;color:#333;">
                    To take the assessment:
                </div>
                <div style="font-size:14px;color:#333;">
                    <ul>
                        <li>Have the child in front of the computer or tablet ready to go</li>
                        <li>Click the link above to open the assessment landing page</li>
                        <li>Select to take the assessment in English or in Spanish</li>
                        <li>When prompted, key in (do not cut/paste) the IDs into the assessment login screen</li>
                        <li>The child is presented a welcome greeting from Max the Bear</li>
                        <li>Max the Bear will narrate the assessment, starting with a tutorial task</li>
                        <li>After the tutorial, the child will be prompted to complete a series of tasks. It should take no more than 10 minutes to complete.  </li>
                        <li>Upon completion, the Tailored Learning Profile and next-step action materials will be available in the Report Center</li>
                    </ul>
                </div>
                <div style="font-size:14px;color:#333;">
                    To access the Report Center: *
                </div>
                <div style="font-size:14px;color:#333;">
                    <ul>
                        <li>Click the link above to open the assessment landing page</li>
                        <li>Select View Report</li>
                        <li>Be sure to click any "Learn More" links displayed on your report to access supplemental next-step action materials</li>
                    </ul>
                </div>
                <div style="font-size:14px;color:#333;">
                    * Please note that you will also receive a link to your child’s Tailored Learning Profile via email.
                </div>
                <br>
                <div style="font-size:14px;color:#333;">
                    Thank you again for your purchase.
                </div>
                <br>
                <div style="font-size:14px;color:#333;">
                    Warm regards,
                </div>
                <div style="font-size:14px;color:#333;">
                    <i>The GenTree Discover Assessment Team</i>
                </div>
            </div>
        </div>

';
    if(smtpmailer($to, "service@GenTree.com", "GenTree Discover", $subject, $message))
    {
        redirect("/step3/");
    }
    else{
         redirect('/signup_purchase/?userid='.$user_id);
    }


?>