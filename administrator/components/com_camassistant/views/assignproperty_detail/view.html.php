<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class assignproperty_detailViewassignproperty_detail extends JView
{
	 // Constructor
	function __construct( $config = array())
	{
		global $context;
		$context = '.list.';
		parent::__construct( $config );
	}
 
	/**
	 * Display the view
	 */
    
	function display($tpl = null)
	{
    	global $mainframe, $context;
		
		// set document title
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Manage Property') );
   
    	// Set ToolBar title
    	JToolBarHelper::title(   JText::_( 'Create / Manage Property ' ), 'generic.png' );
    
   		// Set toolbar items for the page
	    JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
 		/*JToolBarHelper::addNewX();
 		JToolBarHelper::editListX();		
		JToolBarHelper::deleteList();
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();*/
		JToolBarHelper::save();	
		JToolBarHelper::apply();	
		JToolBarHelper::cancel();
		
		$filter_order_req = JRequest::getWord('filter_order');
		if($filter_order_req == '')
		$filter_order = 'name';
		else
		$filter_order = $filter_order_req;
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir',	'asc','word' );
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		
    	// Get URL
		$uri			=& JFactory::getURI();
		
		$model	=& $this->getModel('assignproperty_detail');
		//$this->setLayout('form');
		//$lists = array();
		$detail	=& $this->get('Data');
		//$detail			= & $this->get( 'Data');
		$total			= & $this->get( 'Total');
		$pagination 	= & $this->get( 'Pagination' );
		$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .',published';
        $search 		= JRequest::getWord('search');
		$lists['vendorslist'] =& $this->get( 'vendorslist' ) ;
		//echo "<pre>"; print_r($detail);  exit;
		//$model			=& $this->getModel('assignproperty');
		
	
		
		//Completed
		// Getting boardmembers list
		$bmembers = & $this->get( 'boardmembers' );
		//$userslist = & $this->get( 'users' );
			//echo "<pre>"; print_r($userslist);
		$rows = & $this->get( 'states');
		$row1[0] = new stdClass();
		$row1[0]->value = "";
		$row1[0]->text = "-Select State-";
		$rows=array_merge($row1,$rows);
		
		$userslist = & $this->get( 'users');
		$userslist1[0] = new stdClass();
		$userslist1[0]->id = "";
		$userslist1[0]->username = " Select Camfirm";
		$users_list=array_merge($userslist1,$userslist);
		
		$this->assignRef('bmembers',$bmembers);
		//save a reference into view	
		$this->assignRef('states',	$rows);
		$this->assignRef('userslist',	$users_list);
		$this->assignRef('user',		JFactory::getUser());	
		$this->assignRef('lists',		$lists);    
		$this->assignRef('detail',		$detail[0]); 
		$this->assignRef('search',		$search);		
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		$this->assignRef('orderby',		$orderby);

		//call parent display
		parent::display($tpl);
  }
}
?>

