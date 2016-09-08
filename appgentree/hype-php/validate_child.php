<?php

header("Access-Control-Allow-Origin: *");

//class add for db connect
require('classes.php');

// array for JSON response
$response = array();



$t_id=$_POST['teacherid'];
$s_id=$_POST['studentid'];
$time=$_POST['time'];

$teacherid=strtolower($t_id);
$studentid=strtolower($s_id);

//geting id from student and child table using username
$student = $db->get_results("SELECT * from ".TABLE_CHILD." WHERE child_username='".$studentid."'");

// For Teacher 
if($student[0]->teacher_id!='0')
{ 
   $teacher = $db->get_results("SELECT * from ".TABLE_TEACHER." WHERE teacher_username='".$teacherid."'");
   $check_class = $db->get_results("SELECT * FROM ".TABLE_CLASS." WHERE class_id='".$student[0]->class_id."'");
      if(count($teacher)>0 && count($student)>0 && count($check_class)>0)
      {
         $child = $db->get_results("SELECT * from ".TABLE_CHILD." WHERE child_id='".$student[0]->child_id."' AND teacher_id='".$teacher[0]->teacher_id."'");
         if(count($child) > 0)
         {
            $result_scene = $db->get_results("SELECT * from ".TABLE_RESULT." WHERE child_id='".$student[0]->child_id."' AND teacher_id='".$teacher[0]->teacher_id."' order by result_id DESC");
            $response["status"]="success";
            $response["child_id"]=$child[0]->child_id;
            $response["childname"]=$child[0]->child_firstname." ".$child[0]->child_lastname;
            $response["class_id"]=$child[0]->class_id;
            $response["teacher_id"]=$teacher[0]->teacher_id;
         }
         else
         {  
         $response["status"]="error + check";
         }
      }else
      {
      $response["status"]="error";
      }
      echo json_encode($response);
}else
{
   // For Parents
        $parent = $db->get_results("SELECT * from ".TABLE_PARENT." WHERE username='".$teacherid."'");
        if(count($parent)>0 )
        {
            $child = $db->get_results("SELECT * from ".TABLE_CHILD." WHERE child_id='".$student[0]->child_id."' AND parent_id='".$parent[0]->user_id."' and child_test_count >= 1");


           if(count($child) > 0 )
            {
               $cur_time   = strtotime(date("Y-m-d"));
               $validity_time=strtotime($child[0]->child_registration_date);
               $datediff=($cur_time-$validity_time);
               $diff=floor($datediff/(60*60*24));
               if($diff<7)
               {
                     $response["status"]="success";
                     $response["child_id"]=$child[0]->child_id;
                     $response["childname"]=$child[0]->child_firstname." ".$child[0]->child_lastname;
                     $response["class_id"]='0';
                     $response["teacher_id"]=$parent[0]->user_id;

                     // child count test
                     $data_child=array(
                        "child_test_count"=>'0',
                        );
                     $table = TABLE_CHILD;
                     $where = array("child_id" => $child[0]->child_id);
                     $db->update($table,$data_child, $where);
               }else
               {
                   $response["status"]="errorexpire";
               }       
            }
            else
            {  
                $response["status"]="errorused";
            }
      }else
      {
      $response["status"]="error";
      }
      echo json_encode($response);
}      
?>