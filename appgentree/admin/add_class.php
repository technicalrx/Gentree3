<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("index.php");
}

// Check that class to login teacher or not
if(isset($_GET['editid']))
{
$check_class = $db->get_results("select * from ".TABLE_CLASS." Where class_id='".$_GET['editid']."' and teacher_id='".$_SESSION['admin_panel']."'");
if(count($check_class)==0)
  redirect('dashboard.php');
}

// Get teacher detail
$sid = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$_SESSION['admin_panel']."'");
$s_id=$sid[0]->school_id;
if($_POST['submit'] == "Save" && $_GET['editid'] == '')
{
  $classname=addslashes($_POST['class_name']);
  $check_class_exist=$db->get_results("SELECT * FROM ".TABLE_CLASS." where class_name='".$classname."'");

  if(count($check_class_exist)==0)
  {
    	$data = array(
    		
    			"teacher_id" 			=>	$_SESSION['admin_panel'],  
          "school_id"       => $s_id,
    			"class_name" 			=>	stripslashes($_POST['class_name']),
    			"class_level" 		=>	sqlinj($_POST['class_level']),
    			"class_grade" 			=>	sqlinj($_POST['class_grade']),
    	);
    	$table = TABLE_CLASS;
    	$db->insert($table, $data);
    	$insert_id = $db->insert_id;
      redirct("view_class.php");
	}else
  {
    redirct("add_class.php?class_error='1'");
  }
	
}
if($_GET['editid'] != '')
{
	$get_property_detail = $db->get_results("select * from ".TABLE_CLASS." where class_id = '".$_GET['editid']."'");
	if($_POST['submit'] == "Save")
	{
		$data = array(
      "school_id"     =>  sqlinj($_POST['school_id']),
      "class_name"      =>  $_POST['class_name'],
       "school_id"       => $s_id,
      "class_level"     =>  sqlinj($_POST['class_level']),
      "class_grade"       =>  sqlinj($_POST['class_grade'])
		);
		$table = TABLE_CLASS;
		$where = array("class_id" => $_GET['editid']);
		$db->update($table, $data, $where);	
		

		
		redirct("view_class.php");
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


<script src="../alert/alertify.min.js"></script>
<link href="../alert/alertify.core.css" rel="stylesheet" type="text/css" />
<link href="../alert/alertify.default.css" rel="stylesheet" type="text/css" />

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
          <h3 class="page-title">Add Class</h3>
          <ul class="breadcrumb">
            <li> <i class="icon-home"></i> <a href="assets">Home</a> <span class="icon-angle-right"></span> </li>
            <li>Add Class</li>
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


                     

                      <div class="row-fluid">
                      <?php
                      $get_number_classes = $db->get_results("select * from ".TABLE_CLASS." where teacher_id = '".$_SESSION['admin_panel']."'");

                      $get_teacher = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$_SESSION['admin_panel']."'");

                      $count=count($get_number_classes);
                      ?>
                      
                        <div class="span12">
                          <div class="control-group">
                            <label class="control-label">Class Name</label>
                            <div class="controls">
                              <input  type="text"  name="class_name"  class="m-wrap span12"
                               value="<?php if($_GET['editid'] != '') { ?><?=stripslashes($get_property_detail[0]->class_name)?><?php }else{ ?><?=$get_teacher[0]->firstname."'s class"?><?php } ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span6">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">Class Level</label>
                                <div class="controls">
                                 
                                    <select required aria-required="true" class="m-wrap span12" name="class_level">
                                            <option value="">Select Level</option>
                                            <option selected="selected" <?php if($get_property_detail[0]->class_level=="pre_elem") { ?>selected <?php } ?> value="pre_elem">Pre Elementary</option>
                                            <option <?php if($get_property_detail[0]->class_level=="elem") { ?>selected <?php } ?>value="elem">Elementary</option>
                                              <!--
                                            <option <?php if($get_property_detail[0]->class_level=="jr_high") { ?>selected <?php } ?>value="jr_high">Junior High School</option>
                                            <option <?php if($get_property_detail[0]->class_level=="high") { ?>selected <?php } ?>value="high">High School</option>  -->
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
                                <label class="control-label">Class Grade</label>
                                <div class="controls">
                                  
                                   <select required aria-required="true" class="m-wrap span12" name="class_grade">
                                            <option value="">Select Grade</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="PK") { ?>selected<?php } ?> value="PK">Pre-K</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="K") { ?>selected<?php } ?> value="K">Kindergarten</option>
                                             <option <?php if($get_property_detail[0]->class_grade=="1") { ?>selected<?php } ?> value="1">First Grade</option>
                                             <!--
                                            <option <?php if($get_property_detail[0]->class_grade=="2") { ?>selected<?php } ?> value="2">2</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="3") { ?>selected<?php } ?> value="3">3</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="4") { ?>selected<?php } ?> value="4">4</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="5") { ?>selected<?php } ?> value="5">5</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="6") { ?>selected<?php } ?> value="6">6</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="7") { ?>selected<?php } ?> value="7">7</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="8") { ?>selected<?php } ?> value="8">8</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="9") { ?>selected<?php } ?> value="9">9</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="10") { ?>selected<?php } ?> value="10">10</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="11") { ?>selected<?php } ?> value="11">11</option>
                                            <option <?php if($get_property_detail[0]->class_grade=="12") { ?>selected<?php } ?> value="12">12</option> -->
                                             </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                          
                      
                          
                      
                      
                      
                      
                      
                     


              <!--         <div class="row-fluid">
                        <div class="span12 ">
                          <div class="control-group">
                            <label class="control-label" for="firstName">Image</label>
                            <div class="controls">
                              <input type="file" name="school_image">
                              <?php
							  if($get_property_detail[0]->school_image != "")
							  {
								?>
                              <img src="../school_img/<?=$get_property_detail[0]->school_image?>" width="250">
                              <?php
							  }
							  ?>
                            </div>
                          </div>
                        </div>
                      </div> -->


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
   <script type="text/javascript">
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

     <?php
         if(isset($_GET['class_error']))
         {
            ?>

          alertify.alert("This class name is already present", function(){
                  
            });
     <?php
         }
         ?>

   </script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<div style="top:0px; left:0px; height:100%; width:100%; position:fixed; display:none;" id="loading">
  <div style="top:40%; left:50%; position:absolute;"><img src="assets/img/processing.gif" width="132" height="122"></div>
</div>
