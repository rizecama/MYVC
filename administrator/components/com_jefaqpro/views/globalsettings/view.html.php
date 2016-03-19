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

jimport( 'joomla.application.component.view' );
jimport('joomla.utilities.date');

class  jefaqViewGlobalsettings  extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		$model             = & $this->getModel();

		// Tool Bar..
		JToolBarHelper::title(   JText::_( 'JE_FAQ' ) . ' - ' .  JText::_( 'JE_FAQ_SETTINGS' ), 'faq.png' );
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::custom('help_faq','help', '',JText::_( 'JE_HELP' ), false);

		// Get global settings..
		$globalconfig 		= $model->globalConfig();
		$themes		 		= $model->getThemes();

		$group = array(
			JHTML::_('select.option',  'ordering', JText::_( 'JE_ORDERBY_ORDERING' )),
			JHTML::_('select.option',  'id', JText::_( 'JE_ORDERBY_ID' )),
			JHTML::_('select.option',  'questions', JText::_( 'JE_ORDERBY_QUESTIONS' ) ),
		);

		$sort = array(
			JHTML::_('select.option',  'desc', JText::_( 'JE_SORT_DESCENDING' )),
			JHTML::_('select.option',  'asc', JText::_( 'JE_ASCENDING' )),
		);

		$this->assignRef('group',	$group);
		$this->assignRef('sorting',	$sort);

		$this->assignRef( 'items', 		 $globalconfig );
		$this->assignRef( 'themes', 	 $themes );

		parent::display($tpl);
	}
}
