<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("index.php");
}
// Check that class to login teacher or not
$check_class = $db->get_results("select * from ".TABLE_CLASS." Where class_id='".$_GET['classid']."' and teacher_id='".$_SESSION['admin_panel']."'");
if(count($check_class)==0)
redirect('dashboard.php');


if($_GET['id'] != "")
{
	$db->get_results("delete from ".TABLE_CHILD." where child_id = '".$_GET['id']."'");
	redirct("view_child.php?classid=".$_GET['classid']);
}
if($_POST['action_type'] != "" && count($_POST['ids']) > 0)
{
	foreach($_POST['ids'] as $ids)
	{
		if($_POST['action_type'] == "delete")
		{
			$db->get_results("delete from ".TABLE_CHILD." where child_id = '".$ids."'");
		}
		
	}
	redirct("view_child.php?classid=".$_GET['classid']);
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
						<h3 class="page-title">View Child</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>View Child </li>
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
							<div class="portlet-title"><h4>View Child</h4></div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group">
										<button class="btn green" onClick="window.location='add_child.php?classid=<?=$_GET['classid']?>'">
										Add New Child&nbsp;<i class="icon-plus"></i>
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
                                            <th>Username</th>
                                            <th>Name</th>
											<th>Class</th>
                                            <th>DOB</th>
                                            <th>Gender</th>
                                            <th>Race</th>
                                            <th>Glasses</th>
                                            <th>Color Blind</th>
                                            <th>Hearing Impaired</th>
                                            <th>Known Learning Difference</th>
                                            <th>Action</th>
                                            <th>Result</th>
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
											<td><?=$i?></td>
                                            <td><input type="checkbox" name="ids[]" value="<?=$pl->child_id?>"></td>
											<td><?=$pl->child_username?></td>
                                            <td><?=$pl->child_firstname." ".$pl->child_lastname?></td>
                                            <?php $cl = $db->get_results("select * from ".TABLE_CLASS." Where class_id='".$pl->class_id."'"); ?>
                                            <td><?=stripslashes($cl[0]->class_name)?></td>
                                            <td><?=date('m-d-Y', strtotime($pl->dob))?></td>
                                            <td><?php if($pl->sex =='m'){ echo "Male"; }else{ echo 'Female';}?></td>
                                            <td><?=$pl->race?></td>
                                            <td><?=getValue($pl->glasses)?></td>
                                            <td><?=getValue($pl->color_blind)?></td>
                                           <!--  <td><?=$pl->hearing_impaired?></td> -->
                                            
                                            <td><?=getValue($pl->hearing_impaired)?></td>
                                            <td><?=$pl->known_learning_diff?></td>
											<td><a href="add_child.php?editid=<?=$pl->child_id?>&classid=<?=$_GET['classid']?>">Edit</a> | <a onClick="check_del('<?=$pl->child_id?>')">Delete</a></td>

											<?php
											$classname=addslashes($cl[0]->class_name);
											 $get_student = $db->get_results("select * from ".TABLE_RESULT." where teacher_id = '".$_SESSION['admin_panel']."' and class_id = '".$cl[0]->class_id."' and child_id  = '".$pl->child_id."' ORDER BY result_id DESC");
											
											?>

                                            <td><a href="view_result.php?childid=<?=$pl->child_id?>&classid=<?=$_GET['classid']?>&resultid=<?=$get_student[0]->result_id?>">View</a></td>
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
			window.location='view_child.php?id='+id+"&classid="+<?php echo $_GET['classid'] ?>;
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
				window.location = 'view_school.php?classid=<?=$_GET['classid']?>';
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
	<?php
	function getValue($c)
	{
		$str;
		switch($c)
		{
			case 'n':
			$str="No";
			break;

			case 'y':
			$str="Yes";
			break;

			case 'u':
			$str="Unknown";
			break;

			Default:
			$str="Unknown";
			break;
		}

		return $str;
	}
	?>
</body>
<!-- END BODY -->
</html>
