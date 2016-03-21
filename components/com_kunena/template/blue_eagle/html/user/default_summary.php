<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage User
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

$private = KunenaFactory::getPrivateMessaging();
if ($this->me->userid == $this->user->id) {
	$PMCount = $private->getUnreadCount($this->me->userid);
	$PMlink = $private->getInboxLink($PMCount ? JText::sprintf('COM_KUNENA_PMS_INBOX_NEW', $PMCount) : JText::_('COM_KUNENA_PMS_INBOX'));
} else {
	$PMlink = $this->profile->profileIcon('private');
}
?>
<?php if ($this->avatarlink) : ?>

<div class="kavatar-lg">
<?php //echo $this->avatarlink; ?>
<?php 
				
	$user = JFactory::getUser($_REQUEST['userid']);
	$db = & JFactory::getDBO();
	if($user->user_type == '11'){
	$getvendorimage = "SELECT image FROM `#__cam_vendor_company`  where user_id=".$user->id." ";
	$db->setQuery($getvendorimage);
	$path1 = $db->loadResult();
	$path2 = $siteURL."components/com_camassistant/assets/images/vendors/";
		if($path1){
		$path1 = $path1 ;
		$image = $path2.$path1;	
		}
		else {
		$path1 = 'emptylogo.jpg' ;
		$image = $path2.$path1;	
		}
	}
	else if($user->user_type == '13'){
	$getfirmimage = "SELECT comp_logopath FROM `#__cam_customer_companyinfo`  where cust_id=".$user->id." ";
	$db->setQuery($getfirmimage);
	$firmlogo = $db->loadResult();
	$path2 = $siteURL."components/com_camassistant/assets/images/properymanager/";
	$path1 = $firmlogo;
		if($path1){
		$path1 = $path1 ;
		}
		else {
		$path1 = 'emptylogo.jpg' ;
		}
	$image = $path2.$path1;	
	}
	else{
	$getcid = "SELECT comp_id FROM `#__cam_customer_companyinfo`  where cust_id=".$user->id." ";
	$db->setQuery($getcid);
	$cid = $db->loadResult();
	$firmid = "SELECT cust_id FROM `#__cam_camfirminfo`  where id=".$cid." ";
	$db->setQuery($firmid);
	$firm_id = $db->loadResult();
	$getfirmimage = "SELECT comp_logopath FROM `#__cam_customer_companyinfo`  where cust_id=".$firm_id." ";
	$db->setQuery($getfirmimage);
	$firmlogo = $db->loadResult();
	$path2 = $siteURL."components/com_camassistant/assets/images/properymanager/";
	$path1 = $firmlogo;
		if($path1){
		$path1 = $path1 ;
		}
		else {
		$path1 = 'emptylogo.jpg' ;
		}
	$image = $path2.$path1;	
	}
	
	$image = str_replace(' ','%20',$image);
	$apath= getimagesize($image);
	$height_orig=$apath[1];
	$width_orig=$apath[0];
	$aspect_ratio = (float) $height_orig / $width_orig;
	$thumb_width =150;
	$thumb_height = 150 ;//round($thumb_width * $aspect_ratio)
	if($thumb_height == 0){
	$thumb_height = '150';
	}		
	$path1 = str_replace('&','_',$path1);
	?>
	<?php if($user->user_type == '11'){ ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<?php } else { ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } ?>

</div>
<?php endif; ?>
<div id="kprofile-stats">
<ul>
	<?php if ( !empty($this->banReason) ) : ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_BANINFO'); ?>:</strong> <?php echo $this->escape($this->banReason); ?></li><?php endif ?>
	<li><span class="kicon-button kbuttononline-<?php echo $this->profile->isOnline('yes', 'no') ?>"><span class="online-<?php echo $this->profile->isOnline('yes', 'no') ?>"><span><?php echo $this->profile->isOnline(JText::_('COM_KUNENA_ONLINE'), JText::_('COM_KUNENA_OFFLINE')); ?></span></span></span></li>
	<?php if (!empty($this->usertype)): ?><li class="usertype"><?php echo $this->escape($this->usertype); ?></li><?php endif; ?>
	<?php if (!empty($this->rank_title)): ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_RANK'); ?>: </strong><?php echo $this->escape($this->rank_title); ?></li><?php endif; ?>
	<?php if (!empty($this->rank_image)): ?><li class="kprofile-rank"><?php echo $this->rank_image; ?></li><?php endif; ?>
	<?php if (!empty($this->registerdate)): ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_REGISTERDATE'); ?>:</strong> <span title="<?php echo KunenaDate::getInstance($this->registerdate)->toKunena('ago'); ?>"><?php echo KunenaDate::getInstance($this->registerdate)->toKunena('date_today', 'utc'); ?></span></li><?php endif; ?>
	<?php if (!empty($this->lastvisitdate)): ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_LASTVISITDATE'); ?>:</strong> <span title="<?php echo KunenaDate::getInstance($this->lastvisitdate)->toKunena('ago'); ?>"><?php echo KunenaDate::getInstance($this->lastvisitdate)->toKunena('date_today', 'utc'); ?></span></li><?php endif; ?>
	<li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_TIMEZONE'); ?>:</strong> GMT <?php echo $this->localtime->toTimezone(); ?></li>
	<li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_LOCAL_TIME'); ?>:</strong> <?php echo $this->localtime->toKunena('time'); ?></li>
	<?php if (!empty($this->posts)): ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_POSTS'); ?>:</strong> <?php echo intval($this->posts); ?></li><?php endif; ?>
	<?php if (!empty($this->thankyou)): ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_THANKYOU_RECEIVED'); ?></strong> <?php echo intval($this->thankyou); ?></li><?php endif; ?>
	<?php if (!empty($this->userpoints)): ?><li><strong><?php echo JText::_('COM_KUNENA_AUP_POINTS'); ?></strong> <?php echo intval($this->userpoints); ?></li><?php endif; ?>
	<?php if (!empty($this->usermedals)) : ?><li><?php foreach ( $this->usermedals as $medal ) : echo $medal,' '; endforeach ?></li><?php endif ?>
	<li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_PROFILEVIEW'); ?>:</strong> <?php echo intval($this->profile->uhits); ?></li>
	<li><?php echo $this->displayKarma(); ?></li>
	<?php if ($PMlink) : ?>
	<li><?php if( $this->me->userid != $this->user->id): ?><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_SEND_MESSAGE'); ?>:</strong> <?php  endif ?><?php echo $PMlink; ?></li>
	<?php  endif ?>
	<?php if( !empty($this->personalText) ) { ?><li><strong><?php echo JText::_('COM_KUNENA_MYPROFILE_ABOUTME'); ?>:</strong> <?php echo KunenaHtmlParser::parseText($this->personalText); ?></li><?php } ?>
</ul>
</div>
