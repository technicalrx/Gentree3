<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("index.php");
}
if($_POST['submit'] == "Save" && $_GET['editid'] == '')
{
	$data = array(
		
			"school_name" 			=>	sqlinj($_POST['school_name']),
			"school_address1" 		=>	sqlinj($_POST['school_address1']),
      "school_address2"     =>  sqlinj($_POST['school_address2']),
			"school_state" 			=>	sqlinj($_POST['school_state']),
      "school_city"      =>  sqlinj($_POST['school_city']),
			"school_zip" 			=>	sqlinj($_POST['school_zip']),
      "school_type"      =>  sqlinj($_POST['school_type']),
      "school_year_div"      =>  sqlinj($_POST['school_year_div']),
	);
	$table = TABLE_SCHOOL;
	$db->insert($table, $data);
	$insert_id = $db->insert_id;
	
	// if($_FILES['school_image']['name'] != "")
	// {
	// 	$id = $insert_id;
	// 	$valiad_mime_types = array('jpg', 'jpeg', 'png', 'gif');
	// 	$destination_dir = '../school_img/';
	// 	$file_name = upload_file($_FILES['school_image'], $destination_dir, $valiad_mime_types, $id);
	// 	$data = array(
	// 		"school_image"  => $file_name,
	// 	);
	// 	$table = TABLE_SCHOOL;
	// 	$where = array("school_id" => $insert_id );
	// 	$db->update($table, $data, $where); 
	// }
	
	redirct("edit-profile.php?schoolid=".$insert_id."&teacherid='".$_SESSION['admin_panel']."");
}
if($_GET['editid'] != '')
{
	$get_property_detail = $db->get_results("select * from ".TABLE_SCHOOL." where school_id = '".$_GET['editid']."'");
	if($_POST['submit'] == "Save")
	{
		$data = array(
      "school_name"       =>  sqlinj($_POST['school_name']),
      "school_address1"     =>  sqlinj($_POST['school_address1']),
      "school_address2"     =>  sqlinj($_POST['school_address2']),
      "school_state"      =>  sqlinj($_POST['school_state']),
      "school_city"      =>  sqlinj($_POST['school_city']),
      "school_zip"      =>  sqlinj($_POST['school_zip']),
      "school_type"      =>  sqlinj($_POST['school_type']),
      "school_year_div"      =>  sqlinj($_POST['school_year_div']),

		);
		$table = TABLE_SCHOOL;
		$where = array("school_id" => $_GET['editid']);
		$db->update($table, $data, $where);	
		
		
		// if($_FILES['school_image']['name'] != "")
		// {
		// 	$id = $_GET['editid'];
		// 	$valiad_mime_types = array('jpg', 'jpeg', 'png', 'gif');
		// 	$destination_dir = '../school_img/';
		// 	unlink($destination_dir.$get_property_detail[0]->school_image);
		// 	$file_name = upload_file($_FILES['school_image'], $destination_dir, $valiad_mime_types, $id);
		// 	$data = array(
		// 		"school_image"  => $file_name,
		// 	);
		// 	$table = TABLE_SCHOOL;
		// 	$where = array("school_id" => $_GET['editid']);
		// 	$db->update($table, $data, $where); 
		// }
		
		redirct("add_class.php");
	}
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title>
<?=SITE_TITLE?>
</title>
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
          <h3 class="page-title">Add School</h3>
          <ul class="breadcrumb">
            <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
            <li>Add School </li>
          </ul>
        </div>
      </div>
      <!-- END PAGE HEADER--> 
      <!-- BEGIN PAGE CONTENT-->
      <div class="row-fluid">
        <div class="span12">
          <div class="tabbable tabbable-custom boxless">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="portlet box blue">
                  <div class="portlet-title">
                    <h4>Enter Information</h4>
                  </div>
                  <div class="portlet-body form"> 
                    <!-- BEGIN FORM-->
                    <form action="" class="horizontal-form" method="post" enctype="multipart/form-data">
                      <div class="raw-fluid">
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">Name</label>
                                <div class="controls">
                                  <input type="text" class="m-wrap span12" value="<?=$get_property_detail[0]->school_name?>" name="school_name" required>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">Address 1</label>
                                <div class="controls">
                                  <input type="text" class="m-wrap span12" value="<?=$get_property_detail[0]->school_address1?>" name="school_address1" required>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="raw-fluid">
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">Address 2</label>
                                <div class="controls">
                                  <input type="text" class="m-wrap span12" value="<?=$get_property_detail[0]->school_address2?>" name="school_address2">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">State</label>
                                <div class="controls">
                                  <input type="text" class="m-wrap span12" value="<?=$get_property_detail[0]->school_state?>" name="school_state" required>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="raw-fluid">
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">City</label>
                                <div class="controls">
                                  <input type="text" class="m-wrap span12" value="<?=$get_property_detail[0]->school_city?>" name="school_city" required>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">Zipcode</label>
                                <div class="controls">
                                  <input type="text" class="m-wrap span12" value="<?=$get_property_detail[0]->school_zip?>" name="school_zip">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="raw-fluid">
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">School Type</label>
                                <div class="controls">
                                 
                                    <select class="m-wrap span12" name="school_type">
                                            <option value="-">Select School Type</option>
                                            <option <?php if($get_property_detail[0]->school_type=="public") { ?>selected<?php } ?> value="public">Public</option>
                                            <option <?php if($get_property_detail[0]->school_type=="private") { ?>selected<?php } ?> value="private">Private</option>
                                            <option <?php if($get_property_detail[0]->school_type=="charter") { ?>selected<?php } ?> value="charter">Charter</option>
                                        </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">School Year Div</label>
                                <div class="controls">
                                 
                                  <select class="m-wrap span12" value="<?=$get_property_detail[0]->school_year_div?>" name="school_year_div">
                                  <option value="-">Select Year Div</option>
                                  <option <?php if($get_property_detail[0]->school_year_div=="semester") { ?>selected<?php } ?> value="semester">Semester</option>
                                  <option <?php if($get_property_detail[0]->school_year_div=="trimester"){ ?>selected<?php } ?> value="trimester">Trimester</option>
                                  <option <?php if($get_property_detail[0]->school_year_div=="other") { ?>selected<?php } ?> value="other">Other</option>
                                  </select> 
                                       
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    

                      <div class="form-actions">
                        <input type="submit" class="btn blue" name="submit" value="Save">
                      </div>
                    </form>
                    <!-- END FORM--> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END PAGE CONTENT--> 
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
<script src="assets/js/jquery.cookie.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]--> 
<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script> 
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script> 
<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script src="assets/js/app.js"></script> 
<script>
      jQuery(document).ready(function() {       
      
         // to fix chosen dropdown width in inactive hidden tab content
         $('.advance_form_with_chosen_element').on('shown', function (e) {
            App.initChosenSelect('.chosen_category:visible');
         });
      
         // initiate layout and plugins
         App.init();
      });
	  
	  function fetch_state(id) {
		  
		jQuery(document).ready(function ($) {

		$('#loading').fadeIn('slow');
		var formURL = "fetch_state.php?id="+id;
		jQuery.ajax({
			url: formURL,
			type: "POST",
			contentType: false,
			cache: false,
			processData:false,
			success: function( data, textStatus, jqXHR ) {
					$("#replace_state").html(data);
				setTimeout(function(){$('#loading').fadeOut('slow');}, 500);
			},
			error: function( jqXHR, textStatus, errorThrown ) {
			}
		});
		});
	}
   </script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<div style="top:0px; left:0px; height:100%; width:100%; position:fixed; display:none;" id="loading">
  <div style="top:40%; left:50%; position:absolute;"><img src="assets/img/processing.gif" width="132" height="122"></div>
</div>
