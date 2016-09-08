<?php
require ("../classes.php");
if(!$administrator_user->check_login())
{
	redirct("../index.php");
}

$teacher_id=$_GET['teacherid'];
if(isset($_GET['schoolid']))
{
	$schoolid=$_GET['schoolid'];
}

// Check edit profile is edited by same teacher or not
if($teacher_id!=$_SESSION['admin_panel'])
	redirct('dashboard.php');


if($_POST['submit'] == "Save")
{
	$str=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
	$data = array(
			"school_id" 			=>	sqlinj($_POST['school_id']),
			"spl_ed_exp" 			=>	sqlinj($_POST['spl_ed_exp']), 
			"sex" 					=>	sqlinj($_POST['sex']), 
			"color_blind" 			=>	sqlinj($_POST['color_blind']),
			"nr_year_teaching" 		=>	sqlinj($_POST['nr_year_teaching']),
			"nr_year_education" 	=>	sqlinj($_POST['nr_year_education']),
			"certification"			=>  sqlinj($_POST['certification']),
			"certification_date"    =>  $str,
			"favorite_subject" 		=>  sqlinj($_POST['favorite_subject']),
			"known_learning_pref"   =>  sqlinj($_POST['known_learning_pref']),
			"subject"               =>  sqlinj($_POST['subject']),

	);
	$table = TABLE_TEACHER;
	$where = array("teacher_id" => $teacher_id);
	$db->update($table, $data, $where);	
	
	
	redirct("dashboard.php");
}

