<?php
$page_name = basename($_SERVER['PHP_SELF']);
$get_detail = $db->get_results("select * from ".TABLE_TEACHER." where teacher_id = '".$_SESSION['admin_panel']."'");

?>
<div class="page-sidebar nav-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->         
         <ul>
            <li>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone" style="margin-bottom:15px;"></div>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
          
            <li class="start <?php if($page_name == "dashboard.php") { ?> active <?php } ?>">
               <a href="dashboard.php">
               <i class="fa fa-home"></i> 
               <span class="title"><?=$get_detail[0]->firstname." ".$get_detail[0]->lastname?></span>
               </a>
            </li>
            <!-- Dashboard -->
            <li class="start">
               <a href="dashboard.php">
               <i class="fa fa-user-secret"></i> 
               <span class="title"><?=$get_detail[0]->teacher_username?></span>
               </a>
            </li>
            <!-- Assessment -->
             <li class="start">
               <a href="../genTree" target="_blank">
               <i class="fa fa-trophy"></i>
               <span class="title">Assessment</span>
               </a>
            </li>
  
             <!--  Child and classes -->
            <li class="has-sub <?php if($page_name == "add_class.php" || $page_name == "view_class.php" || $page_name == "add_child.php" || $page_name == "view_child.php") { ?> active <?php } ?>">
               <a href="javascript:;">
               <i class="fa fa-building-o"></i>
               <span class="title">Classes</span>
               <span class="arrow <?php if($page_name == "add_class.php" || $page_name == "view_class.php" || $page_name == "add_child.php" || $page_name == "view_child.php") { ?> open <?php } ?>"></span>
               </a>
               <ul class="sub">
                  <li class="<?php if($page_name == "add_class.php" || $page_name == "view_class.php" ) { ?> active <?php } ?>">
                  <a style="display: inline-block;width:44%;background-color:#6C77FF;padding-left:10px !important;" href="add_class.php">
                  Add Class
                  </a> 
                  
                  <a  style="display: inline-block;width:44%;background-color:#6C77FF;padding-left:10px !important;" href="view_class.php">
                  View Classes
                  </a>
                  </li>
                  <?php
                        $class_ = $db->get_results("select * from ".TABLE_CLASS." Where teacher_id='".$_SESSION['admin_panel']."'order by class_name");
                        foreach($class_ as $sch)
                        {
                  ?>

                   <li class="<?php if($_GET['classid']== $sch->class_id) { ?> active <?php } ?>"><a href="view_child.php?classid=<?=$sch->class_id?>"><?=stripslashes($sch->class_name)." (Grade ".$sch->class_grade.")"?></a></li>

                  <?php
                        }
                  ?>

               </ul>
            </li>
            <!-- result -->
            <li class="start <?php if($page_name == "class_result.php") { ?> active <?php } ?>">
               <a href="class_result.php">
               <i class="fa fa-users"></i>
               <span class="title">Reports</span>
               </a>
            </li>
            <!-- Edit Profile -->
            <li class="start <?php if($page_name == "edit-profile.php") { ?> active <?php } ?>">
               <a href="edit-profile.php?teacherid=<?=$_SESSION['admin_panel']?>">
               <i class="fa fa-edit"></i> 
               <span class="title">Edit Profile</span>
               </a>
            </li>
            <!-- Logout -->
            <li class="">
               <a href="logout.php">
               <i class="fa fa-sign-out"></i> 
               <span class="title">Logout</span>
               </a>
            </li>
         </ul>
         <!-- END SIDEBAR MENU -->
      </div>