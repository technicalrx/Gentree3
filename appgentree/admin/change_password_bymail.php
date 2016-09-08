<?php
require ("../classes.php");
if(isset($_GET['teacherid']))
{
   
   $id=$_GET['teacherid']; 
   $eid = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$id."'");
   $pass=$eid[0]->teacher_password; 
   if($pass!=$_GET['pass'])
      redirct("../index.php");

}


if($_POST['npass'] != "" && $_POST['cpass'] != "")
{
   
   $data = array(
   "teacher_password" =>  md5(SALT.$_POST['cpass']),
   );
   $table = TABLE_TEACHER;
   $where = array("teacher_id" => $id);
   $db->update($table, $data, $where);
      
   redirct("index.php");
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
<?php require ("common_file.php"); ?>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->

   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/css/metro.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
   <link href="assets/css/style_responsive.css" rel="stylesheet" />
   <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   <link rel="shortcut icon" href="favicon.ico" />
   <div class="header navbar navbar-inverse navbar-fixed-top">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
         <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="../index.php">
               GenTree Discover
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
            <img src="assets/img/menu-toggler.png" alt="" />
            </a>          
            <!-- END RESPONSIVE MENU TOGGLER -->            
        
            <!-- END TOP NAVIGATION MENU --> 
         </div>
      </div>
      <!-- END TOP NAVIGATION BAR -->
   </div>
   
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class="page-container row-fluid">
      <!-- BEGIN SIDEBAR -->
 
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div class="container">
         <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
       
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                
                  <!-- END BEGIN STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                     Change Password
                  </h3>
                 
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
                                 <form action="" class="horizontal-form" method="post" enctype="multipart/form-data" onSubmit="return check_pass()">
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
                                                <input type="password" class="m-wrap span12" value="" id="cpass" name="cpass" placeholder="Confirm Password" required=>
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
            }
         }  
     }

      function isValidPassord(pass)
         {
          
           var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
           return re.test(pass);
         }
     
     
   </script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
<div style="top:0px; left:0px; height:100%; width:100%; position:fixed; display:none;" id="loading">
   <div style="top:40%; left:50%; position:absolute;"><img src="assets/img/processing.gif" width="132" height="122"></div>
</div>
