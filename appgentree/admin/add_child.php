<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
  redirct("../index.php");
}




if(isset($_POST['class_id']))
  {
    $classId=$_POST['class_id'];
  }else
  {
    $classId=$_GET['classid'];
  }

// Check that class to login teacher or not
$check_class = $db->get_results("select * from ".TABLE_CLASS." Where class_id='".$classId."' and teacher_id='".$_SESSION['admin_panel']."'");
if(count($check_class)==0)
    redirect('dashboard.php');
if(isset($_GET['editid']))
{
    $check_child = $db->get_results("select * from ".TABLE_CHILD." Where child_id='".$_GET['editid']."' and class_id='".$classId."' and teacher_id='".$_SESSION['admin_panel']."'");
    if(count($check_child)==0)
    redirect('dashboard.php');
}



if($_POST['submit'] == "Save" && $_GET['editid'] == '')
{
     $str=$_POST['year']."-".$_POST['month']."-".$_POST['day'];

  $data = array(
    
      "teacher_id"      =>  $_SESSION['admin_panel'],
      "class_id"      =>   $classId,
      "child_firstname" => sqlinj($_POST['child_firstname']),
      "child_lastname" => sqlinj($_POST['child_lastname']),
      "dob" => $str,
      "sex"     =>  sqlinj($_POST['sex']),
      "glasses"      =>  sqlinj($_POST['glasses']),
      "race" => $_POST['race'],
      "color_blind"      =>  sqlinj($_POST['color_blind']),
      "hearing_impaired"     =>  sqlinj($_POST['hearing_impaired']),
      "known_learning_diff"       =>  stripslashes($_POST['known_learning_diff']),
      "child_username" => RandomString($_POST['child_firstname'],$_POST['child_lastname']),
  );
  $table = TABLE_CHILD;
  $db->insert($table, $data);
  $insert_id = $db->insert_id;
  
  
  redirct("view_child.php?classid=$classId");
}

