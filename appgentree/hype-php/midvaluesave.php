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


$school;





$data = array(
			"midpoint"          =>  $answer,
	);
   
	    $table = TABLE_RESULT;

		$where = array(
			"result_id" => $result_id,
			"Period" => $date,
			"child_id"=>$child_id
		 );
		$updated=$db->update($table, $data, $where); 

		$response["status"]="success";


echo json_encode($response);
?>