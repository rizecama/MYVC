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

class  jefaqViewFaq  extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if ( $this->_layout == 'form') {

			// Load the form validation behavior
			JHTML::_('behavior.formvalidation');

			$model  			= & $this->getModel();
			$user 				= & JFactory::getUser();
			$params				= & $mainframe->getParams('com_content');

			$settings			= $model->getGlobalsettings();
			$category			= $model->getCategory();

			$date	 			= new JDate();
			$today				= $date->toFormat('%Y-%m-%d %H:%M:%S');

			$view	 	  		= & JRequest::getVar('view','');
			$itemid	 	   		= & JRequest::getVar('Itemid','');
			$catid 				= & JRequest::getInt('catid', 0);
			$remote_ip 			= $_SERVER['REMOTE_ADDR'];

			$this->assignRef('today',		$today);
			$this->assignRef('user',		$user);
			$this->assignRef('settings',	$settings);
			$this->assignRef('params',		$params);
			$this->assignRef('category',	$category);
			$this->assignRef('catid',		$catid);
			$this->assignRef('view',		$view);
			$this->assignRef('itemid',		$itemid);
			$this->assignRef('remote_ip',	$remote_ip);


		} else {
			$catid				= '';
			$db 				= & JFactory::getDBO();
			$user				= & JFactory::getUser();
			$model  			= & $this->getModel();
			$settings			= $model->getGlobalsettings();
			$remote_ip 			= $_SERVER['REMOTE_ADDR'];

			$limit				= $settings->cat_perpage;

			$limitstart 		= JRequest::getVar('limitstart', 0, '', 'int');
       		$limitstart 		= ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

			$catid				= $model->getAllfaqs();
			
			$where 				= array();

			$where[] 			= 's.state = 1';   // while published
			$where[] 			= 's.catid IN ('.$catid.')';
			
			// From Search FAQ's using default search module.
				$sid			= & JRequest::getVar('sid');
				if ( is_numeric ( $sid ) ) {
					$where[]		= 's.id='. $db->Quote( $sid );
				}

			$filter_order		= 'c.category, s.'.$settings->group.' '.$settings->sorting;
			$where				= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
			$orderby			= ' ORDER BY '. $filter_order .', s.id';

			// get the total number of records
			$query 				= 'SELECT count(*) FROM #__je_faq AS s '.
									$where
									;
			$db->setQuery( $query );

			if (!$db->query())	{
				echo $db->getErrorMsg();
			}

			$total 				= $db->loadResult();

			$pageNav   			= new JPagination( $total, $limitstart, $limit );

			$query				= 'SELECT s.* FROM #__je_faq AS s '.
									' LEFT JOIN ' .
							   		' #__je_faq_category AS c ON c.id = s.catid'
								  	. $where
									. $orderby
									;
			$db->setQuery( $query, $limitstart, $limit );

			if (!$db->query())	{
				echo $db->getErrorMsg();
			}

			$rows 				= $db->loadObjectList();

			// Get title..
			$params				= & $mainframe->getParams('com_content');

			$this->assignRef('items',		$rows);
			$this->assignRef('params',		$params);
			$this->assignRef('settings',	$settings);
			$this->assignRef('user',		$user);
			$this->assignRef('remote_ip',	$remote_ip);
			$this->assignRef('pageNav',		$pageNav);
		}

		parent::display($tpl);
	}
}

