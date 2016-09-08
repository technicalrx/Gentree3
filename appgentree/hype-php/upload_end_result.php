<?php
//IMPORTANTE
header("Access-Control-Allow-Origin: *");

//class add for db connect
require('classes.php');
require_once('../mail/class.phpmailer.php');
// array for JSON response
$response = array();

$result_id=$_POST['result'];

$data = array("result_scene_status" =>	'0',);
	$table = TABLE_RESULT;

		$where = array(
			"result_id" => $result_id,
		 );
		$updated=$db->update($table, $data, $where); 

		$response["status"]="success";


// Mail 
define('GUSER', 'service@gentreediscover.com'); // GMail username
define('GPWD', 'GenTree100%'); // GMail password

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
$resultidsend=md5($result_id);
// Using result Id get all detail
		$result_detail=$db->get_results("SELECT * from ".TABLE_RESULT." where result_id='".$result_id."'");
		if($result_detail[0]->parent_id!='0')
		{
			$parent_detail=$db->get_results("SELECT  * FROM ".TABLE_PARENT." where user_id='".$result_detail[0]->parent_id."'");
			$child_detail=$db->get_results("SELECT  * FROM ".TABLE_CHILD." where child_id='".$result_detail[0]->child_id."'");

			$to=$parent_detail[0]->user_email;
        $subject="Your child's Tailored Learning Profile is ready";
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
                    <strong>Hi '.$parent_detail[0]->user_firstname.' '.$parent_detail[0]->user_lastname.',</strong>
                </div>
                <div style="font-size:14px;color:#333;">
                    Congratulations! Your child&#39;s GenTree Discover assessment is complete. To access your child&#39;s Tailored Learning Profile, click the following link:
                </div><br>
                <div style="font-size:14px;color:#333;">
                    <a href="'.SITE_URL.'parent/download-report/file/child-report.php?resultid='.$resultidsend.'&previous=---">'.ucfirst($child_detail[0]->child_firstname).' '.$child_detail[0]->child_lastname.'&#39;s assessment report</a>
                </div><br>
                <div style="font-size:14px;color:#333;">
                    Your child&#39;s Tailored Learning Profile includes:
                    <ul>
                        <li>Assessment results identifying your child&#39;s optimal learning path and social preferences</li>
                        <li>Suggestions for improving your child&#39;s problem-solving skills</li>
                        <li>Take-Action Steps for Success: be sure to click the "Learn More" links noted throughout the report to access documents that can be downloaded, saved, or printed. </li>
                    </ul>
                </div><br>
                <div style="font-size:14px;color:#333;">
                    Please note:  you may forward the Tailored Learning Profile link to family members, caregivers, and/or teachers. You may not use this information for public resale or any other commercial benefit without prior written authorization. 
                </div><br>
                <div style="font-size:14px;color:#333;">
                    If you have questions, please email <a href="mailto:service@gentreediscover.com">service@gentreediscover.com</a>.  
                </div><br>
                <div style="font-size:14px;color:#333;">
                    Warm regards,
                </div>
                <div style="font-size:14px;color:#333;">
                    <i>The GenTree Discover Assessment Team</i>
                </div>
            </div>
        </div>

';
			if(smtpmailer($to, "service@gentreediscover.com", "GenTree Discover", $subject, $message))
			    {
			    	$str="success";
			    }else
			    {
			    	$str="fail";
			    }	
		}

// Mail to user
        


echo json_encode($response);
?>