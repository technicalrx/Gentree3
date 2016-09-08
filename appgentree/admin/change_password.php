<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
   redirct("../index.php");
}
if(isset($_GET['teacherid']))
{
   $id=$_GET['teacherid']; 
   $eid = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$id."'");
   $pass=$eid[0]->teacher_password; 
   if($pass!=$_GET['pass'])
      redirct("../index.php");
}
if(isset($_GET['pass']))
{
   $pass=$_GET['pass'];
}
if(isset($_SESSION['admin_panel']))
{
   $id=$_SESSION['admin_panel'];
}

$success=0;

if($_POST['npass'] != "" && $_POST['cpass'] != "" && (strlen($_POST['npass'])>=8) && (strlen($_POST['npass'])<=30))
{
	
	$data = array(
	"teacher_password" =>	md5(SALT.$_POST['cpass']),
	);
	$table = TABLE_TEACHER;
	$where = array("teacher_id" => $id);
	$db->update($table, $data, $where);
	redirct("change_password.php?success=1");
}else if(isset($_POST['npass']))
{
   redirct("change_password.php?lerror=1");
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title><?=SITE_TITLE?> | Change Password</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<?php require ("common_file.php"); ?>
<body class="fixed-top">
   <!-- BEGIN HEADER -->

   <? include 'header.php'; ?>
   
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class="page-container row-fluid">
      <!-- BEGIN SIDEBAR -->
      <?php if(!isset($_GET['teacherid'])) { ?>
      <? include 'left_panel.php'; ?>
      <?php } ?>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <div id="portlet-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>portlet Settings</h3>
            </div>
            <div class="modal-body">
               <p>Here will be a configuration form</p>
            </div>
         </div>
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                  <div class="color-panel hidden-phone">
                     <div class="color-mode-icons icon-color"></div>
                     <div class="color-mode-icons icon-color-close"></div>
                     <div class="color-mode">
                        <p>THEME COLOR</p>
                        <ul class="inline">
                           <li class="color-black current color-default" data-style="default"></li>
                           <li class="color-blue" data-style="blue"></li>
                           <li class="color-brown" data-style="brown"></li>
                           <li class="color-purple" data-style="purple"></li>
                           <li class="color-white color-light" data-style="light"></li>
                        </ul>
                        <label class="hidden-phone">
                        <input type="checkbox" class="header" checked value="" />
                        <span class="color-mode-label">Fixed Header</span>
                        </label>                    
                     </div>
                  </div>
                  <!-- END BEGIN STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                     Change Password
                  </h3>
                  <?php if(!isset($_GET['teacherid'])) { ?>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="assets">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="change_password.php">Change Password</a>
                     </li>
                  </ul>
                   <?php } ?>
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
                                 <h4><i class="icon-reorder"></i>Change Password Form</h4>
                               <!--   <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div> -->
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form  method="post" enctype="multipart/form-data" onSubmit="return check_pass()">
                                    <h3 class="form-section">Password Info</h3>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="firstName">New Password</label>
                                             <div class="controls">
                                                <input type="password" class="m-wrap span12" value="" id="npass" placeholder="New Password" name="npass" required>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="firstName">Confirm Password</label>
                                             <div class="controls">
                                                <input type="password" class="m-wrap span12" value="" id="cpass" name="cpass" placeholder="Confirm Password" required>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div><!--/row--> 
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label" style="color:black" for="Error"><i class="fa fa-info-circle" aria-hidden="true"></i> The password must be 8 characters and include at least one lowercase letter, one uppercase letter, and a number</label>
                                           </div>
                                       </div>
                                    </div>
                                             
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Change Password</button>
                                      
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
	  
	  function check_pass()
	  {
			np = document.getElementById('npass').value;
			cp = document.getElementById('cpass').value;
			if(np != cp)
			{
            alertify.alert("The passwords do not match.<br>Please try again.");
				//alert('Password Not Match');	
				document.getElementById('cpass').value = '';
				document.getElementById('cpass').focus();
				return false;
			}else{
            if(np.length<8)
            {
              alertify.alert("Password is too short<br>Please try again");
               return false;
            }else if(!isValidPassord(document.getElementById('npass').value))
            {
            	alertify.alert("Your password must include at least one lowercase letter, one uppercase letter, and a number");
            	return false;
            }else
            {
					jQuery.ajax({
						url: "ajax_change_password.php?pass="+np+"&id=<?=$id?>",
						type: "POST",
						contentType: false,
						cache: false,
						processData:false,
						success: function( data, textStatus, jqXHR ) {
							    alertify.alert("Your password has been changed.", function()
							    {
			                  		window.location="/admin/dashboard.php";
			                    });
						},
						error: function( jqXHR, textStatus, errorThrown ) {
						}
					});
				return false;
            }
         }  
	  }

	   function isValidPassord(pass)
         {
          
           var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
           return re.test(pass);
         }
	  
   
      <?php
         if(isset($_GET['success']))
         {
            ?>

          alertify.alert("Your password has been changed.", function(){
                  window.location="/admin/dashboard.php";
            });
     <?php
         }
         ?>
   <!-- END JAVASCRIPTS -->   
   </script>
</body>
<!-- END BODY -->
</html>
<div style="top:0px; left:0px; height:100%; width:100%; position:fixed; display:none;" id="loading">
	<div style="top:40%; left:50%; position:absolute;"><img src="assets/img/processing.gif" width="132" height="122"></div>
</div>
