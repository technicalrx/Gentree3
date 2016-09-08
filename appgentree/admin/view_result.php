<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("index.php");
}
$childid=$_GET['childid'];
$resultid=$_GET['resultid'];

// Check that result table is correspond to login teacher
$check_teacher = $db->get_results("select * from ".TABLE_RESULT." where child_id = '".$childid."' And result_id='".$resultid."' and teacher_id='".$_SESSION['admin_panel']."' Order by Period DESC");
if(count($check_teacher)==0)
{
	redirect('dashboard.php');
}


$to = 'TO';
$nul = "";
$check =0;
$cut = 0;
$tar = 0;
$conflict = 0;
$no_entry = 0;
$count = 0;
$average=0;
// $returnThis=0;
// Array of attribute
$array_result = array();
$array_result['PK']="Physical";
$array_result['nPK']="Non-Physical";
$array_result['GRP']="Group Study";
$array_result['SLF']="Self Study";
$array_result['TP']="Physical-Tactile";
$array_result['nTP']="Non-Physical Tactile";
$array_result['AA']="Auditory";
$array_result['nAA']="Non-Auditory";
$array_result['VB']="Verbal";
$array_result['nVB']="Non-Verbal";
$array_result['NS']="Science";
$array_result['nNS']="Non-Science";
$array_result['ML']="Math/Logic";
$array_result['nML']="Non-Math/Logic";
$array_result['VS']="Visual";
$array_result['nVS']="Non-Visual";
$array_result['VST']="Visual-Physical-Tactile";
// $array_result['Comp']="Complete";
// $array_result['']="No Ans";
$array_result['TO']="Time Out";


