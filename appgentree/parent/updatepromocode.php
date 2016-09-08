<?php require('../classes.php'); 
  /*******************************************************************************
* File Name        : updatepromocode.php                                                     
* File Description : Updatepromocode file                                                               
* Author           : SimSam                                                              
*******************************************************************************/

?>

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

		 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
		  <link rel="stylesheet" href="/resources/demos/style.css">
		  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
		  
		<style type="text/css">
			.navbar{
				min-height: 60px;
			}
		</style>
	</head>
	<body>
	
		<div id="wrapper">
			<div id="header" class="" style="background-color:white;z-index:1000;">
				<!-- TOP NAV -->
				<header id="topNav">
					<div class="container">
						<nav class="navbar ">
						    <!-- Brand and toggle get grouped for better mobile display -->
					    	<div class="navbar-header">
						      	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							        <span class="sr-only">Toggle navigation</span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
						      	</button>
							    <a class="navbar-brand" href="/phase2">
							      	<img class="img-resposine" src="images/gentree-discover.png">
							    </a>
						    </div>
						</nav>
					</div>
				</header>
			</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="row">
 <?php
 if(!isset($_SESSION['admintime']))
 {
 	redirect("/phase2/gentree-admin.php");
 }
if($_POST['submit'] == "Save")
{
	// $start_day = ((strlen($_POST['start_day'])>1)?$_POST['start_day']:'0'.$_POST['start_day']);
	// $start_month = ((strlen($_POST['start_month'])>1)?$_POST['start_month']:'0'.$_POST['start_month']);
	// $start_time = strtotime($start_month.'/'.$start_day.'/'.$_POST['start_year']);
	// $str_start_time = date('Y-m-d',$start_time);

	// $end_day = ((strlen($_POST['end_day'])>1)?$_POST['end_day']:'0'.$_POST['end_day']);
	// $end_month = ((strlen($_POST['end_month'])>1)?$_POST['end_month']:'0'.$_POST['end_month']);
	// $end_time = strtotime($end_month.'/'.$end_day.'/'.$_POST['end_year']);
	// $str_end_time = date('Y-m-d',$end_time);

	$start_time = strtotime($_POST['datepicker']);
	$str_start_time = date('Y-m-d',$start_time);

	$end_time = strtotime($_POST['datepicker2']);
	$str_end_time = date('Y-m-d',$end_time);

	$data = array(
	    "promotion_code"=>$_POST['promocode'],
		"promotion_code_percentage" => $_POST['percentage_amount'],
		"promotion_code_flat" => $_POST['flat_amount'],
		"promotion_code_start_date" => $str_start_time,
		"promotion_code_end_date" => $str_end_time,
	);
 // Submit Form
   	$table = 'promotion_code';
	$insert_id = $db->insert($table, $data);
	$insert_id = $db->insert_id;
}
?>   
<form role="form"  action=""   method="POST" enctype="multipart/form-data">
											<div class="col-md-12 col-sm-12 col-xs-12 right-form">
												<!-- parent profile starts -->
												<h2 class="color-blue">Add Promo Code</h2>
												<div class="row">
													<div class="form-group">
														<div class="col-md-2 col-sm-2">
															<label class="input">Promo Code</label>
															<input type="text" class="form-control" id="promocode" name="promocode"  required="">
															
														</div>
														<div class="col-md-2 col-sm-2">
															<label class="input">Flat Discount ($)</label>
															<input type="text" class="form-control" id="flat_amount" name="flat_amount" value='0'>
															
														</div>
														<div class="col-md-2 col-sm-2">
															<label class="input">Percentage Discount (%)</label>
															<input type="text" class="form-control" id="percentage_amount" name="percentage_amount" value='0'>
															
														</div>
														
														<div class="col-md-2 col-sm-2">
																			<label class="input">Start Date (MM-DD-YYYY)</label><br>
																			<input class="form-control" type="text" name="datepicker" id="datepicker" placeholder="MM-DD-YYYY" required>
																			<!-- <INPUT NAME="start_month" id="start_month"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="01" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="12" placeholder="01" required >-
																			<INPUT NAME="start_day" id="start_day"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="01" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="31" placeholder="01" required >-
																			<INPUT NAME="start_year" id="start_year" type="number"  style="width: initial;padding:5px;" 
                            value="2016" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000"  required> -->
																			<!-- <input type="date" class="form-control" placeholder="" id="child1_dob" name="child1_dob" value="" onblur="check_child1_dob()"> --><br>
																			<span style="color:#b8071b" id="child1_dob_error" ></span>
														</div>
														<div class="col-md-2 col-sm-2">
																			<label class="input">End Date (MM-DD-YYYY)</label><br>
																			<input class="form-control" type="text" name="datepicker2" id="datepicker2" placeholder="MM-DD-YYYY" required>
																			<!-- <INPUT NAME="end_month" id="end_month"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="01" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="12" placeholder="01" required >-
																			<INPUT NAME="end_day" id="end_day"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="01" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="31" placeholder="01" required >-
																			<INPUT NAME="end_year" id="end_year" type="number"  style="width: initial;padding:5px;" 
                            value="2016" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000"  required> -->
																			<!-- <input type="date" class="form-control" placeholder="" id="child1_dob" name="child1_dob" value="" onblur="check_child1_dob()"> --><br>
																			<span style="color:#b8071b" id="child1_dob_error" ></span>
														</div>
														<div class="col-md-2 col-sm-2" align="center">
															<button type="submit" name="submit" value="Save" class="custom-blue btn btn-lg">Submit</button>
														</div>
													</div>
												</div>
												<!-- <div class="row margin-top-30 margin-bottom-20">
													<div class="col-md-12 col-sm-12 col-xs-12">
														
													</div>
												</div> -->
											</div>	
							</form>
					</div>	
	</div>	
	<div class="col-md-12 col-sm-12 col-xs-12">
	<h1>Promo Code List</h1>
	<div class="row">
	<table class="table table-bordered">
    <thead>
    	<tr>
    	<th>
    	Serial No.
    	</th>
    	<th>
    	Promo Code
    	</th>
    	<th>
    	Flat Discount ($)
    	</th>
    	<th>
    	Percentage Discount (%)
    	</th>

    	<th>
    	Starting Date (MM-DD-YYYY)
    	</th>
    	<th>
    	End Date (MM-DD-YYYY)
    	</th>
    	</tr>
    </thead>
    <tbody>
    	<?php
    	$promocode=$db->get_results("SELECT * FROM promotion_code order by promotion_code_id DESC");
    	$i=0;
    	foreach ($promocode as $pc) {
    		?>
    		<tr>
    		<th><?=($i+1)?></th>
    		<th><?=$pc->promotion_code?></th>
    		
    		<th><?='$ '.$pc->promotion_code_flat?></th>
    		<th><?=$pc->promotion_code_percentage.'%'?></th>
    		<th><?=date("m-d-y", strtotime($pc->promotion_code_start_date));?></th>
    		<th><?=date("m-d-y", strtotime($pc->promotion_code_end_date))?></th>
    		</tr>
    		<?php
    		$i++;
    	}
    	?>
    </tbody>
	</table>
	</div>
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
		<script>
		  $( function() {
		    $( "#datepicker" ).datepicker();
		  } );
		  $( function() {
		    $( "#datepicker2" ).datepicker();
		  } );
		  </script>
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
        
        <script type="text/javascript" src="assets/js/scripts.js"></script>
   

	</body>
</html>