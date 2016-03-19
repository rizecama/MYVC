<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class vendorcompliancesVIEWvendorcompliances extends JView
{
	function display($tpl = null)
	{
	
		global $mainframe, $option;	
   		 // Set ToolBar title
   		 JToolBarHelper::title(   JText::_( 'CUSTOMER MANAGER DETAIL' ), 'generic.png' );
		JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
		// Get URL, User,Model
		$uri 		=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$this->setLayout('default');
		$lists = array();
		$detail	=& $this->get('Data');
		for($x=0; $x<count($detail); $x++)
		{
		/*	 $vendor_GLI_compliance_alert	=	$model->proposalCentre_active_inactive($detail[$x]->id);
			if(($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_status'] == 0 && $vendor_GLI_compliance_alert['W9_status'] == 0 && ($vendor_GLI_compliance_alert['PLN_needed'] == 'no' || ($vendor_GLI_compliance_alert['PLN_needed'] == 'yes' && $vendor_GLI_compliance_alert['PLN_status'] == 0))) && (($vendor_GLI_compliance_alert['GLI_exp'] == 0) && ($vendor_GLI_compliance_alert['W9_status'] == 0) &&  ($vendor_GLI_compliance_alert['PLN_needed'] == 'no' || ($vendor_GLI_compliance_alert['PLN_needed'] == 'yes' && $vendor_GLI_compliance_alert['PLN_exp'] == 0))) ) 
			 {
				$detail[$x]->ProposalCentre_status = 'Active';
			 }
			 else
			 {
				$detail[$x]->ProposalCentre_status = 'Inactive';
			 }	
		}
		*/
		$vendor_GLI_compliance_alert	=	$model->proposalCentre_active_inactive($detail[$x]->id);
         if($vendor_GLI_compliance_alert['PLN_needed'] == 'no') { 
					if($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0) { 
					
					$detail[$x]->ProposalCentre_status = 'Active';
					 }  else
					{
					$detail[$x]->ProposalCentre_status = 'Inactive';
					}	
				} else if($vendor_GLI_compliance_alert['PLN_needed'] == 'yes'){ 
					if($vendor_GLI_compliance_alert['W9_exist'] != 0 && $vendor_GLI_compliance_alert['GLI_exist'] != 0 && $vendor_GLI_compliance_alert['PLN_exist'] != 0) { 
					$detail[$x]->ProposalCentre_status = 'Active';
					} else
					{
				$detail[$x]->ProposalCentre_status = 'Inactive';
					}	
				} 
			}
    	// the new record ?  Edit or Create?
		$isNew		= ($detail[0]->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'THE DETAIL' ), $detail[0]->catname );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Set toolbar items for the page
		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		JToolBarHelper::title(   JText::_( 'Vendor Compliances' ).': <small>' );
		JToolBarHelper::editListX();	
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		JToolBarHelper::help( 'screen.customer.edit' );

		// Edit or Create?
		if (!$isNew)
		{
		  //EDIT - check out the item
			$model->checkout( $user->get('id') );
		}

		// build the html select list
		$published = ($detail[0]->id) ? $detail[0]->published : 1;
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $published );
		if($_REQUEST['filter_order'] == '')
		$filter_order = 'V.vendor_id';
		else
		$filter_order = $_REQUEST['filter_order'];
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir',	'asc',			'word' );
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
        	 $search 		= JRequest::getVar('search');
		//clean  data
		jimport('joomla.filter.filteroutput');	
		JFilterOutput::objectHTMLSafe( $detail[0], ENT_QUOTES, 'catdescription' );
		
		$this->assignRef('lists',			$lists);
		$this->assignRef('items',		$detail);
		$this->assignRef('search',		$search);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
	}

}

?>

