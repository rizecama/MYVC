<?php defined('_JEXEC') or die('Restricted access'); 


echo '<div id="phocapdf-pane">';
$pane =& JPane::getInstance('Tabs', array('startOffset'=> 0));
echo $pane->startPane( 'pane' );

// - - - - - - - - - - - - - - - 
// Site
echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocapdf/assets/images/icon-16-site.png','', '', '', '', '') . '&nbsp;'.JText::_('Site'), 'site' );
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
if($output = PhocaPDFHelperParams::renderSite($this->params, 'params', 'phocasite')) {
	echo $output;
} else {
	echo '<div style="text-align: center; padding: 5px;">'.JText::_('There are no parameters for this item').'</div>';
}
echo $pane->endPanel();
// - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - 
// Header
echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocapdf/assets/images/icon-16-header.png','', '', '', '', '') . '&nbsp;'.JText::_('Header'), 'header' );
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
if($output = PhocaPDFHelperParams::renderMisc($this->params, 'params', 'phocaheader')) {
	echo $output;
} else {
	echo '<div style="text-align: center; padding: 5px; ">'.JText::_('There are no parameters for this item').'</div>';
}
echo $pane->endPanel();
// - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - 
// Footer
echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocapdf/assets/images/icon-16-footer.png','', '', '', '', '') . '&nbsp;'.JText::_('Footer'), 'footer' );
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
if($output = PhocaPDFHelperParams::renderMisc($this->params, 'params', 'phocafooter')) {
	echo $output;
} else {
	echo '<div style="text-align: center; padding: 5px; ">'.JText::_('There are no parameters for this item').'</div>';
}
echo $pane->endPanel();
// - - - - - - - - - - - - - - -

// - - - - - - - - - - - - - - - 
// PDF
echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocapdf/assets/images/icon-16-pdf.png','', '', '', '', '') . '&nbsp;'.JText::_('PDF'), 'pdf' );
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
if($output = PhocaPDFHelperParams::renderMisc($this->params, 'params', 'phocapdf')) {
	echo $output;
} else {
	echo '<div style="text-align: center; padding: 5px;">'.JText::_('There are no parameters for this item').'</div>';
}
echo $pane->endPanel();
// - - - - - - - - - - - - - - -

echo $pane->endPane();
echo '</div>';

echo '<div id="phocapdf-apply"><a href="#" onclick="javascript: submitbutton(\'apply\')">'.JText::_('Save').'</a></div>';
	
echo '<div style="margin-top:20px">';	
if (isset($this->tmpl['plugin']->published)) {
	if ($this->tmpl['plugin']->published == 1) {
		echo JHTML::_('image.site',  'icon-16-true.png', '/components/com_phocapdf/assets/images/', NULL, NULL, '' )
		.' ' . JText::_('Plugin is enabled in Plugin Manager');
	} else {
		echo JHTML::_('image.site',  'icon-16-false.png', '/components/com_phocapdf/assets/images/', NULL, NULL, '' )
		.' '. JText::_('Plugin is disabled in Plugin Manager');
	}
	
}

echo '<br />' .JHTML::_('image.site',  'icon-16-warning.png', '/components/com_phocapdf/assets/images/', NULL, NULL, '' )
.' '. JText::_('Phoca PDF Settings Warning');

echo '<div>';
echo '<div style="clear:both"></div>';