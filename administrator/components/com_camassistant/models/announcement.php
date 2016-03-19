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
class announcementModelannouncement extends JModel
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
	  $this->_table_prefix = '#__cam_announcement';	
	  
		//DEVNOTE: Get the pagination request variables
		//$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		//$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
        if($_REQUEST['limit'] == '' && $_REQUEST['limitstart'] == '')
		{
		 $limit = 20;
		 $limitstart = 0;
		}
		else
		{
		 $limit = $_REQUEST['limit'];
		 $limitstart = $_REQUEST['limitstart'];
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
		
		$query = ' SELECT * FROM '.$this->_table_prefix.'';
		
	   $orderby	= $this->_buildContentOrderBy();
	
	
		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $context;

		//DEVNOTE:give me ordering from request
		//$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		if($_REQUEST['filter_order'] == '')
		$filter_order = 'id';
		else
		$filter_order = $_REQUEST['filter_order'];
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
			$query = 'DELETE FROM '.$this->_table_prefix.' WHERE id IN ( '.$cids.' )';
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
