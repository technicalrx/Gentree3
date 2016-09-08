<?php 

  /*******************************************************************************
* File Name        : view-report-listing.php                                                     
* File Description : View report of childs .It contant list of report of parent.                                                               
* Author           : SimSam                                                              
*******************************************************************************/

?>

 <?php
 if(!isset($_SESSION['user_id']))
 {
 	redirect('/login/');
 } 
$userid=$_GET['userid'];
$check_parent = $db->get_results("select * from ".TABLE_PARENT." where md5(user_id) = '".$userid."'");
if(count($check_parent)==0)
{
	redirect('/login/');
}
 ?>

 

	<style type="text/css">
		.form-control {
		    font-family: "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
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
			<!-- breadcrump -->
			<div id="bluebackground">
			    <div class="container">
			        <div class="row">
			            <div class="col-md-12">
			                <h2>Report Center</h2>
			            </div><!-- end col -->
			        </div><!-- end row -->
			    </div><!-- end container -->
			</div><!-- end bluebackground -->
		
			<!-- getting details -->
			<?php
				$get_teacher = $db->get_results("select * from ".TABLE_PARENT." where md5(user_id) = '".$userid."'");

				$tr=$get_teacher[0];

				$get_child = $db->get_results("select * from ".TABLE_CHILD." where md5(parent_id) = '".$userid."'");


			?>
		<div  class="register-content" id="content_height">
			<!-- landing page content -->
			<section class="app_landing">
				<div class="container content">
					
					<div class="row">
						<!-- left side steps -->
						<div class="col-md-3 padright allwhite">
							<?php include("left-menu.php"); ?>
						</div>
						<div class="col-md-9">
							<div class="bigwhitebox">
							<div class="row">
							<?php
							$i=1;
							
							$checkReportAvailable=true;
							foreach ($get_child as $gc) {
								$get_result = $db->get_results("select * from ".TABLE_RESULT." where child_id = '".$gc->child_id."' and md5(parent_id) = '".$userid."' order by result_id DESC ");
								$j=0;
								$checkFlagReport=true;
								foreach ($get_result as $gr) {
										$checkReportAvailable=false;
									if($checkFlagReport==false)
										break;
									$checkFlagReport=false;
									?>
								<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-10 small-size-border" style="padding:0;">
									<!-- <h2 class="color-blue">Child Name and Date of Report- 
									</h2> -->
									<div class="row margin-bottom-20">
										<div class="col-md-3 col-sm-3 col-xs-6">
										<!-- child image -->
										<?php if($gc->child_pic!=""){ ?>
											<img class="img-responsive" style="border-radius:50%;width:150px;height:150px;" src="child_image/<?=$gc->child_pic?>">
										<?php }else if($gc->sex==1){ ?>	
										<img class="img-responsive" style="border-radius:50%;" src="images/boy-image.png">
										<?php }else{ ?>
											<img class="img-responsive" style="border-radius:50%;" src="images/girl-image.png">
											<?php } ?>
										</div>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class="">
												<div class="col-md-12 col-sm-12 col-xs-12">
												<!-- child name -->
													<h3>
													<?php echo ucfirst($gc->child_firstname); ?>
													<?php echo ucfirst($gc->child_lastname); ?>
													-
													<a href="/report/?childid=<?=md5($gc->child_id)?>&resultid=<?=md5($gr->result_id)?>&previous=
													<?php
													if (array_key_exists(($j+1), $get_result))
																	         {
																				  echo $get_result[$j+1]->Period.'&assessment='.($j);
																			 }else
																			 {
																			 	echo "---";
																			 }
													?>
													&parentid=<?=md5($get_teacher[0]->user_id)?>">Click to access report</a>
													</h3>
												</div>
												<!-- child info -->
												<div class="row" >
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="col-md-7 col-sm-7 col-xs-12 info bg-grey">Age at Assessment Date</div>
														<div class="col-md-5 col-sm-5 col-xs-12 info bg-grey">
															<?php
															$dob= $gc->dob;
															$doa= $gr->Period;
															$dob = strtotime($dob);
															$doa = strtotime($doa);
															// echo $dob." ";
															// echo $doa;
															$diff = abs($dob-$doa);
															// echo " ".$diff." ";
															$month = floor($diff / 2678400);
															// echo $month;
															if($month>12)
															{
																$year = floor($month/12);
																$num_month = $month%12;
																echo $year." year(s) ".$num_month." month(s)";
															}
															else{
																echo $month." month(s)";
															}
															?>
														</div>
													</div>
												</div>
												<div class="row" >
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="col-md-7 col-sm-7 col-xs-12 info">Date of Assessment</div>
													<div class="col-md-5 col-sm-5 col-xs-12 info"><?=date('m-d-Y', strtotime($gr->Period))?></div>
												</div>
												</div>
												<div class="row" >
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="col-md-7 col-sm-7 col-xs-12 info bg-grey">Date of Previous Assessment</div>
													<div class="col-md-5 col-sm-5 col-xs-12 info bg-grey">
													<?php if (array_key_exists(($j+1), $get_result))
													         {
													         	?>
													         	<a href="/report/?childid=<?=md5($get_result[$j+1]->child_id)?>&resultid=<?=md5($get_result[$j+1]->result_id)?>&previous=
													<?php
													if (array_key_exists(($j+2), $get_result))
																	         {
																				  echo $get_result[$j+2]->Period.'&assessment='.($j+1);
																			 }else
																			 {
																			 	echo "---";
																			 }
													?>
													&parentid=<?=md5($get_teacher[0]->user_id)?>"><?=date('m-d-Y',strtotime($get_result[$j+1]->Period))?>  Click here</a>
																
																  <?php
															 }else
															 {
															 	echo "None";
															 }
													?>
														
													</div>
												</div>
												</div>
											</div>
										</div>
									</div>
								</div>
										<?php
									 $j++;
									
								   }
								   $i++;
								}
								if($checkReportAvailable)
								{
								?>
								<h2>No Report available</h2>
								<?php } ?>											
							</div>
						</div>
					</div>
				</div>
			</div>		
		</section>
	</div>
</div>
	</div>
	<!-- <script type="text/javascript" src="assets/js/backstretch.js"></script> -->
	<!-- <script type="text/javascript">
		$("#wrapper").backstretch("images/red-pattern.jpg");
	</script> -->
<script type="text/javascript">
    function resize()
    {
        var heights = window.innerHeight;
        var height_header = document.getElementById("header").offsetHeight;
        document.getElementById("wrapper").style.minHeight = (heights-85) + "px";
        document.getElementById("content_height").style.minHeight = (heights-87-85-height_header) + "px";
    }
    resize();
    window.onresize = function() {
        resize();
    };
</script>
