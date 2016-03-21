<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Category
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

// Disable caching
$this->cache = false;

// Show one topic row
?>
<?php if ($this->spacing) : ?>
<tr>
	<td class="kcontenttablespacer" colspan="<?php echo empty($this->topicActions) ? 5 : 6 ?>">&nbsp;</td>
</tr>
<?php endif; ?>

<?php
	$topic_type = $this->topic->type ;
	if($this->topic->first_post_userid){
	$user_c = JFactory::getUser($this->topic->first_post_userid);
	}
	else{
	}
	$creatorid_type = $user_c->user_type ;
	if($this->topic->selectedid){
	$user_seleted = JFactory::getUser($this->topic->selectedid);
	}
	else{
	}
	$db = & JFactory::getDBO();
	$type = JRequest::getVar('type','');

if( $topic_type == 'personal' && ($user_seleted->user_type == 13 || $user_seleted->user_type == 12) )
{	
	if($user_seleted->user_type ==13 && $user_seleted->accounttype == 'master') 
	{
		
		$sql1 = "SELECT firmid from #__cam_masteraccounts where masterid=".$this->topic->selectedid." ";
		$db->Setquery($sql1);
		$subfirms = $db->loadObjectlist();
		$subfirms[]->firmid = $this->topic->selectedid ;
		if($subfirms)
		{
			for( $a=0; $a<count($subfirms); $a++ )
				{
					$firmid1[] = $subfirms[$a]->firmid;
					$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$subfirms[$a]->firmid." ";
					$db->Setquery($sql);
					$companyid[] = $db->loadResult();
				}
        }
				
	}
	
	if($user_seleted->user_type == 13 && $user_seleted->accounttype != 'master') 
	{
			
			$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$this->topic->selectedid." ";
			$db->Setquery($sql);
			$companyid[] = $db->loadResult();
	}
		
	/*if($user_seleted == 12)
	{
		$sql = "SELECT comp_id from #__cam_customer_companyinfo where cust_id=".$this->topic->first_post_userid." ";
		$db->Setquery($sql);
		$compid = $db->loadResult();
		$sql = "SELECT cust_id from #__cam_camfirminfo where id=".$compid." ";
		$db->Setquery($sql);
		$camfirmid = $db->loadResult();	 //Camfirm ID
			$sql_g = "SELECT masterid from #__cam_masteraccounts where firmid=".$camfirmid." ";
			$db->Setquery($sql_g);
			$get_master = $db->loadResult(); // Master ID
			if($get_master)
			{
				$sql1 = "SELECT firmid from #__cam_masteraccounts where masterid=".$get_master." ";
				$db->Setquery($sql1);
				$subfirms = $db->loadObjectlist();
				$subfirms[]->firmid = $get_master ;
				if($subfirms)
					{
						for( $a=0; $a<count($subfirms); $a++ )
							{
								$firmid1[] = $subfirms[$a]->firmid;
								$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$subfirms[$a]->firmid." ";
								$db->Setquery($sql);
								$companyid[] = $db->loadResult();
							}
					}
		
			}	
			
			else
			{
				$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$camfirmid." ";
				$db->Setquery($sql);
				$companyid[] = $db->loadResult();
			}
			
			
	}	*/
	
	
	// Get logged in user company name
	$user_log = JFactory::getUser();
	if($user_log->user_type != 11){
		if($user_log->user_type == 13){
		$sql = "SELECT id from #__cam_camfirminfo where cust_id=".$user_log->id." ";
		$db->Setquery($sql);
		$log_companyid = $db->loadResult();	
		}
		if($user_log->user_type == 12){
		$sql = "SELECT comp_id from #__cam_customer_companyinfo where cust_id=".$user_log->id." ";
		$db->Setquery($sql);
		$log_companyid = $db->loadResult();	
		}
		
		if(in_array($log_companyid,$companyid)){
			if( !$type || $type == 'public' ){
				$display = 'none';
			}
			else {
				$display = '';
			}
		}
		else
		{
			$display = 'none';
		}
	}	
}
	
	if($user_log->user_type != 11){
		if($type && $type != 'public') {
			if( $type == $this->topic->selectedid )
			$display = '';
			else
			$display = 'none';
		}
	}
	else {
		if( $topic_type == 'personal') {
			$display = 'none';
		}
		
	}
