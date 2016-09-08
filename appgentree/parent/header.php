<!-- 
/*******************************************************************************
* File Name        : header.php                                                     
* File Description : All css and js file include from this file and header file include logo and purchase now and slogan text                                                  
* Author           : SimSam                                                              
*******************************************************************************/
 -->
<!DOCTYPE html>

<html lang="en">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<link rel="canonical" href="">
		<base href="<?=SITE_URL.'parent/'?>">
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
		<div id="redpattern">
			<div id="top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12 logo">
                            <a href="/home/"><img src="images/gentree-discover.png" alt="GenTree Discover"></a>
                        </div><!-- end col -->
                        <?php
						 			
						 	        $check_purchase_now_files=basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
						 	        //echo $check_purchase_now_files;
						 	        if( $check_purchase_now_files=='login' || $check_purchase_now_files=='' || $check_purchase_now_files=='home' )
						 	        {	?>
                        <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12 slogan">
                            Haven't purchased yet?
                        </div><!-- end purchase slogan -->
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="topbuttons">
                            <a href="/signup/">PURCHASE NOW</a>
                        </div><!-- end col -->
                        <?php }else{ ?>
                        <div class="col-lg-9 col-md-9 col-sm-7 col-xs-12 slogantwo">
							A revolutionary approach to maximizing your child's learning potential
						</div><!-- end slogantwo -->
						<?php } ?>
                    </div><!-- end row -->
                </div><!-- end container -->
            </div><!-- end top -->
			