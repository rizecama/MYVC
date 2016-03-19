<?php
/**
* @package HelloWorld
* @version 1.5
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
error_reporting(0);
//DEVNOTE: import MODEL object class
jimport('joomla.application.component.model');

/**
 * helloworld Component helloworld Model
 *
 * @author wojta <vojtechovsky@gmail.com>
 * @package		Joomla
 * @subpackage	helloworld
 * @since 1.5
 */
class AssignpropertyModelAssignproperty extends JModel
{

	/**
	 * helloworld data
	 *
	 * @var array
	 */
	var $_data = null;
	/**
	 * Category total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

  /**
	 * table_prefix - table prefix for all component table
	 * 
	 * @var string
	 */
	var $_table_prefix = null;
	
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe, $context;

		//initialize class property
	  $this->_table_prefix = '#__cam_';	
	  
		//DEVNOTE: Get the pagination request variables
		//$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		//$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		$limit		= JRequest::getWord('limit');
		$limitstart		= JRequest::getWord('limitstart');
        if($limit == '' && $limitstart == '')
		{
		 $limit = 20;
		 $limitstart = 0;
		}
		else
		{
		 $limit = $limit;
		 $limitstart = $limitstart;
		}
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

	}
	
	
	/**
	 * Method to get a helloworld data
	 *
	 * this method is called from the owner VIEW by VIEW->get('Data');
	 * - get list of all helloworld for the current data page.
	 * - pagination is spec. by variables limitstart,limit.
	 * - ordering of list is build in _buildContentOrderBy  	 	 	  	 
	 * @since 1.5
	 */
	function getData()
	{
		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			 $query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}


		return $this->_data;
}

	/**
	 * Method to get the total number of helloworld items
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	/**
	 * Method to get a pagination object for the helloworld
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	function _buildQuery()
	{  
	 //code added on 06-02-2010
	    $db =& JFactory::getDBO();
		$orderby	= $this->_buildContentOrderBy();
		$search		= JRequest::getWord('search');
	    $where = ' WHERE LOWER(C.catname) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	    $where .=  ' OR LOWER(C.catdescription) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		$query = 'SELECT * FROM #__cam_boardmembers ';
		//code added on 06-02-2010
	    /*$orderby	= $this->_buildContentOrderBy();
		$query = ' SELECT * FROM '.$this->_table_prefix.'category'.$orderby;
		*/
		return $query;
	}
	function &getvendorslist() 
	{
	  global $mainframe;
	  $javascript		= ' onchange="document.adminForm.submit();" ';
	  $catlist[] = JHTML::_('select.option', '0', '-Choose Category-');
	  $this->_filter_catlist			= $mainframe->getUserStateFromRequest( $context.'filter_catlist', 'filter_catlist', 0,	'string' );	
	  $query = 'SELECT id,catname FROM #__symaffiliate_category order by catname asc' ;
	  $this->_db->setQuery($query);
	  $objects = $this->_db->loadObjectList() ; 
		foreach( $objects as $obj ) 
		{
			$catlist[] = JHTML::_('select.option',  $obj->id, $obj->catname);
		}
		
	 $result = JHTML::_('select.genericlist',	$catlist, 'filter_catlist', 'class="inputbox" size="1" ' . $javascript , 'value', 'text', $this->_filter_catlist);	
	 
	 return $result;
	}
	function _buildContentOrderBy()
	{
		global $mainframe, $context;

		//DEVNOTE:give me ordering from request
		//$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		$filter_order		= JRequest::getWord('filter_order');
		if($filter_order == '')
		$filter_order = 'name';
		else
		$filter_order = $filter_order;
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		

		//DEVNOTE: all countries are in the same category(no category)  
		$orderby 	= ' ORDER BY  '. $filter_order .' '. $filter_order_Dir;				

		return $orderby;
	}

	function delete($cid = array())
	{
		$result = false;


		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
		echo $query = 'DELETE FROM '.$this->_table_prefix.'_boardmembers WHERE id IN ( '.$cids.' )'; exit;
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}
	
	
}
?>
