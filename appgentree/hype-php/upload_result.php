<?php
//IMPORTANTE
header("Access-Control-Allow-Origin: *");

//class add for db connect
require('classes.php');

// array for JSON response
$response = array();


$childName=$_POST['name'];
$dob=$_POST['dob'];
$date=$_POST['date'];
$teacherid=$_POST['teacher_id'];
$class_id=$_POST['class_id'];
$child_id=$_POST['child_id'];
$answer=$_POST['answer'];
$result_id=$_POST['result'];
$current_task=$_POST['current_task'];
$current_task=substr($current_task,4);
$total_time=floatval($_POST['duration']);
// if($_POST['result_id']!="")	
// 	{
// 		$result_id=$_POST['result_id'];
// 	}
// $childName="vikrant";
// $dob="1991-11-11";
// $date="2016-02-02";
// $teacherid="1";
// $class_id="1001";
// $child_id="1";
// $answer="PK";
// $question_no="1";
$school;

$result="Result".$current_task;
$duration="Duration".$current_task;


if($class_id!='0')
{	
		//Get Teacher Name
			$teach = $db->get_results("SELECT * from ".TABLE_TEACHER." WHERE teacher_id = '".$teacherid."'");
			$teacherName= $teach[0]->firstname." ".$teach[0]->lastname;

		//Get Class name
			$rclass = $db->get_results("select * from ".TABLE_CLASS." where class_id = '".$class_id."'");
			$schoolId=$rclass[0]->school_id;
		    $className=$rclass[0]->class_name;

		//Get School Name
			$temp = $db->get_results("select * from ".TABLE_SCHOOL." where school_id = '".$schoolId."'");
			$schoolName=$temp[0]->school_name;
			

		$data = array(
					"child_id" 			=>	$child_id,
					"ChildName" 		=>	$childName,
					"teacher_id"		=>  $teacherid,
					"TeacherName" 		=>	$teacherName,
					"ClassName" 		=>	$className,
					"class_id"          =>  $class_id,
					"SchoolName" 		=>	$schoolName,
					"school_id" 		=>	$schoolId,
					"Period" 			=>	$date,
					$result             =>  $answer,
					$duration 			=>  $total_time,
					"result_scene_status"  => '1',
					"result_scene_name" => $_POST['current_task'],
					"result_left_time"=>date('Y-m-d H:i:s'),
			);
}
else
{

		$data = array(
					"child_id" 			=>	$child_id,
					"parent_id"		=>  $teacherid,
					"Period" 			=>	$date,
					$result             =>  $answer,
					$duration 			=>  $total_time,
					"result_scene_status"  => '1',
					"result_scene_name" => $_POST['current_task'],
					"result_left_time"=>date('Y-m-d H:i:s'),
			);
		$schoolId='0';
}

	$table = TABLE_RESULT;
// 	// Insert Array
if($result_id=="")	
	{
	   $db->insert($table, $data);
	   $insert_id = $db->insert_id;

	   $response["status"]="success";
	   $response["insertid"]=$insert_id;	   
	   $response["school_id"]=$schoolId;
       $response["resultId"]=$insert_id;
    }
else{
		$where = array(
			"result_id" => $result_id,
			"child_id"=>$child_id
		 );
		$updated=$db->update($table, $data, $where); 

		$response["status"]="error";
    }


echo json_encode($response);
?>