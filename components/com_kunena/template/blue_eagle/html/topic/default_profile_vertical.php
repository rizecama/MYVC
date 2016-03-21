<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Topic
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>

	<ul class="kpost-profile">
		<?php /*?><li class="kpost-username">
			<?php echo $this->profile->getLink() ?>
		</li><?php */?>
		<?php if (!empty($this->usertype)) : ?>
		<li class="kpost-usertype">
			<span class = "kmsgusertype">( <?php echo JText::_($this->escape($this->usertype)) ?> )</span>
		</li>
		<?php endif ?>
		<?php $avatar = $this->profile->getAvatarImage ('kavatar', 'post'); if ($avatar) : ?>
		<li class="kpost-avatar">
			<span class="kavatar"><?php 
	$user = JFactory::getUser($this->profile->userid);
	$db = & JFactory::getDBO();
	if($user->user_type == '11'){
	$getvendorimage = "SELECT image,company_name FROM `#__cam_vendor_company`  where user_id=".$user->id." ";
	$db->setQuery($getvendorimage);
	$deta = $db->loadObject();
	$path1 = $deta->image ;
	$replyname = $deta->company_name ;
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
	$replyname = $user->name. ' ' . $user->lastname ;
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
	
	else if($user->user_type == '16'){
	
	$propertyimage = "SELECT propertyowner_image FROM `#__cam_propertyowner_image`  where user_id=".$user->id." ";
	$db->setQuery($propertyimage);
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
	$replyname = $user->name. ' ' . $user->lastname ;
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
	$thumb_width =90;
	$thumb_height = round($thumb_width * $aspect_ratio) ;
	if($thumb_height == 0){
	$thumb_height = '93';
	}		
	$path1 = str_replace('&','_',$path1);
	?>
	<?php if($user->user_type == '11'){ ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<?php } else { ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } ?>
	<br /><strong><?php echo $replyname; ?></strong>
	<?php 
			//echo $this->profile->getLink( $avatar ); ?></span>
		</li>
		<?php endif; ?>

		<?php if ($this->profile->exists()): ?>

		<?php /*?><li>
			<span class="kicon-button kbuttononline-<?php echo $this->profile->isOnline('yes', 'no') ?>">
				<span class="online-<?php echo $this->profile->isOnline('yes', 'no') ?>">
					<span><?php echo $this->profile->isOnline(JText::_('COM_KUNENA_ONLINE'), JText::_('COM_KUNENA_OFFLINE')); ?></span>
				</span>
			</span>
		</li><?php */?>

		<?php if (!empty($this->userranktitle)) : ?>
		<li class="kpost-userrank">
			<?php echo $this->escape($this->userranktitle) ?>
		</li>
		<?php endif ?>
		<?php if (!empty($this->userrankimage)) : ?>
		<li class="kpost-userrank-img">
			<?php echo $this->userrankimage ?>
		</li>
		<?php endif ?>

		<?php if (!empty($this->personalText)) : ?>
		<li class="kpost-personal">
			<?php echo $this->personalText ?>
		</li>
		<?php endif ?>
		<?php if ($this->userposts) : ?>
		<li class="kpost-userposts"><?php echo JText::_('COM_KUNENA_POSTS') .' '. intval($this->userposts); ?></li>
		<?php endif ?>
		<?php if ($this->userthankyou) : ?>
			<li class="kpost-usertyr"><?php echo JText::_('COM_KUNENA_MYPROFILE_THANKYOU_RECEIVED') .' '. intval($this->userthankyou); ?></li>
		<?php endif ?>
		<?php if ($this->userpoints) : ?>
		<li class="kpost-userposts"><?php echo JText::_('COM_KUNENA_AUP_POINTS') .' '. intval($this->userpoints); ?></li>
		<?php endif ?>
		<?php if ( $this->userkarma ) : ?>
		<?php /*?><li class="kpost-karma">
			<span class="kmsgkarma">
				<?php echo $this->userkarma ?>
			</span>
		</li><?php */?>
		<?php endif ?>
		<?php if ( !empty($this->usermedals) ) : ?>
			<li class="kpost-usermedals">
			<?php foreach ( $this->usermedals as $medal ) : ?>
				<?php echo $medal; ?>
			<?php endforeach ?>
			</li>
		<?php endif ?>

		<?php /*?><li class="kpost-smallicons">
			<?php echo $this->profile->profileIcon('gender'); ?>
			<?php echo $this->profile->profileIcon('birthdate'); ?>
			<?php echo $this->profile->profileIcon('location'); ?>
			<?php echo $this->profile->profileIcon('website'); ?>
			<?php echo $this->profile->profileIcon('private'); ?>
			<?php echo $this->profile->profileIcon('email'); ?>
		</li><?php */?>

		<?php endif ?>
</ul>
