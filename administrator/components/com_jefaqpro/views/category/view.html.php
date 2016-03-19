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

class  jefaqViewCategory  extends JView
{
	function display($tpl = null)
	{

		if($this->_layout == 'form') {

			$this->_defaultForm( $tpl );
			return;

		} else {

			$this->_listCategory( $tpl );
			return;
		}

	}

	function _defaultForm( $tpl )
	{

		$faqCategory  = & $this->get('Data');

		$model 		  = & $this->getModel();
		$ordering 	  = $model->getOrdering();

		// Toolbar.
		$text 		  = $faqCategory->id ? JText::_( 'JE_FAQ_EDIT' ) : JText::_( 'JE_FAQ_NEW' );
		JToolBarHelper::title(   JText::_( 'JE_FAQ' ). ' - ' . JText::_( 'JE_FAQ_COM_CATEGORY' ) . ': <small><small>[ ' . $text.' ]</small></small>' ,'faq.png');
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($faqCategory->id)	{
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else	{
			JToolBarHelper::cancel();
		}

		// build the select list for the image positions
		$active					    =  ( $faqCategory->image_position ? $faqCategory->image_position : 'left' );
		$lists['image_position'] 	= JHTML::_('list.positions',  'image_position', $active, NULL, 0, 0 );
		// Imagelist
		$lists['image'] 			= JHTML::_('list.images',  'image', $faqCategory->image );
		$lists['ordering']			= $ordering;

		// Assing the values
		$this->assignRef('lists',	    $lists);
		$this->assignRef('row',	        $faqCategory);

		parent::display( $tpl );

	}

	function _listCategory( $tpl )
	{

		global $mainframe;

		$model = & $this->getModel();
		$db    = & JFactory::getDBO();

		JToolBarHelper::title(   JText::_( 'JE_FAQ' ) . ' - ' .  JText::_( 'JE_FAQ_COM_CATEGORY' ), 'faq.png' );
		JToolBarHelper::publish();
		JToolBarHelper::unpublish();
		JToolBarHelper::deleteListX(JText::_( 'JE_WARN_DELETE' ));
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::custom('help_faq','help', '',JText::_( 'JE_HELP' ), false);

		$context			= 'com_jefaqpro';

		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		's.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',			'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( $context.'filter_state',		'filter_state',		'',			'word' );
		$search				= $mainframe->getUserStateFromRequest( $context.'search',			'search',			'',			'string' );

		$limit				= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart 		= $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );

		$where = array();

		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 's.state = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 's.state = 0';
			}
		}

		if ($search) {
			$where[] = 'LOWER(s.category) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

		$where		 = count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	 = ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', s.id';

		// get the total number of records
		$query 		 = 'SELECT count(*) FROM #__je_faq_category AS s '
			. $where
			;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo $db->getErrorMsg();
		}

		$total 	 = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$query 	 = 'SELECT s.* FROM #__je_faq_category AS s '
		. $where
		. $orderby
		;

		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();

		// state filter
		$lists['state']		= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']	= $search;

		$this->assignRef('items',		$rows);
		$this->assignRef('pageNav',		$pageNav);
		$this->assignRef('lists',		$lists);

		parent::display($tpl);

	}
}