// Get detail about child and class
	$get_child_detail = $db->get_results("select * from ".TABLE_CHILD." where child_id = '".$childid."'");
	$get_class_name = $db->get_results("select * from ".TABLE_CLASS." where class_id = '".$get_child_detail[0]->class_id."'");

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
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<? include 'header.php'; ?>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<? include 'left_panel.php'; ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->			
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">View Result</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="fa fa-building-o"></i>
								<a href="view_child.php?classid=<?=$get_class_name[0]->class_id?>">Class List</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>View Result</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<?php $get_detail = $db->get_results("select * from ".TABLE_RESULT." where child_id = '".$childid."' And result_id='".$resultid."' Order by Period DESC");
						// foreach($get_detail as $pl)
						// 				{
						$pl=$get_detail[0];
						if(empty($pl)== 0){
						   $no_entry = 0;
						}
						else{
							$no_entry = 1;
						}
						
										?>
										<!-- Result Detail -->
						<div class="portlet box blue">
							<div class="portlet-title"><h4><?=$pl->Period?></h4></div>
							<div class="portlet-body">
							<?php 
							
							$get_school_detail = $db->get_results("select * from ".TABLE_SCHOOL." where school_id = '".$get_class_name[0]->school_id."'");
							$get_teacher_name = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$get_child_detail[0]->teacher_id."'");
							?>
								<div class="row-fluid">
								<!-- child details -->
									<div class="span4">Student :&nbsp; <?=$get_child_detail[0]->child_firstname." ".$get_child_detail[0]->child_lastname?></div>
									<div class="span4">Race :&nbsp; <?=$get_child_detail[0]->race?></div>
									<div class="span4">Known Learning Difference : &nbsp;<?= ucfirst($get_child_detail[0]->known_learning_diff)?></div>
									
								</div>
								
								<div class="row-fluid">
									<div class="span4">Child U-ID: &nbsp;<?=$get_child_detail[0]->child_username?></div>
									<div class="span4">Color Blind : &nbsp;
									<?php 
										if($get_child_detail[0]->color_blind=='y')
										{
											?><?="Yes"?><?php
										}
										else if($get_child_detail[0]->color_blind=='n')
										{
											?><?="No"?><?php
										}
										else
										{
											?><?="Unknown"?><?php
										}
									?>
									</div>
									<div class="span4">School Zip Code :&nbsp;
										<?=$get_school_detail[0]->school_zip?>
									</div>
									
								</div>
								<div class="row-fluid">
									<div class="span4">Gender : &nbsp; 
									<?php
										if($get_child_detail[0]->sex=='m')
										{
											?><?="Male"?><?php
										}
										else if($get_child_detail[0]->sex=='f')
										{
											?><?="Female"?><?php
										}
										else{
											?><?="-"?><?php
										}
									?>
									</div>
									<div class="span4">Glasses : &nbsp;
									<?php 
										if($get_child_detail[0]->glasses=='y')
										{
											?><?="Yes"?><?php
										}
										else if($get_child_detail[0]->glasses=='n')
										{
											?><?="No"?><?php
										}
										else
										{
											?><?="Unknown"?><?php
										}
									?>
									</div>
									<div class="span4">Teacher :&nbsp; <?=$get_teacher_name[0]->firstname." ".$get_teacher_name[0]->lastname?></div>
								</div>
								<div class="row-fluid">
									<div class="span4">Birth Date :&nbsp; <?=date('m-d-Y', strtotime($get_child_detail[0]->dob))?></div>
									<div class="span4">Hearing Impaired : &nbsp;
									<?php 
										if($get_child_detail[0]->hearing_impaired=='y')
										{
											?><?="Yes"?><?php
										}
										else if($get_child_detail[0]->hearing_impaired=='n')
										{
											?><?="No"?><?php
										}
										else
										{
											?><?="Unknown"?><?php
										}
									?>
									</div>
									<div class="span4">Class :&nbsp; <?=stripslashes($get_class_name[0]->class_name)?></div>
								</div>
								<br>
								<div class="row-fluid">
									
									<div class="row-fluid">
										<div class="span4">
											<div class="row-fluid">
												<div class="span12">
													<b style="text-decoration: underline;">Learning Modality</b>
												</div>
											</div>
											<div class="row-fluid">
											<!-- physical -->
												<div class="span5 padding-top-5">Physical :</div>
												<div class="span7 padding-top-5"><?
													if($no_entry==1){
														?>

														<?
													}
													else
													{
														if($pl->Result1A1 == "PK" )
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else
														{
															?>---<?
														}
													}
													?>
												</div>
											</div>

											<div class="row-fluid">
											<!-- Visual -->
												<div class="span5 padding-top-5">Visual :</div>
												<div class="span7 padding-top-5"><?
													if($no_entry==1){
														?>

														<?
													}
													else{
														if($pl->Result3B2 == "VS")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else {
															?>---<?
														}
														
													}
													?>
												</div>
											</div>

											<div class="row-fluid">
											<!-- auditory -->
												<div class="span5 padding-top-5">Auditory :</div>
												<div class="span7 padding-top-5">
													<?
													if($no_entry==1){
														?>

														<?
													}
													else{
														if($pl->Result2B1 == "AA")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else
														{
															?>---<?
														}
													}
													?>
												</div>
											</div>
											
											<div class="row-fluid">
											<!-- math/logic -->
												<div class="span5 padding-top-5">Math/ Logic :</div>
												<div class="span7 padding-top-5">
												<?php
												if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
												{
													?><i style="color: green;" class="fa fa-check"></i><?
												}
												else if($pl->Result3A2 == "ML")
												{
													?><i style="color: green;" class="fa fa-check"></i><?
												}
												else {
													?>---<?
												}
												?>
												</div>
											</div>
											
											<div class="row-fluid">
											<!-- Nat/science -->
												<div class="span5 padding-top-5">Science :</div>
												<div class="span7 padding-top-5">
												<?
													if($no_entry==1){
														?>

														<?
													}
													else{
														if($pl->Result3A1 == "NS")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else
														{
															?>---<?
														}
													}
												?>
												</div>
											</div>
											<div class="row-fluid">
											<!-- self/group -->
												<div class="span5 padding-top-5">Verbal - Linguistic :</div>
												<div class="span7 padding-top-5">
													<?
													if($no_entry==1){
														?>
														<?
													}
													else{
														if( $pl->Result2B2=="nVB")
														{
															?>---<?
														}
														else if( $pl->Result2B2 =="VB")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else {
															?>---<?
														}
													}
													?>
												</div>
											</div>
											
										</div>
										<!-- further assessment -->
										<div class="span4">
											<div class="row-fluid">
												<div class="span12">
													<b style="text-decoration: underline;">Social Preference</b>
												</div>
											</div>
											<div class="row-fluid">
											<!-- Dyslexic -->
												<div class="span12 padding-top-5">
													
													<?
												if($no_entry==1){
														?>

														<?
													}
													else{
														if($pl->midpoint=="0" || $pl->midpoint=="2" || $pl->Result4A1=="")
														{
															if( $pl->Result1A2 == "SLF")
															{
																?>Self Study<?
															}
															else if( $pl->Result1A2 == "GRP")
															{
																?>Group Study<?
															}
															else {
																echo "---";
															}
														}
														else{
															if( $pl->Result4A1 == "SLF")
															{
																?>Self Study<?
															}
															else if( $pl->Result4A1 == "GRP")
															{
																?>Group Study<?
															}
															else {
																echo "---";
															}
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="span4">
											<div class="row-fluid">
												<div class="span12">
													<b style="text-decoration: underline;">Review Indicator</b>
												</div>
											</div>
											<!-- <div class="row-fluid"> -->
											<!-- autism -->
												
											<div class="row-fluid">
											<!-- Dyslexic -->
												<div class="span6 padding-top-5">Auditory Sensitive :</div>
												<div class="span6 padding-top-5">
													<?
													if($no_entry==1){
														?>
														<?
													}
													else{
														if($pl->Result2C1!="" && $pl->Result2C2!="" && $pl->Result2C3!="")
														{
															if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
															{
																echo "---";
															}
															else if(($pl->Result2C1=="nML"||$pl->Result2C1==$to)&&($pl->Result2C2=="nML"||$pl->Result2C2==$to)&&($pl->Result2C3=="nML"||$pl->Result2C3==$to))
															{
																?><i style="color: green;" class="fa fa-check"></i><?
															}
															else{
																echo "---";
															}
														}
													}
													?>
												</div>
											</div>
											<div class="row-fluid">
											<!-- ADD -->
												<div class="span6 padding-top-5">Attention Sensitive :</div>
												<div class="span6 padding-top-5">
													<?
													if($no_entry==1){
														?>
														<?
													}
													else{
														if($pl->midpoint=="1" )
														{
															?>---<?
														}
														else if ($pl->midpoint=="2")
														{
															?>
															<i style="color:green;" class="fa fa-check"></i>
															<?
														}
													}
													?>
												</div>
												
											</div>
											<!-- dev delay -->
											<!-- <div class="row-fluid">
											
												<div class="span3 padding-top-5">Dev Delay :</div>
												<div class="span9 padding-top-5">
													<?
													if($pl->Duration1A1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration1A1;
													}

													if($pl->Duration1A2==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration1A2;
													}

													if($pl->Duration1B1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration1B1;
													}

													if($pl->Duration2A1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2A1;
													}

													if($pl->Duration2B1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2B1;
													}

													if($pl->Duration2B2==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2B2;
													}

													if($pl->Duration2C1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2C1;
													}

													if($pl->Duration2C2==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2C2;
													}

													if($pl->Duration2C3==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2C3;
													}

													if($pl->Duration2C4==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration2C4;
													}

													if($pl->Duration3A1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration3A1;
													}

													if($pl->Duration3A2==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration3A2;
													}

													if($pl->Duration3B1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration3B1;
													}

													if($pl->Duration3B2==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration3B2;
													}

													if($pl->Duration3C1==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration3C2;
													}

													if($pl->Duration4A2==30)
													{
														$count++;
													}
													else{
														$average=$average+$pl->Duration4A2;
													}
													
													$average=$average/16;
													if(($count>=3)||($average>=20))
													{
														?>Y<?
													}
													else{
														?> <?
													}
													

													?>
												</div>
											</div> -->
											
										</div>
									</div>
								</div>
								<div class="portlet box blue">
								<div class="row-fluid">
									<div class="span12">
										
													<div class="portlet-title"><h4>Question Responses</h4></div>
													
												
									</div>
									<div class="portlet-body">
									<div class="span6">
										<table class="table table-striped table-hover table-bordered">
											<thead>
												<tr>
													<th style="text-decoration: underline;">SCREEN</th>
		                                            <th style="text-decoration: underline;">RESPONSE</th>
													<th style="text-decoration: underline;">TIME</th>
													<!-- <th style="text-decoration: underline;">CHECK</th> -->
												</tr>
											</thead>
											<tbody>
												<!-- 1A1 -->
												<tr>
													<td>1A.1</td>
													<td><?=$array_result[$pl->Result1A1] ?></td>
													<!-- <td><?=$pl->Result1A1?></td> -->
													<td><?php echo number_format($pl->Duration1A1,1); ?></td>
													<!-- <td>
														 <?php
														// if($pl->Result1A1 == "PK")
														// {
															// if($pl->Result3B1 == "nPK")
															// {
															// 	echo "3B.1";
															// }
														// }
														// else if($pl->Result1A1 == "nPK")
														// {
															// if($pl->Result3B1 == "PK")
															// {
															// 	echo "3B.1";
															// }
														// }
														?>
													</td> -->
												</tr>
												<!-- 1A2 -->
												<tr>
													<td>1A.2</td>
													<td>
														<?//$array_result[$pl->Result1A2]?>
														<?php
														if($pl->Result1A2 != "")
														{
															if($pl->Result1A1 == "PK")
															{
																if($pl->midpoint == "2")
																{
																	if($pl->Result1A2 == "SLF")
																	{
																		echo $array_result["SLF"];
																	}
																	else if($pl->Result1A2 == "GRP")
																	{
																		echo $array_result["GRP"];
																	}
																	else if($pl->Result1A2 == $to)
																	{
																		echo $array_result["TO"];
																	}
																}
																else {
																	if($pl->Result4A1 == "")
																	{
																		if($pl->Result1A2 == "SLF")
																		{
																			echo $array_result["SLF"];
																		}
																		else if($pl->Result1A2 == "GRP")
																		{
																			echo $array_result["GRP"];
																		}
																		else if($pl->Result1A2 == $to)
																		{
																			echo $array_result["TO"];
																		}
																	}
																	if($pl->Result4A1 == "SLF")
																	{
																		echo $array_result["SLF"];
																	}
																	else if($pl->Result4A1 == "GRP")
																	{
																		echo $array_result["GRP"];
																	}
																	else if($pl->Result4A1 == $to)
																	{
																		echo $array_result["TO"];
																	}
																}
															}
															else if($pl->Result1A1 == "nPK")
															{
																echo "---";
															}
														}
														?>
													</td>
													<!-- <td><?=$pl->Result1A2?></td> -->
													<td><?php echo number_format($pl->Duration1A2,1); ?></td>
													<!-- <td>
														
													</td> -->
												</tr>
												<!-- 1B1 -->
												<tr>
													<td>1B.1</td>
													<td><?=$array_result[$pl->Result1B1]?></td>
													<!-- <td><?=$pl->Result1B1?></td> -->
													<td><?php echo number_format($pl->Duration1B1,1); ?></td>
													<!-- <td> </td> -->
												</tr>
												<!-- 2A1 -->
												<tr>
													<td>2A.1</td>
													<td>
														<?//$array_result[$pl->Result2A1]?>
														<?php
														if($pl->Result2A1 != "")
														{
															if($pl->Result2B2 == "VB")
															{
																// if($pl->Result2B2 == "nVB")
																// {
																	echo $array_result["VB"];
																//}
															}
															else if($pl->Result2B2 == "nVB")
															{
																// if($pl->Result2B2 == "VB")
																// {
																	echo $array_result["nVB"];
																// }
															}
															else if($pl->Result2B2 == $to)
															{
																echo $array_result["TO"];
															}
														}
														?>
													</td>
													<!-- <td><?=$pl->Result2A1?></td> -->
													<td><?php echo number_format($pl->Duration2A1,1); ?></td>
													<!-- <td>
														
													</td> -->
												</tr>
												<!-- 2B1 -->
												<tr>
													<td>2B.1</td>
													<td><?=$array_result[$pl->Result2B1]?></td>
													<!-- <td><?=$pl->Result2B1?></td> -->
													<td><?php echo number_format($pl->Duration2B1,1); ?></td>
													<!-- <td>
														<?php
														if($pl->Result2B1 == "AA")
														{
															
														}
														else if($pl->Result2B1 == "nAA")
														{
															
														}
														?>
													</td> -->
												</tr>
												<!-- 2B2 -->
												<tr>
													<td>2B.2</td>
													<td><?=$array_result[$pl->Result2B2]?></td>
													<!-- <td><?=$pl->Result2B2?></td> -->
													<td><?php echo number_format($pl->Duration2B2,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result2B2 == "VB")
														// {
														// 	if($pl->Result2A1 == "nVB")
														// 	{
														// 		echo "2A.1";
														// 	}
														// }
														// else if($pl->Result2B2 == "nVB")
														// {
														// 	if($pl->Result2A1 == "VB")
														// 	{
														// 		echo "2A.1";
														// 	}
														// }
														
														?>
													</td> -->
												</tr>
												<!-- 2C1 -->
												<tr>
													<td>2C.1</td>
													<td>
														<?//array_result[$pl->Result2C1]?>
														<?php
														if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
														{
															echo $array_result["ML"];
														}
														else if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML" && $pl->Result2C3 == "nML")
														{
															echo $array_result["nML"];
														}
														else if($pl->Result2C1==$to && $pl->Result2C2==$to && $pl->Result2C3==$to )
															{
																echo $array_result[$to];
															}
														else if($pl->Result2C1 == "" && $pl->Result2C2 == "" && $pl->Result2C3 == "")
														{
															echo "";
														}
														else{
															echo "---";
														}
														?>
													</td>
													<!-- <td><?=$pl->Result2C1?></td> -->
													<td><?php echo number_format($pl->Duration2C1,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result2C1 == "ML")
														// {
														// 	if($pl->Result2C2 == "nML" && $pl->Result2C3 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.2, 2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C2 == "nML" && $pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.2, 2C.3";
														// 	}
														// 	else if($pl->Result2C2 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C3 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C2 == "nML")
														// 	{
														// 		echo "2C.2";
														// 	}
														// 	else if($pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.3";
														// 	}
														// 	else if($pl->Result3A2 == "nML")
														// 	{
														// 		echo "3A.2";
														// 	}
														// }
														// else if($pl->Result2C1 == "nML")
														// {
														// 	if($pl->Result2C2 == "ML" && $pl->Result2C3 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.2, 2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.2, 2C.3";
														// 	}
														// 	else if($pl->Result2C2 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C3 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C2 == "ML")
														// 	{
														// 		echo "2C.2";
														// 	}
														// 	else if($pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.3";
														// 	}
														// 	else if($pl->Result3A2 == "ML")
														// 	{
														// 		echo "3A.2";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 2C2 -->
												<tr>
													<td>2C.2</td>
													<td>
														<?//$array_result[$pl->Result2C2]?>
														<?php
														if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
														{
															echo $array_result["ML"];
														}
														else if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML" && $pl->Result2C3 == "nML")
														{
															echo $array_result["nML"];
														}
														else if($pl->Result2C1==$to && $pl->Result2C2==$to && $pl->Result2C3==$to )
															{
																echo $array_result[$to];
															}
														else if($pl->Result2C1 == "" && $pl->Result2C2 == "" && $pl->Result2C3 == "")
														{
															echo "";
														}
														else{
															echo "---";
														}
														?>
													</td>
													<!-- <td><?=$pl->Result2C2?></td> -->
													<td><?php echo number_format($pl->Duration2C2,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result2C2 == "ML")
														// {
														// 	if($pl->Result2C1 == "nML" && $pl->Result2C3 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.1, 2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "nML" && $pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.1, 2C.3";
														// 	}
														// 	else if($pl->Result2C1 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.1, 3A.2";
														// 	}
														// 	else if($pl->Result2C3 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "nML")
														// 	{
														// 		echo "2C.1";
														// 	}
														// 	else if($pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.3";
														// 	}
														// 	else if($pl->Result3A2 == "nML")
														// 	{
														// 		echo "3A.2";
														// 	}
														// }
														// else if($pl->Result2C2 == "nML")
														// {
														// 	if($pl->Result2C1 == "ML" && $pl->Result2C3 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.1, 2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "ML" && $pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.1, 2C.3";
														// 	}
														// 	else if($pl->Result2C1 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.1, 3A.2";
														// 	}
														// 	else if($pl->Result2C3 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.3, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "ML")
														// 	{
														// 		echo "2C.1";
														// 	}
														// 	else if($pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.3";
														// 	}
														// 	else if($pl->Result3A2 == "ML")
														// 	{
														// 		echo "3A.2";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 1A1 -->
												<!-- 2c3 -->
												<tr>
													<td>2C.3</td>
													<td>
														<?//$array_result[$pl->Result2C3]?>
														<?php
														if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
														{
															echo $array_result["ML"];
														}
														else if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML" && $pl->Result2C3 == "nML")
														{
															echo $array_result["nML"];
														}
														else if($pl->Result2C1==$to && $pl->Result2C2==$to && $pl->Result2C3==$to )
															{
																echo $array_result[$to];
															}
														else if($pl->Result2C1 == "" && $pl->Result2C2 == "" && $pl->Result2C3 == "")
														{
															echo "";
														}
														else{
															echo "---";
														}
														?>
													</td>
													<!-- <td><?=$pl->Result2C3?></td> -->
													<td><?php echo number_format($pl->Duration2C3,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result2C3 == "ML")
														// {
														// 	if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.1, 2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML")
														// 	{
														// 		echo "2C.1, 2C.2";
														// 	}
														// 	else if($pl->Result2C1 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.1, 3A.2";
														// 	}
														// 	else if($pl->Result2C2 == "nML" && $pl->Result3A2 == "nML")
														// 	{
														// 		echo "2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "nML")
														// 	{
														// 		echo "2C.1";
														// 	}
														// 	else if($pl->Result2C2 == "nML")
														// 	{
														// 		echo "2C.2";
														// 	}
														// 	else if($pl->Result3A2 == "nML")
														// 	{
														// 		echo "3A.2";
														// 	}
														// }
														// else if($pl->Result2C3 == "nML")
														// {
														// 	if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.1, 2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML")
														// 	{
														// 		echo "2C.1, 2C.2";
														// 	}
														// 	else if($pl->Result2C1 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C2 == "ML" && $pl->Result3A2 == "ML")
														// 	{
														// 		echo "2C.2, 3A.2";
														// 	}
														// 	else if($pl->Result2C1 == "ML")
														// 	{
														// 		echo "2C.1";
														// 	}
														// 	else if($pl->Result2C2 == "ML")
														// 	{
														// 		echo "2C.2";
														// 	}
														// 	else if($pl->Result3A2 == "ML")
														// 	{
														// 		echo "3A.2";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 2C4 -->
												<!-- <tr>
													<td>2C.4</td>
													<td><?=$array_result[$pl->Result2C4]?></td>-->
													<!-- <td><?=$pl->Result2C4?></td> -->
													<!--<td><?php //echo number_format($pl->Duration2C4,1); ?></td>
													<td> </td>
												</tr> -->
											</tbody>
										</table>
									</div>
									<div class="span6">
										<table class="table table-striped table-hover table-bordered">
											<thead>
												<tr>
													<th style="text-decoration: underline;">SCREEN</th>
		                                            <th style="text-decoration: underline;">RESPONSE</th>
													<th style="text-decoration: underline;">TIME</th>
													<!-- <th style="text-decoration: underline;">CHECK</th> -->
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Midpoint</td>
													<td>
														<?php
														if($pl->midpoint == "1")
														{
															echo "Go";
														}
														else if($pl->midpoint == "2")
														{
															echo "Stop";
														}
														?>
													</td>
													<td></td>
													<!-- <td></td> -->
												</tr>
												<!-- 3A1 -->
												<tr>
													<td>3A.1</td>
													<td><?=$array_result[$pl->Result3A1]?></td>
													<!-- <td><?=$pl->Result3A1?></td> -->
													<td><?php echo number_format($pl->Duration3A1,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result3A1== "nNS")
														// {
														// 	if($pl->Result3B3 == "NS")
														// 	{
														// 		echo "3B.3";
														// 	}
														// }
														// else if($pl->Result3A1 == "NS")
														// {
														// 	if($pl->Result3B3 == "nNS")
														// 	{
														// 		echo "3B.3";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 3A2 -->
												<tr>
													<td>3A.2</td>
													<td>
														<?//$array_result[$pl->Result3A2]?>
														<?php
														if($pl->Result3A2 != "")
														{
															if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
															{
																echo $array_result["ML"];
															}
															else
															{ 
																if($pl->Result3A2 == "ML")
																{
																	echo $array_result["ML"];
																}
																else if($pl->Result3A2 == "nML")
																{
																	echo $array_result["nML"];
																}
																else if($pl->Result3A2 == $to)
																{
																	echo $array_result["TO"];
																}
															}
														}
														?>
													</td>
													<!-- <td><?=$pl->Result3A2?></td> -->
													<td><?php echo number_format($pl->Duration3A2,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result3A2 == "ML")
														// {
														// 	if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML" && $pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.1, 2C.2, 2C.3";
														// 	}
														// 	else if($pl->Result2C1 == "nML" && $pl->Result2C2 == "nML")
														// 	{
														// 		echo "2C.1, 2C.2";
														// 	}
														// 	else if($pl->Result2C1 == "nML" && $pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.1, 2C.3";
														// 	}
														// 	else if($pl->Result2C2 == "nML" && $pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.2, 2C.3";
														// 	}
														// 	else if($pl->Result2C1 == "nML")
														// 	{
														// 		echo "2C.1";
														// 	}
														// 	else if($pl->Result2C2 == "nML")
														// 	{
														// 		echo "2C.2";
														// 	}
														// 	else if($pl->Result2C3 == "nML")
														// 	{
														// 		echo "2C.3";
														// 	}
														// }
														// else if($pl->Result3A2 == "nML")
														// {
														// 	if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.1, 2C.2, 2C.3";
														// 	}
														// 	else if($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML")
														// 	{
														// 		echo "2C.1, 2C.2";
														// 	}
														// 	else if($pl->Result2C1 == "ML" && $pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.1, 2C.3";
														// 	}
														// 	else if($pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.2, 2C.3";
														// 	}
														// 	else if($pl->Result2C1 == "ML")
														// 	{
														// 		echo "2C.1";
														// 	}
														// 	else if($pl->Result2C2 == "ML")
														// 	{
														// 		echo "2C.2";
														// 	}
														// 	else if($pl->Result2C3 == "ML")
														// 	{
														// 		echo "2C.3";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 3B1 -->
												<tr>
													<td>3B.1</td>
													<td>
														<?//$array_result[$pl->Result3B1]?>
														<?php
														if($pl->Result3B1 != "")
														{
															if($pl->Result1A1 == "PK")
															{
																echo $array_result["PK"];
															}
															else if($pl->Result1A1 == "nPK")
															{
																echo $array_result["nPK"];
															}
															else if($pl->Result1A1 == $to)
															{
																echo $array_result["TO"];
															}
														}
														?>
													</td>
													<!-- <td><?=$pl->Result3B1?></td> -->
													<td><?php echo number_format($pl->Duration3B1,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result3B1== "PK")
														// {
														// 	if($pl->Result1A1 == "nPK")
														// 	{
														// 		echo "1A.1";
														// 	}
														// }
														// else if($pl->Result3B1 == "nPK")
														// {
														// 	if($pl->Result1A1 == "PK")
														// 	{
														// 		echo "1A.1";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 3B2 -->
												<tr>
													<td>3B.2</td>
													<td><?=$array_result[$pl->Result3B2]?></td>
													<!-- <td><?=$pl->Result3B2?></td> -->
													<td><?php echo number_format($pl->Duration3B2,1); ?></td>
													<!-- <td>
														
													</td> -->
												</tr>
												<!-- 3C1 -->
												<tr>
													<td>3B.3</td>
													<td>
														<?//$array_result[$pl->Result3B3]?>
														<?php
														if($pl->Result3B3 != "")
														{
															if($pl->Result3A1 == "NS")
															{
																echo $array_result["NS"];
															}
															else if($pl->Result3A1 == "nNS")
															{
																echo $array_result["nNS"];
															}
															else if($pl->Result3A1 == $to)
															{
																echo $array_result['TO'];
															}
														}
														?>
													</td>
													<!-- <td><?=$pl->Result3C1?></td> -->
													<td><?php echo number_format($pl->Duration3B3,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result3B3 == "NS")
														// {
														// 	if($pl->Result3A1 == "nNS" )
														// 	{
														// 		echo "3A.1";
														// 	}
														// }
														// else if($pl->Result3B3 == "nNS")
														// {
														// 	if($pl->Result3A1 == "NS" )
														// 	{
														// 		echo "3A.1";
														// 	}
														// }
														?>
													</td> -->
												</tr>
												<!-- 4A1 -->
												<tr>
													<td>4A.1</td>
													<td>
														<?//$array_result[$pl->Result4A1]?>
														<?php
														if($pl->Result4A1 != "")
														{
															// if($pl->Result1A1 == "nPK")
															// {
																if($pl->Result4A1 == "SLF")
																{
																	echo $array_result["SLF"];
																}
																else if($pl->Result4A1 == "GRP")
																{
																	echo $array_result["GRP"];
																}
																else if($pl->Result4A1 == $to)
																{
																	echo $array_result['TO'];
																}
																else {
																	echo "";
																}
															// }
															// else if($pl->Result1A1 == "PK")
															// {
															// 	echo "---";
															// }
														}
														?>
													</td>
													<!-- <td><?=$pl->Result4B1?></td> -->
													<td><?php echo number_format($pl->Duration4A1,1); ?></td>
													<!-- <td>
														<?php
														// if($pl->Result4A1 == "SLF")
														// {
														// 	if($pl->Result1A2 == "GRP")
														// 	{
														// 		echo "1A.2";
														// 	}
														// }
														// else if($pl->Result4A1 == "GRP")
														// {
														// 	if($pl->Result1A2 == "SLF")
														// 	{
														// 		echo "1A.2";
														// 	}
														// }
														?>
													</td> -->
												</tr>
											</tbody>
										</table>
									</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12">
										<p style="margin: 5px 15px;">
											<strong>Note :</strong> Each task will time out at 30 seconds
										</p>
									</div>
								</div>
								</div>
							</div>
						</div>
						<?php //} ?>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<? include 'footer.php'; ?>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_editable");
			App.init();
		});
	
	function check_del(id)
	{
		if(!confirm("Are You Sure to Delete This Record"))
		{
			return false;
		}
		else
		{
			window.location='view_school.php?id='+id;
		}
	}
	
	/* common function for chnage status
	id = id which status is changed
	table = table in which the data is changed
	status_field = status field name wihch was updated
	id_field = id field name which is update
	status = status which is change
*/
function change_status(id, table, status_field, id_field, status) {
	jQuery(document).ready(function ($) {

	$('#loading').fadeIn('slow');
	var formURL = "change_status_file.php?id="+id+"&table="+table+"&status_field="+status_field+"&id_field="+id_field+"&status="+status;
	jQuery.ajax({
		url: formURL,
		type: "POST",
		contentType: false,
		cache: false,
		processData:false,
		success: function( data, textStatus, jqXHR ) {
			json_data = JSON.parse(data);
			$('#loading').fadeOut('slow');
			if(json_data.Result == "0")
			{
			}
			else if(json_data.Result == "1")
			{
				window.location = 'view_school.php';
			}
			setTimeout(function(){$('#loading_div_show').fadeOut('slow');}, 500);
		},
		error: function( jqXHR, textStatus, errorThrown ) {
		}
	});
	e.preventDefault();


	});
}
function do_action(action)
{
	if(confirm("Are You Sure to Perform This Action"))
	{
		$("#action_type").val(action);
		$("#form").submit();
	}
}
	</script>
</body>
<!-- END BODY -->
</html>
