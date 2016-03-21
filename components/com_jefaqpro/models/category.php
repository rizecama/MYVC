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
jimport('joomla.application.component.model');

class jefaqModelCategory extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData()
	{
		$row =& $this->getTable();
		$row->load( $this->_id );
		return $row;
	}

	function getGlobalsettings()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT * FROM #__je_faq_settings';
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$rows  = $db->loadObject();

		return $rows;
	}

	function getResponsedet( $id, $catid )
	{
		$userid		= '';
		$db    		= & JFactory::getDBO();
		$user 		= & JFactory::getUser();
		if ( $user->get('id') > 0 ) {
			$userid		=  ' AND userid='.$user->get('id');
		}

		$query 	= 'SELECT userid, faqid,remote_ip FROM #__je_faq_responses where faqid="'.$id.'" AND catid="'.$catid.'"'.$userid;
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$res  	= $db->loadObject();

		return $res;
	}
	
	function getResponsecount( $id, $catid )
	{
		$db    	= & JFactory::getDBO();

		$query 	= 'SELECT sum(response_no) as response_no , sum(response_yes) as response_yes FROM #__je_faq_responses where faqid="'.$id.'" AND catid="'.$catid.'"';
		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$count  	= $db->loadObject();

		return $count;
	}
	
	function getCategories( $id )
	{
		$db    			= & JFactory::getDBO();
		if ( is_numeric ( $id )) {
			$where[]	= 'c.id='. $db->Quote( $id );
		}

		$where			= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby		= ' ORDER BY c.ordering ';

		$query 			= 'SELECT c.* FROM '. $db->nameQuote( '#__je_faq_category' ) .' AS c'
							  .$where
							  .$orderby 	;

		$db->setQuery( $query );

		if (!$db->query())	{
			echo $db->getErrorMsg();
		}

		$category 		= $db->loadObject();

		return $category;
	}

}
?>