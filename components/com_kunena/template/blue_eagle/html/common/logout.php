<?php
$layout = JRequest::getVar('layout','');
?>
<script type="text/javascript">
function geterrorpopup(){
alert("Please choose your membership to SUBSCRIBE today to join the discussion.");
//document.location.href = 'index.php?option=com_camassistant&controller=vendors&task=subscriptions&Itemid=213';
}
L = jQuery.noConflict();
L(document).ready(function(){
	L('.forumtype').change(function(){
		drop = L('.forumtype').val();
		href = 'index.php?option=com_kunena&view=topic&layout=create&catid=2&Itemid=223';
		L('.newtopic').attr('href',href+'&type='+drop) ;
		newhref = 'index.php?option=com_kunena&view=category&catid=2&Itemid=232&type='+drop ;
		<?php if($layout != 'create'){ ?>
		window.location.href = newhref ;
		<?php } else { ?>
		L('.forum_type').val(drop);
		<?php }?>
	});
});
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
$type = JRequest::getVar('type','');
?>
<div class="kblock kpbox">
	<div class="kcontainer" id="kprofilebox">
		<div class="kbody" style="border:none; background:none;">
		<?php
		if($_REQUEST['id'] || $_REQUEST['layout']=='reply'){
		$display = 'none';  }

		?>				
