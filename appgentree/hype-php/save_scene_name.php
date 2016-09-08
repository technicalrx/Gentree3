<?php 
//IMPORTANTE
header("Access-Control-Allow-Origin: *");

//class add for db connect
require('classes.php');
//http://127.0.0.1:49251'

// array for JSON response
$response = array();
$result_id=$_POST['result'];
$scene_name=$_POST['scene_name'];
$table = TABLE_RESULT;
$data=array(
		"result_left_time"=>date('Y-m-d H:i:s'),
		"result_scene_name"=>$scene_name,
	);
$where = array(
			"result_id" => $result_id,
		 );
		$updated=$db->update($table, $data, $where); 
		$response["status"]="success";

echo json_encode($response);
?>		