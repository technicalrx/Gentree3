<?php
require ("../classes.php");

$result=$db->get_results("select * from ".TABLE_RESULT);
foreach ($result as $cl) 
{
$classname=addslashes($cl->SchoolName);
$get_classes = $db->get_results("select * from ".TABLE_SCHOOL." where school_name = '".$classname."'");
$table = TABLE_RESULT;
// 	// Insert Array
	if(count($get_classes)>0)
	{
		$data = array(
		        "school_id" => $get_classes[0]->school_id,
			);
				$where = array(
					"SchoolName" => $get_classes[0]->school_name,
				 );
				$updated=$db->update($table, $data, $where); 
	}
}
echo "done";	
?>