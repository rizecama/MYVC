<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class AssignpropertyViewAssignproperty extends JView
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
		$task=JRequest::getVar('task','');
		// set document title
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Manage Property') );
   
    	// Set ToolBar title
    	JToolBarHelper::title(   JText::_( 'Create / Manage Property ' ), 'generic.png' );
    
   		// Set toolbar items for the page
	    //JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
 		JToolBarHelper::addNewX();
 		//JToolBarHelper::editListX();		
		JToolBarHelper::deleteList();
		JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
		
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
		$model			=& $this->getModel();
		$items			= & $this->get( 'Data');
		$total			= & $this->get( 'Total');
		$pagination 	= & $this->get( 'Pagination' );
		$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .',published';
        $search 		= JRequest::getWord('search');
		$lists['vendorslist'] =& $this->get( 'vendorslist' ) ;
		//echo "<pre>"; print_r($items);  exit;
		//save a reference into view
			// Getting countries list
		
		//Completed
		
		$this->assignRef('user',		JFactory::getUser());	
		$this->assignRef('lists',		$lists);    
		$this->assignRef('items',		$items); 
		$this->assignRef('search',		$search);		
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		$this->assignRef('orderby',		$orderby);

		//call parent display
		//get the properties
		$properties = $this->get('properties');
		$this->assignRef('properties', $properties);
		//Completed
		//get the camfirms
		$camfirms = $this->get('camfirms');
		//echo "<pre>"; print_r($camfirms); exit;
		$this->assignRef('camfirms', $camfirms);
		//Completed
		//get the managers
		$managers = $this->get('managers');
		$this->assignRef('managers', $managers);
		//Completed
		//get the states
		$states = $this->get('states_sort');
		$this->assignRef('state_sort', $states);
		//Completed
		//get the states
		$cities = $this->get('cities_sort');
		$this->assignRef('cities', $cities);
		//Completed
		//reasign property
		if($task =='reasign'){
		$custmers = & $this->get( 'custmers' );
		$this->assignRef('custmers',$custmers);
		$this->setLayout('reasign_property');
		}
		//completd
		parent::display($tpl);
  }
}
?>

