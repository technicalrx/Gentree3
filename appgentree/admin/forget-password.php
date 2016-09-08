<?php
require ("../classes.php");

 ?>
 <html>
<head>
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/css/metro.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
   <link href="assets/css/style_responsive.css" rel="stylesheet" />
   <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   <link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body class="login">
	<div class="container container-closer" style="background-color:transparent;padding:20px 40px 25px;border-bottom-left-radius:4px;border-bottom-right-radius:4px;">
		<div class="row-fluid">
			<div class="span8"><a style="color: white;text-decoration: none;font-size: 25px;" href="../index.php">GenTree</a></div>
			<div class="span2"><a style="color: white;text-decoration: none;font-size: 20px;padding: 20px;background-color: #6E00FF;" href="index.php">Login</a></div>
			<div class="span2"><a style="color: white;text-decoration: none;font-size: 20px;padding: 20px;background-color: #6E00FF;" href="../register">Register</a></div>
		</div>
	</div>
	<div class="container container-closer" style="background-color:white;padding:0 40px 25px;border-bottom-left-radius:4px;border-bottom-right-radius:4px;">
		<div class="row-fluid">
			<div class="span12 padding-0">
				<div class="span12" >

	              <p>  
	              	<h2>
	                Can't sign in? Forget your password ?
	                </h2>
	                Enter your email address below and we'll send you password reset instructions.
	                
	                <br>
	                
	                <h3>Enter your email address</h3>
	                </p>
	                 <form action="forgetpassword_redirect.php"  method="post" enctype="multipart/form-data">
	                 	
						<div class="control-group">
							<div class="controls">
								<input type="text" name="email" class="m-wrap span6" placeholder="Email Address" required autofocus>
							  <span class="input-group-addon" id="basic-addon2">abc@example.com</span>
							</div>
							  
						</div>
						
						   <button type="submit" style="margin-top:30px" class="btn">Send Me Reset Instructions</button>
					 </form>	   
              </div>
              <div class="row-fluid">
              	<div class="span11" >
              	<div class="alert alert-warning" role="alert">
              		<h4>A note about spam filters</h4>
              			If you dont get an email from us within a few minutes  please be sure to check 
              			your spam filter. <b>Email will be coming from support@xpertmoms.com</b>
              	</div>
              </div>
              </div>
              
			</div>
		</div>
	</div>
	
	</body>
</html>