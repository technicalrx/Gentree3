<?php include('header.php'); ?>
<!-- 
    /*******************************************************************************
* File Name        : signinl.php                                                     
* File Description : sign in file                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->
 <?php 
if($_POST['submit']=='Save')
{
	$check=$db->get_results("SELECT * FROM ".TABLE_PARENT." where username='".$_POST['username']."' and user_activation_key='".$_POST['activation_key']."'");
	if(count($check)>0)
	{
		$cur_time   =    strtotime(date("Y-m-d")) ;
		$validity_time=strtotime($check[0]->user_activation_key_validity);
		if($cur_time<=$validity_time)
		{

			redirect("http://brolance.com/parentgentreeapp/?userid=".md5($check[0]->user_id));
			//header('Location: http://brolance.com/gentreeapp7/');
			//header("Location: ");
		}else
		{
			//echo "<h1>error</h1>";
			redirect("/phase2/signin.php?activationerror=1");
		}
		
	}else
	{
		redirect("/phase2/signin.php?error=1");
	}
}
?>

	<style type="text/css">
		.form-control {
		    font-family: "Open Sans","Cabin",Arial,sans-serif!important;
		    border-radius: 0;
		    border-left: 2px solid green;
		}

		.icon-addon {
		    position: relative;
		    color: #555;
		    display: block;
		}

		.icon-addon:after,
		.icon-addon:before {
		    display: table;
		    content: " ";
		}

		.icon-addon:after {
		    clear: both;
		}

		.icon-addon.addon-md .glyphicon,
		.icon-addon .glyphicon, 
		.icon-addon.addon-md .fa,
		.icon-addon .fa {
			color: #aaa;
		    position: absolute;
		    z-index: 2;
		    left: 10px;
		    font-size: 14px;
		    width: 20px;
		    margin-left: -2.5px;
		    text-align: center;
		    padding: 12px 0;
		    top: 1px
		}

		.icon-addon.addon-lg .form-control {
		    line-height: 1.33;
		    height: 46px;
		    font-size: 18px;
		    padding: 10px 16px 10px 40px;
		}

		.icon-addon.addon-sm .form-control {
		    height: 30px;
		    padding: 5px 10px 5px 28px;
		    font-size: 12px;
		    line-height: 1.5;
		}

		.icon-addon.addon-lg .fa,
		.icon-addon.addon-lg .glyphicon {
		    font-size: 18px;
		    margin-left: 0;
		    left: 11px;
		    top: 4px;
		}

		.icon-addon.addon-md .form-control,
		.icon-addon .form-control {
		    padding-left: 30px;
		    float: left;
		    font-weight: normal;
		}

		.icon-addon.addon-sm .fa,
		.icon-addon.addon-sm .glyphicon {
		    margin-left: 0;
		    font-size: 12px;
		    left: 5px;
		    top: -1px
		}

		/*.icon-addon .form-control:focus + .glyphicon,
		.icon-addon:hover .glyphicon,
		.icon-addon .form-control:focus + .fa,
		.icon-addon:hover .fa {
		    color: #2580db;
		}*/
	</style>
	
			<!-- landing page content -->
			<section class="app_landing" id="content_height">
				<div class="container">
					<div class="row">
						<div class="" >
							<div class="tableT">
								<div class="tableC">
									<div class="contentC">
										<div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px 30px;background-color:white;">
										
										<form class=""  method="post">
									      	<h3 class="center_normal">Launch Assessment</h3>
									      	<div class="form-group">
									      		 <div class="icon-addon addon-md">
								                    <input type="text" placeholder="Parent/Teacher ID" name="username" class="form-control" id="input-username" required>
								                    <label for="input-username" class="glyphicon glyphicon-user" rel="tooltip" title="email"></label>
								                </div>
									      	</div>
									      	<div class="form-group">
									      		<div class="icon-addon addon-md">
									      			<input type="password" placeholder="Activation Key" name="activation_key" class="form-control" id="input-password" required>
									      			<label for="input-password" class="glyphicon glyphicon-lock" rel="tooltip" title="email"></label>
									      		</div>
									      	</div>
									      	<?php
										      	if(isset($_GET['error']))
										      	{
										      	?>
										      	<span style="color:#b8071b" id="email-error"><i class="icon-warning-sign"></i>&nbsp;invalid username and password</span>
										    <?php } ?>

										    <?php
										      	if(isset($_GET['activationerror']))
										      	{
										      	?>
										      	<span style="color:#b8071b" id="email-error"><i class="icon-warning-sign"></i>&nbsp;Your activation key is expire</span>
										    <?php } ?>

									      	<div class="form-group" align="right">
									      		<button type="submit" name="submit" value="Save" class="btn btn-danger" >Login</button>
									      	</div>
									      	
									    </form>
									    <div class="col-md-12 col-sm-12 col-xs-12">
									    	<p class="font-18">Please check your email for your login information</p>
									    </div>
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	<?php include('footer.php');?>
	<!-- <script type="text/javascript" src="assets/js/backstretch.js"></script>
	<script type="text/javascript">
		$("#wrapper").backstretch("images/bg_without_bear.png");
	</script> -->
	<style type="text/css">
		#wrapper{
			background-image: url('images/bg_without_bear.png');
		}
	</style>
	<script type="text/javascript">
    function resize()
    {
        var heights = window.innerHeight;

        document.getElementById("wrapper").style.minHeight = (heights-85) + "px";
        // document.getElementById("content_height").style.height = (heights-216) + "px";
    }
    resize();
    window.onresize = function() {
        resize();
    };
</script>
