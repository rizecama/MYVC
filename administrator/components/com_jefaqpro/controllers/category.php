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

class jefaqControllerCategory extends JController
{
	function __construct( $config = array() )
	{
		parent::__construct( $config );
		$this->registerTask( 'add',	        'edit' );
		$this->registerTask( 'new',	        'edit' );
		$this->registerTask( 'apply',       'save' );
		$this->registerTask( 'unpublish',	'publish' );
		$this->registerTask( 'help_faq',	'help' );
	}

	function display()
	{
		JRequest::setVar( 'view', 'category');
		parent::display();
	}

	function edit()
	{
		JRequest::setVar( 'view',        'category');
		JRequest::setVar( 'layout',      'form'  );
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
	}

	function cancel()
	{
		$msg = JText::_( 'JE_MSG_CANCELED' );
		$this->setRedirect( 'index.php?option=com_jefaqpro&controller=category', $msg );
	}

	// save the faq categories
	function save()
	{
		$model = $this->getModel('category');

		if ($cid = $model->store())	{
			$msg = JText::_( 'JE_ITEM_SAVE_SUCCESS' );
		} else {
			$msg = JText::_( 'JE_ITEM_SAVE_FAILED' );
		}

		if($this->_task == 'apply')	{
			$link 	= 'index.php?option=com_jefaqpro&controller=category&task=edit&cid[]='. $cid;
		} else {
			$link = 'index.php?option=com_jefaqpro&controller=category';
		}
		$this->setRedirect($link, $msg);
	}
	// delete a categories
	function remove()
	{
		$model = $this->getModel('category');

		$this->setRedirect( 'index.php?option=com_jefaqpro&controller=category');

		if($model->remove()) {
			$msg = JText::_( 'JE_ITEM_DELETE_SUCCESS' );
		} else {
			return JError::raiseWarning( 500, JText::_( 'JE_ITEM_DELETE_FAILURE' ));
		}

		$this->setRedirect( 'index.php?option=com_jefaqpro&controller=category', $msg );
	}

	function publish()
	{
		$model = $this->getModel('category');

		$result = $model->publish();

		$this->setRedirect( 'index.php?option=com_jefaqpro&controller=category');

		if($result ==  1) {
			$msg = JText::_( 'JE_ITEM_PUBLSIH_SUCCESS' );
		} else if ($result == -1) {
			return JError::raiseWarning( 500, JText::_( 'JE_ITEM_PUBLSIH_FAILURE' ));
		} else if($result ==  2) {
			$msg = JText::_( 'JE_ITEM_UNPUBLSIH_SUCCESS' );
		} else if ($result == -2) {
			return JError::raiseWarning( 500, JText::_( 'JE_ITEM_UNPUBLSIH_FAILURE' ));
		} else if ($result == 0) {
			return JError::raiseNotice( 500, JText::_( 'JE_NO_ITEM_SELECTED' ));
		}
		$this->setRedirect( 'index.php?option=com_jefaqpro&controller=category', $msg);
	}

	// ordering up and down..
	function orderup()
	{
		$model = $this->getModel('category');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_jefaqpro&controller=category');
	}

	function orderdown()
	{
		$model = $this->getModel('category');
		$model->move(1);
		$this->setRedirect('index.php?option=com_jefaqpro&controller=category' );
	}
	// ordering up and down end..

	// Save ordering..
	function saveorder()
	{
		$model = $this->getModel('category');
		if ($model->saveorder())
		{
			$msg = JText::_( 'JE_NEW_ORDERING' );
		}

		$link = 'index.php?option=com_jefaqpro&controller=category';
		$this->setRedirect($link, $msg);
	}
	// Save ordering end..

	function help()
	{
		$model = $this->getModel('category');

		$model->faqHelp();

		JRequest::setVar( 'view',        'category');
		parent::display();
	}
}
?>