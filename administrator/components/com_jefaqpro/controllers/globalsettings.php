<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class jefaqControllerGlobalsettings extends JController
{
	function __construct( $config = array() )
	{
		parent::__construct( $config );
		$this->registerTask( 'apply', 'save' );
		$this->registerTask( 'help_faq',	'help' );
	}

	function display()
	{
		JRequest::setVar( 'view', 'globalsettings');
		parent::display();
	}

	function cancel()
	{
		$msg = JText::_( 'JE_MSG_CANCELED' );
		$this->setRedirect( 'index.php?option=com_jefaqpro&controller=globalsettings', $msg );
	}
	// save the subscriber
	function save()
	{
		$model = $this->getModel('globalsettings');

		if ($cid = $model->store())
		{
			$msg = JText::_( 'JE_ITEM_UPDATE_SUCCESS' );
		}
		else {
			$msg = JText::_( 'JE_ITEM_SAVE_FAILED' );
		}
		if($this->_task == 'apply')
		{
			$link 	= 'index.php?option=com_jefaqpro&controller=globalsettings';
		}
		else
		{
			$link = 'index.php?option=com_jefaqpro&controller=globalsettings';
		}
		$this->setRedirect($link, $msg);
	}

	function help()
	{
		$model = $this->getModel('globalsettings');
		$model->faqHelp();

		JRequest::setVar( 'view', 'globalsettings');
		parent::display();
	}

	function themes()
	{
		$model = $this->getModel('globalsettings');
		$model->getPreview();
	}
}
?>