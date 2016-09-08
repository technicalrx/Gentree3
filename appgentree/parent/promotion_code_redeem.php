<?php
require('../classes.php');
/*******************************************************************************
* File Name        : payment_code_redeem.php                                                     
* File Description : Payement summary and can use promocode in that screen                                                               
* Author           : SimSam                                                              
*******************************************************************************/
 $promo=$db->get_results("select * from ".TABLE_PROMOTIONCODE." where LOWER(promotion_code)='".strtolower($_GET['promotion_code'])."'");
 if(count($promo)>0)
 {
 	$cur_time   = strtotime(date("Y-m-d")) ;
	$validity_time=strtotime($promo[0]->promotion_code_end_date);
	$starting_time=strtotime($promo[0]->promotion_code_start_date);
	if($cur_time<=$validity_time && $cur_time>=$starting_time)
		{
 	        $data['status'] = 1;
			 	if($promo[0]->promotion_code_flat=='0')
			 	{
			 	 $data['flat']='0';	
			 	 $data['percentage']="".$promo[0]->promotion_code_percentage;
			 	}else
			 	{
			 	 $data['flat']=$promo[0]->promotion_code_flat;	
			 	 $data['percentage']='0';
			 	}
     }else
     {
     	$data['status'] = 3;
     }
 }else
 {
 	$data['status'] = 2;
 }
 echo json_encode($data);
?>