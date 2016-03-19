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

class  jefaqViewFaq  extends JView
{
	function display($tpl = null)
	{
		if($this->_layout == 'form') {

			$this->_formLayout( $tpl );
			return;

		} else {

			$this->_defaultLayout( $tpl );
			return;
		}
	}

	// function for form layout
	function _formLayout( $tpl )
	{
		$model  			= & $this->getModel();
		$faqRecord 			= & $this->get('Data');
		$user	  			= & JFactory::getUser();
		$remote_ip 			= $_SERVER['REMOTE_ADDR'];

		// tool bar.
		$text 				= $faqRecord->id ? JText::_( 'JE_FAQ_EDIT' ) : JText::_( 'JE_FAQ_NEW' );
		JToolBarHelper::title(   JText::_( 'JE_FAQ' ).': <small><small>[ ' . $text.' ]</small></small>' ,'faq.png');
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($faqRecord->id)	{
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else	{
			JToolBarHelper::cancel();
		}
		// toolbar end.

		$category			= $model->getCategory();
		$date	 			= new JDate();
		$today				= $date->toFormat('%Y-%m-%d %H:%M:%S');

		if ( $faqRecord->posted_by == '' ) {
			$posted['postedby'] 	 = $user->get( 'name' );
		} else {
			$posted['postedby'] 	 = $faqRecord->posted_by;
		}

		if ( $faqRecord->posted_date == '' || $faqRecord->posted_date == '0000-00-00 00:00:00' ) {
			$posted['posteddate']    = $today;
		} else {
			$posted['posteddate']    = $faqRecord->posted_date;
		}

		if ( $faqRecord->posted_email == '' ) {
			$posted['email']	 	 = $user->get( 'email' );
		} else {
			$posted['email']		 = $faqRecord->posted_email;
		}

		if ( $faqRecord->gid == '' ) {
			$posted['gid']	 	 = $user->get( 'gid' );
		} else {
			$posted['gid']		 = $faqRecord->gid;
		}

		if ( $faqRecord->remote_ip == '' ) {
			$posted['remote_ip'] = $remote_ip;
		} else {
			$posted['remote_ip'] = $faqRecord->remote_ip;
		}

		// assign values here.
		$this->assignRef('row',	        $faqRecord);
		$this->assignRef('category',	$category);
		$this->assignRef('today',		$today);
		$this->assignRef('posted',		$posted);

		parent::display($tpl);
	}

	// function for default layout
	function _defaultLayout( $tpl )
	{
		global $mainframe;

		$model  			= & $this->getModel();
		$db 				= & JFactory::getDBO();

		JToolBarHelper::title(   JText::_( 'JE_FAQ' ) . ' - ' .  JText::_( 'JE_FAQ_COM' ), 'faq.png' );
		JToolBarHelper::publish();
		JToolBarHelper::unpublish();
		JToolBarHelper::deleteListX(JText::_( 'JE_WARN_DELETE' ));
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::custom('help_faq','help', '',JText::_( 'JE_HELP' ), false);

		$context			= 'com_jefaqpro.faq';

		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		'c.category',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( $context.'filter_state',		'filter_state',		'',				'word' );
		$search				= $mainframe->getUserStateFromRequest( $context.'search',			'search',			'',				'string' );
		$catid				= $mainframe->getUserStateFromRequest( $context.'catid',			'catid',			-1,				 'int' );
		$limit				= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'),   'int' );
		$limitstart 		= $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );

		$where = array();

		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] 	= 's.state = 1';
			} else if ($filter_state == 'U' ) {
				$where[] 	= 's.state = 0';
			}
		}

		if ($search) {
			$where[]		= 'LOWER(s.questions) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

		// Category filter
		if ($catid >= 0) {
			$where[] 		= 's.catid = ' . (int) $catid;
		}

		$where				= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		if ($filter_order == 's.ordering') {
			$orderby 		= ' ORDER BY c.category, s.ordering '. $filter_order_Dir;
		} else {
			$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', c.category, s.ordering';
		}


		// get the total number of records
		$query 		 		= 'SELECT count(*) FROM #__je_faq AS s ' .
							   ' LEFT JOIN ' .
							   ' #__je_faq_category AS c ON c.id = s.catid'
							  . $where ;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo $db->getErrorMsg();
		}

		$total 	 			= $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav 			= new JPagination( $total, $limitstart, $limit );

		$query  			= ' SELECT s.*, c.category FROM #__je_faq AS s ' .
							   ' LEFT JOIN ' .
							   ' #__je_faq_category AS c ON c.id = s.catid'
								. $where
								. $orderby	;
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows				= $db->loadObjectList();


		// Get list of categories for dropdown filter
		$query 				= 'SELECT c.id AS value, c.category AS text ' .
							  ' FROM #__je_faq_category AS c' .
							  ' ORDER BY c.ordering';
		$lists['catid'] 	= $model->filterCategory($query, $catid);
		// Categories list end.

		// State filter.
		$lists['state']		= JHTML::_('grid.state',  $filter_state );
		// State filter End.

		// Table ordering.
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		// Table ordering End.

		// Search filter
		$lists['search']	= $search;
		// Search fiter End

		// assign values here.
		$this->assignRef('items',		$rows);
		$this->assignRef('pageNav',		$pageNav);
		$this->assignRef('lists',		$lists);

		parent::display($tpl);
	}

}
