<script type="text/javascript">
function getpopup(){
alert("Please sign in or create an account to join the discussion.");
}
</script>
<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Common
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();
?>
<div class="kblock kpbox">
	<div class="kcontainer" id="kprofilebox">
		<div class="kbody">
<table class="kprofilebox" style="display:none;">
	<tbody>
		<tr class="krow1">
			<td valign="top" class="kprofileboxcnt">
				<div class="k_guest">
					<?php echo JText::_('COM_KUNENA_PROFILEBOX_WELCOME'); ?>,
					<b><?php echo JText::_('COM_KUNENA_PROFILEBOX_GUEST'); ?></b>
				</div>
				<?php if ($this->login->enabled()) : ?>
				<form action="<?php echo KunenaRoute::_('index.php?option=com_kunena') ?>" method="post" name="login">
					<input type="hidden" name="view" value="user" />
					<input type="hidden" name="task" value="login" />
					[K=TOKEN]

					<div class="input">
						<span>
							<?php echo JText::_('COM_KUNENA_LOGIN_USERNAME') ?>
							<input type="text" name="username" class="inputbox ks" alt="username" size="18" />
						</span>
						<span>
							<?php echo JText::_('COM_KUNENA_LOGIN_PASSWORD'); ?>
							<input type="password" name="password" class="inputbox ks" size="18" alt="password" /></span>
						<span>
							<?php if($this->remember) : ?>
							<?php echo JText::_('COM_KUNENA_LOGIN_REMEMBER_ME'); ?>
							<input type="checkbox" name="remember" alt="" value="1" />
							<?php endif; ?>
							<input type="submit" name="submit" class="kbutton" value="<?php echo JText::_('COM_KUNENA_PROFILEBOX_LOGIN'); ?>" />
						</span>
					</div>
					<div class="klink-block">
						<span class="kprofilebox-pass">
							<a href="<?php echo $this->lostPasswordUrl ?>" rel="nofollow"><?php echo JText::_('COM_KUNENA_PROFILEBOX_FORGOT_PASSWORD') ?></a>
						</span>
						<span class="kprofilebox-user">
							<a href="<?php echo $this->lostUsernameUrl ?>" rel="nofollow"><?php echo JText::_('COM_KUNENA_PROFILEBOX_FORGOT_USERNAME') ?></a>
						</span>
						<?php
						if ($this->registerUrl) : ?>
						<span class="kprofilebox-register">
							<a href="<?php echo $this->registerUrl ?>" rel="nofollow"><?php echo JText::_('COM_KUNENA_PROFILEBOX_CREATE_ACCOUNT') ?></a>
						</span>
						<?php endif; ?>
					</div>
				</form>
				<?php endif; ?>
			</td>
			<!-- Module position -->
			<?php if ($this->moduleHtml) : ?>
			<td class = "kprofilebox-right">
				<div class="kprofilebox-modul">
					<?php echo $this->moduleHtml; ?>
				</div>
			</td>
			<?php endif; ?>
		</tr>
	</tbody>
</table>
<?php
if($_REQUEST['id'] && $_REQUEST['layout'] != 'reply' ){
?>
<div class="kmsg-header kmsg-header-left" style="border-bottom:0px; margin-top:1px; border-right:none">
	<h2 style="background:#fff;">
		<span style="background:none; padding-left:0px;" class="kmsgtitle kmsg-title-left">
		</span>
		<span class="kmsg-id-left">
			<a style="color:#636363 !important; line-height:23px;" class="newtopic" href="index.php?option=com_kunena&view=category&catid=2&Itemid=233">MAIN FORUM</a>
		</span>
		<span class="kmsg-id-left" style="background: url('/dev/templates/camassistant_left/images/list-bg-news.gif') no-repeat scroll right center transparent; padding-right:10px; margin-bottom:0px; line-height:22px;">
			<a style="color:#636363 !important; " class="newtopic" onclick="getpopup();" href="#">REPLY </a>
		</span>
	</h2>
</div>
<?php } ?>
<?php
	$db = & JFactory::getDBO();
	if($_REQUEST['id'] || $_REQUEST['layout'] == 'reply'){
	$topicdata ="select first_post_message, subject, first_post_time, first_post_userid from #__kunena_topics where id =".$_REQUEST['id'];
	$db->setQuery($topicdata);
	$deta = $db->loadObject();
	?>
	<?php 
				
	$user = JFactory::getUser($deta->first_post_userid);
	$db = & JFactory::getDBO();
	if($user->user_type == '11'){
	$getvendorimage = "SELECT image,company_name FROM `#__cam_vendor_company`  where user_id=".$deta->first_post_userid." ";
	$db->setQuery($getvendorimage);
	$cdeta = $db->loadObject();
	$path1 = $cdeta->image ;
	$name = $cdeta->company_name ;
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
	$name = $user->name . ' ' . $user->lastname ;
	$getfirmimage = "SELECT comp_logopath FROM `#__cam_customer_companyinfo`  where cust_id=".$deta->first_post_userid." ";
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
	$name = $user->name . ' ' . $user->lastname ;
	$getcid = "SELECT comp_id FROM `#__cam_customer_companyinfo`  where cust_id=".$deta->first_post_userid." ";
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
<table style="border:1px solid #E2E2E2; margin-top:-1px;">
<tbody>
<tr>
<td valign="top" style="padding:10px; padding-left:0px; padding-right:0px; width:17%; min-width:0px; border:1px solid #E2E2E2; background:#fff" class="kprofile-left  kauthor" rowspan="2">
<p style="margin-left:0px; text-align:center">
<?php if($user->user_type == '11'){ ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<?php } else { ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } ?>
</p>
<p style="height:10px;"></p>
<p style="font-weight:bold; text-align:center;"><?php echo $name; ?></p>
</td>
<td style="width:83px;background:#fff;" class="kmessage-left khistorymsg">
<span class="kmsgtitle kmsg-title-left" style="background:none; padding-left:20px; color:#7AB800"><?php echo $deta->subject; ?>		</span><br>
<span style="padding-left:20px; padding-bottom:5px;" title="13 Nov 2013 03:22" class="kmsgdate khistory-msgdate">
<strong><?php echo KunenaDate::getInstance($deta->first_post_time)->toKunena('config_post_dateformat') ?></strong>
</span>
<div class="kmsgbody">
<div class="kmsgtext" style="padding-left:20px;">
<?php echo $deta->first_post_message; ?>							</div>
</div>
<p style="height:54px;"></p>
</td>
</tr>
</tbody>
</table>
<p style="border-bottom:1px solid #E2E2E2; margin-top:-1px;"></p>
<p style="height:15px; background:#fff;"></p>
<?php } else { ?>
<table class="kprofilebox">
<tr>
<td class="kprofileboxcnt" style="padding-left:0px; background-color:#fff; padding-bottom:0px; padding-top:0px; vertical-align:top;">
				<ul class="kprofilebox-welcome" style="margin-top:1px; margin-bottom:0px;">
					<li style="font-size:20px; padding-bottom:0px; padding-top:0px; font-size: 25px;font-weight: bold;">
					<header><p style="padding-top:2px;">MyVendorCenter Forum</p></header>
					<p style="font-size:12px; margin-top:7px;">All posts are subject to review and may be removed for inappropriate content or spam</p>
					<p style="height:20px;"></p>
				</ul>
				
			</td>
</tr>
</table>
<?php } ?>
		</div>
	</div>
</div>
