<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
?>
<?php
//To get the rating
$user = JFactory::getUser();
$db = & JFactory::getDBO();
$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$user->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$user->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
		if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$user->id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	}

	
	if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			
	?>
<p class="vendorating" style="margin-top:-15px; margin-left:-18px;"><img src="components/com_camassistant/assets/images/rating/vendorrating/<?php echo $rate_image; ?>"><br><br><?php echo $rating; ?> Out of 5 
</p><p style="height: 13px;"></p>
<p style="border-top:1px dotted; width:90px; margin-left:38px;" align="center"></p><p style="height:5px"></p>
<p align="center" style="margin-right:20px;"><?php echo count($count_vs); ?> Reviews</p>
<p></p>