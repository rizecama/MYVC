<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport('joomla.client.helper');

class PhocaPDFCpControllerPhocaFont extends PhocaPDFCpController
{
	function __construct() {
		parent::__construct();
	
		$this->registerTask( 'install'  , 'install' );
	}
	
	function remove() {
		global $mainframe;

		$cid 	= JRequest::getVar( 'cid', array(), '', 'array' );// POST (Icon), GET (Small Icon)
		
		JArrayHelper::toInteger($cid);
	
		if (count($cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		
		$model 		= $this->getModel( 'phocafonts' );
		$errorMsg	= $model->delete($cid);
 		if($errorMsg != '') {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca PDF Font' ) . '<br />' . $errorMsg;
		}
		else {
			$msg = JText::_( 'Phoca PDF Font Deleted' );
		}

		$link = 'index.php?option=com_phocapdf&view=phocafonts';
		$this->setRedirect( $link, $msg );
	}
	
	function install() {
		// Check for request forgeries
		JRequest::checkToken() or die( 'Invalid Token' );
		$post = JRequest::get('post');
		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
		$model	= &$this->getModel( 'phocafonts' );

		if ($model->install()) {
			$cache = &JFactory::getCache('mod_menu');
			$cache->clean();
			$msg = JText::_('New Font Installed');
		}
		
		$this->setRedirect( 'index.php?option=com_phocapdf&view=phocafonts', $msg );
	}
}
?>