?>
<?php /*?><tr class="<?php echo $this->getTopicClass('k', 'row') ?>" style="height:100px; display:<?php echo $display; ?>"><?php */?>
<tr class="<?php echo $this->topic->selectedid; ?>" style="height:100px; display:<?php echo $display; ?>">
	<td class="kcol-first kcol-ktopicreplies" style="width:17%; border-right:1px solid #E2E2E2; border-bottom:none;">
		<?php /*?><strong><?php echo $this->formatLargeNumber ( max(0,$this->topic->getTotal()-1) ); ?></strong> <?php echo JText::_('COM_KUNENA_GEN_REPLIES') ?><?php */?>
		<?php 
		if($this->topic->first_post_userid){
		$user = JFactory::getUser($this->topic->first_post_userid);
		}
		else{
		}
		$type = $user->user_type;
			$db = & JFactory::getDBO();
	if($type == '11'){
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
	else if($type == '13'){
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
	else if($type == '16'){
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
	$thumb_width =80;
	$thumb_height = round($thumb_width * $aspect_ratio) ;
	if($thumb_height == 0){
	$thumb_height = '83';
	}		
	$path1 = str_replace('&','_',$path1);
	?>
	<?php if($user->user_type == '11'){ ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/vendors/<?php echo $path1; ?>" />
	<?php } else { ?>
	<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="components/com_camassistant/assets/images/properymanager/<?php echo $path1; ?>" />
	<?php } ?>
		
	</td>

	<td class="kcol-mid kcol-ktopicicon">
		<?php echo $this->getTopicLink ( $this->topic, 'unread', $this->topic->getIcon() ) ?>
	</td>

	<td class="kcol-mid kcol-ktopictitle" style="border:none;">
    <div class="ktopic-details">
		<?php if ($this->topic->attachments) echo $this->getIcon ( 'ktopicattach', JText::_('COM_KUNENA_ATTACH') ); ?>
		<?php if ($this->topic->poll_id) echo $this->getIcon ( 'ktopicpoll', JText::_('COM_KUNENA_ADMIN_POLLS') ); ?>

		<div class="ktopic-title-cover">
			<?php
			//echo $this->topic;
			echo $this->getTopicLink ( $this->topic, null, null, KunenaHtmlParser::stripBBCode ( $this->topic->first_post_message, 500), 'ktopic-title km' );
			if ($this->topic->getUserTopic()->favorite) {
				echo $this->getIcon ( 'kfavoritestar', JText::_('COM_KUNENA_FAVORITE') );
			}
			if ($this->me->exists() && $this->topic->getUserTopic()->posts) {
				echo $this->getIcon ( 'ktopicmy', JText::_('COM_KUNENA_MYPOSTS') );
			}
			if ($this->topic->unread) {
				echo $this->getTopicLink ( $this->topic, 'unread', '<sup dir="ltr" class="knewchar">(' . $this->topic->unread . ' ' . JText::_('COM_KUNENA_A_GEN_NEWCHAR') . ')</sup>' );
			}
			?>
		</div>
        <div class="ktopic-details-kcategory">
			<?php if (!isset($this->category) || $this->category->id != $this->topic->getCategory()->id) : ?>
			<span class="ktopic-category"> <?php echo JText::sprintf('COM_KUNENA_CATEGORY_X', $this->getCategoryLink ( $this->topic->getCategory() ) ) ?></span>
			<?php endif; ?>
        </div>
         <div class="ktopic-details-kcategory">
			<span class="ktopic-posted-time" title="<?php echo KunenaDate::getInstance($this->topic->first_post_time)->toKunena('config_post_dateformat_hover'); ?>">
				<?php echo JText::_('COM_KUNENA_TOPIC_STARTED_ON') . ' ' . KunenaDate::getInstance($this->topic->first_post_time)->toKunena('config_post_dateformat');?>
			</span>
			<?php 
//			echo "<pre>"; print_r($this->topic);
			if($this->topic->first_post_userid){
			$user = JFactory::getUser($this->topic->first_post_userid);
			}
			else{
			}
			?>
			<span class="ktopic-by ks"><?php echo JText::_('COM_KUNENA_BY') . ' ' ; ?> <strong><?php echo  $user->name. ' ' . $user->lastname ; ?></strong></span>
			<br /><p style="height:10px;"><?php //echo nl2br($this->topic->first_post_message); ?>
			<?php
			$strlen = strlen($this->topic->first_post_message) ;
		  if($strlen > 200){
		$result = substr($this->topic->first_post_message, 0, 200);
		$topic =  $result.'...' ;
		}
		else{
		$topic = $this->topic->first_post_message ;
		}
		?>
		
			<p><?php echo KunenaHtmlParser::parseBBCode ($topic, $this) ?></p>
		  </div>
		  

        <div class="ktopic-details-kcategory" style="clear:both;">
		<?php if ($this->pages > 1) : ?>
		<ul class="kpagination">
			<li class="page"><?php echo JText::_('COM_KUNENA_PAGE') ?></li>
			<li><?php echo $this->GetTopicLink ( $this->topic, 0, 1 ) ?></li>
			<?php if ($this->pages > 4) : $startPage = $this->pages - 3; ?>
			<li class="more">...</li>
			<?php else: $startPage = 1; endif;
			for($hopPage = $startPage; $hopPage < $this->pages; $hopPage ++) : ?>
			<li><?php echo $this->getTopicLink ( $this->topic, $hopPage, $hopPage+1 ) ?></li>
			<?php endfor; ?>
		</ul>
		<?php endif; ?>
		</div>

		<?php if (!empty($this->keywords)) : ?>
		<div class="ktopic-keywords">
			<?php echo JText::sprintf('COM_KUNENA_TOPIC_TAGS', $this->escape($this->keywords)) ?>
		</div>
		<?php endif; ?>
	  </div>
	</td>

	<td class="kcol-mid kcol-ktopicviews visible-desktop" style="border:none;">
	<div class="kuneaviews_myvc">
		<span class="ktopic-views-number"><?php echo $this->formatLargeNumber ( $this->topic->hits );?></span>
		<span class="ktopic-views"> <?php echo JText::_('COM_KUNENA_GEN_HITS');?> </span>
		</div>
	</td>

	

<?php if (!empty($this->topicActions)) : ?>
	<td class="kcol-mid ktopicmoderation"><input class ="kcheck" type="checkbox" name="topics[<?php echo $this->topic->id?>]" value="1" /></td>
<?php endif; ?>
</tr>

<?php
if($display == 'none'){
		
}
else{
echo "<tr height='20'></tr>";
}
$display = '';
//$display = '';
//	$topic_type = $this->topic->type ;
//	if($topic_type == 'personal'){
//	}
//	else
//	echo "<tr height='20'></tr>";
	
?>

<!-- Module position -->
<?php if ($this->module) : ?>
<tr>
	<td class="ktopicmodule" colspan="<?php echo empty($this->topicActions) ? 5 : 6 ?>"><?php echo $this->module; ?></td>
</tr>
<?php endif; ?>


<div class="ktopic-details-kcategory" style="clear:both;">
		<?php if ($this->topic->posts > $this->config->messages_per_page) : ?>
		<ul class="kpagination">
			<li class="page"><?php echo JText::_('COM_KUNENA_PAGE') ?></li>
			<li><?php echo $this->GetTopicLink ( $this->topic, 0, 1 ) ?></li>
			<?php if ($this->pages > 4) : $startPage = $this->pages - 3; ?>
			<li class="more">...</li>
			<?php else: $startPage = 1; endif;
			for($hopPage = $startPage; $hopPage < $this->pages; $hopPage ++) : ?>
			<li><?php echo $this->getTopicLink ( $this->topic, $hopPage, $hopPage+1 ) ?></li>
			<?php endfor; ?>
		</ul>
		<?php endif; ?>
		</div>
		
