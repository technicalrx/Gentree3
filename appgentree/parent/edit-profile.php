<!-- 
/*******************************************************************************
* File Name        : edit-profile.php                                                     
* File Description : Edit profile of user and his childs profile.                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->
<!-- Code is checking authentication -->
 <?php
 if(!isset($_SESSION['user_id']))
 {
 	redirect('/login/');
 } 
$userid=$_GET['userid'];
$pdata = $db->get_results("select * from ".TABLE_PARENT." where md5(user_id) = '".$userid."'");
if(count($pdata)==0)
{
	redirect('/login/');
}

$cdata = $db->get_results("select * from ".TABLE_CHILD." where md5(parent_id) = '".$userid."' order by child_id ASC");

 ?>



<?php
if($_POST['submit'] == "Save")
{

$data = array(
		"user_firstname" => $_POST['user_firstname'],
		"user_lastname" => $_POST['user_lastname'],
		"user_city" => $_POST['user_city'],
		"user_state" => $_POST['user_state'],
		"user_zip"=> $_POST['user_zip'],
		"user_email"=> $_POST['user_email'],
		"user_password"=>md5(SALT.$_POST['user_password']),
	);
	$table = TABLE_PARENT;
	$where = array('user_id' => $pdata[0]->user_id,);
	$db->update($table, $data, $where); 
    


 $i=0;
		while ($i<count($cdata)) 
		{

			$str='child'.($i+1);
			$month = ((strlen($_POST[$str.'_month'])>1)?$_POST[$str.'_month']:'0'.$_POST[$str.'_month']);
			$time = strtotime($month.'/1/'.$_POST[$str.'_year']);
			$str_dob = date('Y-m-d',$time);
			$data_child=array(
				"child_firstname"=>$_POST[$str.'_first_name'],
				"child_lastname"=>$_POST[$str.'_last_name'],
				"dob"=>$str_dob,
				"sex"=>substr($_POST[$str.'_gender'],0,1),
				);

		        $table = TABLE_CHILD;
				$where = array("child_id" => $cdata[$i]->child_id);
				$db->update($table,$data_child, $where); 


		   if($_FILES[$str.'_pic']['name'] != "")
			{
			
				$valiad_mime_types = array('jpg', 'jpeg', 'png', 'gif');
				$destination_dir = 'parent/child_image/';
				$file_name = upload_file($_FILES[$str.'_pic'], $destination_dir, $valiad_mime_types, $_POST[$str.'_first_name']."change".time());
				$data_c = array(
					"child_pic"  => $file_name,
				);
				
				$table = TABLE_CHILD;
				$where = array("child_id" => $cdata[$i]->child_id);
				$db->update($table, $data_c, $where); 
			}

		   $i++;
		}

		redirect("/edit-profile/?userid=".$userid);
}		
?>

			<!-- breadcrump -->
			<div id="bluebackground">
			    <div class="container">
			        <div class="row">
			            <div class="col-md-12">
			                <h2>Report Center</h2>
			            </div><!-- end col -->
			        </div><!-- end row -->
			    </div><!-- end container -->
			</div><!-- end bluebackground -->
			<section class="register-content">
				<div class="container content">
					
					<div class="row">
							
						<!-- left side steps -->
						<div class="col-md-3 padright allwhite">
							<?php include('left-menu.php'); ?>
						</div>
						<!-- right side form -->
						<div class="col-md-9">
							<div class="bigwhitebox">
								<form role="form"  method="POST" onsubmit="return(formUpdate());" action="" enctype="multipart/form-data">
									<div class="">
										<!-- parent profile starts -->
										<h2 class="color-blue">Update User Profile</h2>
										<div class="row">
											<div class="form-group">
												<div class="col-md-4 col-sm-4">
													<label class="input">First Name</label>
													<input type="text" class="form-control" id="user_firstname" name="user_firstname" value="<?=$pdata[0]->user_firstname?>" placeholder="" onblur="check_firstname()">
													<span style="color:#b8071b" id="user_first_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
													<label class="input">Last Name</label>
													<input type="text" class="form-control" id="user_lastname" name="user_lastname" value='<?=$pdata[0]->user_lastname?>' placeholder="" onblur="check_lastname()">
													<span style="color:#b8071b" id="user_last_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
												</div>
											</div>
										</div>

										
										<div class="row">
											<div class="form-group">
												<div class="col-md-4 col-sm-4">
													<label class="input">City</label>
													<input type="text" class="form-control" id="user_city" placeholder="" value="<?=$pdata[0]->user_city?>" name="user_city" onblur="check_city()">
													<span style="color:#b8071b" id="user_city_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
													<label class="input">State</label>
													<input type="text" class="form-control" id="user_state" placeholder="" value="<?=$pdata[0]->user_state?>" name="user_state" >
													<span style="color:#b8071b" id="user_state_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
													<label class="input">Zip</label>
													<input type="text" class="form-control" id="user_zip" placeholder="" value="<?=$pdata[0]->user_zip?>" name="user_zip" >
													<span style="color:#b8071b" id="user_zip_error"></span>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group">
												<div class="col-md-6 col-sm-6">
													<label class="input">Email Address (this will be your username)</label>
													<input type="email" class="form-control" id="user_email" placeholder="" value="<?=$pdata[0]->user_email?>" name="user_email" onblur="check_email()" readonly >
													
												</div>
												<div class="col-md-6 col-sm-6">
													<label class="input">Confirm Email Address</label>
													<input type="email" id="cnf-email" class="form-control" placeholder="" value="<?=$pdata[0]->user_email?>" name="cnf-email" onblur="check_cnf_email()" readonly>
													
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<div class="col-md-6 col-sm-6">
													<label class="input">Change Your Password</label>
													<input type="password" class="form-control" id="user_password" placeholder="" value="" name="user_password" onblur="check_password()" >
													<span  id="pass-guide" >Must contain at least 8 characters and include at least one number and one special character</span>
													<span style="color:#b8071b" id="pass-error" ></span>
												</div>
												<div class="col-md-6 col-sm-6">
													<label class="input">Confirm Changed Password</label>
													<input type="password" id="cnf_password" class="form-control" placeholder="" value="" name="cnf-password" onblur="check_cnf_password()" >
													<span style="color:#b8071b" id="cnf-pass-error" ></span>
												</div>
											</div>
										</div>
										<!-- <div class="row">
											<div class="form-group">
												<div class="col-md-6 col-sm-6">
													<span style="font-size:17px;">Upload your profie picture(optional)</span><br>
													<span>must be at least 300 pixels wide and tall</span>
												</div>
												<div class="col-md-6 col-sm-6">
													<input type="file" class="buttn btn btn-default btn-lg" id="profile_pic"  name="user_pic">
														Click to browse &amp; upload
													</input>
												</div>
											</div>
										</div> -->
										<!-- parent profile ends -->
										<div class="row">
											<div class="form-group"></div>
										</div>
										<!-- <div class="row">
											<div class="form-group"></div>
										</div> -->
										<!-- child profiles -->
										<!-- <h2 class="color-blue">Update your Child's Profile(s)</h2> -->
										<!-- <div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												You may register up to 4 children at once. How many would you like to register?
												<br>
												<div class="row">
													<div class="col-md-3 col-sm-3">
														<button type="button" onclick="generateChild(1)" class="btn btn-default">One</button>
													</div>
													<div class="col-md-3 col-sm-3">
														<button type="button" onclick="generateChild(2)" class="btn btn-default">Two</button>
													</div>
													<div class="col-md-3 col-sm-3">
														<button type="button" onclick="generateChild(3)" class="btn btn-default">Three</button>
													</div>
													<div class="col-md-3 col-sm-3">
														<button type="button" onclick="generateChild(4)" class="btn btn-default">Four</button>
													</div>
												</div>
											</div>
										</div> -->
										

										<!-- child one -->
										<?php if(count($cdata)>0){?>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_one">
												<h2 style="margin-bottom:0;" class="color-blue">Child One:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-12 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" placeholder="" id="child1_first_name" name="child1_first_name" value="<?=$cdata[0]->child_firstname?>" onblur="check_child1_first()">
																	<span style="color:#b8071b" id="child1_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" name="child1_last_name" id="child1_last_name" value="<?=$cdata[0]->child_lastname?>" >
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<?php
																				$time=strtotime($cdata[0]->dob);
																				$month=date("m",$time);
																				$year=date("Y",$time);
																			 ?>

																			<INPUT NAME="child1_month"  id="child1_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?=$month ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="12" placeholder="01" required >
																			-
																			<INPUT NAME="child1_year" id="child1_year" type="number"  style="width: initial;padding:5px;" 
                            value="<?=$year ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" required><br>
																			<!-- <input type="date" class="form-control" placeholder="" name="child2_dob" id="child2_dob" value="" onblur="check_child2_dob()"> -->
																			<span style="color:#b8071b" id="child1_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" id="child1_gender" name="child1_gender" <?php if($cdata[0]->sex=='1'){ ?>checked<?php }?> value="1" onblur="check_child1_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" id="child1_gender" name="child1_gender" <?php if($cdata[0]->sex=='2'){ ?>checked<?php }?> value="2" onblur="check_child1_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child1_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:16px;">Upload your profie picture (optional)</span><br>
																	<span style="font-size:12px;">must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<input type="file" id="child1_pic" accept="image/*" style="width:230px;" name="child1_pic" class="buttn btn btn-default" >
																		Click to browse &amp; upload
																	
																	
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12" style="padding-top:20px;">
														<button type="button" id="remove1" class="btn btn-default remove-btn">Remove</button>
														<img class="img-responsive" id="child1_pic_preview" style="max-width:250px;max-height:250px;height:250px;" src="<?php if($cdata[0]->child_pic){ echo "child_image/".$cdata[0]->child_pic;} ?>" alt="Child One Image Preview">
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<!-- child one ends -->

										<!-- child two starts -->
										<?php if(count($cdata)>1){?>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_two">
												<h2 style="margin-bottom:0;" class="color-blue">Child Two:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-12 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" id="child2_first_name" placeholder="" name="child2_first_name" value="<?=$cdata[1]->child_firstname?>" onblur="check_child2_first()">
																	<span style="color:#b8071b" id="child2_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" id="child2_last_name" name="child2_last_name" value="<?=$cdata[1]->child_lastname?>" >
																	
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<?php
																				$time=strtotime($cdata[1]->dob);
																				$month=date("m",$time);
																				$year=date("Y",$time);
																			 ?>

																			<INPUT NAME="child2_month" id="child2_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" 
																			value="<?=$month?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="12" placeholder="01" required >
																			-
																			<INPUT NAME="child2_year" id="child2_year" type="number"  style="width: initial;padding:5px;" 
                            value="<?=$year?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" required><br>
																			<!-- <input type="date" class="form-control" placeholder="" id="child1_dob" name="child1_dob" value="" onblur="check_child1_dob()"> -->
																			<span style="color:#b8071b" id="child2_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" name="child2_gender" id="child2_gender" <?php if($cdata[1]->sex=='1'){ ?>checked<?php }?> value="1" onblur="check_child2_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" name="child2_gender" id="child2_gender" <?php if($cdata[1]->sex=='2'){ ?>checked<?php }?> value="2" onblur="check_child2_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child2_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:17px;">Upload your profie picture (optional)</span><br>
																	<span>must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<input type="file" class="buttn btn btn-default" style="width:230px;" id="child2_pic" name="child2_pic" >
																		Click to browse &amp; upload
																	
																</div>
															</div>
														</div>

													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<button type="button" id="remove2" class="btn btn-default remove-btn">Remove</button>
														<img class="img-responsive" id="child2_pic_preview" style="max-width:250px;max-height:250px;height:250px;" src="<?php if($cdata[1]->child_pic){ echo "child_image/".$cdata[1]->child_pic;} ?>" alt="Child Two Image Preview">
														
													</div>
												</div>
														
												
												
											</div>
										</div>
										<?php } ?>
										<!-- child two ends -->

										<!-- child three starts -->
										<?php if(count($cdata)>2){?>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_three">
												<h2 style="margin-bottom:0;" class="color-blue">Child Three:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-12 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" placeholder="" name="child3_first_name" id="child3_first_name" value="<?=$cdata[2]->child_firstname?>" onblur="check_child3_first()">
																	<span style="color:#b8071b" id="child3_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" name="child3_last_name" id="child3_last_name" value="<?=$cdata[2]->child_lastname?>" >
																
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<?php
																				$time=strtotime($cdata[2]->dob);
																				$month=date("m",$time);
																				$year=date("Y",$time);
																			 ?>

																			<INPUT NAME="child3_month" id="child3_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?=$month?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="12" placeholder="01" required >
																			-
																			<INPUT NAME="child3_year" id="child3_year" type="number"  style="width: initial;padding:5px;" 
                            value="<?=$year?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" required><br>
																			<!-- <input type="date" class="form-control" placeholder="" id="child1_dob" name="child1_dob" value="" onblur="check_child1_dob()"> -->
																			<span style="color:#b8071b" id="child3_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" name="child3_gender" id="child3_gender" <?php if($cdata[2]->sex=='1'){ ?>checked<?php }?> value="1" onblur="check_child3_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" name="child3_gedner" id="child3_gender" <?php if($cdata[2]->sex=='2'){ ?>checked<?php }?> value="2" onblur="check_child3_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child3_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:17px;">Upload your profie picture (optional)</span><br>
																	<span>must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<input type="file" style="width:230px;" class="buttn btn btn-default" id="child3_pic" name="child3_pic" >
																		Click to browse &amp; upload
																	
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<button type="button" id="remove3" class="btn btn-default remove-btn">Remove</button>
														<img class="img-responsive" id="child3_pic_preview" style="max-width:250px;max-height:250px;height:250px;" src="<?php if($cdata[2]->child_pic){ echo "child_image/".$cdata[2]->child_pic;} ?>" alt="Child Three Image Preview">
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<!-- child three ends -->

										<!-- child four starts -->
										<?php if(count($cdata)>3){?>
										<div class="row ">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_four">
												<h2 style="margin-bottom:0;" class="color-blue">Child Four:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-12 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" placeholder="" id="child4_first_name" name="child4_first_name" value="<?=$cdata[3]->child_firstname?>" onblur="check_child4_first()">
																	<span style="color:#b8071b" id="child4_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" id="child4_last_name" name="child4_last_name" value="<?=$cdata[3]->child_lastname?>" >
																
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																<?php
																				$time=strtotime($cdata[3]->dob);
																				$month=date("m",$time);
																				$year=date("Y",$time);
																			 ?>
																	<INPUT NAME="child4_month" id="child4_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?=$month?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="12" placeholder="01" required >
																			-
																			
																			<INPUT NAME="child4_year" id="child4_year"  type="number"  style="width: initial;padding:5px;" 
                            value="<?=$year?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" required><br>
																			<!-- <input type="date" class="form-control" placeholder="" id="child1_dob" name="child1_dob" value="" onblur="check_child1_dob()"> -->
																			<span style="color:#b8071b" id="child4_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" name="child4_gender" id="child4_gender" <?php if($cdata[3]->sex=='1'){ ?>checked<?php }?> value="1" onblur="check_child4_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" name="child4_gender" id="child4_gender" <?php if($cdata[3]->sex=='2'){ ?>checked<?php }?> value="2" onblur="check_child4_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child4_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:17px;">Upload your profie picture (optional)</span><br>
																	<span>must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<input type="file" class="buttn btn btn-default" style="width:230px;" id="child4_pic" name="child4_pic" >
																		Click to browse &amp; upload
																	
																	
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4 col-sm-12 col-xs-12">
														<button type="button" id="remove4" class="btn btn-default remove-btn">Remove</button>
														<img class="img-responsive" id="child4_pic_preview" style="max-width:250px;max-height:250px;height:250px;" src="<?php if($cdata[3]->child_pic){ echo "child_image/".$cdata[3]->child_pic;} ?>" alt="Child Four Image Preview">
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<!-- child four starts -->
										<div class="row margin-top-30 margin-bottom-20">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<button type="submit" name="submit" value="Save" class="custom-blue btn btn-lg">Update</button>
											</div>
										</div>
									</div>
								  </form>	
							</div>
						</div>
					</div>
				</div>
							
			</section>
		</div>
		</div>
		<script type="text/javascript">

function initMap() {

    var input = document.getElementById('user_city');
    
    var autocomplete = new google.maps.places.Autocomplete(input);
  


    autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();
     
  
       
    
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    
        
      
        //Location details
        for (var i = 0; i < place.address_components.length; i++) {
            if(place.address_components[i].types[0] == 'postal_code'){
                document.getElementById('user_zip').value = place.address_components[i].long_name;
            }
            if(place.address_components[i].types[0] == 'country'){
                //document.getElementById('country').value = place.address_components[i].long_name;
            }
        }
        var address=place.formatted_address.split(',');
        //document.getElementById('searchInput').value = place.formatted_address;
        //document.getElementById('country').innerHTML=((address[address.length-1] != null)?address[address.length-1]:'');
        document.getElementById('user_state').value=((address[address.length-2] != null)?(address[address.length-2].replace(/[0-9]/g, '')):'');
        document.getElementById('user_city').value=((address[address.length-3] != null)?address[address.length-3]:'');  
       // document.getElementById('lat').innerHTML = place.geometry.location.lat();
        //document.getElementById('lon').innerHTML = place.geometry.location.lng();
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAorGXTUrQYGnHTwv0Kgy91PWxOK_16ZKw&libraries=places&callback=initMap" async defer></script>
		
<script type="text/javascript">
        	var number =["One","Two","Three","Four"];

        	function childCountFunction(d)
        	{
        	  // Ajax add in php how many child is there
		          $.ajax({
				        type: 'post',
				        url: 'ajax_count_childs.php?childcount='+d,
				        data: "search="+d,
					      success: function (response) 
					       {
					       		if(response=='1')
				      			{
				      		        return true;	
				      	        }
				      	        else
				      	        {	
				      	    	    return false;
				      	        }	
					       }
				        });
        	}

  
</script> 
<!-- Picture preview -->
<script type="text/javascript">
		// for child one
	    function readURL1(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
	                $('#child1_pic_preview').attr('src', e.target.result);
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
    
	    $("#child1_pic").change(function(){
	        readURL1(this);
	    });
	    // for child two
	    function readURL2(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
	                $('#child2_pic_preview').attr('src', e.target.result);
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
    
	    $("#child2_pic").change(function(){
	        readURL2(this);
	    });
	    // for child three
	    function readURL3(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
	                $('#child3_pic_preview').attr('src', e.target.result);
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
    
	    $("#child3_pic").change(function(){
	        readURL3(this);
	    });
	    // for child four
	    function readURL4(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
	                $('#child4_pic_preview').attr('src', e.target.result);
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
    
	    $("#child4_pic").change(function(){
	        readURL4(this);
	    });

	    $("#remove1").click(function(){
	    	$('#child1_pic_preview').attr('src', "");
	    	$('#child1_pic').val('');
	    });

	    $("#remove2").click(function(){
	    	$('#child2_pic_preview').attr('src', "");
	    	$('#child2_pic').val('');
	    });

	    $("#remove3").click(function(){
	    	$('#child3_pic_preview').attr('src', "");
	    	$('#child3_pic').val('');
	    });

	    $("#remove4").click(function(){
	    	$('#child4_pic_preview').attr('src', "");
	    	$('#child4_pic').val('');
	    });
</script>

	