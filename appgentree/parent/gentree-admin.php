<?php require('../classes.php'); ?>
<!-- 
/*******************************************************************************
* File Name        : gentree-admin.php                                                     
* File Description : add promocode using this file.Access only on admin.                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->


 <?php 
  if(isset($_SESSION['admintime']))
 {
 	redirect("/parent/updatepromocode.php");
 }
if($_POST['submit']=='Save')
{
	$check=$db->get_results("SELECT * FROM admin where admin_username='".$_POST['username']."' and admin_password='".md5(SALT.$_POST['password'])."'");
	if(count($check)>0)
	{
		$_SESSION['admintime']='admin_time';
		redirect("/parent/updatepromocode.php");		
	}else
	{
		redirect("/parent/gentree-admin.php?error=1");
	}
}
?>

<!-- 
    register.php
    Purpose: Header

    @author Simsam
    @version 1.0 7/11/2016
 -->
<!DOCTYPE html>

<html lang="en">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<link rel="canonical" href="">
		<meta name="robots" content="index,follow" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />

		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/validation.js"></script>
	</head>
	<body>
	
		<div id="wrapper">
			<div id="header" class="" style="background-color:white;z-index:1000;">
				
			</div>
		</div>	

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
				<div class="container">
					<div class="row">
						<div class="" >
							<div class="tableT">
								<div class="tableC">
									<div class="contentC">
										<div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px 30px;background-color:white;">
										
										<form class=""  method="post">
									      	<h3 class="center_normal">Admin-Login</h3>
									      	<div class="form-group">
									      		 <div class="icon-addon addon-md">
								                    <input type="text" placeholder="Admin Username" name="username" class="form-control" id="username" required>
								                    <label for="input-username" class="glyphicon glyphicon-user" rel="tooltip" title="email"></label>
								                </div>
									      	</div>
									      	<div class="form-group">
									      		<div class="icon-addon addon-md">
									      			<input type="password" placeholder="Admin Password" name="password" class="form-control" id="password" required>
									      			<label for="input-password" class="glyphicon glyphicon-lock" rel="tooltip" title="Password"></label>
									      		</div>
									      	</div>
									      	<?php
										      	if(isset($_GET['error']))
										      	{
										      	?>
										      	<span style="color:#b8071b" id="email-error"><i class="icon-warning-sign"></i>&nbsp;invalid username and password</span>
										    <?php } ?>

										    

									      	<div class="form-group" align="right">
									      		<button type="submit" name="submit" value="Save" class="btn btn-danger" >Login</button>
									      	</div>
									      	
									    </form>
									   
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	<footer>
			<section class="footer-section">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span class="copyright"><br>&copy;&nbsp;Copyright 2016 GenTree Solutions, LLC<!-- <sup>
								<span class="fa-stack" style="font-size:12px;">
								  	<i class="fa fa-circle fa-stack-2x"></i>
								  	<i class="fa fa-trademark fa-stack-1x fa-inverse"></i>
								</span>
							</sup> -->, All rights reserved.</span> 
							
							
						</div>
					
					</div>
				</div>
			</section>
		</footer>
		
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
        
        <script type="text/javascript" src="assets/js/scripts.js"></script>
   

	</body>
</html>
	<!-- <script type="text/javascript" src="assets/js/backstretch.js"></script>
	<script type="text/javascript">
		$("#wrapper").backstretch("images/bg_without_bear.png");
	</script> -->
	<style type="text/css">
		#wrapper{
			background-image: url('images/bg_without_bear.png');
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
