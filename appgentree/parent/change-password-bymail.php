<!-- 
/*******************************************************************************
* File Name        : change-password-bymail.php                                                     
* File Description : using this code change passwword,after getting mail in forget password process.                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 -->
<?php 


if($_POST['submit']=='save')
{
	$check=$db->get_results("SELECT * FROM ".TABLE_PARENT." where md5(user_id)='".$_GET['userid']."'");
	$check_token=$db->get_results("SELECT * FROM ".TABLE_FORGET_TOKEN." where token='".$_GET['token']."' and status='1'");
	if(count($check)>0 && count($check_token)>0)
	{
		$data=array(
		"user_password"=>md5(SALT.$_POST['user_password']),
		);
		$table = TABLE_PARENT;
		$where = array('user_id' => $check[0]->user_id,);
		$db->update($table, $data, $where); 

		// Update token status
		$data_token=array(
		"status"=>'0',
		);
		$table_token = TABLE_FORGET_TOKEN;
		$where_token = array('token' => $_GET['token'],);
		$db->update($table_token, $data_token, $where_token); 

		redirect("/change-password-bymail?success=1");
   }else
   {
   	 redirect("/change-password-bymail?error=1");
   }
}
?>
	<style type="text/css">
		.form-control {
		    font-family: "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
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
						<div class="col-md-12 col-sm-12 col-xs-12" >
							<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12" style="margin-top:8%;padding:0;background-color:white;">
								<div class="col-md-12 col-sm-12 col-xs-12" style="padding:20px 30px;background-color:white;">
									<form class="" onsubmit="return(formCheckPassword());" method="post">
								      	<h3 class="center_normal">Change Password</h3>
								      	<div class="form-group">
								      		<label>New Password</label>
								      		 <div class="">
							                    <input type="password" placeholder="New Password" name="user_password" class="form-control" id="user_password" onblur="check_password()" >
							                    <span style="color:#b8071b" id="pass-error" ></span>
							                </div>
								      	</div>
								      	<div class="form-group">
								      		<label>Confirm Password</label>
								      		<div class="">
								      			<input type="password" placeholder="Confirm Password" name="cnf_password" class="form-control" id="cnf_password" onblur="check_cnf_password()">
								      			<span style="color:#b8071b" id="cnf-pass-error" ></span>
								      		</div>
								      	</div>
								      	<div class="form-group">
								      		<p>The password must be 8 characters and include at least one lowercase letter, one uppercase letter, and a number</p>
								      	</div>
								      	<?php if($_GET['success'])
								      	{
								      		?>
								      	<div class="form-group" style="color:#5cb85c">
								      		<p>Password has changed successfully.!!</p>
								      	</div>
								      	<?php } ?>

								      	<?php if($_GET['error'])
								      	{
								      		?>
								      	<div class="form-group" style="color:#b8071b">
								      		<p>Error.!!</p>
								      	</div>
								      	<?php } ?>

								      	<div class="form-group" >
								      		<button type="submit" value="save" name="submit" class="btn btn-danger pull-right" >Change Password</button>
								      	</div>
								    </form>
								</div>
							    
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

	<!-- <script type="text/javascript" src="assets/js/backstretch.js"></script>
	<script type="text/javascript">
		$("#wrapper").backstretch("images/bg_without_bear.png");
	</script> -->

	<?php if(isset($_GET['success'])){ ?>
		<script>
			 window.setTimeout(function(){

        // Move to a new location or you can do something else
        window.location.href = "/login/";

    }, 3000);
		</script>
    <?php } ?>

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
