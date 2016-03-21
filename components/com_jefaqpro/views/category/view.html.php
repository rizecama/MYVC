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
jimport('joomla.html.pagination');

class  jefaqViewCategory  extends JView
{
	function display($tpl = null)
	{
		if( $this->_layout == 'categorylist') {
			$this->_categorylistLayout( $tpl );
			return;

		} else {
			$this->_defaultLayout( $tpl );
			return;
		}
	}

	function _defaultLayout( $tpl )
	{
		global $mainframe;

		$db		 			= & JFactory::getDBO();
		$model 	 			= & $this->getModel();
		$uri 				= & JFactory::getURI();

		$settings			= $model->getGlobalsettings();
		$baseurl			= JURI::base();

		$context			= 'com_jefaqpro';
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order',		's.ordering',	'cmd' );
		$limit				= $settings->cat_perpage;

		$limitstart 		= JRequest::getVar('limitstart', 0, '', 'int');
        $limitstart 		= ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$where = array();

		$where[]		 	= 's.state = 1';   // while published

		// From Search FAQ category using default search module.
			$sid			= & JRequest::getVar('sid');
			if ( is_numeric ( $sid ) ) {
				$where[]		= 's.id='. $db->Quote( $sid );
			}
			
		if ( $settings->group == 'questions' ) {
			$settings->group 	= 'category';
		}
		$filter_order		= 's.'.$settings->group.' '.$settings->sorting;

		$where				= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby			= ' ORDER BY '. $filter_order .', s.id';

		// get the total number of records
		$query 				= 'SELECT count(*) FROM #__je_faq_category AS s '
								. $where
								;
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$total				= $db->loadResult();

		// Call pagenation class
		$pageNav   			= new JPagination( $total, $limitstart, $limit );

		$query 				= 'SELECT s.* FROM #__je_faq_category AS s '
								. $where
								. $orderby
								;
		$db->setQuery( $query , $limitstart, $limit );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows 				= $db->loadObjectList();

		// Get title..
		$params				= & $mainframe->getParams('com_content');

		$this->assignRef('action', 		$uri->toString());
		$this->assignRef('items',		$rows);
		$this->assignRef('params',		$params);
		$this->assignRef('settings',	$settings);
		$this->assignRef('baseurl',		$baseurl);
		$this->assignRef('pageNav',		$pageNav);

		parent::display($tpl);
	}

	function _categorylistLayout( $tpl )
	{
		global $mainframe;

		$db		 			= & JFactory::getDBO();
		$user				= & JFactory::getUser();
		$model 	 			= & $this->getModel();
		$settings			= $model->getGlobalsettings();
		$baseurl			= JURI::base();
		$remote_ip 			= $_SERVER['REMOTE_ADDR'];

		// Get title..
		$params				= & $mainframe->getParams('com_content');
		$faq->catid			= JRequest::getInt( 'catid', 0 );

		$where = array();

		$where[]		 	= 's.state = 1';   // while published

		if ( is_numeric ( $faq->catid ) ) {
			$where[]		= 's.catid='. $db->Quote( $faq->catid );
		}

		$filter_order		= 's.'.$settings->group.' '.$settings->sorting;
		$where				= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby			= ' ORDER BY '. $filter_order .', s.id';


		$query 				= 'SELECT s.*,s.id AS faqid FROM '. $db->nameQuote( '#__je_faq' ) .' AS s '
								. $where
								. $orderby
								;
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows 				= $db->loadObjectList();

		// function for select category details.
		$category			= $model->getCategories( $faq->catid );

		$this->assignRef('items',		$rows);
		$this->assignRef('category',		$category);
		$this->assignRef('params',		$params);
		$this->assignRef('settings',	$settings);
		$this->assignRef('catid',		$faq->catid);
		$this->assignRef('baseurl',		$baseurl);
		$this->assignRef('user',		$user);
		$this->assignRef('remote_ip',	$remote_ip);

		parent::display($tpl);
	}
}