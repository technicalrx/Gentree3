<?php
/*******************************************************************************
* File Name        : left-menu.php                                                     
* File Description : Left panel after login.It provide flow after login in website                                                               
* Author           : SimSam                                                              
*******************************************************************************/
?>
<style type="text/css">
	.ul-white {
		list-style-type: square;
		font-size: 17px;
		color: white;
	}
</style>

<ul class="ul-white">
	<li>
		
		<a class="a-color-white" href="/view-report-listing/?userid=<?=$_GET['userid']?>">
			View Reports	
		</a>
		
	</li>
	<li>
		
		<a class="a-color-white" href="/edit-profile/?userid=<?=$_GET['userid']?>">
			Update User Profile
		</a>
		
	</li>
	<!-- <li>
		
		<a class="a-color-white" href="repurchase_payment_summary.php?userid=<?=$_GET['userid']?>">
			Purchase Another Assessment
		</a>
		
	</li> -->
	<li>
		
		<a class="a-color-white" href="/logout">
			Logout
		</a>
		
	</li>
</ul>
	