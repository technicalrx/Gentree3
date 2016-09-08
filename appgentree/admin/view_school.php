<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("index.php");
}
if($_GET['id'] != "")
{
	$db->get_results("delete from ".TABLE_SCHOOL." where school_id = '".$_GET['id']."'");
	redirct("view_school.php");
}
if($_POST['action_type'] != "" && count($_POST['ids']) > 0)
{
	foreach($_POST['ids'] as $ids)
	{
		if($_POST['action_type'] == "delete")
		{
			$db->get_results("delete from ".TABLE_SCHOOL." where school_id = '".$ids."'");
		}
		
	}
	redirct("view_school.php");
}

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
						<h3 class="page-title">View School</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>View School </li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title"><h4>View Data</h4></div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group">
										<button class="btn green" onClick="window.location='add_school.php'">
										Add New School &nbsp;<i class="icon-plus"></i>
										</button>
									</div>
								</div>
                                <form method="post" id="form">
                                <input type="hidden" name="action_type" id="action_type">
                                <div class="" style="overflow: auto;">
								<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
									<thead>
										<tr>
											<th>S.No</th>
                                            <th></th>
                                            <th>Name</th>
											<th>Address 1</th>
                                            <th>Address 2</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Zip</th>
                                            <th>Type</th>
                                            <th>Year Division</th>
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>
                                    	<?
										$i = 1;
										$property_list = $db->get_results("select * from ".TABLE_SCHOOL."");
										foreach($property_list as $pl)
										{
										?>
										<tr class="">
											<td><?=$i?></td>
                                            <td><input type="checkbox" name="ids[]" value="<?=$pl->school_id?>"></td>
											<td><?=$pl->school_name?></td>
                                            <td><?=$pl->school_address1?></td>
                                            <td><?=$pl->school_address2?></td>
                                            <td><?=$pl->school_state?></td>
                                            <td><?=$pl->school_city?></td>
                                            <td><?=$pl->school_zip?></td>
                                            <td><?=$pl->school_type?></td>
                                            <td><?=$pl->school_year_div?></td>
                                            
											<td><a href="add_school.php?editid=<?=$pl->school_id?>">Edit</a> | <a onClick="check_del('<?=$pl->school_id?>')">Delete</a></td>
                                            
										</tr>
                                        <?
										$i++;
										}
										?>
									</tbody>
								</table>
								</div>
                                <span class="btn red" style="cursor:pointer;" onClick="do_action('delete')">Delete</span>
     
                                </form>
							</div>
						</div>
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