<table class="kprofilebox" style="display:<?php //echo $display; ?>">
	<tbody>
		<tr class="krow1">
			<?php if ($this->me->getAvatarImage('welcome')) : ?>
			<td class="kprofilebox-left" style="background:#fff; border-right:1.5px solid gray; margin-right:10px; padding-top:0px; padding-bottom:0px; height:89px; width:17%">
				<?php 
				
	$user = JFactory::getUser();
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
	else if($user->user_type == '16'){
	$getfirmimage = "SELECT propertyowner_image FROM `#__cam_propertyowner_image`  where user_id=".$user->id." ";
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
	$thumb_width =90;
	$thumb_height = round($thumb_width * $aspect_ratio) ;
	if($thumb_height == 0){
	$thumb_height = '93';
	}		
	$path1 = str_replace('&','_',$path1);
	?>
	<?php if($user->user_type == '11'){ ?>
	<img style="margin-left:25px;" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<?php } else { ?>
	<img style="margin-left:25px;" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } ?>
	<?php 
	
	
				//echo $this->me->getAvatarImage('kavatar', 'welcome'); ?>
			</td>
			<?php endif; ?>
			<td class="kprofileboxcnt" style="padding-left:0px; background-color:#fff; padding-bottom:0px; padding-top:0px; vertical-align:top;">
				<ul class="kprofilebox-link">
					<?php if (!empty($this->privateMessagesLink)) : ?><li><?php echo $this->privateMessagesLink ?></li><?php endif ?>
					<?php if (!empty($this->editProfileLink)) : ?><li><?php echo $this->editProfileLink ?></li><?php endif ?>
					<?php if (!empty($this->announcementsLink)) : ?><li><?php echo $this->announcementsLink ?></li><?php endif ?>
				</ul>
			<?php
			$user = JFactory::getUser();
			if($user->user_type == '11'){
			$getcname = "SELECT company_name FROM `#__cam_vendor_company`  where user_id=".$user->id." ";
			$db->setQuery($getcname);
			$companyname = $db->loadResult();
			$subscribe = $user->subscribe ;
			}
			else{
			$companyname = $user->name . ' ' . $user->lastname ;
			}
			?>	
				<?php
				if($_REQUEST['id']){
				$disp = "none";
				}
				if($_REQUEST['layout'] == 'create'){
				$disp = "none";				
				}
				
				?>
				<?php
			if($user->user_type != '11'){
				$sql = "SELECT comp_name from #__cam_customer_companyinfo where cust_id=".$user->id." ";
				$db->Setquery($sql);
				$cnamem = $db->loadResult();
			}
			else{
				$cnamem = 'Personal';			
			}
			?>	
			
				<ul class="kprofilebox-welcome" style="margin-top:1px; margin-bottom:0px; display:<?php //echo $disp; ?>">
					<li style="font-size:20px; padding-bottom:0px; padding-top:0px; font-size: 25px;font-weight: bold;">
					<header>
					<?php if($user->user_type != '11'){ ?>
					<p style="font-size:14px; padding-bottom:6px;">Please choose a forum</p>
					<p style="padding-top:2px;">
				<?php
					if($user->user_type == '13' && $user->accounttype == 'master'){ 
						$sql = "SELECT firmid from #__cam_masteraccounts where masterid=".$user->id." ";
						$db->Setquery($sql);
						$companies = $db->loadObjectList();
							foreach($companies as $company){
								$list_companies[] = $company->firmid ;
							}
					$list_companies[] = $user->id;
					}
					else if($user->user_type == '13' && $user->accounttype != 'master'){
						$sql = "SELECT masterid from #__cam_masteraccounts where firmid=".$user->id." ";
						$db->Setquery($sql);
						$companies = $db->loadResult();
						if($companies)
						$list_companies[] = $companies;
						$list_companies[] = $user->id;
					}
					else if($user->user_type == '12'){
						$list_companies[] = $firm_id;
						$sql = "SELECT masterid from #__cam_masteraccounts where firmid=".$firm_id." ";
						$db->Setquery($sql);
						$companies = $db->loadResult();
						if($companies)
						$list_companies[] = $companies;
					}
					
					
				?>
				<?php
				$view = JRequest::getVar('view','');
				$tid = JRequest::getVar('id','');
				if($view == 'topic' && $tid){
						$sql_selected = "SELECT selectedid from #__kunena_topics where id = ".$tid." ";
						$db->Setquery($sql_selected);
						$type = $db->loadResult(); 
				}
				?>
					<select name="forumtype" class="forumtype">
					<option value="public">Public</option>
					<?php 
					for( $c=0; $c<count($list_companies); $c++ ){
						$sql = "SELECT comp_name from #__cam_customer_companyinfo where cust_id = ".$list_companies[$c]." ";
						$db->Setquery($sql);
						$cnames = $db->loadResult(); 
						if($type == $list_companies[$c])
						$selected = 'selected="selected"';
						else
						$selected = '';
						?>
						<option <?php echo $selected; ?> value="<?php echo $list_companies[$c]; ?>"><?php echo $cnames; ?></option>
					<?php }
					?>
					</select>
					</p>
				<?php  
				} else {
				  ?>	
				<p style="padding-top:2px;">MyVendorCenter Forum</p>
				<p style="font-size:12px; margin-top:7px;">All posts are subject to review and may be removed for inappropriate content or spam</p>
				<?php } ?>
					</header>
					
					<?php if ($this->logout->enabled()) : ?>
					<?php /*?><li>
					<form action="<?php echo KunenaRoute::_('index.php?option=com_kunena') ?>" method="post" name="login">
						<input type="hidden" name="view" value="user" />
						<input type="hidden" name="task" value="logout" />
						[K=TOKEN]

						<input type="submit" name="submit" class="kbutton" value="<?php echo JText::_('COM_KUNENA_PROFILEBOX_LOGOUT'); ?>" />
					</form>
					</li><?php */?>
					<?php endif; ?>
				</ul>
				
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
		$db = JFactory::getDBO();
		$id = JRequest::getVar('id','');
		$first_creator ="select first_post_userid from #__kunena_topics Where id =".$id;
		$db->setQuery($first_creator);
		$creatorid = $db->loadResult();
		if($creatorid){
		$user	= JFactory::getUser($creatorid);
		}
		else{
		
		}
		$creator_type = $user->user_type;
		$user	= JFactory::getUser();
		$user_type = $user->user_type; 
		//echo "CREATOR: ".$creator_type.'<br />';
		//echo "LOGGED IN: ".$user_type.'<br />';
		?>
<p style="height:10px; background-color:#fff;"></p>
<?php
if($_REQUEST['id'] && $_REQUEST['layout'] != 'reply' ){
?>
<div class="kmsg-header kmsg-header-left" style="border-bottom:0px; margin-top:1px; border-right:none">
	<h2 style="background:#fff;">
		<span style="background:none; padding-left:0px;" class="kmsgtitle kmsg-title-left">
		</span>
	<?php
	if( $_REQUEST['id'] ){
	$topicdata ="select selectedid from #__kunena_topics where id =".$_REQUEST['id'];
	$db->setQuery($topicdata);
	$topic_type = $db->loadResult();
	}
	?>
	<?php
	if( $_REQUEST['id'] ){ ?>
			<span class="kmsg-id-left" style="margin-top:-1px;">
<a style="color:#636363 !important; line-height:23px;" class="newtopic" href="index.php?option=com_kunena&view=category&catid=2&type=<?php echo $topic_type; ?>&Itemid=233">MAIN FORUM</a>
<?php } ?>
		</span>
		<?php if($creator_type == '11'){ 
			  if( $user_type == '13' || $user_type == '12' || $user->id == $creatorid ){ ?>
		<span class="kmsg-id-left" style="background: url('templates/camassistant_left/images/list-bg-news.gif') no-repeat scroll right center transparent; padding-right:10px; margin-bottom:8px; line-height:22px;">
		<?php if( $subscribe == 'yes' || $user_type == '13' || $user_type == '12' ){ ?>
			<a style="color:#636363 !important; " class="newtopic" href="index.php?option=com_kunena&view=topic&layout=reply&catid=2&id=<?php echo $id; ?>&Itemid=223">REPLY </a>
			<?php } else { ?>
			<a style="color:#636363 !important; " class="newtopic" href="#" onclick="geterrorpopup();">REPLY </a>
			<?php } ?>
		</span>
		
		<?php } 
		}
		 else{
				if( $user_type == '13' || $user_type == '12' || $user_type == '11' || $user->id == $creatorid ){  ?>
			<span class="kmsg-id-left" style="background: url('templates/camassistant_left/images/list-bg-news.gif') no-repeat scroll right center transparent; padding-right:10px; margin-bottom:8px; line-height:22px;">
			<?php if( $subscribe == 'yes' || $user_type == '13' || $user_type == '12' || $user_type == '16'  ){ ?>
			<a style="color:#636363 !important;" class="newtopic" href="index.php?option=com_kunena&view=topic&layout=reply&catid=2&id=<?php echo $id; ?>&Itemid=223">REPLY</a>
			<?php } else { ?>
			<a style="color:#636363 !important; " class="newtopic" href="#" onclick="geterrorpopup();">REPLY </a>
			<?php } ?>
			</span>
			
			<?php } 
			}
			?>
		
	</h2>
</div>
<?php } ?>
		</div>
		
<?php
	if($_REQUEST['id'] || $_REQUEST['layout'] == 'reply'){
	$topicdata ="select first_post_message, subject, first_post_time, first_post_userid from #__kunena_topics where id =".$_REQUEST['id'];
	$db->setQuery($topicdata);
	$deta = $db->loadObject();
	?>
	<?php 
	if($deta->first_post_userid){			
	$user = JFactory::getUser($deta->first_post_userid);
	}
	else{
	}
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
<?php } ?>
	</div>
</div>
