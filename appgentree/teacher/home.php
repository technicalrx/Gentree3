<?php
require('../classes.php');
include ("header.php"); 
?>
	<body>
		<div class="wrapper" id="wrapper">
			<header id="header" style="background-color:white;">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<nav class="navbar">
							  <div class="container-fluid">
							    <!-- Brand and toggle get grouped for better mobile display -->
							    <div class="navbar-header">
							      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							        <span class="sr-only">Toggle navigation</span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							      </button>
							      <a class="navbar-brand" href="home.php"><img class="img-responsive" src="../images/icon.png"></a>
							    </div>

							    <!-- Collect the nav links, forms, and other content for toggling -->
							    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							      
							      <ul class="custom-nav nav navbar-nav navbar-right">
							        <!-- <li><a href="#">Login</a></li> -->
							        <?php
							        if($administrator_user->check_login())
									{
										$user = $db->get_results("select * from ".TABLE_TEACHER." Where teacher_id='".$_SESSION['admin_panel']."'");
									?>
										<li>
											<a href="admin/dashboard.php"><i class="fa fa-user"></i>
								               <?=$user[0]->firstname." ".$user[0]->lastname?>
								            </a>
							            </li>
							        <?php
									}
									?>
							        
							        
							      </ul>
							    </div><!-- /.navbar-collapse -->
							  </div><!-- /.container-fluid -->
							</nav>
						</div>
					</div>
				</div>
			</header>
			<section class="content-1" id="content-1">
				<div class="container" >
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10">
							<div class="row">
								 <?php
							        if(!$administrator_user->check_login())
									{
								  ?>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
									<div class="teacher-section">
										<h1>For Teacher</h1>
										<br>
										<br>
										<br>
										<a href="/admin/index.php">Login</a>
										<a href="/teacher/register.php">Register</a>
									</div>
								</div>
								<?php 
							      } 
							    ?>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
									<div class="student-section">
										<h1>For Student</h1>
										<br>
										<br>
										<br>
										<a id="box" href="/genTree/">Let's Get Started</a>
									</div>
								</div>
							</div> 
						</div>
					</div>
				</div>
			</section>
		</div>
		
<?php include ("footer.php");  ?>