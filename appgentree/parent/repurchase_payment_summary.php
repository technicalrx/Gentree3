<?php include('header.php'); ?>
<!-- 
  /*******************************************************************************
* File Name        : repurchase_payment_summary.php                                                     
* File Description : repurchase payment transaction file.                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->

<?php

 $user_id=$_GET['userid'];
 $userdetail=$db->get_results("select * from ".TABLE_PARENT." where md5(user_id)='".$user_id."'");
 $childcount=$db->get_results("select * from ".TABLE_CHILD." where md5(parent_id)='".$user_id."'");
 // Get amount from table
 $getamount=$db->get_results("Select * from ".TABLE_CHILD_PRICE);
 if(count($childcount)>0)
 {
 	$amount=($getamount[0]->price)*count($childcount);
 }

// foreach ($_POST as $key => $entry)
// {
//      print $key . ": " . $entry . "<br>";
// }
?>
<style type="text/css">
table, td, th {
    border: 1px solid #ddd;
    text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 15px;
}
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
var flag=0;

$(document).ready(function() {
 var amount = parseFloat(document.getElementById("total_amount").innerHTML);
	 	     $('#payamount').val(''+amount);
	 	 });

$(document).ready(function() {
	 $("#promotion_code_btn").on('click',function(){

	 	 var amount = parseFloat(document.getElementById("total_amount").innerHTML);
	 
        	$("#divLoading").addClass('show');
            var promotion_code = $('#promotion_code').val();
            $.ajax({
                type:'POST',
                url:'promotion_code_redeem.php?promotion_code='+promotion_code,
                dataType: "json",
                data:promotion_code,
                success:function(data){
                    if (data.status == 1)
                    {
                    	var percentage=parseFloat(data.percentage);
                    	if(data.percentage==0)
                        {
                        	var remaining_amount=amount-parseFloat(data.flat);
                        }else
                        {	
                    	    var remaining_amount=amount-((amount*percentage)/100);
                        }
                    	remaining_amount=parseFloat(remaining_amount).toFixed(2)
                    	flag=1;
                    	//alert("amount : "+amount+" percentage "+percentage+" remaining_amount "+remaining_amount);
                    	$('#payamount').val(''+remaining_amount);
                    	$("#divLoading").removeClass('show');
                    	//alert(remaining_amount);
                    	$("#redeem_amount").html(''+remaining_amount);
                    	$("#redeem_error").html("");
                    	$("#redeem_sucess").html('<i class="icon-ok"></i>')
                      
                    }else
                    {
                    	$('#payamount').val(''+amount);
                    	$("#redeem_amount").html(amount);
                    	$("#divLoading").removeClass('show');
                    	$("#redeem_error").html('<i class="icon-warning-sign"></i>');
                    	$("#redeem_sucess").html("");
                    	
                    }
                }
            });
    });
});	
$(document).ready(function() {
	 $("#submit_amount").on('click',function(){
$("#purchase_form").submit(function(){
});
});
});

</script>
			<!-- breadcrump -->
			<section class="register-background">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h2 class="register">Registration</h2>
						</div>
					</div>
				</div>
			</section>

			<section class="register-content">
				<div class="container">
				<div id="divLoading"> 
                </div>
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
												<!-- parent profile starts -->
												<h2 class="color-blue">Purchase Summary</h2>

												<div class="row">
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-md-5 col-sm-5 col-xs-12">
																<div class="row">
																	<div class="col-md-5 col-sm-5 col-xs-5 margin-bottom-15"><strong>Product</strong></div>
																	<div class="col-md-7 col-sm-7 col-xs-7 margin-bottom-15">Child Assessment</div>
																</div>
															</div>
															<div class="col-md-7 col-sm-7 col-xs-12">
																<div class="row">
																	<div class="col-md-4 col-sm-4 col-xs-4 margin-bottom-15"><strong>Quantity</strong></div>
																	<div class="col-md-8 col-sm-8 col-xs-8 margin-bottom-15"><?=count($childcount)?></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-md-5 col-sm-5 col-xs-12">
																<!-- <div class="row">
																	<div class="col-md-5 col-sm-5 col-xs-5 margin-bottom-15"><strong>Term</strong></div>
																	<div class="col-md-7 col-sm-7 col-xs-7 margin-bottom-15"><?//$date_validity = date('m-d-Y', strtotime("+7 days"));?></div>
																</div> -->
															</div>
															<div class="col-md-7 col-sm-7 col-xs-12">
																<div class="row">
																	<div class="col-md-4 col-sm-4 col-xs-4 margin-bottom-15"><strong>Price</strong></div>
																	<div class="col-md-8 col-sm-8 col-xs-8 margin-bottom-15">
																		<?//count($childcount).' x $ 29.50 = $ '.number_format($amount,2)?>
																		<?=count($childcount).' x $ '.number_format($getamount[0]->price,2)?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-md-5 col-sm-5 col-xs-12"></div>
															<div class="col-md-7 col-sm-7 col-xs-12 margin-bottom-15">
																<div class="row">
																	<div class="col-md-4 col-sm-4 col-xs-4"><strong>Total</strong></div>
																	<div class="col-md-8 col-sm-8 col-xs-8" >$ <span id="total_amount"><?=number_format($amount,2)?></span></div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-md-5 col-sm-5 col-xs-12"></div>
															<div class="col-md-7 col-sm-7 col-xs-12 margin-bottom-15">
																<div class="row">
																	<div class="col-md-4 col-sm-4 col-xs-4 padding-0">
																		<strong>Promotion Code</strong>
																	</div>
																	<div class="col-md-8 col-sm-8 col-xs-8">
																		<input type="text" class="" id="promotion_code" name="promotion_code" placeholder="Enter Code">
																		
																		<input type="button" id="promotion_code_btn" value="Apply" >&nbsp;<span style="color:#b8071b" id="redeem_error"></span>
													        			<span style="color:##1c9a71" id="redeem_sucess"></span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-md-5 col-sm-5 col-xs-12"></div>
															<div class="col-md-7 col-sm-7 col-xs-12 margin-bottom-15" id="coderedeem">
																<div class="row">
																	<div class="col-md-4 col-sm-4 col-xs-4">
																	<strong>Amount Due</strong>
																	</div>
																	<div class="col-md-8 col-sm-8 col-xs-8">
																		$ <span id="redeem_amount"><?=number_format($amount,2)?><span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													   
												</div>
												<form  id="purchase_form" action="repurchase.php?userid=<?=$_GET['userid']?>"   method="POST" >
													<input type="hidden" id="payamount" name="payamount">
													<div class="row margin-top-30 margin-bottom-20">
													<div class="col-md-12 col-sm-12 col-xs-12">
														<button type="submit" class="custom-blue btn btn-lg">Submit</button>
													</div>
												</div>
												</form>
												
												<!-- child four starts -->
												
											</div>
										  
										</div>
									</div>
								</div>
							</div>
							<!-- step 1 div ends -->
							<!-- step 2 div starts -->

						</div>
					
				</div>
			</section>
		</div>
		<style type="text/css">
			#wrapper{
				background-image: url('images/red-pattern.jpg');
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
	<?php include('footer.php');?>