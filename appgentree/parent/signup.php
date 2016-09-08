<!-- 
   /*******************************************************************************
* File Name        : signup.php                                                     
* File Description : signup process first step user registration and child registration                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->
<?php 
if(isset($_SESSION['user_id']))
{
	redirect('/view-report-listing/?userid='.md5($_SESSION['user_id']));
}
?>
<?php
if($_POST['submit'] == "Save")
{
	
  if(isset($_SESSION['childcount']))
  {
// Submit Registration form
  		while(1)
			{
				$user_st=RandomString($_POST['user_firstname'],$_POST['user_lastname']);
				$userdetail=$db->get_results("select * from ".TABLE_PARENT." where username='".$user_st."'");
				if(count($userdetail)>0)
				{
					continue;
				}else
				{
					break;
				}
			}
$data = array(
	    "username"=>$user_st,
		"user_firstname" => $_POST['user_firstname'],
		"user_lastname" => $_POST['user_lastname'],
		"user_city" => $_POST['user_city'],
		"user_state" => $_POST['user_state'],
		"user_zip"=> $_POST['user_zip'],
		"user_email"=> $_POST['user_email'],
		"user_password"=>md5(SALT.$_POST['user_password']),
		"user_pic"=>$_POST['user_pic'],
		"user_registration_date"=>date('Y-m-d H:i:s'),
	);
 // Submit Form
   	$table = TABLE_PARENT;
	$insert_id = $db->insert($table, $data);
	$insert_id = $db->insert_id;

	    $i=0;
		while ($i<$_SESSION['childcount']) 
		{

			
			while(1)
			{
				$str='child'.($i+1);
				$child_st=RandomString($_POST[$str.'_first_name'],$_POST[$str.'_last_name']);
				$childdetail=$db->get_results("SELECT * from ".TABLE_CHILD." where child_username='".$child_st."'");
				if(count($childdetail)>0)
				{
					continue;
				}else
				{
					break;
				}
			}
			$month = ((strlen($_POST[$str.'_month'])>1)?$_POST[$str.'_month']:'0'.$_POST[$str.'_month']);
			$time = strtotime($month.'/1/'.$_POST[$str.'_year']);
			$str_dob = date('Y-m-d',$time);
			$data_child=array(
				"parent_id"=>$insert_id,
				"child_firstname"=>$_POST[$str.'_first_name'],
				"child_lastname"=>$_POST[$str.'_last_name'],
				"dob"=>$str_dob,
				"sex"=>substr($_POST[$str.'_gender'],0,1),
				"child_registration_date"=>date('Y-m-d H:i:s'),
				"child_username" => $child_st,
				"child_test_count"=>'1'
				);

		   $table = TABLE_CHILD;
		   $insert_childid = $db->insert($table, $data_child);
		   $insert_childid = $db->insert_id;


		   if($_FILES[$str.'_pic']['name'] != "")
			{
				$id = $insert_childid;
				$valiad_mime_types = array('jpg', 'jpeg', 'png', 'gif');
				$destination_dir = 'parent/child_image/';
				// $file_name = upload_file($_FILES[$str.'_pic'], $destination_dir, $valiad_mime_types, $_POST[$str.'_first_name'].$id);


					$img = $_FILES[$str.'_pic']['tmp_name'];
					$dst = $destination_dir . $_FILES[$str.'_pic']['name'].$id;

					if (($img_info = getimagesize($img)) === FALSE)
					  die("Image not found or not an image");

					$width = $img_info[0];
					$height = $img_info[1];

					switch ($img_info[2]) {
					  case IMAGETYPE_GIF  : $src = imagecreatefromgif($img);  break;
					  case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); break;
					  case IMAGETYPE_PNG  : $src = imagecreatefrompng($img);  break;
					  default : die("Unknown filetype");
					}

					$tmp = imagecreatetruecolor($width, $height);
					imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);
					imagejpeg($tmp, $dst.".jpg");
					$file_name=$_FILES[$str.'_pic']['name'].$id.'.jpg';

				$data = array(
					"child_pic"  => $file_name,
				);
				$table = TABLE_CHILD;
				$where = array("child_id" => $insert_childid);
				$db->update($table, $data, $where); 
			}

		   $i++;
		}
		redirect("/signup_purchase/?userid=".md5($insert_id));
  }else
  {
  	echo '<script>alert("Enter at least one child");</script>';
  }

}

// foreach ($_POST as $key => $entry)
// {
//      print $key . ": " . $entry . "<br>";
// }
?>
			
			<!-- breadcrump -->
			<div id="bluebackground">
			    <div class="container">
			        <div class="row">
			            <div class="col-md-12">
			                <h2>Let's get started!</h2>
			            </div><!-- end col -->
			        </div><!-- end row -->
			    </div><!-- end container -->
			</div><!-- end bluebackground -->
			<section class="register-content">
				<div class="container content">
					
					<div class="row">
						<div class="col-md-3 padright allwhite">
							<h3>Step 1 of 4</h3>
							<h4>Important Information About Registration:</h4>
							<ol>
							  <li>You may register up to 4 children at a time.</li>
							  <li>Once payment is received, you will be issued an activation code (per child) and a link via email so that you can easily launch the assessment from a personal computer or a tablet.</li>
							  <li>Your child will have 7 days to take the assessment. If the activation code expires before the child takes the assessment, re-payment will be required.</li>
							  <li>Your child's customized learning profile report will be automatically sent via email after the assessment has been completed. This report will be available for up to one year on the online portal.</li>
							  <li>Individualized "Learn more" content to review and share with other family members or teachers will be available as a link to review, print, or save from the Tailored Learning Profile.</li>
							</ol>
						</div><!-- end col -->
						
						<!-- right side form -->
						<div class="col-md-9">
							<div class="bigwhitebox">
								<form role="form" onsubmit="return(formSignupSubmit());" action=""   method="POST" enctype="multipart/form-data">
									<div class="" >
										<!-- parent profile starts -->
										<h2 class="color-blue">Build Your Parent Profile</h2>
										<div class="row">
											<div class="form-group">
												<div class="col-md-4 col-sm-4">
													<label class="input">First Name</label>
													<input type="text" class="form-control" id="user_firstname" name="user_firstname" value="<?=$_POST['user_firstname']?>" placeholder="" onblur="check_firstname()">
													<span style="color:#b8071b" id="user_first_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
													<label class="input">Last Name</label>
													<input type="text" class="form-control" id="user_lastname" name="user_lastname" value="<?=$_POST['user_lastname']?>" placeholder="" onblur="check_lastname()">
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
													<input type="text" class="form-control" id="user_city" placeholder="" value="<?=$_POST['user_city']?>" name="user_city" onblur="check_city()">
													<span style="color:#b8071b" id="user_city_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
													<label class="input">State</label>
													<input type="text" class="form-control" id="user_state" placeholder="" value="<?=$_POST['user_state']?>" name="user_state" onblur="check_city()" >
													<span style="color:#b8071b" id="user_state_error"></span>
												</div>
												<div class="col-md-4 col-sm-4">
													<label class="input">Zip</label>
													<input type="text" class="form-control" id="user_zip" placeholder="" value="<?=$_POST['user_zip']?>" name="user_zip" onblur="check_zip()">
													<span style="color:#b8071b" id="user_zip_error"></span>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="form-group">
												<div class="col-md-6 col-sm-6">
													<label class="input">Email Address (this will be your username)</label>
													<input type="email" class="form-control" id="user_email" placeholder="" value="<?=$_POST['user_email']?>" name="user_email" onblur="check_email()" >
													<span style="color:#b8071b" id="email-error"></span>
												</div>
												<div class="col-md-6 col-sm-6">
													<label class="input">Confirm Email Address</label>
													<input type="email" id="cnf-email" class="form-control" placeholder="" value="<?=$_POST['cnf-email']?>" name="cnf-email" onblur="check_cnf_email()" >
													<span style="color:#b8071b" id="cnf-email-error"></span>
												</div>
												<input type="hidden"  id="check_email_value" name="check_email_value" value="0">
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<div class="col-md-6 col-sm-6">
													<label class="input">Create Your Password</label>
													<input type="password" class="form-control" id="user_password" placeholder="" value="" name="user_password" onblur="check_password()" >
													<span  id="pass-guide" >Must contain at least 8 characters and include at least one number and one special character</span>
													<span style="color:#b8071b" id="pass-error" ></span>
												</div>
												<div class="col-md-6 col-sm-6">
													<label class="input">Confirm Password</label>
													<input type="password" id="cnf_password" class="form-control" placeholder="" value="" name="cnf-password" onblur="check_cnf_password()" >
													<span style="color:#b8071b" id="cnf-pass-error" ></span>
												</div>
											</div>
										</div>
										<!-- <div class="row">
											<div class="form-group">
												<div class="col-md-6 col-sm-6">
													<span style="font-size:17px;">Upload your profie picture (optional)</span><br>
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
										<div class="row">
											<div class="form-group"></div>
										</div>
										<!-- child profiles -->
										<h2 class="color-blue">Build Your Child's Profile(s)</h2>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												You may register up to 4 children at once. How many would you like to register?
												<br>
												<br>
												<div class="row">
													<div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-10">
														<button type="button" onclick="generateChild(1)" class="btn btn-default">One</button>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-10">
														<button type="button" onclick="generateChild(2)" class="btn btn-default">Two</button>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-10">
														<button type="button" onclick="generateChild(3)" class="btn btn-default">Three</button>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-6 margin-bottom-10">
														<button type="button" onclick="generateChild(4)" class="btn btn-default">Four</button>
													</div>
												</div>
											</div>
										</div>
										<!-- child one -->
										
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_one">
												<h2 style="margin-bottom:0;" class="color-blue">Child One:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-8 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" placeholder="" id="child1_first_name" name="child1_first_name" value="" onblur="check_child1_first()">
																	<span style="color:#b8071b" id="child1_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" name="child1_last_name" id="child1_last_name" value="" onblur="check_child1_last()">
																	<span style="color:#b8071b" id="child1_last_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<INPUT NAME="child1_month" id="child1_month"  type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?php if(!$month){echo 01;}else{echo $month;} ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="01" max="12" placeholder="01" onblur="check_child1_dob()" required >
																	-
																	<INPUT NAME="child1_year" id="child1_year" type="number"  style="width: initial;padding:5px;" 
                    value="<?php if($year){echo $year;}else{echo date("Y");} ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" onblur="check_child1_dob()" required>
																	<!-- <input type="date" class="form-control" placeholder="" id="child1_dob" name="child1_dob" value="" onblur="check_child1_dob()"> --><br>
																	<span style="color:#b8071b" id="child1_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" id="child1_gender" name="child1_gender" value="1" onblur="check_child1_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" id="child1_gender" name="child1_gender" value="2" onblur="check_child1_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child1_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:14px;">Upload your profie picture (optional)</span><br>
																	<span style="font-size:12px;">must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6 action">
																	<!-- <input type="file"  class="buttn btn btn-default form-control" > 
																	</input>-->
																	<input type="file" id="child1_pic" name="child1_pic" accept="image/*" style="float:left; width: 250px" >
	        														Click to browse &amp; upload
	        														
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4 col-sm-4 col-xs-12" style="padding-top:20px;">
														<button type="button" id="remove1" class="btn btn-default remove-btn">Remove</button>
														<img id="child1_pic_preview" style="width:100%;max-height:250px;height: 250px;" class="img-responsive" src="" alt="Child One Image Preview">
													</div>
												</div>
											</div>
										</div>
										<!-- child one ends -->

										<!-- child two starts -->
										
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_two">
												<h2 style="margin-bottom:0;" class="color-blue">Child Two:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-8 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" id="child2_first_name" placeholder="" name="child2_first_name" value="" onblur="check_child2_first()">
																	<span style="color:#b8071b" id="child2_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" id="child2_last_name" name="child2_last_name" value="" onblur="check_child2_last()">
																	<span style="color:#b8071b" id="child2_last_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<INPUT NAME="child2_month" id="child2_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?php if(!$month){echo 01;}else{echo $month;} ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="12" placeholder="01" onblur="check_child2_dob()" required >
																	-
																	<INPUT NAME="child2_year" id="child2_year" type="number"  style="width: initial;padding:5px;" 
                    value="<?php if($year){echo $year;}else{echo date("Y");} ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" onblur="check_child2_dob()" required>
																	<!-- <input type="date" class="form-control" placeholder="" name="child2_dob" id="child2_dob" value="" onblur="check_child2_dob()"> --><br>
																	<span style="color:#b8071b" id="child2_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" name="child2_gender" id="child2_gender" value="1" onblur="check_child2_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" name="child2_gender" id="child2_gender" value="2" onblur="check_child2_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child2_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:14px;">Upload your profie picture (optional)</span><br>
																	<span style="font-size:12px;">must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<!-- <input type="file" class="buttn btn btn-default btn-lg" id="child2_pic" name="child2_pic" onblur="check_child2_pic()"> -->
																	<input type="file" id="child2_pic" name="child2_pic" accept="image/*" style="float:left; width: 250px" >
																	Click to browse &amp; upload
																	
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4 col-sm-4 col-xs-12" style="padding-top:20px;">
														<button type="button" id="remove2" class="btn btn-default remove-btn">Remove</button>
														<img id="child2_pic_preview" style="width:100%;max-height:250px;height: 250px;" class="img-responsive" src="" alt="Child Two Image Preview">
													</div>
												</div>
											</div>
										</div>
										<!-- child two ends -->

										<!-- child three starts -->
										
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_three">
												<h2 style="margin-bottom:0;" class="color-blue">Child Three:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-8 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" placeholder="" name="child3_first_name" id="child3_first_name" value="" onblur="check_child3_first()">
																	<span style="color:#b8071b" id="child3_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" name="child3_last_name" onblur="check_child3_last()" id="child3_last_name" value="" >
																	<span style="color:#b8071b" id="child3_last_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<INPUT NAME="child3_month" id="child3_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?php if(!$month){echo 01;}else{echo $month;} ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="12" placeholder="01" onblur="check_child3_dob()" required >
																	-
																	<INPUT NAME="child3_year" id="child3_year" type="number"  style="width: initial;padding:5px;" 
                    value="<?php if($year){echo $year;}else{echo date("Y");} ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" onblur="check_child3_dob()" required>
																	<!-- <input type="date" class="form-control" id="child3_dob"  placeholder="" name="child3_dob" value=""  onblur="check_child3_dob()"> --><br>
																	<span style="color:#b8071b" id="child3_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" id="child3_gender" name="child3_gender" value="1" onblur="check_child3_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" id="child3_gender" name="child3_gender" value="2" onblur="check_child3_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child3_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<span style="font-size:14px;">Upload your profie picture (optional)</span><br>
																	<span style="font-size:12px;">must be at least 300 pixels wide and tall</span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<!-- <input type="file" class="buttn btn btn-default btn-lg" id="child3_pic" name="child3_pic" onblur="check_child3_pic()"> -->
																	<input type="file" id="child3_pic" name="child3_pic" accept="image/*" style="float:left; width: 250px" >
																		Click to browse &amp; upload
																	
																	
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4 col-sm-4 col-xs-12">
														<button type="button" id="remove3" class="btn btn-default remove-btn">Remove</button>
														<img id="child3_pic_preview" style="width:100%;max-height:250px;height: 250px;" class="img-responsive" src="" alt="Child Three Image Preview">
													</div>
												</div>
														
												
														
											</div>
										</div>
										<!-- child three ends -->

										<!-- child four starts -->
										
										<div class="row ">
											<div class="col-md-12 col-sm-12 col-xs-12 margin-top-30" id="child_four">
												<h2 style="margin-bottom:0;" class="color-blue">Child Four:</h2>
												<div class="row">
													<div class="col-md-8 col-sm-8 col-xs-12">
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">First Name</label>
																	<input type="text" class="form-control" placeholder="" id="child4_first_name" name="child4_first_name" value="" onblur="check_child4_first()">
																	<span style="color:#b8071b" id="child4_first_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Last Name</label>
																	<input type="text" class="form-control" placeholder="" id="child4_last_name" onblur="check_child4_last()" name="child4_last_name" value="" >
																	<span style="color:#b8071b" id="child4_last_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group">
																<div class="col-md-6 col-sm-6">
																	<label class="input">Date of Birth (MM-YYYY)</label><br>
																	<INPUT NAME="child4_month" id="child4_month" type="number" onkeydown="limitmonth(this);" onkeyup="limitmonth(this);" style="width: initial;padding:5px;" value="<?php if(!$month){echo 01;}else{echo $month;} ?>" SIZE=2 MAXLENGTH=2 onKeyPress="return numbersonly(this, event)" min="1" max="12" placeholder="01" required  onblur="check_child4_dob()" >
																	-
																	<INPUT NAME="child4_year"  id="child4_year" type="number"  style="width: initial;padding:5px;" 
                    value="<?php if($year){echo $year;}else{echo date("Y");} ?>" SIZE=4 MAXLENGTH=4 onKeyPress="return numbersonly(this, event)" min="2000" placeholder="<?=date("Y")?>" max="<?=date("Y")?>" onblur="check_child4_dob()" required>
																	<!-- <input type="date" class="form-control" placeholder="" id="child4_dob" name="child4_dob" value="" onblur="check_child4_dob()"> -->
																	<br>
																	<span style="color:#b8071b" id="child4_dob_error" ></span>
																</div>
																<div class="col-md-6 col-sm-6">
																	<label class="input">Gender</label>
																	<br>
																	<label class="radio">
																		<input type="radio" name="child4_gender" id="child4_gender" value="1" onblur="check_child4_gender()">
																		<i></i> Male
																	</label>
																	<label class="radio">
																		<input type="radio" name="child4_gender" id="child4_gender" value="2" onblur="check_child4_gender()">
																		<i></i> Female
																	</label><br>
																	<span style="color:#b8071b" id="child4_gender_error" ></span>
																</div>
															</div>
														</div>
														<div class="row">
													<div class="form-group">
														<div class="col-md-6 col-sm-6">
															<span style="font-size:14px;">Upload your profie picture (optional)</span><br>
															<span style="font-size:12px;">must be at least 300 pixels wide and tall</span>
														</div>
														<div class="col-md-6 col-sm-6">
															<!-- <input type="file" class="buttn btn btn-default btn-lg" id="child4_pic" name="child4_pic" onblur="check_child4_pic()"> -->
															<input type="file" id="child4_pic" name="child4_pic" accept="image/*" style="float:left; width: 250px" >
																Click to browse &amp; upload
															
															
														</div>
													</div>
												</div>
													</div>
													<div class="col-md-4 col-sm-4 col-xs-12">
														<button type="button" id="remove4" class="btn btn-default remove-btn">Remove</button>
														<img id="child4_pic_preview" style="width:100%;max-height:250px;height: 250px;" class="img-responsive" src="" alt="Child Four Image Preview">
													</div>
												</div>
														
														
												
											</div>
										</div>
										<!-- child four starts -->
										<div class="row margin-top-30 margin-bottom-20">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<button type="submit" name="submit" value="Save" class="custom-blue btn btn-lg">Go to Purchase Summary</button>
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
        	
        	$(document).ready(function(){
        		document.getElementById("child_one").style.display = "none";
        		document.getElementById("child_two").style.display = "none";
        		document.getElementById("child_three").style.display = "none";
        		document.getElementById("child_four").style.display = "none";
        	});
        	function generateChild(d)
        	{
        		// How many child selected store in js varibale for form validation
        		childcount=d;
        		// Function use for storing how many child in database
        		childCountFunction(childcount);
        		document.getElementById("child_one").style.display = "none";
        		document.getElementById("child_two").style.display = "none";
        		document.getElementById("child_three").style.display = "none";
        		document.getElementById("child_four").style.display = "none";
        		if(d==1){
        			document.getElementById("child_one").style.display = "block";
        		}
        		else if(d==2){
        			document.getElementById("child_one").style.display = "block";
        			document.getElementById("child_two").style.display = "block";
        		}
        		else if(d==3){
        			document.getElementById("child_one").style.display = "block";
        			document.getElementById("child_two").style.display = "block";
        			document.getElementById("child_three").style.display = "block";
        		}
        		else if(d==4){
        			document.getElementById("child_one").style.display = "block";
        			document.getElementById("child_two").style.display = "block";
        			document.getElementById("child_three").style.display = "block";
        			document.getElementById("child_four").style.display = "block";
        		}
        	}

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
<!-- DOB -->
<script type="text/javascript">
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
	function resize()
    {
        var widths = window.innerWidth;
        // if(widths<1000)
        // {
        // 	$("change_container").removeClass("container");
	       //  $("change_container").addClass("container-fluid");
        // }
        if(widths<1000)
        {
        	document.getElementById("change_container").style.minWidth = (widths) + "px";
        }
        // document.getElementById("content_height").style.height = (heights-216) + "px";
    }
    resize();
    window.onresize = function() {
        resize();
    };
</script>
