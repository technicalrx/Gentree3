<?php
require('../classes.php');
/*******************************************************************************
* File Name        : ajax_count_childs.php                                                     
* File Description : using this code check count the number of child.                           
* Author           : SimSam                                                              
*******************************************************************************/
if(isset($_POST['search']))
{
    $_SESSION['childcount'] = $_GET['childcount'];
    echo "1";
}else{
	echo "0";
}
?>