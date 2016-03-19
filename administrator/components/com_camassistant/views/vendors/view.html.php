<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class vendorsViewvendors extends JView
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
		//echo '<pre>'; print_r($_REQUEST); exit;
		// set document title
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Vendor') );
   
    	// Set ToolBar title
    	JToolBarHelper::title(   JText::_( 'Manage Vendors' ), 'generic.png' );
   		// Set toolbar items for the page
	    //JToolBarHelper::custom('','html.png','html.png','Control Panel',false);
 		//JToolBarHelper::addNewX();
		JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
		JToolBarHelper::addNewX();
 		JToolBarHelper::editListX();		
		JToolBarHelper::deleteList();
		//JToolBarHelper::publishList();
		//JToolBarHelper::unpublishList();
		$filter_order_req = JRequest::getWord('filter_order');
		if($filter_order_req == '')
		$filter_order = 'name';
		else
		$filter_order = $filter_order_req;
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir',	'asc', 'word' );
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
    	// Get URL
		$uri			=& JFactory::getURI();
		$model			=& $this->getModel();
		$items			= & $this->get( 'Data');
		
		for($x=0; $x<count($items); $x++)
		{
			 $vendor_GLI_compliance_alert	=	$model->proposalCentre_active_inactive($items[$x]->user_id);
			// echo '<pre>'; print_r($vendor_GLI_compliance_alert);
			  if($vendor_GLI_compliance_alert['PLN_needed'] == 'no') { 
					if($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0) { 
					$items[$x]->ProposalCentre_status = 'Active';
					 }  else
					{
					$items[$x]->ProposalCentre_status = 'Inactive';
					}	
				} else if($vendor_GLI_compliance_alert['PLN_needed'] == 'yes'){ 
					if($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0 && $vendor_GLI_compliance_alert['PLN_exist'] != 0) { 
					$items[$x]->ProposalCentre_status = 'Active';
					} else
					{
				$items[$x]->ProposalCentre_status = 'Inactive';
					}	
				} 
			}
			/*if($vendor_GLI_compliance_alert['W9_exist'] != 0 || $vendor_GLI_compliance_alert['GLI_exist'] != 0 || ($vendor_GLI_compliance_alert == 'yes' && $vendor_GLI_compliance_alert['PLN_exist'] == 0) )
			 {
				$items[$x]->ProposalCentre_status = 'Active';
			 }
			 else
			 {
				$items[$x]->ProposalCentre_status = 'Inactive';
			 }	
		}
		*/
		
		
		
		$total			= & $this->get( 'Total');
		$pagination 	= & $this->get( 'Pagination' );
		$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .',published';
        $search 		= JRequest::getWord('search');
		$lists['vendorslist'] =& $this->get( 'vendorslist' ) ;
		$filter_vendorslist		= JRequest::getWord('filter_vendorslist');
		//echo "<pre>"; print_r($items);  exit;
		//save a reference into view	
		$this->assignRef('user',		JFactory::getUser());	
		$this->assignRef('lists',		$lists);    
		$this->assignRef('items',		$items); 
		$this->assignRef('search',		$search);		
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());
		$this->assignRef('orderby',		$orderby);
		$this->assignRef('filter_vendorslist',	$filter_vendorslist);

		//call parent display
		parent::display($tpl);
  }
}
?>

