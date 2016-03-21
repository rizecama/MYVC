<?php

error_reporting(0);

//don't allow other scripts to grab and execute our file

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//To get the rating

$user = JFactory::getUser();

$db = & JFactory::getDBO();

$subtype = "SELECT subscribe_admin,subscribe_type FROM `#__users`  where id=".$user->id." ";
$db->setQuery($subtype);
$subscribetypes = $db->loadObject();
if( $subscribetypes->subscribe_type ){
	$subscribe = $subscribetypes->subscribe_type;
}
else{
	$subscribe = $subscribetypes->subscribe_admin;
}
	if( $subscribe == 'free' ){
		$free_icon = '<li><div class="unverified_vendor"></div></li>';
		$free_head = '<li class="unverified_head">UNVERIFIED</li>';
		$free_text = '<li class="unverified_text"><a href="index.php?option=com_camassistant&controller=vendors&task=subscriptions&type=public&Itemid=213">change your subscription</a> <span>to become verified</span></li>';
	}
	else if( $subscribe == 'public' ) {
		$public_icon = '<li class="public_vendor">&nbsp;</li>';
		$public_head = '<li class="public_head">VERIFIED</li>';
		$public_text = '<li class="public_text"><a href="index.php?option=com_camassistant&controller=vendors&task=subscriptions&type=all&Itemid=213">change your subscription</a> <span>to become a sponsor</span></li>';
	}
	else{
		$all_icon = '<li class="all_vendor"><div class="all_vendor1"></div><div class="all_vendor2"></div></li>';
		$all_head1 = '<li class="all_head"><span class="green">VERIFIED</span> <span class="normal">+</span> <span class="yellow">SPONSOR</span></li>';
	}
?>	

<ul class="acciountype_vendor">
<?php 
echo $free_icon;
echo $free_head;
echo $free_text;

echo $public_icon;
echo $public_head;
echo $public_text;

echo $all_icon;
echo $all_head1;
?>
</ul>