$obj = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$_GET['teacherid']."'");
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
		.controls:focus {
    border-color: rgba(82,168,236,.8) ;
    outline: 0;
    outline: thin dotted \9;
    -moz-box-shadow: 0 0 8px rgba(82,168,236,.6);
    box-shadow: 0 0 8px rgba(82,168,236,.6) !important;
    background-color: #eee;
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
						<h3 class="page-title">Edit Profile</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>Edit Profile </li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
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
			                    <h4>Enter your details</h4>
			                  </div>
			                  <div class="portlet-body form"> 
			                    <!-- BEGIN FORM-->
			                    <form action="" class="horizontal-form" method="post" enctype="multipart/form-data">
			                    	 <div class="row-fluid">
				                        <div class="span8">
				                          <div class="control-group">
				                            <label class="control-label">School</label>     
									               <div class="controls">
			                                  				 <input type="text" class="m-wrap span12" readonly
			                                  				 <?php
			                                  				 	$school = $db->get_results("select * from ".TABLE_SCHOOL." order by school_name");
												                  foreach($school as $sch)
												                  {
			                                  				  		if((isset($_GET['schoolid']) && $schoolid==$sch->school_id) || $obj[0]->school_id==$sch->school_id) 
			                                  				  			{ ?> value="<?=$sch->school_name?>" 
			                                  				      <?php } 
			                                  				      }?>
			                                  				       autofocus="autofocus"/>

			                                  				   <input type="hidden"
			                                  				   	<?php
			                                  				 	$school = $db->get_results("select * from ".TABLE_SCHOOL." order by school_name");
												                  foreach($school as $sch)
												                  {
			                                  				  		if((isset($_GET['schoolid']) && $schoolid==$sch->school_id) || $obj[0]->school_id==$sch->school_id) 
			                                  				  			{ ?> value="<?=$sch->school_id?>" 
			                                  				      <?php } 
			                                  				      }?>
			                                  				    name="school_id" class="m-wrap span12" readonly>   
			                              			 </div>
									                
				                              
				                          
				                        </div>
				                        </div>
				                        <div class="span4"  style=" margin-top: 26px;">
				                          <a href="add_school.php" class="btn blue">ADD SCHOOL</a>
				                         </div> 
                      					</div>
			                      <div class="row-fluid">
			                        <div class="span3">
			                          <div class="control-group">
			                            <label class="control-label">Special Education Experience.</label>
			                            <div class="controls">
			                              <select  class="m-wrap span12" name="spl_ed_exp">
			                              	<option value="">Select Option</option>
			                              	<option <?php if($obj[0]->spl_ed_exp=="y") { ?>selected<?php } ?> value="y">Yes</option>
			                              	<option <?php if($obj[0]->spl_ed_exp=="n") { ?>selected<?php } ?> value="n">No</option>
			                              	<option <?php if($obj[0]->spl_ed_exp=="u") { ?>selected<?php } ?> value="u">Unknown</option>
			                              </select>
			                            </div>
			                          </div>
			                        </div>
			                        <div class="span3">
			                          <div class="control-group">
			                            <label class="control-label">Gender</label>
			                            <div class="controls">
			                            	<select class="m-wrap span12" name="sex">
				                              	<option value="">Select Option</option>
				                              	<option  <?php if($obj[0]->sex=="m") { ?>selected<?php } ?>  value="m">Male</option>
				                              	<option  <?php if($obj[0]->sex=="f") { ?>selected<?php } ?> value="f">Female</option>
			                              </select>
			                            </div>
			                          </div>
			                        </div>
			                        <div class="span3">
			                          <div class="control-group">
			                            <label class="control-label">Color Blind</label>
			                            <div class="controls">
			                            	<select class="m-wrap span12" name="color_blind">
				                              	<option value="">Select Option</option>
				                              	<option <?php if($obj[0]->color_blind=="y") { ?>selected<?php } ?> value="y">Yes</option>
				                              	<option <?php if($obj[0]->color_blind=="n") { ?>selected<?php } ?>value="n">No</option>
				                              	<option <?php if($obj[0]->color_blind=="u") { ?>selected<?php } ?>value="u">Unknown</option>
			                              </select>
			                            </div>
			                          </div>
			                        </div>
			                        <div class="span3">
			                          <div class="control-group">

			                            <label class="control-label">Known learning preference</label>
			                            <div class="controls">
			                            	<select class="m-wrap span12" name="known_learning_pref">
				                              	<option value="">Select Option</option>
				                              	<option <?php if($obj[0]->known_learning_pref=="auditory") { ?>selected<?php } ?> value="auditory">Auditory</option>
				                              	<option <?php if($obj[0]->known_learning_pref=="physical") { ?>selected<?php } ?> value="physical">Physical</option>
				                              	<option <?php if($obj[0]->known_learning_pref=="math/Logic") { ?>selected<?php } ?> value="math/Logic">Math/Logic</option>
				                              	<option <?php if($obj[0]->known_learning_pref=="visual") { ?>selected<?php } ?> value="visual">Visual</option>
				                              	<option <?php if($obj[0]->known_learning_pref=="science") { ?>selected<?php } ?> value="science">Science</option>
				                              	<option <?php if($obj[0]->known_learning_pref=="Verbal-Linguistic") { ?>selected<?php } ?> value="Verbal-Linguistic">Verbal-Linguistic</option>
			                              </select>
			                            </div>
			                          </div>
			                        </div>
			                      </div>
			                      <div class="row-fluid">
			                        <div class="span6">
			                          <div class="control-group">
			                            <label class="control-label">Highest Certification Received </label>
			                            <div class="controls">
			                              <input type="text" class="m-wrap span12" value="<?=$obj[0]->certification?>" name="certification">
			                            </div>
			                          </div>
			                        </div>
			                        <div class="span6">
			                          <div class="control-group">
			                            <label class="control-label">Highest Certification Received Date (MM-DD-YYYY)</label>
			                            <div class="controls">
			                           
			                            	<!-- <input type="date" data-date-format="MMMM DD YYYY" class="m-wrap" value="<?=date('Y-m-d',strtotime($obj[0]->certification_date))?>" name="certification_date"> -->
			                            	<?php
					                              $parts = explode('-',$obj[0]->certification_date);
					                               
					                              $month=$parts[1];
					                              $year=$parts[0];
					                              $day=$parts[2];
					                             ?>
					                            
					                            <div class="controls">
					                            <INPUT NAME="month"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;" value="<?=$month ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="12" placeholder="01" required />-
					                            <INPUT NAME="day" type="number" onkeydown="limitday(this);" onkeyup="limitday(this);" style="width: initial;" value="<?=$day ?>"  SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="31" placeholder="01" required/>-
					                            <INPUT NAME="year" type="number"  style="width: initial;" value="<?=$year ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" required/>
					                           </div>
			                            </div>
			                          </div>
			                        </div>
			                      </div>
			                      <div class="row-fluid">
			                        <div class="span6">
			                          <div class="control-group">
			                            <label class="control-label">Number of year teaching </label>
			                            <div class="controls">
			                              <input type="number" class="m-wrap span12" value="<?=$obj[0]->nr_year_teaching?>" name="nr_year_teaching">
			                            </div>
			                          </div>
			                        </div>
			                        <div class="span6">
			                          <div class="control-group">
			                            <label class="control-label">Number of year education</label>
			                            <div class="controls">
			                            	<input type="number" class="m-wrap span12" value="<?=$obj[0]->nr_year_education?>" name="nr_year_education">
			                            </div>
			                          </div>
			                        </div>
			                      </div>
			                      <div class="row-fluid">
			                        <div class="span6">
			                          <div class="control-group">
			                            <label class="control-label"> Subject</label>
			                            <div class="controls">
			                              <input type="text" class="m-wrap span12" value="<?=$obj[0]->subject?>" name="subject">
			                            </div>
			                          </div>
			                        </div>
			                        <div class="span6">
			                          <div class="control-group">
			                            <label class="control-label"> Favorite Subject</label>
			                            <div class="controls">
			                            	<input type="text" class="m-wrap span12" value="<?=$obj[0]->favorite_subject?>" name="favorite_subject">
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
			window.location='view_child.php?id='+id;
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
</body>
<!-- END BODY -->
</html>
