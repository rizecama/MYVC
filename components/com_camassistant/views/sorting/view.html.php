<?php

/**

 * @version		1.0.0 camassistant $

 * @package		camassistant

 * @copyright	Copyright © 2010 - All rights reserved.

 * @license		GNU/GPL

 * @author

 * @author mail	nobody@nobody.com

 *

 *

 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com

 */



// no direct access

defined('_JEXEC') or die('Restricted access');



jimport( 'joomla.application.component.view' );



class sortingViewsorting extends Jview

{

	function display($tpl = null){

		// global $mainframe;

		$task = JRequest::getVar("task",'');
		$var = JRequest::getVar("var",'');

		if($task=='sorting_rfps_by_property')// to display vendor info form in registation process

		{

			//echo "<pre>"; print_r($_REQUEST); exit;

			$model = $this->getModel('sorting');
			$user = JFactory::getUser();
			if($user->user_type == 13 && $user->accounttype == 'master') {
			$Properties = $model->get_masterproperties();
			}
			else{
			$Properties = $model->get_Properties();
			}
			
			//$Properties = $model->get_Properties();

			$RFP_status = $model->get_RFP_status();

			$RFP_list_by_Prp = $model->get_limit_records('property_id');
			$allindustries = $model->getallindustries();
			$pagination =& $this->get('Pagination');

			//$pagination = $model->getPagination('property_id');

		//echo "<pre>";	print_r($pagination);



		//print_r($pagination->pages.total);

			$this->assignRef('pagination', $pagination);

			$this->assignRef('viewall_proposals',$viewall_proposals);
                    $user = JFactory::getUser();
			//echo "<pre>"; print_r($RFP_list);
						 if($user->user_type == 13 && $user->accounttype == 'master') {
                        $Managers = $model->get_masterManagers();
                         }
						 	
                         if($user->user_type == 13 && $user->accounttype != 'master') {
                        $Managers = $model->get_Managers();
                         }
						 if($user->user_type == 12 && $user->dmanager == 'yes') {
                        $Managers = $model->get_dmManagers();
                         }
						 
			$filter_Properties		= JRequest::getWord('filter_Properties');

			$filter_Status		= JRequest::getWord('filter_Status');
                        $this->assignRef('Managers',$Managers);
			$this->assignRef('RFP_list_by_Prp',$RFP_list_by_Prp);

			$this->assignRef('RFP_status',$RFP_status);

			$this->assignRef('Properties',$Properties);

			$this->assignRef('filter_Properties',$filter_Properties);

			$this->assignRef('filter_Status',$filter_Status);
			$this->assignRef('industries', $allindustries);
			if($var != 'manager'){
			$this->setLayout('sorting_rfps_by_property');
			}
			else{
			$this->setLayout('dm_rfps_by_managers');
			}
			parent::display();

		}

		else if($task=='sorting_rfps_by_managers')

		{

			$model = $this->getModel('sorting');

			$Managers = $model->get_Managers();

			$RFP_status = $model->get_RFP_status();

			$RFP_list_by_Mgr = $model->get_RFP_list('cust_id');

			//$pagination1 =& $this->get('Pagination1');

			$pagination1 = $model->getPagination1('cust_id');

			$this->assignRef('pagination1', $pagination1);

			$this->assignRef('viewall_proposals',$viewall_proposals);

			//echo "<pre>"; print_r($RFP_list);

			$filter_Properties		= JRequest::getWord('filter_Properties');

			$filter_Status		= JRequest::getWord('filter_Status');

			$this->assignRef('RFP_list_by_Mgr',$RFP_list_by_Mgr);

			$this->assignRef('RFP_status',$RFP_status);

			$this->assignRef('Managers',$Managers);

			$this->assignRef('filter_Properties',$filter_Properties);

			$this->assignRef('filter_Status',$filter_Status);

			$this->setLayout('sorting_rfps_by_managers');

			parent::display();

		}
//distric manager
else if($task=='dm_rfps_by_managers')

		{

			$model = $this->getModel('sorting');

			//$Managers = $model->get_Managers();

			$dm_manager_rfp_list = $model->get_dm_rfps_by_managers();
			$user=JFactory::getUser(); 
			if($user->dmanager == 'yes'){
			$Managers = $model->get_dmManagers();
			}
			if($user->user_type == '13'){
			$Managers = $model->get_Managers();
			}
			$RFP_status = $model->get_RFP_dmstatus();
 			//echo '<pre>'; print_r($Managers);
			//$RFP_list_by_Mgr = $model->get_RFP_list('cust_id');
			$pagination5 = $model->getPagination5('cust_id');
			//$pagination5 =& $this->get('pagination5');

			//$pagination1 = $model->getPagination1('cust_id');

			$this->assignRef('pagination5', $pagination5);

			//$this->assignRef('viewall_proposals',$viewall_proposals);

			//echo "<pre>"; print_r($RFP_list);

			//$filter_Properties		= JRequest::getWord('filter_Properties');

			//$filter_Status		= JRequest::getWord('filter_Status');

			$this->assignRef('dm_manager_rfp_list',$dm_manager_rfp_list);

			$this->assignRef('RFP_status',$RFP_status);

			$this->assignRef('Managers',$Managers);

			$this->assignRef('filter_Properties',$filter_Properties);

			$this->assignRef('filter_Status',$filter_Status);

			$this->setLayout('dm_rfps_by_managers');

			parent::display();

		}
//completed
	}



}

?>