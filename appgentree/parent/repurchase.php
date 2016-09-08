<?php 
 require('../classes.php');
 ?>
<!-- 
  /*******************************************************************************
* File Name        : repurchase.php                                                     
* File Description : Repurchase option in website code.Payment process of repurchase.                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->
 <?php

 $user_id=$_GET['userid'];
 $userdetail=$db->get_results("select * from ".TABLE_PARENT." where md5(user_id)='".$user_id."'");
 $childcount=$db->get_results("select * from ".TABLE_CHILD." where md5(parent_id)='".$user_id."'");
  // Get amount from table
 $getamount=$db->get_results("Select * from ".TABLE_CHILD_PRICE);

 	$amount=$_POST['payamount'];
 
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
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="assets/css/paypal.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
        <script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.creditCardValidator.js"></script>
        <style type="text/css">
        	#divLoading.show
				{
				    display : block;
				    position : fixed;
				    z-index: 100;
				    background-image : url('images/loading.gif');
				    background-color:#666;
				    opacity : 0.4;
				    background-repeat : no-repeat;
				    background-position : center;
				    left : 0;
				    bottom : 0;
				    right : 0;
				    top : 0;
				}
        </style>
        <script type="text/javascript">
function cardFormValidate(){
    var cardValid = 0;
      
    //Card validation
    $('#card_number').validateCreditCard(function(result) {
        var cardType = (result.card_type == null)?'':result.card_type.name;
        if(cardType == 'Visa'){
            var backPosition = result.valid?'2px -163px, 260px -87px':'2px -163px, 260px -61px';
        }else if(cardType == 'MasterCard'){
            var backPosition = result.valid?'2px -247px, 260px -87px':'2px -247px, 260px -61px';
        }else if(cardType == 'Maestro'){
            var backPosition = result.valid?'2px -289px, 260px -87px':'2px -289px, 260px -61px';
        }else if(cardType == 'Discover'){
            var backPosition = result.valid?'2px -331px, 260px -87px':'2px -331px, 260px -61px';
        }else if(cardType == 'Amex'){
            var backPosition = result.valid?'2px -121px, 260px -87px':'2px -121px, 260px -61px';
        }else{
            var backPosition = result.valid?'2px -121px, 260px -87px':'2px -121px, 260px -61px';
        }
        $('#card_number').css("background-position", backPosition);
        if(result.valid){
            $("#card_type").val(cardType);
            $("#card_number").removeClass('required');
            cardValid = 1;
        }else{
            $("#card_type").val('');
            $("#card_number").addClass('required');
            cardValid = 0;
        }
    });
      
    //Form validation
    var cardName = $("#name_on_card").val();
    var expMonth = $("#expiry_month").val();
    var expYear = $("#expiry_year").val();
    var email=$("#payeremail").val();
    var cvv = $("#cvv").val();
    var regName = /^[a-z ,.'-]+$/i;
    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var regYear = /^2016|2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    var regCVV = /^[0-9]{3,3}$/;
    var regEmail=/^\w+([-+.']\ w+)*@\w+([-.]\ w+)*\.\w+([-.]\ w+)*$/;
    if (cardValid == 0) {
        $("#card_number").addClass('required');
        $("#card_number").focus();
        return false;
    }else if (!regMonth.test(expMonth)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").addClass('required');
        $("#expiry_month").focus();
        return false;
    }else if (!regYear.test(expYear)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").addClass('required');
        $("#expiry_year").focus();
        return false;
    }else if (!regCVV.test(cvv)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").removeClass('required');
        $("#cvv").addClass('required');
        $("#cvv").focus();
        return false;
    }else if (!regName.test(cardName)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").removeClass('required');
        $("#cvv").removeClass('required');
        $("#name_on_card").addClass('required');
        $("#name_on_card").focus();
        return false;
    }
    else{
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").removeClass('required');
        $("#cvv").removeClass('required');
        $("#name_on_card").removeClass('required');
        $('#cardSubmitBtn').prop('disabled', false);  
        return true;
    }
}
    
$(document).ready(function() {
    //Demo card numbers
    $('.card-payment .numbers li').wrapInner('<a href="javascript:void(0);"></a>').click(function(e) {
        e.preventDefault();
        $('.card-payment .numbers').slideUp(100);
        cardFormValidate()
        return $('#card_number').val($(this).text()).trigger('input');
    });

    // $('body').click(function() {
    //     return $('.card-payment .numbers').slideUp(100);
    // });
    // $('#sample-numbers-trigger').click(function(e) {
    //     e.preventDefault();
    //     e.stopPropagation();
    //     return $('.card-payment .numbers').slideDown(100);
    // });
    
    //Card form validation on input fields
    $('#paymentForm input[type=text]').on('keyup',function(){
        cardFormValidate();
    });
    
     //Submit card form
    $("#cardSubmitBtn").on('click',function(){
        if (cardFormValidate()) {
        	$("#divLoading").addClass('show');
            var formData = $('#paymentForm').serialize();
            $.ajax({
                type:'POST',
                url:'repurchase_payment.php?userid=<?=$user_id?>',
                dataType: "json",
                data:formData,
                beforeSend: function(){  
                    $("#cardSubmitBtn").val('Processing....');
                },
                success:function(data){
                    if (data.status == 1)
                    {
                    	$("#divLoading").removeClass('show');
                       //alert("successfully");
                       $("#cardSubmitBtn").val('Submit');
                       $("#cardSubmitBtn").removeClass('custom-red btn btn-lg');
      				   $("#cardSubmitBtn").addClass('btn-success btn btn-lg');
      				   window.location="step3.php";
                    }else
                    {
                    	$("#divLoading").removeClass('show');
                    	 alert("Check your card detail..!!");
                    	 $("#cardSubmitBtn").val('Submit');
                         $("#carderror").css('display', 'block');
                         $("#card_number").focus();
                         $("#card_number").addClass('required');
                    }
                }
            });
        }
    });

});
</script>

	</head>
	<body>
		<div id="wrapper">
			<div id="header" class="">
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

						    <!-- Collect the nav links, forms, and other content for toggling -->
						    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						    	<?php
						 			
						 	        $check_purchase_now_files=basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
						 	        //echo $check_purchase_now_files;
						 	        if($check_purchase_now_files=='phase2' || $check_purchase_now_files=='login.php' || $check_purchase_now_files=='index.php')
						 	        {	?>
							 	        <ul class="nav navbar-nav navbar-right">
								      		<li class="slogan1">Haven't purchased yet?</li>
								        	<li class="slogan2"><a style="background-color:#8ac736;color:white;" href="/phase2/signup.php" class="" style="">PURCHASE NOW</a></li>
								      	</ul>	
						    		<?php }else{ ?>
							    		<ul class="nav navbar-nav navbar-right">
								        	<li class="slogan"><!-- <i>A revolutionary approach to maximizing your child's learning potential.</i> -->
								        	<i>A revolutionary approach to maximizing your child's learning potential</i>
								        	</li>
								      	</ul>
						    		<?php } ?>
					    	</div><!-- /.navbar-collapse -->
						</nav>
					</div>
				</header>
			</div>
			<!-- breadcrump -->
			<section class="register-background">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h2 class="register">Repurchase</h2>
						</div>
					</div>
				</div>
			</section>

			<section class="register-content">
				<div class="container">
				<div id="divLoading"> 
                </div>
					<form method="post" id="paymentForm">
						<div class="row">
							<!-- step 1 div -->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="row">
									<!-- left side steps -->
									<div class="col-md-3 col-sm-4 col-xs-12">
										<?php include('left-menu.php'); ?>
									</div>
									<!-- right side form -->
									<div class="col-md-9 col-sm-8 col-xs-12">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 right-form">
												<!-- payment profile starts -->
												<h2 class="color-blue">Enter Your Payment Information</h2>
												<h4 class="required" id="carderror" style="display:none"><span style="color:#b8071b" id="user_first_error"><i class="icon-warning-sign"></i>&nbsp;Wrong card details given, please try again.</span></h4>
												<h4 class="color-blue">Total Amount Due: $ <?=$amount?></h4>
												<h3>Credit Card Details</h3>
												<input  type="hidden"  id="amount" value="<?=$amount?>" name="amount">
												
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														Credit Card Number
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="text" placeholder="1234 5678 9012 3456" id="card_number"  name="card_number">
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
													Expiration Date
													</div>
													<div class="col-md-4 col-sm-5">
														<div class="row">
															<div class="col-md-6 col-sm-6 col-xs-6">
															<label for="expiry_month">Expiry month</label>
                                                                <input class="form-control" type="text" placeholder="MM" maxlength="2" id="expiry_month" name="expiry_month">
															</div>
															<div class="col-md-6 col-sm-6 col-xs-6">
																
															 		<label for="expiry_year">Expiry year</label>
                          											<input class="form-control" type="text" placeholder="YYYY" maxlength="4" id="expiry_year" name="expiry_year">
                          										
															</div>
															
														</div>
																
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														CVV
													</div>
													<div class="col-md-4 col-sm-5">
														<div class="row">
															<div class="col-md-6 col-sm-6 col-xs-6">
															<input class="form-control" type="text" placeholder="123" maxlength="3" id="cvv" name="cvv">
															</div>
															<div class="col-md-6 col-sm-6 col-xs-6">
																
															</div>
															
														</div>
														
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														Name on card
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="text" placeholder="Alan Smith" id="name_on_card"  name="name_on_card">
													</div>
												</div>
												
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														Email Receipt To
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="email"  name="payeremail" id="payeremail">
													</div>
												</div>
												<br>
												<h3>Billing Address</h3>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														Address
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="text" name="address" id="address">
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														City
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="text" value="<?=$userdetail[0]->user_city?>" name="city" id="city">
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;" >
														Country
													</div>
													<div class="col-md-4 col-sm-5">
														    <input class="form-control" type="text"  name="country" id="country">
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														State
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="text" value="<?=$userdetail[0]->user_state?>" name="state" id="state">
													</div>
												</div>
												<div class="row margin-bottom-10">
													<div class="col-md-3 col-sm-4 text-right" style="line-height:40px;">
														Zip/Postal Code
													</div>
													<div class="col-md-4 col-sm-5">
														<input class="form-control" type="text" value="<?=$userdetail[0]->user_zip?>" name="zipcode" id="zipcode">
													</div>
												</div>
												<div class="row margin-top-10 margin-bottom-10">
													<div class="col-md-12 col-sm-12">
														By clicking Submit, you agree to receive information from GenTree Discover relative to the results of the assessment as well as periodic information about our product(s).
													</div>
												</div>
												<div class="row margin-top-10 margin-bottom-10">
													<div class="col-md-12 col-sm-12">
														You are also agreeing to our GenTree Discover <a target="_blank" href="http://www.gentreediscover.com/wp-content/uploads/GENTREEDISCOVER_EULA_Aug15.pdf">End User Liscense Agreement</a> and <a href="http://www.gentreediscover.com/privacy-policy/" target="_blank">Notice of Privacy Practices</a> of GenTree Discover, LLC.
													</div>
													
												</div>
												<div class="row margin-top-30 margin-bottom-20">
													<div class="col-md-12 col-sm-12 col-xs-12">
													
														<input type="button" name="card_submit" id="cardSubmitBtn" value="Submit" class="payment-btn custom-red btn btn-lg" disabled="true" >
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- step 1 div ends -->
							
						</div>
					</form>
				</div>
			</section>
		</div>

        <!-- For Address -->
        <script type="text/javascript">

function initMap() {

    var input = document.getElementById('address');
    
    var autocomplete = new google.maps.places.Autocomplete(input);
  


    autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();
     
  
       
    
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    
        
      
        //Location details
        for (var i = 0; i < place.address_components.length; i++) {
            if(place.address_components[i].types[0] == 'postal_code'){
                document.getElementById('zipcode').value = place.address_components[i].long_name;
            }
            if(place.address_components[i].types[0] == 'country'){
                document.getElementById('country').value = place.address_components[i].long_name;
            }
        }
        var address=place.formatted_address.split(',');
        document.getElementById('address').value = place.formatted_address;
        //document.getElementById('country').innerHTML=((address[address.length-1] != null)?address[address.length-1]:'');
        document.getElementById('state').value=((address[address.length-2] != null)?(address[address.length-2].replace(/[0-9]/g, '')):'');
        document.getElementById('city').value=((address[address.length-3] != null)?address[address.length-3]:'');  
       // document.getElementById('lat').innerHTML = place.geometry.location.lat();
        //document.getElementById('lon').innerHTML = place.geometry.location.lng();
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAorGXTUrQYGnHTwv0Kgy91PWxOK_16ZKw&libraries=places&callback=initMap" async defer></script>
<?php include('footer.php');?>