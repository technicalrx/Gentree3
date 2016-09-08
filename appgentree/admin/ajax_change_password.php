<?php
require ("../classes.php");

	$id=$_GET['id'];
	$data = array(
	"teacher_password" =>	md5(SALT.$_GET['pass']),
	);
	$table = TABLE_TEACHER;
	$where = array("teacher_id" => $id);
	$db->update($table, $data, $where);
	
?>