<?php
require_once('mail/class.phpmailer.php');?>
<!-- 
/*******************************************************************************
* File Name        : login.php                                                     
* File Description : Login to see view reports/updateprofile                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->



<?php 


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

if(isset($_SESSION['user_id']))
{
	redirect('/view-report-listing/?userid='.md5($_SESSION['user_id']));
}

if($_POST['submit']=='save')
{
	$check=$db->get_results("SELECT * FROM ".TABLE_PARENT." where user_email='".$_POST['username']."' and user_password='".md5(SALT.$_POST['password'])."'");
	if(count($check)>0)
	{
		$_SESSION['user_id']=$check[0]->user_id;
		redirect("/view-report-listing/?userid=".md5($check[0]->userd_id));
	}else
	{
		redirect("/login/?error=1");
	}
}

// Email Send forget password
if($_POST['fsubmit']=='Save')
{
	$check_user=$db->get_results("SELECT * FROM ".TABLE_PARENT." where user_email='".$_POST['forget_email']."'");
	if(count($check_user)>0)
	{
		$token=str_shuffle(substr(md5($check_user[0]->user_id), 0,20));
		$data_token=array(
			"token"=>$token,
		);
		$table_token=TABLE_FORGET_TOKEN;
		$insert_id = $db->insert($table_token, $data_token);
	    $insert_id = $db->insert_id;
		// Mail to user
        $to=$check_user[0]->user_email;
        $subject="Here is the link to reset your password";
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

					<div style="margin:20px 30px 20px 30px;line-height:21px">
						<div style="font-size:13px;color:#333333"><strong>Hi '.$check_user[0]->user_firstname.' '.$check_user[0]->user_lastname.',</strong>
						</div><br>
						<div style="font-size:13px;color:#333;">
							You recently requested a password reset. To change your GenTree Discover password,<br> please <a style="" href="'.SITE_URL.'change-password-bymail/?userid='.md5($check_user[0]->user_id).'&token='.$token.'">Click the link here</a> to complete the process.<br><br>
						</div>
						
						<span style="font-size:13px;color:#333;">
							If you did not make this request, please contact <a href="mailto:service@gentreediscover.com">service@gentreediscover.com</a>.
						</span>
					</div>
			';
    if(smtpmailer($to, "service@gentreediscover.com", "GenTree Discover", $subject, $message))
    {
       // echo json_encode($data);
        redirect("/login/?mailsuccess=1");
    }
	}else
	{
		redirect("/login/?mailerror=1");
	}
}

?>
	<style type="text/css">
		.form-control {
		    font-family: "Open Sans","Cabin",Arial,sans-serif!important;
		    border-radius: 0;
		    border-left: 2px solid green;
		}

		.icon-addon {
		    position: relative;
		    color: #555;
		    display: block;
		}

		.icon-addon:after,
		.icon-addon:before {
		    display: table;
		    content: " ";
		}

		.icon-addon:after {
		    clear: both;
		}

		.icon-addon.addon-md .glyphicon,
		.icon-addon .glyphicon, 
		.icon-addon.addon-md .fa,
		.icon-addon .fa {
			color: #aaa;
		    position: absolute;
		    z-index: 2;
		    left: 10px;
		    font-size: 14px;
		    width: 20px;
		    margin-left: -2.5px;
		    text-align: center;
		    padding: 12px 0;
		    top: 1px
		}

		.icon-addon.addon-lg .form-control {
		    line-height: 1.33;
		    height: 46px;
		    font-size: 18px;
		    padding: 10px 16px 10px 40px;
		}

		.icon-addon.addon-sm .form-control {
		    height: 30px;
		    padding: 5px 10px 5px 28px;
		    font-size: 12px;
		    line-height: 1.5;
		}

		.icon-addon.addon-lg .fa,
		.icon-addon.addon-lg .glyphicon {
		    font-size: 18px;
		    margin-left: 0;
		    left: 11px;
		    top: 4px;
		}

		.icon-addon.addon-md .form-control,
		.icon-addon .form-control {
		    padding-left: 30px;
		    float: left;
		    font-weight: normal;
		}

		.icon-addon.addon-sm .fa,
		.icon-addon.addon-sm .glyphicon {
		    margin-left: 0;
		    font-size: 12px;
		    left: 5px;
		    top: -1px
		}

		/*.icon-addon .form-control:focus + .glyphicon,
		.icon-addon:hover .glyphicon,
		.icon-addon .form-control:focus + .fa,
		.icon-addon:hover .fa {
		    color: #2580db;
		}*/
	</style>
	
			<!-- landing page content -->
			<section class="app_landing" id="content_height">
				<div id="forget-password" style="z-index:10000;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content" >

							<!-- Modal Header -->
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h2 style="font-weight:200;" class="modal-title text-center" id="myModalLabel">What's my password?</h2>
							</div>
							<form method="POST" >
							<!-- Modal Body -->
							<div class="modal-body" align="center">
								<p>If you have forgotten your password you can reset here.</p>
								<div class="form-group">
									<input style="padding:5px 10px;" type="email" id="forget_email" name="forget_email" placeholder="E-mail Address">
								</div>
								
							</div>

							<!-- Modal Footer -->
							<div class="modal-footer" style="text-align:center;">
								<button type="submit" name="fsubmit" value="Save" id="forgetpassbtn" class="btn btn-danger">Send</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="" >
							<div class="tableT">
								<div class="tableC">
									<div class="contentC">
										<div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px 30px;background-color:white;">
											<form class=""  method="post">
										      	<h3 class="center_normal">Login to your account</h3>
										      	<div class="form-group">
										      		 <div class="icon-addon addon-md">
									                    <input type="text" placeholder="Email Address" name="username" class="form-control" id="input-username">
									                    <label for="input-username" class="glyphicon glyphicon-user" rel="tooltip" title="email"></label>
									                </div>
										      	</div>
										      	<div class="form-group">
										      		<div class="icon-addon addon-md">
										      			<input type="password" placeholder="Password" name="password" class="form-control" id="input-password">
										      			<label for="input-password" class="glyphicon glyphicon-lock" rel="tooltip" title="email"></label>
										      		</div>
										      	</div>
										      	<?php
										      	if(isset($_GET['error']))
										      	{
										      	?>
										      	<span style="color:#b8071b" id="email-error"><i class="icon-warning-sign"></i>&nbsp;invalid username and password</span>
										      	<?php } ?>
										      	<div class="form-group" >
										      		<a data-toggle="modal" data-target="#forget-password">Forgot Password!</a>
										      		<button type="submit" value="save" name="submit" class="btn btn-danger pull-right" >Login</button>
										      	</div>
										    </form>
										</div>
										<?php
										      	if(isset($_GET['mailsuccess']))
										      	{
										      	?>
										      	<span style="color:#449d44;padding-left: 32px;" ><i class="icon-warning-sign"></i>&nbsp;Email was sent successfully.</span>
										      	<?php } ?>

										 <?php
										      	if(isset($_GET['mailerror']))
										      	{
										      	?>
										      	<span style="color:#b8071b;padding-left: 32px;" ><i class="icon-warning-sign"></i>&nbsp;Invalid Email</span>
										      	<?php } ?>     	
									    <div class="col-md-12 col-sm-12 col-xs-12" style="border-top:1px solid #ddd;padding:20px 30px;background-color:white;">
									    	Don't have an account!<br>
									    	<a class="font-18" href="/signup">Purchase Now</a>
									    </div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<!-- <script type="text/javascript" src="assets/js/backstretch.js"></script>
	<script type="text/javascript">
		$("#wrapper").backstretch("images/bg_without_bear.png");
	</script> -->
	<style type="text/css">
		#wrapper{
			background-image: url('images/bg_without_bear.png');
			background-size: cover;
		}
	</style>
	<script type="text/javascript">
    function resize()
    {
        var heights = window.innerHeight;

        document.getElementById("wrapper").style.minHeight = (heights-85) + "px";
        // document.getElementById("content_height").style.height = (heights-216) + "px";
    }
    resize();
    window.onresize = function() {
        resize();
    };
</script>
