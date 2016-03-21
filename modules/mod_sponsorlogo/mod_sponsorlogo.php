<?php

error_reporting(0);

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

$user = JFactory::getUser();

$db = & JFactory::getDBO();

$subscribe = "SELECT subscribe_type from #__users where id=".$user->id." ";

$db->setQuery($subscribe);

$subscribe = $db->loadResult();

$path2 = $siteURL."modules/mod_sponsorlogo";

$path1 = 'MyVCSealSilverv2.png';

$image = $path2.$path1;	

$image = str_replace(' ','%20',$image);

$apath= getimagesize($image);

$height_orig=$apath[1];

$width_orig=$apath[0];

$aspect_ratio = (float) $height_orig / $width_orig;

$thumb_width =220;

$thumb_height = round($thumb_width * $aspect_ratio);

if($thumb_height == 0){

$thumb_height = '220';

}		



if($subscribe == 'sponsor' || $subscribe == 'all' ){ 

?><br />

	<p align="center" style="border-top: 1px dotted; width: 217px; height:20px;"></p>

	<div style="margin-left:21px">

	<img src="modules/mod_sponsorlogo/<?php echo $path1; ?>" />

	</div>

	<p style="height:17px"></p>

	

	<?php } ?>