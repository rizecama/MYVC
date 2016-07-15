<?php
/*------------------------------------------------------------------------
 # Vt NewsTicker  - Version 1.0 - YouTech Club
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 YouTech Club. All Rights Reserved.
 # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 # Author: Ytcvn.Com
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<?php
        $user =& JFactory::getUser();
 		$id = $user->get('id');
	
		$user_type = $user->get('user_type');
		//print_r($user_type);
		$db = & JFactory::getDBO();
        if($user_type!='11'){
			if($user_type=='13'){
			$query = "SELECT comp_state FROM #__cam_customer_companyinfo  WHERE `cust_id` =".$id;
			$db->setQuery($query);
			$statename = $db->loadResult();
			}
			else{
			$query = "SELECT comp_id FROM #__cam_customer_companyinfo  WHERE `cust_id` =".$id;
			$db->setQuery($query);
			$cid = $db->loadResult();
			
			$query = "SELECT cust_id FROM #__cam_camfirminfo  WHERE `id` =".$cid;
			$db->setQuery($query);
			$camfirmid = $db->loadResult();
			
			$query = "SELECT comp_state FROM #__cam_customer_companyinfo  WHERE `cust_id` =".$camfirmid;
			$db->setQuery($query);
			$statename = $db->loadResult();
			}
			
		if ($user_type){
		$where[] ='user_type='.$user_type;
		}
		if($statename)
		$where[] ="( state_name='".$statename."' OR state_name='' OR state_name=0 OR state_name=57)";
		else
		$where[] ="(state_name='' OR state_name=0 OR state_name=57)";
		$where=implode(' AND ',$where);
	 	$qry = "SELECT announcement FROM #__cam_announcement WHERE published=1 AND ".$where." ORDER BY id DESC";
		$db->Setquery($qry);
		$announcement = $db->loadObjectList();
		if($user_type=='16')
		{
		$qry = "SELECT announcement FROM #__cam_announcement WHERE published=1 AND user_type=16";
		$db->Setquery($qry);
		$announcement = $db->loadObjectList();
		}
           } else {
                $query = "SELECT state FROM #__cam_vendor_company  WHERE `user_id` =".$id;
		$db->setQuery($query);
		$statename = $db->loadResult();
		$query1 = "SELECT industry_id FROM #__cam_vendor_industries  WHERE `user_id` =".$id;
		$db->setQuery($query1);
		$industry = $db->loadResultArray();
		$industries=implode(',',$industry);
		/*echo "<pre>";
		print_r($industry);*/
		if ($user_type){
		$where[] ='user_type='.$user_type;
		}
		if($statename)
		$where[] ="(state_name='".$statename."' OR state_name='' OR state_name=0)";
		else
		$where[] ="(state_name='' OR state_name=0)";

		if($industry)
		$where[] ="(industry_name IN (".$industries.") OR industry_name='' OR industry_name=0)";
		else
		$where[] ="(industry_name='' OR industry_name=0)";

		$where=implode(' AND ',$where);

	 	$announcement = "SELECT announcement FROM #__cam_announcement WHERE published=1 AND ".$where." ORDER BY id DESC";
		$db->Setquery($announcement);
		$announcement = $db->loadObjectList();
             }
 ?>
<style type="text/css">
#slideshow { width: 100%; height: 150px;}
#slideshow #slide { width: 670px; height: 150px; padding-top: 20px; color: #333; text-align: left; overflow: hidden }
</style>
<script type="text/javascript" src="modules/mod_vt_newsticker/assets/newslide.js"></script>
<script>
    var K=jQuery.noConflict();
    K('#slideshow').cycle({
    fx:    "scrollHorz",
    speed: "5000",
    prev: '#previous', //#id of your previous button
    next: '#next' //#id of your next button
});
 var KN=jQuery.noConflict();
KN(document).ready(function() {
	var toggle = KN('#toggle').click(function() {
		var paused = slideshow.is(':paused');
		slideshow.cycle(paused ? 'resume' : 'pause', true);
	});

    var slideshow = KN('.slideshow').cycle({
		timeout: 200,
		pause: true,
        fx:    "scrollHorz",
		speed: "5000",
		paused: function(cont, opts, byHover) {
			!byHover && toggle.html('<img src="components/com_camassistant/assets/images/play.gif">');

		},
		resumed: function(cont, opts, byHover) {
			!byHover && toggle.html('<img src="components/com_camassistant/assets/images/pause.gif">');

		}
	});
});

    </script>
	<br />
<div class="nav" align="center">
  <a href="#" id="previous"><img src="components/com_camassistant/assets/images/leftarrow.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="#" id="toggle"><img src="components/com_camassistant/assets/images/pause.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="#" id="next"><img src="components/com_camassistant/assets/images/rightarrow.gif"></a>
  </div>
  <div id="slideshow" class="slideshow"><?php
	foreach($announcement as $item) {
	?><div id="slide">
	  <?php echo $item->announcement; ?>

     </div><?php
		}
		?>

  </div>

