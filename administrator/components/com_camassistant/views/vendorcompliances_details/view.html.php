<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class vendorcompliances_detailsVIEWvendorcompliances_details extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;
		$task = JRequest::getVar('task','' );
		if($task == 'edit')
		JToolBarHelper::save();
   		 // Set ToolBar title
   		 JToolBarHelper::title(   JText::_( 'CUSTOMER MANAGER DETAIL' ), 'generic.png' );
		// Get URL, User,Model
		$uri 		=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$this->setLayout('default');
		$lists = array();
		$detail	=& $this->get('Data');
    	// the new record ?  Edit or Create?
		$isNew		= ($detail[4]->id < 1);
		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'THE DETAIL' ), $detail[0]->catname );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}
		// Set toolbar items for the page

		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		JToolBarHelper::title(   JText::_( 'Vendor Documents' ).': <small>' );
		//JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);

		//JToolBarHelper::apply('apply');
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
		//clean  data
		jimport('joomla.filter.filteroutput');
		JFilterOutput::objectHTMLSafe( $detail[0], ENT_QUOTES, 'catdescription' );
		$this->assignRef('lists',			$lists);
		$this->assignRef('OLN',		$detail[0]);
		$this->assignRef('PLN',		$detail[1]);
		$this->assignRef('GLI',		$detail[2]);
		$this->assignRef('WCI',		$detail[3]);
		$this->assignRef('W9',		$detail[4]);
		$this->assignRef('request_url',	$uri->toString());


		if($task=='vendorcompliancesdetails') // to change the vendorcompliancesdetails layout
		{
			$model = $this->getModel('vendorcompliances_details');
		    $introtext = $model->get_reject_mailcontent();
			$this->assignRef('introtext',$introtext);
			$this->setLayout('vendorreject');
			parent::display();
		}
		else if($task == 'upload_select')
		{
			$this->setLayout('task_uploadfile_form');
                        parent::display();
		}
		/********************************************to display compliance form added by lalitha*****************************************************/
		else if($task == 'vendor_compliance_docs')
		{
			$model = $this->getModel('vendorcompliances_details');
			$userid = JRequest::getVar('userid','');
			$GLI_policy_configurations = $model->get_GLI_policy_configurations();
			$this->assignRef('GLI_policy_configurations',$GLI_policy_configurations);
			$liscense_categories = $model->get_liscense_categories();
			$this->assignRef('liscense_categories',$liscense_categories);
			$W9_data = $model->get_compliance_W9_data($userid);
			if(count($W9_data)>0)
			$this->assignRef('W9_data',$W9_data[0]);
			$WC_data = $model->get_compliance_WC_data($userid);
			if(count($WC_data)>0)
			$this->assignRef('WC_data',$WC_data);
			$AIP_data = $model->get_compliance_AIP_data($userid);
             if(count($AIP_data)>0)
			$this->assignRef('AIP_data',$AIP_data);
			
			$UMB_data = $model->get_compliance_UMB_data($userid);
             if(count($UMB_data)>0)
			$this->assignRef('UMB_data',$UMB_data);
			$OMI_data = $model->get_compliance_OMI_data($userid);
             if(count($OMI_data)>0)
			$this->assignRef('OMI_data',$OMI_data);
			
			$WCI_data = $model->get_compliance_WCI_data($userid);
			if(count($WCI_data)>0)
			$this->assignRef('WCI_data',$WCI_data);
			$GLI_data = $model->get_compliance_GLI_data($userid);
			$this->assignRef('GLI_data',$GLI_data);
			$OLN_data = $model->get_compliance_OLN_data($userid);
			$this->assignRef('OLN_data',$OLN_data);
			$PLN_data = $model->get_compliance_PLN_data($userid);
			$this->assignRef('PLN_data',$PLN_data);
			$states = $model->get_edit_compliance_states();
			$this->assignRef('states',$states);
			$OLN_states = $model->get_compliances_OLN_states();
			$this->assignRef('OLN_states',$OLN_states);
			$PLN_states = $model->get_compliances_PLN_states();
			$this->assignRef('PLN_states',$PLN_states);
			$W9_upld_cert_link = $model->get_W9_upld_cert_link();
			$this->assignRef('W9_upld_cert_link',$W9_upld_cert_link);
			$GLI_upld_cert_link = $model->get_GLI_upld_cert_link();
			$this->assignRef('GLI_upld_cert_link',$GLI_upld_cert_link);
			$WCI_upld_cert_link = $model->get_WCI_upld_cert_link();
			$this->assignRef('WCI_upld_cert_link',$WCI_upld_cert_link);
			$OLN_upld_cert_link = $model->get_OLN_upld_cert_link();
			$this->assignRef('OLN_upld_cert_link',$OLN_upld_cert_link);
			$PLN_upld_cert_link = $model->get_PLN_upld_cert_link();
			$this->assignRef('PLN_upld_cert_link',$PLN_upld_cert_link);
			
			$firmslist = $model->getpreferredclist($userid);
			$this->assignRef('firmslist',$firmslist);
			
			$getindustryids = $model->getindustry_ids($user->id);
			if($getindustryids)
			if(in_array('56',$getindustryids))
			$PLN_needed = 'yes'; else $PLN_needed = 'no';
			$this->assignRef('PLN_needed',$PLN_needed);
			if(count($GLI_data)>0)
			$this->setLayout('vendor_compliance_docs_edit');
			else
			$this->setLayout('vendor_compliance_docs_edit');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_OLN_form') //Ajax form to "Add another ocupational lincese" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$states = $model->get_compliances_OLN_states();
			$this->assignRef('states',$states);
			$OLN_upld_cert_link = $model->get_OLN_upld_cert_link($compliance);
			$this->assignRef('OLN_upld_cert_link',$OLN_upld_cert_link);
			$this->setLayout('ajax_compliance_oln_form');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_PLN_form') //Ajax form to "Add another ocupational lincese" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$liscense_categories = $model->get_liscense_categories();
			$this->assignRef('liscense_categories',$liscense_categories);
			$states = $model->get_compliances_PLN_states();
			$this->assignRef('states',$states);
			$PLN_upld_cert_link = $model->get_PLN_upld_cert_link($compliance);
			$this->assignRef('PLN_upld_cert_link',$PLN_upld_cert_link);
			$this->setLayout('ajax_compliance_pln_form');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_gli_form') //Ajax form to "Add another General liability insurance" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$this->setLayout('ajax_compliance_gli_form');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_aip_form') //Ajax form to "Add another General liability insurance" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$this->setLayout('ajax_compliance_aip_form');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_umb_form') //Ajax form to "Add another General liability insurance" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$this->setLayout('ajax_compliance_umb_form');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_omi_form') //Ajax form to "Add another General liability insurance" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$this->setLayout('ajax_compliance_omi_form');
			parent::display($tpl);
		}
		else if($task == 'ajax_compliance_wci_form') //Ajax form to "Add another General liability insurance" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$this->setLayout('ajax_compliance_wci_form');
			parent::display($tpl);
		}else if($task == 'ajax_compliance_wc_form') //Ajax form to "Add another General liability insurance" - in compliance form
		{
			$compliance = JRequest::getVar('compliance','');
			$model = $this->getModel('vendorcompliances_details');
			$this->setLayout('ajax_compliance_wc_form');
			parent::display($tpl);
		}
		else if($task=='compliance_upload_form')	//to upload certificates in vendor compliance documents
		{
			$model = $this->getModel('vendorcompliances_details');
			//$industries = $model->getindustires();
			//$this->assignRef('industries',$industries);
			$this->setLayout('compliance_upload_form');
			parent::display($tpl);
		}
		else if($task=='get_subcat')
		{
			$this->setLayout('ajax_get_subcat');
			parent::display($tpl);
		}
		/********************************************end to display compliance form added by lalitha*****************************************************/
		else
		{
		    parent::display($tpl);
		}
	}



}

?>

