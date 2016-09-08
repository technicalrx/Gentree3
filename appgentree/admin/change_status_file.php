<?php
require ("../classes.php");
if($_GET['id'] != "" && $_GET['table'] != "" && $_GET['status_field'] != "" && $_GET['id_field'] != "" && $_GET['status'] != "")
{
	$data = array(
		sqlinj($_GET['status_field']) => sqlinj($_GET['status'])
	);
	$table = sqlinj($_GET['table']);
	$where = array(
		sqlinj($_GET['id_field']) => sqlinj($_GET['id'])
	);
	$a= $db->update($table, $data, $where);
	if($a)
	{
		$ar = array("Result"=>1, "Message"=>"Status Changed Successfully");
		echo json_encode($ar);
	}
	else
	{
		$ar = array("Result"=>0, "Message"=>"Some Error Occure!!!");
		echo json_encode($ar);
	}
}
?>