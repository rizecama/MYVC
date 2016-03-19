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

class PhocaPDFCpControllerPhocaPlugin extends PhocaPDFCpController
{
	function __construct() {
		parent::__construct();

		$this->registerTask( 'apply'  , 'save' );
	}

	function save() {
	
		$cid 				= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$post				= JRequest::get('post');
		$post['id'] 		= (int) $cid[0];
		$post['message']	= JRequest::getVar( 'message', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$model = $this->getModel( 'phocaplugin' );

		$id	= $model->store($post);//you get id and you store the table data
		if ($id && $id > 0) {
			$msg = JText::_( 'Changes to Phoca PDF Plugin Saved' );
		} else {
			$msg = JText::_( 'Error Saving Phoca PDF Plugin' );
		}
		
		switch ( JRequest::getCmd('task') ) {
			case 'save':
			default:
				$link = 'index.php?option=com_phocapdf';
			break;
			
			case 'apply':
				$link = 'index.php?option=com_phocapdf&view=phocaplugins&cid[]='.(int)$id;
			break;
		}

		$this->setRedirect($link, $msg);
	}
}
?>
