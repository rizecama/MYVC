<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class announcementViewannouncement extends JView
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
		$document->setTitle( JText::_('Announcement') );
   
    	// Set ToolBar title
    	JToolBarHelper::title(   JText::_( 'Manage Announcements' ), 'generic.png' );
    
   		// Set toolbar items for the page
	    JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
 		JToolBarHelper::addNewX();
 		JToolBarHelper::editListX();		
		JToolBarHelper::deleteList();
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		
		
		$filter_order_req = JRequest::getWord('filter_order');
		if($filter_order_req == '')
		$filter_order = 'industry_name';
		else
		$filter_order = $filter_order_req;
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir',	'asc',			'word' );
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		
    	// Get URL
		$uri			=& JFactory::getURI();
		$model			=& $this->getModel();
		$items			= & $this->get( 'Data');
		//echo "<pre>"; print_r($items);
		$total			= & $this->get( 'Total');
		$pagination 	= & $this->get( 'Pagination' );
		$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .',published';
        $search 		= JRequest::getWord('search');
		
		//save a reference into view	
		$this->assignRef('user',		JFactory::getUser());	
		$this->assignRef('lists',		$lists);    
		$this->assignRef('items',		$items); 
		$this->assignRef('search',		$search);		
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		$this->assignRef('orderby',		$orderby);

		//call parent display
		parent::display($tpl);
  }
}
?>

