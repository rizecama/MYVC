<?php
/**
 * jeFAQ pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$cparams = & JComponentHelper::getParams('com_media');
$tempid	  	=  $this->settings->themes ;
$template 	= 'mymenu'.$tempid ;
?>

<div class="componentheading">
	<?php
		if($this->params->get('show_page_title', 1)) {
			//echo $this->params->get('page_title');
		} else {
			//echo JText::_( 'JE_FAQ_DETAILS' );
		}
	?>
</div>
<div id="contentarea" style="text-align : justify;">

<form action="<?php echo $this->action; ?>" method="post" name="adminForm">
	<table width="100%" align="center" cellpadding="2" class="contentpane<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" >
	<?php
	if ( count( $this->items ) >0 ) {
		$itemid   = &JRequest::getVar('Itemid');
		for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
			$row  = &$this->items[$i];
//echo $row->id;
if($row->id == 1){
$itemid = '146';
}
elseif($row->id == 2){
$itemid = '147';
}
else{
$itemid = $itemid;
}
			$link = JRoute::_('index.php?option=com_jefaqpro&view=category&layout=categorylist&task=lists&catid='.$row->id.'&Itemid='.$itemid);
			?>
				<tr class="contentdescription<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
					<td >
						<div id="je-categorylisting<?php echo $tempid ?>" >

						 	<?php
						 	if ( $this->settings->show_image == '1' ) {
						 		 if ($row->image) {
						 		 	// Category Image.
						 	?>
		 		 		 		 	<a href="<?php echo $link;  ?>" title="<?php echo $row->category; ?>" > <img width="<?php echo $this->settings->image_width; ?>" height="<?php echo $this->settings->image_height; ?>" src="<?php echo $this->baseurl . '/' . $cparams->get('image_path') . '/jefaqcategory/'. $row->image;?>" align="<?php echo $row->image_position;?>" hspace="6" alt="<?php echo $row->image;?>" title="<?php echo $row->category; ?>" /></a>
						 	 <?php
						 		 } else {
						 		 	// Default Image.
							?>
									<a href="<?php echo $link;  ?>" title="<?php echo $row->category; ?>" > <img width="<?php echo $this->settings->image_width; ?>" height="<?php echo $this->settings->image_height; ?>" src="<?php echo $this->baseurl . '/' . 'components' . '/'  . 'com_jefaqpro' . '/' . 'assets' . '/' . 'images' . '/' . 'faq-icon.png' ;?>" align="<?php echo $row->image_position;?>" hspace="6" title="<?php echo $row->category; ?>" alt="<?php echo $row->image;?>" /> </a>
							<?php
						 		 }
						 	}
								 // Category listing.
							 	 echo '<span id="je-category" > <a href="'.$link.'" title="'.$row->category.'" >' . $row->category . '</a> </span>';

								 // Check whether the intro text option is enbaled or not.
								 if ( $this->settings->introtext == '1' ) {
							?>
									<!--<div id="je-introtext"  style="text-align : justify;" >
										<?php echo $row->introtext ; ?>
									</div>-->
							<?php } ?>
							<div class="clr"></div>

						</div>
				 	</td>
				 </tr>
			<?php
		}
	} else {
		echo '<div id="je-nofaqs" style="text-align : center;">'.JText::_('JE_NOCATEGORY').'</div>';
	}
	?>
	</table>

	<!-- Pagination code start -->
	<div id="je-pagination">
		 <?php echo $this->pageNav->getListFooter(); ?>
	</div>
	<!-- Pagination code End -->

	 <input type="hidden" name="option" value="com_jefaqpro" />
	 <input type="hidden" name="boxchecked" value="0" />
	 <input type="hidden" name="limitstart" value="0" />

</form>

</div>

<br style="clear : both"/>

<?php if ( $this->settings->footer_text == '1' ) : ?>
	<p class="copyright" style="text-align : right; font-size : 10px;">
		<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
	</p>
<?php endif; ?>