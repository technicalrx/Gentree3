<?php
require('../classes.php');
require_once('../mail/class.phpmailer.php');
/*
   /*******************************************************************************
* File Name        : repurchase_payment.php                                                     
* File Description : Repurchase payment transcation using this file.                                                               
* Author           : SimSam                                                              
*******************************************************************************/


require('paypal/PaypalPro.php');

// Mail 
define('GUSER', 'service@gentreediscover.com'); // GMail username
define('GPWD', 'GenTree100%'); // GMail password

// User Detail 

 $user_id=$_GET['userid'];
 $userdetail=$db->get_results("select * from ".TABLE_PARENT." where md5(user_id)='".$user_id."'");
 $childetail=$db->get_results("select * from ".TABLE_CHILD." where md5(parent_id)='".$user_id."'");
 $childstr='';
 foreach ($childetail as $ch) {
     $childstr=$childstr.'<p style="font-size:13px;color:#666666;padding:10px 10px;background-color:#fafafa;border:1px solid #dddddd;margin-top:0px">Child ID for '.ucfirst($ch->child_firstname).' '.ucfirst($ch->child_lastname).' : <b>'.$ch->child_username.'</b></p>';
 }

function smtpmailer($to, $from, $from_name, $subject, $body) { 
global $error;
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "mail.gentreediscover.com";
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


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $payableAmount = $_POST['amount'];
    $nameArray = explode(' ',$_POST['name_on_card']);
    
    //Buyer information
    $firstName = $nameArray[0];
    $lastName = $nameArray[1];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $countryCode = $_POST['country'];   
    $address=$_POST['address'];
    $state=$_POST['state'];
    $email=$_POST['payeremail'];
    $userid=$userdetail[0]->user_id;
    //Create an instance of PaypalPro class
    $paypal = new PaypalPro;
    
    //Payment details
    $paypalParams = array(
        'paymentAction' => 'Sale',
        'amount' => $payableAmount,
        'currencyCode' => 'USD',
        'creditCardType' => $_POST['card_type'],
        'creditCardNumber' => trim(str_replace(" ","",$_POST['card_number'])),
        'expMonth' => $_POST['expiry_month'],
        'expYear' => $_POST['expiry_year'],
        'cvv' => $_POST['cvv'],
        'firstName' => $firstName,
        'lastName' => $lastName,
        'city' => $city,
        'zip'   => $zipcode,
        'countryCode' => $countryCode,
    );
    $response = $paypal->paypalCall($paypalParams);
    $paymentStatus = strtoupper($response["ACK"]);
    if ($paymentStatus == "SUCCESS")
    {
        $data['status'] = 1;
        
        // Activation Key
        $cdata=$db->get_results("Select * from ".TABLE_CHILD." where parent_id='".$userdetail[0]->user_id."'");
        foreach ($cdata as $ctemp)
        {
                $data_c=array(
                    "child_test_count" => '1',
                    );
                $where=array(
                    "child_id"=> $ctemp->child_id,
                    );
                $table=TABLE_CHILD;
                $db->update($table,$data_c,$where);
        }

        $transactionID = $response['TRANSACTIONID'];
        //Update order table with tansaction data & return the OrderID
        //SQL query goes here..........
        // Payment update
        $datasubmit=array(
            "payment_user_email"=>$email,
            "payment_user_id"=>$userid,
            "payment_amount"=>$payableAmount,
            "payment_transaction_id"=>$transactionID,
            "payment_status"=>$data['status'],
            "payment_time"=>$response['TIMESTAMP'],
            "payment_address"=>$address,
            "payment_city"=>$city,
            "payment_state"=>$state,
            "payment_country"=>$countryCode,
            "payment_zipcode"=>$zipcode,
            );
        $table="payment_transaction";
        $OrderID = $db->insert($table, $datasubmit);

        $data['transactionID']=$transactionID;
        $data['orderID'] = $OrderID;
        $data['time']=$response['TIMESTAMP'];


        $activation_key=str_shuffle($_GET['userid']);
        $activation_key=substr($activation_key, 0,8);

        $date_validity = date('Y-m-d', strtotime("+7 days"));


        $data_user = array(
        "user_activation_key" => $activation_key,
        "user_activation_key_validity"=>$date_validity ,
        );
        $table = TABLE_PARENT;
        $where = array('user_id' => $userdetail[0]->user_id,);
        $db->update($table, $data_user, $where); 

        // Mail to user
        $to=$userdetail[0]->user_email;
        $subject="IMPORTANT: Assessment Access Information";
        $message='<div dir="ltr" style="border:1px solid #f0f0f0;max-width:650px;font-family:Arial,sans-serif;color:#000000;margin:0 auto;">
            <div style="background-color:#f5f5f5;padding:10px 12px">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tbody>
                        <tr>
                            <td style="width:50%">
                                <span style="font:20px/24px arial">
                                    <a style="color:#777777;text-decoration:none" href="http://brolance.com" target="_blank">GenTree Discover
                                    </a>
                                </span>
                            </td>

                            <td style="width:50%">
                                <span style="float:right;">
                                    <a href="http://brolance.com" target="_blank" ><img style="border:0;vertical-align:middle;padding-left:10px;height:43px;width:150px;" src="http://brolance.com/phase2/images/gentree-discover-small.png"
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
                    Thank you for purchasing another GenTree Discover assessment! The link and activation codes to your child&#39;s individual assessment are as follows: 
                </div>
                <br>
                <!-- <div style="font-size:14px;color:#333">
                    <a href="http://brolance.com/phase2/login.php">log in at GenTree Discover</a>
                </div>
                <br> -->
                <div style="font-size:14px;color:#333">
                    <a href="http://brolance.com/parentgentreeapp/">Link to the assessment</a>
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
                    Here is a quick reminder of how the process works:
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
                    * Please note that you will also receive a link to your child&#39;s Tailored Learning Profile via email.
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
            if(smtpmailer($to, "service@gentreediscover.com", "GenTree Discover", $subject, $message))
            {
                echo json_encode($data);
            }
            }else{
                 $data['status'] = 0;
                 echo json_encode($data);
            }

    
        }
?>