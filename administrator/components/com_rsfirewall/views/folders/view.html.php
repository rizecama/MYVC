<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewFolders extends JView
{
	function display( $tpl = null )
	{
		$elements = $this->get('elements');
		$folders = $this->get('folders');
		$files = $this->get('files');
		
		$this->assignRef('files', $files);
		$this->assignRef('folders', $folders);
		$this->assignRef('elements', $elements);
		$this->assignRef('current_element',$current_element);
		
		$this->assign('function', JRequest::getVar('function'));
		
		parent::display($tpl);
	}
}