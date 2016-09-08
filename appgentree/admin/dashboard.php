<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("../index.php");
}
$page_name = basename($_SERVER['PHP_SELF']);
$get_detail = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$_SESSION['admin_panel']."'");
$get_class = $db->get_results("select * from ".TABLE_CLASS." where teacher_id = '".$_SESSION['admin_panel']."'");

?>
<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title><?=SITE_TITLE?> | Dashboard</title>
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
						<div class="row-fluid">
							<div class="span6">
								<h3 class="page-title">
									Dashboard				
								</h3>
							</div>
							<div class="span2">
								<a class="btn" style="text-decoration: none;background-color: #4B8DF8;color: white;margin: 20px 0 15px 0;" href="class_result.php">Class Reports</a>
							</div>
							<div class="span2">
								<a class="btn" style="text-decoration: none;background-color: #4B8DF8;color: white;margin: 20px 0 15px 0;" href="add_class.php">Add Class</a>
							</div>
							<div class="span2">
								<?php if(count($get_class)>0) { ?>
								<a class="btn" style="text-decoration: none;background-color: #4B8DF8;color: white;margin: 20px 0 15px 0;" href="add_child.php?classid=<?=$get_class[0]->class_id?>">Add Child</a>
								<?php } ?>
							</div>
							
						</div>			
								
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="dashboard.php">Dashboard</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER -->

				<div id="dashboard" style="font-size: 14px;">
					<div class="row-fluid">
						<div class="span12 view-profile11">
							<div class="row-fluid">
								<div class="span10">
									<h2 style="text-decoration: none;padding: 5px;background-color: #eee;margin-bottom: 10px;">Teacher UID :<b> <?=$get_detail[0]->teacher_username?></b></h2>
								</div>
								<div class="span2 padding-top-5">
									<a class="btn-design" style="background-color: #4B8DF8;color: white;" href="edit-profile.php?teacherid=<?=$_SESSION['admin_panel']?>">Edit Profile</a>
								</div>
							</div>
							
							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>Name:</strong></div>
										<div class="span6"><?=$get_detail[0]->firstname?>&nbsp;<?=$get_detail[0]->lastname?></div>
									</div>
									
								</div>
								<div class="span7 padding-top-5">
									<div class="row-fluid">
										<div class="span5"><strong>Email:</strong></div>
										<div class="span7" style="text-transform: lowercase;"><?=$get_detail[0]->teacher_email?></div>
									</div>
								
									
								</div>
								
							</div>

							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>School</strong>:</div>
										<?php $school = $db->get_results("select * from ".TABLE_SCHOOL." Where school_id='".$get_detail[0]->school_id."'"); ?>
										<div class="span6"><?=$school[0]->school_name?></div>
									</div>
									
								</div>
								<div class="span7 padding-top-5">
									<div class="row-fluid">
										<div class="span5"><strong>Special Education Experience</strong>:</div>
										<div class="span7"><?php if($get_detail[0]->spl_ed_exp=='y'){ ?><?="Yes"?><?php }else if($get_detail[0]->spl_ed_exp=='n') { ?><?="No"?><?php }else{ ?><?="Unknown"?><?php } ?></div>
									</div>
									
								</div>
							</div>
							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>Highest Certification Received</strong>:</div>
										<div class="span6"><?=$get_detail[0]->certification?></div>
									</div>
									
								</div>
								<div class="span7 padding-top-5">
									<div class="row-fluid">
										<div class="span5"><strong>Highest Certification Received Date</strong>:</div>
										<div class="span7">
										<?php if($get_detail[0]->certification_date!='0000-00-00') { ?>
										<?=date('m-d-Y', strtotime($get_detail[0]->certification_date))?>
										<?php }else{ ?>
										<?="-"?>
										<?php } ?>
										</div>
									</div>
									 
								</div>
							</div>
							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>Gender</strong>:</div>
										<div class="span6"><?php if($get_detail[0]->sex=='m'){ ?><?="Male"?><?php }else if($get_detail[0]->sex=='f') { ?><?="Female"?><?php }else{ ?><?="-"?><?php } ?></div>
									</div>
								</div>
								<div class="span7 padding-top-5">
									<div class="row-fluid">
										<div class="span5"><strong>No. of years teaching</strong>:</div>
										<div class="span7"><?=$get_detail[0]->nr_year_teaching?></div>
									</div>
								</div>
							</div>
							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>Color Blind</strong>:</div>
										<div class="span6"><?php if($get_detail[0]->color_blind=='y'){ ?><?="Yes"?><?php }else if($get_detail[0]->color_blind=='n') { ?><?="No"?><?php }else{ ?><?="Unknown"?><?php } ?></div>
									</div>
									 
								</div>
								<div class="span7 padding-top-5">
									<div class="row-fluid">
										<div class="span5"><strong>No. of years education</strong>:</div>
										<div class="span7"><?=$get_detail[0]->nr_year_education?></div>
									</div>
									 
								</div>
							</div>
							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>Subject</strong>:</div>
										<div class="span6"><?=$get_detail[0]->subject?></div>
									</div>
									
								</div>
								<div class="span7 padding-top-5">
									<div class="row-fluid">
										<div class="span5"><strong>Favorite Subject</strong>:</div>
										<div class="span7"><?=$get_detail[0]->favorite_subject?></div>
									</div>
									
								</div>
							</div>
							<div class="row-fluid" style="border-bottom:1px solid #eee;">
								<div class="span5 padding-top-5">
									<div class="row-fluid">
										<div class="span6"><strong>Known learning preference</strong>:</div>
										<div class="span6"><?=ucfirst($get_detail[0]->known_learning_pref)?></div>
									</div>
									
								</div>
								<div class="span7 padding-top-5">
									
								</div>
							</div>
						</div>
						<div class="span4 " style="display:none">
							
							<div class="row-fluid">
								<div class="span12">
									<!-- BEGIN EXAMPLE TABLE PORTLET-->
									<div class="portlet box blue">
										<div class="portlet-title"><h4>Recent Activity</h4></div>
										<div class="portlet-body">
											
			                                <form method="post" id="form">
			                                <input type="hidden" name="action_type" id="action_type">
											<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
												<thead>
													<tr>
                                                        <th>Childname</th>
			                                            <th>Child Id</th>
														<th>Class</th>
			                                            
													</tr>
												</thead>
												<tbody>
			                                    	<?
													$i = 1;
													$property_list = $db->get_results("select * from ".TABLE_CHILD." Where class_id='".$_GET['classid']."'");
													foreach($property_list as $pl)
													{
													?>
													<tr class="">
														
			                                            
														<td><?=$pl->child_username?></td>
			                                            <td><?=$pl->child_firstname." ".$pl->child_lastname?></td>
			                                            <td><?=$pl->class_id?></td>
			                                            
													</tr>

			                                        <?
													$i++;
													}
													?>
												</tbody>
											</table>
			                                
			     
			                                </form>
										</div>
									</div>
									<!-- END EXAMPLE TABLE PORTLET-->
								</div>
							</div>
						</div>
					</div>
				</div>
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
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>	
	<![endif]-->	
	<script src="assets/breakpoints/breakpoints.js"></script>		
	<script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>	
	<script src="assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
	<script src="assets/flot/jquery.flot.js"></script>
	<script src="assets/flot/jquery.flot.resize.js"></script>

	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>	
	<script src="assets/js/app.js"></script>				
	<script>
		jQuery(document).ready(function() {		
			//App.setPage("index");  // set current page
			App.init(); // init the rest of plugins and elements
		});
	</script>
    
    <script>
	
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
				window.location = 'dashboard.php';
			}
			setTimeout(function(){$('#loading_div_show').fadeOut('slow');}, 500);
		},
		error: function( jqXHR, textStatus, errorThrown ) {
		}
	});
	e.preventDefault();


	});
}
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
