<?php
require ("../classes.php");

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title><?=SITE_TITLE?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/metro.css" rel="stylesheet" />
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style_responsive.css" rel="stylesheet" />
  <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
  <link href='https://fonts.googleapis.com/css?family=Cabin+Sketch' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<?php require ("common_file.php"); ?>
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="" style="width:100%;background-color:white;padding:20px 0;">
      <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
          <a style="" href="/teacher/home.php"><img style="width:250px;" class="img-responsive" src="../../../images/icon.png">
          </a>
        </div>
      </div>
  </div>
  <div class="logo" style="color:#35aa47; font-size:20px; font-weight:bold;">
  <br><br/> <span style="color:#FFF">Login page</span></div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical" id="loginform" action="admin_login_ajax.php?action=login" method="post">
      <h3 class="form-title">Login to your account</h3>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username/Email Address</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email Address" name="username" id="input-username"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password" id="input-password"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <a style="font-size: 16px;" href="#" data-target="#pwdModal" data-toggle="modal">Forgot Password!</a>
        <button type="submit" class="btn green pull-right" onClick="return login_function()">
        Login <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
      
    </form>
    <div>
      Don't have an account!<br>
      <a style="font-size: 18px;" href="/teacher/register.php">Register Here</a>
    </div>
    <!-- END LOGIN FORM -->
  </div>


<!--modal-->
<div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display:none">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h1 class="text-center">What's My Password?</h1>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                          
                          <p>If you have forgotten your password you can reset it here.</p>
                            <div class="panel-body">
                                <form action="forgetpassword_redirect.php"  method="post" >
                                    <div class="form-group">
                                        <input class="form-control input-lg" placeholder="E-mail Address" name="email" type="email" required>
                                    </div>
                                    <div class="form-actions">
                                    <input class="btn green" name="submit" value="send" type="submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>

  </div>
  </div>
</div>


  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->

  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="assets/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script>
  <script type="text/javascript">
  	function login_function() {
		if($("#input-username").val() == 0)
		{
			alertify.alert("Enter Username");
			$("#input-username").focus();
			return false;
		}
		if($("#input-password").val() == 0)
		{
			alertify.alert("Enter Password");
			$("#input-password").focus();
			return false;
		}
		jQuery(document).ready(function ($) {
			$("#loginform").submit(function (e) {
				$('#loading_div_show').fadeIn('slow');
				var formObj = $(this);
				var formURL = formObj.attr("action");
				if( window.FormData !== undefined ) {
					var formData = new FormData(this);
					$.ajax({
						url: formURL,
						type: "POST",
						data:  formData,
						mimeType:"multipart/form-data",
						contentType: false,
						cache: false,
						processData:false,
						success: function( data, textStatus, jqXHR ) {
							json_data = JSON.parse(data);
							if(json_data.Result == "0")
							{
								alertify.alert(json_data.Message);
                
							}
							else if(json_data.Result == "1")
							{
								alertify.alert(json_data.Message);
								window.location = 'dashboard.php';
							}
							setTimeout(function(){$('#loading_div_show').fadeOut('slow');}, 500);
              
						},
						error: function( jqXHR, textStatus, errorThrown ) {
						}
					});
					e.preventDefault();
				}
			});
		});
	}
<?php
  if($_GET['forget_pass']==1)
{
  ?>
  alertify.alert("Please check your mail box.");
  <?php
}
?>
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>