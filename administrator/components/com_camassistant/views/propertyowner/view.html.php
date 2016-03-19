<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class propertyownerViewpropertyowner extends JView
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
		$task1	= JRequest::getVar( 'task');
		if($task1=='assignmaster'){
			$task='assignmaster';
		}
		// set document title
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Property Owner') );
   
    	// Set ToolBar title
    	JToolBarHelper::title(   JText::_( 'Manage Property Owners' ), 'generic.png' );
    
   		// Set toolbar items for the page
		/*JToolBarHelper::custom('export_mng','export_mng.png','export_mng.png','Export Managers',false);
	    JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
		JToolBarHelper::custom('createmaster','create.png','create.png','Create Master',false);
		JToolBarHelper::custom('removemaster','remove.png','remove.png','Remove from Master',false);
		JToolBarHelper::custom('addtomaster','addmaster.png','addmaster.png','Add to Master',false);*/

 	/*	//JToolBarHelper::addNewX();
// 		JToolBarHelper::editListX();*/		
		JToolBarHelper::deleteList();
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		
		
		$filter_order_req = JRequest::getVar('filter_order');
		if($filter_order_req == '')
		$filter_order = '';
		else
		$filter_order = $filter_order_req;
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir',	'DESC',			'word' );
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
        $search 		= JRequest::getVar('search');
		
		//save a reference into view	
		$this->assignRef('user',		JFactory::getUser());	
		$this->assignRef('lists',		$lists);    
		$this->assignRef('items',		$items); 
		$this->assignRef('search',		$search);		
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		$this->assignRef('orderby',		$orderby);
		
		if($task == 'assignmaster'){
		customerViewcustomer::$task();
		$this->setLayout('addmaster');
		parent::display($tpl);
		}
		
		//call parent display
		parent::display($tpl);
  }
  		function assignmaster(){
		$firmid = JRequest::getVar('firmid','');
		$model			=& $this->getModel();
		$masters	=	$model->getallmasterfirms();
		$firmdata	=	$model->getfirmdetails($firmid);
		$this->assignRef('masters', $masters);
		$this->assignRef('firmdata', $firmdata);
		}
	
}
?>

