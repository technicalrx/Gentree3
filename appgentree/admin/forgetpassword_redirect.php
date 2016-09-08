<?php
require_once('../mail/class.phpmailer.php');
require ("../classes.php");

define('GUSER', 'poojaarya627@gmail.com'); // GMail username
define('GPWD', 'Simsamvikrant11'); // GMail password

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

$email= $_POST['email'];
$eid = $db->get_results("select * from ".TABLE_TEACHER." where teacher_email = '".strtolower($_POST['email'])."'");
//print_r($eid);
$e_id=$eid[0]->teacher_id;
$pass=$eid[0]->teacher_password;
    $to = $email;
    $subject  ="Change Password at GenTree Discover";
    $message  = '<center>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#f2f2f2;width:100%!important;padding:0;margin:0;height:100%!important;border-collapse:collapse!important">
        <tbody><tr>
          <td align="center" valign="top" style="width:100%!important;padding:50px;margin:0;height:100%!important">
            
            <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #dddddd;border-bottom-color:#cccccc;max-width:500px!important;border-collapse:collapse!important">
              <tbody><tr>
                <td align="center" valign="top">
                  
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:1px solid #cccccc;border-top:1px solid #ffffff;background-color:#f8f8f8;border-collapse:collapse!important">
                    <tbody><tr>
                      <td valign="top" style="text-align:center;padding-left:20px;padding-bottom:30px;padding-right:20px;padding-top:30px;line-height:150%;font-size:15px;font-family:Helvetica;color:#424f59">
                        <h1 style="text-align:center;margin-left:0;margin-bottom:10px;margin-right:0;margin-top:0;letter-spacing:normal;line-height:100%;font-weight:normal;font-style:normal;font-size:26px;font-family:Helvetica;display:block;color:#424f59!important">Reset Your Password</h1>
                        <br>
                        <a href="mailto:'.$email.'" target="_blank">'.$email.'</a>, Please click and reset your password
                      </td>
                    </tr>
                    <tr width="100%">
                      <td align="center" valign="top">
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse!important">
                          <tbody><tr height="47">
                            <td align="center" valign="top">
                              
                              <table border="0" cellpadding="0" cellspacing="0" width="65%" style="border-collapse:collapse!important">
                                <tbody><tr>
                                  <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="280" style="border-radius:4px;background-color:#00DD8B;width:100%!important;border-collapse:separate">
                                      <tbody><tr>
                                        <td align="center" valign="middle" style="text-align:center;line-height:100%;font-weight:normal;font-size:20px;font-family:Helvetica;color:#ffffff">
                                          
                                            <a href="http://brolance.com/admin/change_password_bymail.php?teacherid='.$e_id.'&pass='.$pass.'" style="text-decoration:none;font-size:20px;font-family:Helvetica;display:block;color:#ffffff;padding:15px!important" target="_blank">Click here</a>
                                          
                                        </td>
                                      </tr>
                                    </tbody></table>
                                    
                                  </td>
                                </tr>
                              </tbody></table>
                              
                            </td>
                          </tr>
                        </tbody></table>
                        
                      </td>
                    </tr>
                    <tr width="100%">
                      <td align="center" valign="top">
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="70%" style="border-collapse:collapse!important">
                          <tbody><tr>
                            <td valign="top" style="text-align:center;padding-left:20px;padding-bottom:30px;padding-right:20px;padding-top:30px;font-family:Helvetica;color:#8a9ba8;line-height:13px;font-size:11px">Please do not reply directly to this email. This email was sent from a notification-only address that cannot accept incoming email. If you have questions or need assistance, ask us here., please visit <a href="http://brolance.com/" target="_blank">GenTree Discover</a>
                            </td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                  </tbody></table>
                  
                </td>
              </tr>
            </tbody></table>
            
          </td>
        </tr>
      </tbody></table>
    </center>';
// $headers  = 'From:support@catalystimpact.com'."\r\n" .
//             'Reply-To: support@catalystimpact.com' . "\r\n" .
//             'MIME-Version: 1.0' . "\r\n" .
//             'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
//             'X-Mailer: PHP/' . phpversion();
// echo mail($to, $subject, $message, $headers);
 if(smtpmailer($to, "service@GenTree.com", "GenTree Discover", $subject, $message))
  redirct("index.php?forget_pass=1");
?>