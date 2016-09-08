<?php 
/*******************************************************************************
* File Name        : report.php                                                     
* File Description : It show report of child.                                                               
* Author           : SimSam                                                              
*******************************************************************************/
$childid=$_GET['childid'];
$resultid=$_GET['resultid'];
$parentid=$_GET['parentid'];
// For left menu bar
$_GET['userid']=md5($_SESSION['user_id']);
// Redirect to home page if user is not login
$userid=$_GET['userid'];
$check_result = $db->get_results("select * from ".TABLE_RESULT." where md5(child_id) = '".$childid."' and md5(result_id) = '".$resultid."'");
if(count($check_result	)==0)
{
	redirect('/login');
}

$get_previous_assessment = $db->get_results("select * from ".TABLE_RESULT." where md5(child_id) = '".$childid."' and md5(parent_id) = '".$parentid."' order by result_id DESC ");
$assessment=(int)$_GET['assessment'];
?>
<!-- 
    register.php
    Purpose: Register users by three steps

    @author Simsam
    @version 1.0 7/11/2016
 -->



			<!-- breadcrump -->
			<div id="bluebackground">
			    <div class="container">
			        <div class="row">
			            <div class="col-md-12">
			                <h2>Learning Profile</h2>
			            </div><!-- end col -->
			        </div><!-- end row -->
			    </div><!-- end container -->
			</div><!-- end bluebackground -->
			<section class="register-content">
				<div class="container content">
					<form>
						<div class="row">
							
							<!-- left side steps -->
							<div class="col-md-3 padright allwhite">
								<?php include('left-menu.php'); ?>
							</div>

							<?php
							$get_child_detail = $db->get_results("select * from ".TABLE_CHILD." where md5(child_id) = '".$childid."'");
							$get_report = $db->get_results("select * from ".TABLE_RESULT." where md5(child_id) = '".$childid."' and md5(result_id) = '".$resultid."'");
							$gr = $get_report[0];
							$gc = $get_child_detail[0];
							?>
							<!-- All inputs -->
							<?php
							$phys = 0;
							$vis = 0;
							$aud = 0;
							$math_logic = 0;
							$sci = 0;
							$verb = 0;
							$selfs = 0;
							$groups = 0;
							$none = 0;
							// physical
							if($gr->Result1A1 == "PK" )
							{
								$phys=1;
							}
							else
							{
								$phys=0;
							}
							// visual 
							if($gr->Result3B2 == "VS")
							{
								$vis=1;
							}
							else {
								$vis=0;
							}
							// auditory
							if($gr->Result2B1 == "AA")
							{
								$aud=1;
							}
							else
							{
								$aud=0;
							}
							// math logic
							if($gr->Result2C1 == "ML" && $gr->Result2C2 == "ML" && $gr->Result2C3 == "ML")
							{
								$math_logic=1;
							}
							else if($gr->Result3A2 == "ML")
							{
								$math_logic=1;
							}
							else {
								$math_logic=0;
							}
							// science
							if($gr->Result3A1 == "NS")
							{
								$sci=1;
							}
							else
							{
								$sci=0;
							}
							// verbal linguistic
							if( $gr->Result2B2 =="VB")
							{
								$verb=1;
							}
							else {
								$verb=0;
							}
							// self group
							if($gr->midpoint=="0" || $gr->midpoint=="2" || $gr->Result4A1=="")
							{
								if( $gr->Result1A2 == "SLF")
								{
									$selfs = 1;
								}
								else if( $gr->Result1A2 == "GRP")
								{
									$groups = 1;
								}
								else {
									$none = 1;
								}
							}
							else{
								if( $gr->Result4A1 == "SLF")
								{
									$selfs = 1;
								}
								else if( $gr->Result4A1 == "GRP")
								{
									$groups = 1;
								}
								else {
									$none = 1;
								}
							}

							?>
							<!-- right side form -->
							<div class="col-md-9">
								<div class="bigwhitebox">
									<div class="">
										<!-- Report starts -->
										
										<div class="row margin-bottom-20">
											<div class="col-md-3 col-sm-3 col-xs-6">
											<!-- child image -->
											  <?php if($get_child_detail[0]->child_pic!=""){ ?>
												<img class="img-responsive" style="border-radius:50%;width:150px;height:150px;" src="child_image/<?=$get_child_detail[0]->child_pic?>">
											   <?php }else if($get_child_detail[0]->sex==1) {?>	
											       <img class="img-responsive" style="border-radius:50%;" src="images/boy-image.png">
											   <?php }else{ ?>
												<img class="img-responsive" style="border-radius:50%;" src="images/girl-image.png">
											   <?php } ?>

											</div>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<div class="">
													<div class="col-md-12 col-sm-12 col-xs-12">
													<!-- child name -->
														<h3><?php echo ucfirst($gc->child_firstname); ?>
														<?php echo ucfirst($gc->child_lastname); ?></h3>
													</div>
													<!-- child info -->
													<div class="row" >
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="col-md-6 col-sm-6 col-xs-12 info bg-grey">Age at Assessment Date</div>
														<div class="col-md-6 col-sm-6 col-xs-12 info bg-grey">
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
														<div class="col-md-6 col-sm-6 col-xs-12 info">Date of Assessment</div>
														<div class="col-md-6 col-sm-6 col-xs-12 info">
															<?=date('m-d-Y', strtotime($gr->Period))?>
														</div>
													</div>
													</div>
													<div class="row" >
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="col-md-6 col-sm-6 col-xs-12 info bg-grey">Date of Previous Assessment</div>
														<div class="col-md-6 col-sm-6 col-xs-12 info bg-grey">
														<?php
														if($_GET['previous']!='---')
														{
														if (array_key_exists(($assessment+1), $get_previous_assessment))
																		         {
																		         	?>
																					 <a href="/report/?childid=<?=md5($get_previous_assessment[$assessment+1]->child_id)?>&resultid=<?=md5($get_previous_assessment[$assessment+1]->result_id)?>&previous=
														<?php
														if (array_key_exists(($assessment+2), $get_previous_assessment))
																		         {
																					  echo $get_previous_assessment[$assessment+2]->Period.'&assessment='.($assessment+1);
																				 }else
																				 {
																				 	echo "---";
																				 }
														?>
														&parentid=<?=$parentid?>"><?=date('m-d-Y',strtotime($get_previous_assessment[$assessment+1]->Period))?>  Click here</a>
																				<?php }else
																				 {
																				 	echo "None";
																				 }
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
										<!-- quick view -->
										<h3 class="color-blue">Assessment Results Quick View:</h3>
										<div class="row margin-bottom-20">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12 color-green pref">
													<h4>Learning Style(s): 
													<?php
													if($vis == 1 && $aud == 1 && $phys == 1)
													{
														echo "Visual, Auditory, Physical";
													}
													else if($vis ==1 && $aud == 1)
													{
														echo "Visual, Auditory";
													}
													else if($phys ==1 && $aud == 1)
													{
														echo "Auditory, Physical";
													}
													else if($phys ==1 && $vis == 1)
													{
														echo "Visual, Physical";
													}
													else if($phys ==1)
													{
														echo "Physical";
													}
													else if($aud == 1)
													{
														echo "Auditory";
													}
													else if($vis == 1)
													{
														echo "Visual";
													}
													?>
													</h4>
													
												</div>
												<div class="col-md-12 col-sm-12 col-xs-12 color-light-blue pref">
													<h4>Learning Preference(s): 
													<?php
													if($sci ==1 && $math_logic == 1 && $verb == 1)
													{
														echo "Verbal Linguistic, Math, Science";
													}
													else if($verb ==1 && $math_logic == 1)
													{
														echo "Verbal Linguistic, Math";
													}
													else if($sci ==1 && $math_logic == 1)
													{
														echo "Math, Science";
													}
													else if($sci ==1 && $verb == 1)
													{
														echo "Verbal Linguistic, Science";
													}
													else if($sci ==1)
													{
														echo "Science";
													}
													else if($math_logic == 1)
													{
														echo "Math";
													}
													else if($verb == 1)
													{
														echo "Verbal Linguistic";
													}
													?>
													</h4>
													
												</div>
												<div class="col-md-12 col-sm-12 col-xs-12 color-dark-blue pref">
													<h4>Social Preference: 
													<?php
													if($selfs == 1)
													{
														echo "Self Study";
													}
													else if($groups == 1)
													{
														echo "Group Study";
													}
													?>
													</h4>
													
												</div>
											</div>
											<div class="col-md-5 col-sm-5 col-xs-12">
												<!-- <img src="images/quick.PNG" class="img-responsive"> -->
											</div>
										</div>
										<div class="row margin-bottom-20">
											<div class="col-md-7 col-sm-7 col-xs-12">
											
											</div>
										</div>
										<div class="row margin-bottom-20">
											<!-- bar chart -->
											<div class="col-md-6 col-sm-6 col-xs-12">
												
												<div class="col-md-12 col-sm-12 col-xs-12 pref-head color-green margin-bottom-20">
													<h4>Learning Style(s):</h4>	
												</div>
												
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Visual
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info color-white color-green" style="min-height:40px;">
															<?php
															if( $vis == 1)
															{
																?><a class="no-underline color-white" target="_blank" href="http://bit.ly/2c0JKgl"><img src="images/check.png" style="width:17px;"> Learn More</a><?
															}
															else {
																?>----<?
															}
															?>
														</div>
													</div>
												</div>

												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Auditory
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info color-white color-green" style="min-height:40px;">
															<?php
															if( $aud == 1)
															{
																?>	<a class="no-underline color-white" target="_blank" href="http://bit.ly/2bSzLZZ">
																		<img src="images/check.png" style="width:17px;"> Learn More
																	</a><?
															}
															else {
																?>----<?
															}
															?>
														</div>
													</div>
												</div>

												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Physical
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info color-white color-green" style="min-height:40px;">
															<?php
															if( $phys == 1)
															{
																?>	<a class="no-underline color-white" target="_blank" href="http://bit.ly/2bS84C7">
																		<img src="images/check.png" style="width:17px;"> Learn More
																	</a><?
															}
															else {
																?>----<?
															}
															?>
														</div>
													</div>
												</div>
												
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												
													<div class="col-md-12 col-sm-12 col-xs-12 pref-head color-light-blue margin-bottom-20">
														<h4>Learning Preference(s):</h4>	
													</div>
												
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Verbal
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info color-white" style="min-height:40px;background-image:url('images/bubble-blue.png');">
															<?php
															if( $verb == 1)
															{
																?>	<a class="no-underline color-white" target="_blank" href="http://bit.ly/2crgwcc">
																		<img src="images/check.png" style="width:17px;"> Learn More
																	</a><?
															}
															else {
																?>----<?
															}
															?>
														</div>
													</div>
												</div>
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Math
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info color-white" style="min-height:40px;background-image:url('images/bubble-blue.png');">
															<?php
															if($math_logic ==1)
															{
																?><a class="no-underline color-white" target="_blank" href="http://bit.ly/2bCJJOt" style="width:17px;"><img src="images/check.png" style="width:17px;">Learn More</a><?
															}
															else {
																?>----<?
															}
															?>
														</div>
													</div>
												</div>
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Science
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info color-white" style="min-height:40px;background-image:url('images/bubble-blue.png');">
															<?php
															if($sci ==1)
															{
																?><a class="no-underline color-white" target="_blank" href="http://bit.ly/2bHcAyj"><img src="images/check.png" style="width:17px;"> Learn More</a><?
															}
															else
															{
																?>----<?
															}
															?>
														</div>
													</div>
												</div>
												
											</div>
										</div>
										<div class="row margin-bottom-20">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="row">
													<div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-20">
														<div class="pref-head color-dark-blue">
															<h4>Social Preference:</h4>	
														</div>
													</div>
												</div>
												<?php
												

												?>
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Self Study
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info bg-grey" style="min-height:40px;">
															<?php
															if($selfs == 1 && $groups == 0)
															{
																?><a class="no-underline" target="_blank" href="http://bit.ly/2bCi6SF"><img src="images/check.png" style="width:17px;"> Learn More</a><?
															}
															else{
																?>----<?
															}
															?>
														</div>
													</div>
												</div>
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Group Study
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info bg-grey" style="min-height:40px;">
															<?php
															if($selfs == 0 && $groups == 1)
															{
																?><a class="no-underline" target="_blank" href="http://bit.ly/2bS7HaV"><img src="images/check.png" style="width:17px;"> Learn More</a><?
															}
															else{
																?>----<?
															}
															?>
														</div>
													</div>
												</div>
												
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="row">
													<div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-20">
														<div class="pref-head" style="background-color:#3c3a3c;">
															<h4>Additional Indicator(s):</h4>	
														</div>
													</div>
												</div>
												
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Auditory Sensitive
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info bg-grey" style="min-height:40px;">
															<?php
															if($gr->Result2C1!="" && $gr->Result2C2!="" && $gr->Result2C3!="")
															{
																if($gr->Result2C1 == "ML" && $gr->Result2C2 == "ML" && $gr->Result2C3 == "ML")
																{
																	echo "----";
																}
																else if(($gr->Result2C1=="nML"||$gr->Result2C1==$to)&&($gr->Result2C2=="nML"||$gr->Result2C2==$to)&&($gr->Result2C3=="nML"||$gr->Result2C3==$to))
																{
																	?><a class="no-underline" target="_blank" href="http://www.gentreediscover.com/wp-content/uploads/Auditory-Sensitivity.pdf"><img src="images/check.png" style="width:17px;"> Learn More</a><?
																}
																else{
																	echo "----";
																}
															}
															?>
														</div>
													</div>
												</div>
												<div class="row" style="margin-bottom:10px;">
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0;">
														<div class="info bg-grey" style="min-height:40px;">
															Attention Sensitive
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0;">
														<div class="info bg-grey" style="min-height:40px;">
															<?php
															if($gr->midpoint=="1" )
															{
																?>----<?
															}
															else if ($gr->midpoint=="2")
															{
																?>
																<a class="no-underline" target="_blank" href="http://www.gentreediscover.com/wp-content/uploads/Attention-Sensitivity.pdf"><img src="images/check.png" style="width:17px;"> Learn More</a>
																<?
															}
															?>
														</div>
													</div>
												</div>
												
											</div>
											
										</div>
										<div class="row margin-bottom-20">
											<!-- Review required -->
											
										</div>
										<div class="row margin-bottom-20">
											<!-- Review required -->
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h4 class="color-blue" style="font-size:20px;">
													Problem-Solving Skills: Executive Functioning
												</h4>
												<p>Parents and Teachers should create a healthy, safe environment for children to confidently practice the skills below throughout their early childhood years. Repetition and consistency is key for children to apply these skills as they develop problem-solving techniques for home, school, and peers. These skills also apply to developing solid executive functioning skills (as compared to an air traffic control center helping an airplane to land).</p>
												<p>
													<strong>Working memory</strong> is defined as holding, processing, and manipulation of information. It is an important process for reasoning, guidance of decision making, and behavior.
													
												</p>
												<ul>
													<li>Daily, encourage your child to re-tell what they have learned, prompting them with questions to extend their memory recall of the event(s).</li>
													<li>Together, list out steps for completing a chore or project.</li>
													<li>Play matching games such as <span><i>Go Fish</i></span> or games such as <i>Concentration.</i></li>
													<li>Read stories and nursery rhymes or sing songs that allow for echoing or other auditory responses.</li>
												</ul>
												<p><strong>Cognitive flexibility</strong> is the mental ability to switch between thinking about two different concepts, and to think about multiple concepts simultaneously.</p>
												<ul>
													<li>Encourage your child to use imaginative play and practice having conversations with adults such as servers, teachers, doctors, etc.</li>
													<li>Play games with your child that require self-regulation and quick decision making such as <span><i>Red Light-Green Light, Musical Chairs</i></span>, or <i>Simon Says.</i></li>
													<li>Put together age-appropriate jigsaw puzzles or search for hidden objects in picture books created for that purpose to enhance visual discrimination.</li>
													<li>Sort and classify objects and pictures of objects using different and/or new guidelines. Have your child explain their thinking as they are practicing this skill.</li>
												</ul>
												<p><a style="text-decoration:underline;" onclick="show_this()">Reference Link</a></p>
												<div id="show_div" style="display:none;">
													<p>Wikipedia: 2016</p>
													<p>Center on the Developing Child at Harvard University (2014). <i>Enhancing and Practicing Executive Function Skills with Children from Infancy to Adolescence</i>.</p>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</form>
				</div>
			</section>
		</div>
		</div>
		<script type="text/javascript">
			function show_this(){
				if(document.getElementById("show_div").style.display == "none")
				{
					document.getElementById("show_div").style.display = "block";
				}
				else{
					document.getElementById("show_div").style.display = "none";
				}
			}
		</script>
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
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>
		<script type="text/javascript">
			// var ctx = document.getElementById("myChart");
			// var steps =5;
			// var myChart = new Chart(ctx, {
			//     type: 'bar',
			//     data: {
			//         labels: ["Visual", "Auditory", "Physical"],
			//         datasets: [{
			//             label: 'Learning Style',
			//             data: [<?=$vis?>,<?=$aud?>,<?=$phys?>],
			//             backgroundColor: [
			//                 '#8ac736',
			//                 '#8ac736',
			//                 '#8ac736'			                
			//             ]
			//         }]
			//     },
			//     options: {
			//         scales: {
			//             yAxes: [{
			//                 ticks: {
			//                     beginAtZero:true,
			//                     maxTicksLimit:2
			//                 }
			//             }]
			//         },
			//         responsive: true,
			//     }
			// });
			</script>
			<script type="text/javascript">
				function resize()
			    {
			        var widths = window.innerWidth;
			        // if(widths<1000)
			        // {
			        // 	$("change_container").removeClass("container");
				       //  $("change_container").addClass("container-fluid");
			        // }
			        if(widths<1000)
			        {
			        	document.getElementById("change_container").style.minWidth = (widths) + "px";
			        }
			        // document.getElementById("content_height").style.height = (heights-216) + "px";
			    }
			    resize();
			    window.onresize = function() {
			        resize();
			    };
			</script>