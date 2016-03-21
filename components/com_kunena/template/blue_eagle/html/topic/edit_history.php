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

$k = 0;
?>
<div class="kblock khistory">
	<div class="kheader">
		<span class="ktoggler"><a class="ktoggler close" title="<?php echo JText::_('COM_KUNENA_TOGGLER_COLLAPSE') ?>" rel="khistory"></a></span>
		<h2><span><?php echo JText::_ ( 'COM_KUNENA_POST_TOPIC_HISTORY' )?>: <?php echo $this->escape($this->topic->subject) ?></span></h2>
		<div class="ktitle-desc km">
			<?php echo JText::_ ( 'COM_KUNENA_POST_TOPIC_HISTORY_MAX' ) . ' ' . $this->escape($this->config->historylimit) . ' ' . JText::_ ( 'COM_KUNENA_POST_TOPIC_HISTORY_LAST' )?>
		</div>
	</div>
	<div class="kcontainer" id="khistory">
		<div class="kbody">
			<?php foreach ( $this->history as $this->message ):?>
			<table class="myvckunenaa" style="margin-top:10px;">
				<thead>
					<?php /*?><tr class="ksth">
						<th colspan="2">
							<span class="kmsgdate khistory-msgdate" title="<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat_hover') ?>">
								<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat') ?>
							</span>
							<a id="<?php echo intval($this->message->id) ?>"></a>
							<?php echo $this->getNumLink($this->message->id,$this->replycount--) ?>
						</th>
					</tr><?php */?>
				</thead>
				<tbody>
					<tr>
					<?php 
	$user = JFactory::getUser($this->message->getAuthor()->userid);
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
	
						<td rowspan="2" valign="top" class="kprofile-left  kauthor" style="padding:10px; padding-left:0px; padding-right:0px; width:17%; min-width:0px; border-right:1px solid #E2E2E2; vertical-align:middle;">
							<?php //echo $this->message->getAuthor()->getLink() ?>
							<p><?php
								$profile = KunenaFactory::getUser(intval($this->message->userid));
								$useravatar = $profile->getAvatarImage('','','profile');
								/*if ($useravatar) :
									echo $this->message->getAuthor()->getLink( $useravatar );
								endif;*/
								if($user->user_type == '11'){ ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<?php } else { ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } 
							?></p>
							<p style="height:10px;"></p>
	<p style="font-weight:bold;"><?php echo $replyname ; ?></p>
						</td>
						<td class="kmessage-left khistorymsg" style="width:83px;">
						<?php if($_REQUEST['id']){
		$db = & JFactory::getDBO();
		$getcname = "SELECT subject FROM `#__kunena_topics`  where id=".$_REQUEST['id']." ";
		$db->setQuery($getcname);
		$idname = $db->loadResult();
				}
				?>
				<?php /*?><span style="background:none; padding-left:19px; color:#7AB800" class="kmsgtitle kmsg-title-left"><?php echo $idname ; ?>
		</span><br /><?php */?>
						<span class="kmsgdate khistory-msgdate" title="<?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat_hover') ?>" style="padding-left:19px; padding-bottom:5px;">
								<strong><?php echo KunenaDate::getInstance($this->message->time)->toKunena('config_post_dateformat') ?></strong>
							</span>
							<div class="kmsgbody">
								<div class="kmsgtext">
									<?php echo KunenaHtmlParser::parseBBCode( $this->message->message, $this ) ?>
								</div>
							</div>
							<?php
							$this->attachments = $this->message->getAttachments();
							if (!empty($this->attachments)) : ?>
							<div class="kmsgattach">
								<?php echo JText::_('COM_KUNENA_ATTACHMENTS');?>
								<ul class="kfile-attach">
								<?php foreach($this->attachments as $attachment) : ?>
									<li style="background:none; padding-left:0px;">
										<?php echo $attachment->getThumbnailLink(); ?>
										
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>

			<?php endforeach; ?>
		</div>
	</div>
	<p style="height: 40px;"></p>
</div>
<br /><br />