if($_GET['editid'] != '')
{
  $get_property_detail = $db->get_results("select * from ".TABLE_CHILD." where child_id = '".$_GET['editid']."'");
  if($_POST['submit'] == "Save")
  {

    $str=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
    $data = array(
      "class_id"      =>   $classId,
      "child_firstname" => sqlinj($_POST['child_firstname']),
      "child_lastname" => sqlinj($_POST['child_lastname']),
      "dob" => $str,
      "sex"     =>  sqlinj($_POST['sex']),
      "glasses"      =>  sqlinj($_POST['glasses']),
        "race" => $_POST['race'],
      "color_blind"      =>  sqlinj($_POST['color_blind']),
      "hearing_impaired"     =>  sqlinj($_POST['hearing_impaired']),
      "known_learning_diff"      =>  stripslashes($_POST['known_learning_diff']),
    );
    $table = TABLE_CHILD;
    $where = array("child_id" => $_GET['editid']);
    $db->update($table, $data, $where); 
    
     redirct("view_child.php?classid=$classId");
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
          <h3 class="page-title">Add Child</h3>
          <ul class="breadcrumb">
            <li> <i class="icon-home"></i> <a href="dashboard.php">Home</a> <span class="icon-angle-right"></span> </li>
            <li>Add Child</li>
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

                      <!-- First Name -->
                      <div class="row-fluid">
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Child First Name</label>
                            <div class="controls">
                              <input type="text" class="m-wrap span12" value="<?php if($_GET['editid'] != ''){?><?=$get_property_detail[0]->child_firstname?><?php } ?>" name="child_firstname" required>
                            </div>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Child Last Name</label>
                            <div class="controls">
                              <input type="text" class="m-wrap span12" value="<?php if($_GET['editid'] != ''){?><?=$get_property_detail[0]->child_lastname ?><?php } ?>" name="child_lastname" required>
                            </div>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="control-group">
                          <?php
                              $parts = explode('-',$get_property_detail[0]->dob);
                               
                              $month=$parts[1];
                              $year=$parts[0];
                              $day=$parts[2];
                             ?>
                            <label class="control-label">Date of birth (MM-DD-YYYY)</label>
                            <div class="controls">
                            <INPUT NAME="month"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;" 
                            value="<?php if(!$month){echo 01;}else{echo $month;} ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="12" placeholder="01" required >
                            -
                            <INPUT NAME="day" type="number" onkeydown="limitday(this);" onkeyup="limitday(this);" style="width: initial;" 
                            value="<?php if(!$day){echo 01;}else{echo $day;} ?>"  SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="31" placeholder="01" required>
                            -
                            <INPUT NAME="year" type="number"  style="width: initial;" 
                            value="<?php if($year){echo $year;}else{echo date("Y");} ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" required>
                            <!-- <?php
                              $parts = explode('-',$get_property_detail[0]->dob);
                               
                              $month=$parts[1];
                              $year=$parts[0];
                              $day=$parts[2];
                             ?>
                                <select id="month" name="month" required="" style="width: initial;">

                                    <option <?php if($month=='01') { ?>selected<?php } ?> value="01">January</option> 
                                    <option <?php if($month=='02') { ?>selected<?php } ?> value="02">February</option>
                                    <option <?php if($month=='03') { ?>selected<?php } ?> value="03">March</option>
                                    <option <?php if($month=='04') { ?>selected<?php } ?> value="04">April</option>
                                    <option <?php if($month=='05') { ?>selected<?php } ?> value="05">May</option>
                                    <option <?php if($month=='06') { ?>selected<?php } ?> value="06">June</option>
                                    <option <?php if($month=='07') { ?>selected<?php } ?> value="07">July</option>
                                    <option <?php if($month=='08') { ?>selected<?php } ?> value="08">August</option>
                                    <option <?php if($month=='09') { ?>selected<?php } ?> value="09">September</option>
                                    <option <?php if($month=='10') { ?>selected<?php } ?> value="10">October</option>
                                    <option <?php if($month=='11') { ?>selected<?php } ?> value="11">November</option>
                                    <option <?php if($month=='12') { ?>selected<?php } ?> value="12">December</option>
                                </select>

                                 <select id="day" name="day" style="width: initial;">
                                 <?php for($i=1;$i<32;$i++) 
                                 { $value = sprintf( '%02d', $i );
                                  ?>
                                    <option <?php if($day==$value) { ?>selected<?php } ?> value="<?=$value?>"><?=$value?></option>
                                 <?php } ?>   
                                 </select>   

                                  <select  name="year" id="year" style="width: initial;">
                                        <?php
                                        for($i = date("Y"); $i >= date("Y")-16; $i--)
                                        {
                                        ?>
                                            <option <?php if($year==$i) { ?>selected<?php } ?> value="<?=$i?>"><?=$i?></option>
                                        <?php
                                        }
                                       ?>
                                 </select> -->
                            </div>
                          </div>
                        </div>
                      </div>

                      

                        
                      <div class="row-fluid">
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Class Name</label>
                            <div class="controls">
                              <select required aria-required="true" class="m-wrap span12" name="class_id">
                                  <option value=" ">Select Class</option>
                                    <?php
                                    $class_ = $db->get_results("select * from ".TABLE_CLASS." Where teacher_id='".$_SESSION['admin_panel']."' order by class_name");
                                   foreach($class_ as $sch)
                                   {
                                   ?>
                                <option 
                                    <?php 
                                      if($get_property_detail[0]->class_id == $sch->class_id || $_GET['classid']==$sch->class_id)
                                       { ?> selected <?php } ?> 
                                      value="<?=$sch->class_id?>"><?=stripslashes($sch->class_name)." [ Grade ".$sch->class_grade." ]"?></option>
                                    <?php
                                   }
                                   ?>
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Gender</label>
                            <div class="controls">
                              <select required aria-required="true" class="m-wrap span12" name="sex"  >
                                  <option selected value=" ">Select Gender</option>
                           
                                   <option <?php if($get_property_detail[0]->sex == "m") { ?> selected <?php } ?> value="m">Male</option>
                                   <option <?php if($get_property_detail[0]->sex == "f") { ?> selected <?php } ?> value="f">Female</option>
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Race</label>
                            <div class="controls">
                              <select class="m-wrap span12" name="race">
                                  <option value="">Select Option</option>
                           
                    <option <?php if($get_property_detail[0]->race == "white") { ?> selected <?php } ?> value="white">White</option>
                    <option <?php if($get_property_detail[0]->race == "black") { ?> selected <?php } ?> value="black">Black</option>
                    <option <?php if($get_property_detail[0]->race == "hispanic") { ?> selected <?php } ?> value="hispanic">Hispanic</option>
                    <option <?php if($get_property_detail[0]->race == "asian/pacific islander") { ?> selected <?php } ?> value="asian/pacific islander">Asian/Pacific Islander</option>
                    <option <?php if($get_property_detail[0]->race == "american indian/alaska native") { ?> selected <?php } ?> value="american indian/alaska native">American Indian/Alaska Native</option>
                    <option <?php if($get_property_detail[0]->race == "other") { ?> selected <?php } ?> value="other">Other</option>
                    <option <?php if($get_property_detail[0]->race == "unknown") { ?> selected <?php } ?> value="unknown">Unknown</option>
                                </select>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                      
                      
                       
                      <!-- color_blind -->
                      <div class="row-fluid">
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Glasses</label>
                            <div class="controls">
                              <select class="m-wrap span12" name="glasses">
                                  <option value="">Select Option</option>
                           
                                   <option <?php if($get_property_detail[0]->glasses == "y") { ?> selected <?php } ?> value="y">Yes</option>
                                   <option <?php if($get_property_detail[0]->glasses == "n") { ?> selected <?php } ?> value="n">No</option>
                                   <option <?php if($get_property_detail[0]->glasses == "u") { ?> selected <?php } ?> value="u">Unknown</option>
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Color Blind</label>
                            <div class="controls">
                              <select class="m-wrap span12" name="color_blind">
                                  <option value="">Select Option</option>
                           
                     <option <?php if($get_property_detail[0]->color_blind == "y") { ?> selected <?php } ?> value="y">Yes</option>
                     <option <?php if($get_property_detail[0]->color_blind == "n") { ?> selected <?php } ?> value="n">No</option>
                     <option <?php if($get_property_detail[0]->color_blind == "u") { ?> selected <?php } ?> value="u">Unknown</option>
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Hearing Impaired</label>
                            <div class="controls">
                              <select class="m-wrap span12" name="hearing_impaired">
                                  <option value="">Select Option</option>
                           
                     <option <?php if($get_property_detail[0]->hearing_impaired == "y") { ?> selected <?php } ?> value="y">Yes</option>
                     <option <?php if($get_property_detail[0]->hearing_impaired == "n") { ?> selected <?php } ?> value="n">No</option>
                     <option <?php if($get_property_detail[0]->hearing_impaired == "u") { ?> selected <?php } ?> value="u">Unknown</option>
                                </select>
                            </div>
                          </div>
                        </div>
                        
                        
                      </div>
                      <div class="row-fluid">
                        <div class="span4">
                          <div class="control-group">
                            <label class="control-label">Known learning difference</label>
                            <div class="controls">
                              <input type="text" maxlength="18" id="counter1" class="m-wrap span12" value="<?=stripslashes($get_property_detail[0]->known_learning_diff) ?>" name="known_learning_diff" >
                              <div style="font-size: 12px;" class="text-right" id="counter1length">18 Characters left</div>
                                <!-- <select class="m-wrap span12" name="known_learning_pref">
                                <option value="">Select Option</option>
                          <option <?php if($get_property_detail[0]->known_learning_pref == "auditory") { ?> selected <?php } ?> value="auditory">Auditory</option>
                          <option <?php if($get_property_detail[0]->known_learning_pref == "physical") { ?> selected <?php } ?> value="physical">Physical</option>
                          <option <?php if($get_property_detail[0]->known_learning_pref == "math-logic") { ?> selected <?php } ?> value="math-logic">Math-Logic</option>
                          <option <?php if($get_property_detail[0]->known_learning_pref == "visual") { ?> selected <?php } ?> value="visual">Visual</option>
                                </select> -->
                            </div>
                          </div>
                        </div>
                      </div>

                     <div class="row-fluid">
                        
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

  function numbersonly(myfield, e, dec) { var key; var keychar; if (window.event) key = window.event.keyCode; else if (e) key = e.which; else return true; keychar = String.fromCharCode(key); 
  // control keys
   if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) return true; 
   // numbers
    else if ((("0123456789").indexOf(keychar) > -1)) return true; 
    // decimal point jump 
    else if (dec && (keychar == ".")) { myfield.form.elements[dec].focus(); return false; } else return false; } 

    function limitmonth(element)
    {
        var max_chars = 2;

        if(element.value.length > max_chars)
         {
            element.value = 12;
        }
        else
        {
          if(element.value>12)
            element.value=12;
        }
    }

    function limitday(element)
    {
        var max_chars = 2;

        if(element.value.length > max_chars)
         {
            element.value = 01;
         }
        else
        {
          if(element.value>31)
            element.value=01;
        }
    }

    function limityear(element)
    {
        var max_chars = 4;

        if(element.value.length > max_chars)
         {
            element.value = 2000;
         }
        else
        {
          if(element.value<2000 || element.value>2016)
            element.value=2000;
        }
    }

   </script> 
   <script type="text/javascript">
   // the length of known learning difference
    document.getElementById("counter1").onkeyup = function(){
        document.getElementById("counter1length").innerHTML= (18 - this.value.length)+ " Characters left";
    }
    
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<div style="top:0px; left:0px; height:100%; width:100%; position:fixed; display:none;" id="loading">
  <div style="top:40%; left:50%; position:absolute;"><img src="assets/img/processing.gif" width="132" height="122"></div>
</div>
