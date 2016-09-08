<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("index.php");
}
$teacherId=$_SESSION['admin_panel'];

$to = 'TO';
$nul = "";
$check =0;
$cut = 0;
$tar = 0;
$conflict = 0;
$no_entry = 0;


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
	<style type="text/css">
		.portlet.box .portlet-body {
		  
		}
	</style>
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
							<li>View Result</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<?php
				$get_teacher = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$_SESSION['admin_panel']."'");

				$tr=$get_teacher[0];

				$get_classes = $db->get_results("select * from ".TABLE_CLASS." where teacher_id = '".$_SESSION['admin_panel']."'");
				$count_res = 0;
			
				$checkNoResult=true;
				foreach ($get_classes as $cl) {
					
				
					$classname=addslashes($cl->class_name);
					$get_result_count = $db->get_results("select * from ".TABLE_RESULT." where teacher_id = '".$_SESSION['admin_panel']."' and class_id = '".$cl->class_id."'");

					if(count($get_result_count)>0)
					{
						$checkNoResult=false;
						$check_child=0;
						foreach ($get_result_count as $gtr)
						{
								$get_childcount = $db->get_results("select child_id from ".TABLE_CHILD." where child_id = '".$gtr->child_id."'");
								if(count($get_childcount)>0)
								{
									$check_child=1;
									break;
								}

						}
						if($check_child==1)
						{
				?>
				<div class="portlet box blue">
						<div class="portlet-title">
							<h4>Students of <?=stripslashes($cl->class_name)?></h4>
						</div>
						<div class="portlet-body" style="background-color: #f6f6f6;padding: 10px;">
							<div class="row-fluid">
								<div class="span12">
									<div class="row-fluid">
										<div class="span6">
											<h3 style="font-weight: normal;">Class: <?=stripslashes($cl->class_name)?></h3>
										</div>
										<div class="span6">
											<h3 style="font-weight: normal;">Teacher: <?=$tr->firstname." ".$tr->lastname?></h3>
										</div>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span12">
								<div class="" style="overflow: auto;">
									<table class="table table-striped table-hover table-bordered">
										<thead>
											<tr>
												<th style="text-decoration: underline;">S.No</th>
	                                            <th style="text-decoration: underline;">Student</th>
	                                            <th style="text-decoration: underline;">Period</th>
	                                            <th style="text-decoration: underline;text-align: center;">Physical</th>
	                                            <th style="text-decoration: underline;text-align: center;">Visual</th>
	                                            <th style="text-decoration: underline;text-align: center;">Auditory</th>
	                                            <th style="text-decoration: underline;text-align: center;">Math/<br>Logic</th>
	                                            <th style="text-decoration: underline;text-align: center;">Science</th>
	                                            <th style="text-decoration: underline;text-align: center;">Verbal-Linguistic</th>
	                                            <th style="text-decoration: underline;text-align: center;">Social<br>Preference</th>
	                                            <th style="text-decoration: underline;text-align: center;">Auditory<br>Sensitive</th>
	                                            <th style="text-decoration: underline;text-align: center;">Attention<br>Sensitive</th>
	                                            <!-- <th style="text-decoration: underline;text-align: center;">PRI-3</th> -->
	                                            <!-- <th style="text-decoration: underline;">Dev<br>Delay</th> -->
	                                            <th style="text-decoration: underline;text-align: center;">Detail</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$i = 1;
												//$get_student = $db->get_results("select * from ".TABLE_RESULT." where teacher_id = '".$_SESSION['admin_panel']."' and class_id = '".$cl->class_id."' ORDER BY Period DESC");
												$get_student = $db->get_results("select t.* from (select * from ".TABLE_RESULT." where teacher_id = '".$_SESSION['admin_panel']."' and class_id = '".$cl->class_id."' ORDER BY Period DESC , result_id DESC) t GROUP BY t.child_id");

												// $get_student = $db->get_results("select t.* from (select * from ".TABLE_RESULT." where teacher_id = '".$_SESSION['admin_panel']."' and ClassName = '".$classname."' ORDER BY Period DESC , result_id DESC) t GROUP BY t.child_id");
                                               
												foreach ($get_student as $pl) 
												{

													 $check_student = $db->get_results("select * from ".TABLE_CHILD." where child_id=".$pl->child_id);
													 if(count($check_student)==0)
													 	continue;
											?>
											<tr>
												<td><?=$i?></td>
												<td><?=$pl->ChildName?></td>
												<td><?=$pl->Period?></td>
												<!-- Physical -->
												<td style="text-align: center;">
													<?	
													if($pl->Result1A1 == "PK" )
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else
														{
															?>---<?
														}
														
													?>
												</td>
												<!-- Visual -->
													<td style="text-align: center;">
														<?
														if($pl->Result3B2 == "VS")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else
														{
															?>---<?
														}
														
														?>
													</td>
												<!-- Auditory -->
												<td style="text-align: center;">
												<?php
													if($pl->Result2B1 == "AA")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else 
														{
															?>---<?
														}
														
													?>
												</td>
												
												<!-- Math/Logic -->
												<td style="text-align: center;">
													<!-- <?php
													if(($pl->Result2C1 == "ML" && $pl->Result2C2 == "ML" && $pl->Result2C3 == "ML")||($pl->Result3A2 == "ML"))
													{
														?><i style="color: green;" class="fa fa-check"></i><?
													}
													else if(($pl->Result2C1 == $to && $pl->Result2C2 == $to && $pl->Result2C3 == $to)||($pl->Result3A2 == $to))
													{
														?>Review<?
													}
													else if(($pl->Result2C1 == $nul && $pl->Result2C2 == $nul && $pl->Result2C3 == $nul)||($pl->Result3A2 == $nul))
													{
														?>Review<?
													}
													else {
														?>---<?
													}
													?> -->
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
												</td>
													<!-- Nat/Science -->
													<td style="text-align: center;">
													<?php
													if($pl->Result3A1 == "NS")
														{
															?><i style="color: green;" class="fa fa-check"></i><?
														}
														else 
														{
															?>---<?
														}
														
														?>
													</td>
													<td style="text-align:center;">
													<?
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
														?>
													</td>
													<!-- self/group -->
													<td style="text-align: center;">
														<?
														if($pl->midpoint == "0" || $pl->midpoint == "2" || $pl->Result4A1 =="")
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
														?>
													</td>
													
													<!-- Autism -->
													
													<td style="text-align: center;">
														<?
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
														?>
													</td>
													
													<!-- ADD -->
													<td style="text-align: center;">
														<?
															if($pl->midpoint=="1" )
															{
																?>---<?
															}
															else if (($pl->midpoint=="2")||($pl->midpoint=="0")) 
															{
																?>
																<i style="color:green;" class="fa fa-check"></i>
																<?
															}
														?>
													</td>
													
													<!-- dev delay 
													<td>
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
													</td>
													-->
													<td style="text-align: center;">
														<a href="view_result.php?childid=<?=$pl->child_id?>&resultid=<?=$pl->result_id?>">View</a>
													</td>
											</tr>
	                                    	
	                                        <?php
											$i++;
											}
											?> 
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						}

					}

				}
				if($checkNoResult)
				{
					echo "<h1>No Reports Available</h1>";
				}
				?>

				</div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	
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
