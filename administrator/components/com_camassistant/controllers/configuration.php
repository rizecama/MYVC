<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class configurationController extends JController
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

	// function edit
	function edit()
	{
		JRequest::setVar( 'view', 'configuration' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1);

		parent::display();

		$model = $this->getModel('configuration');
		$model->checkout();
	}
      
	// function save

	function save()
	{
 		$task = JRequest::getVar("task",'');
		$post = JRequest::get('post');
 		$data['closedrfp_limit']	= $post['closedrfp_limit'];
		$data['unsubrfp_limit']		= $post['unsubrfp_limit'];
		$data['subrfp_limit']	    = $post['subrfp_limit'];
		$data['awardrfp_limit']	    = $post['awardrfp_limit'];
		$data['unawardrfp_limit']	    = $post['unawardrfp_limit'];
		$data['draftproposals_limit']	= $post['draftproposals_limit'];
		$data['submittedproposals_limit']	= $post['submittedproposals_limit'];
		$data['reviewproposals_limit']	= $post['reviewproposals_limit'];
		$data['awardedproposals_limit']	= $post['awardedproposals_limit'];
		$data['unawarderproposals_limit']	= $post['unawarderproposals_limit'];
		$data['rfps_by_property_limit']	= $post['rfps_by_property_limit'];
		$data['vendor_logo_height']	= $post['vendor_logo_height'];
		$data['vendor_logo_width']	= $post['vendor_logo_width'];
		$data['vendor_policy_limits']	= $post['vendor_policy_limits'];
		$data['vendor_aggregate']	= $post['vendor_aggregate'];
		$data['av_page']	= $post['av_page'];
		$data['survey_days']	= $post['survey_days'];
		if($post['payment_type'] == 'Paypal')
		{
		$data['auth_tx_key']   		= '';
		$data['auth_login_id'] 		= '';
		$data['payment_type']   	= $post['payment_type'];
		$data['pay_name']      		= $post['pay_name'];
		$data['pay_busness_email']  = $post['pay_busness_email'];
		$data['pay_currency'] 		= $post['pay_currency'];
		}
		else if($post['payment_type'] == 'Authorize')
		{
		$data['pay_name']      		= '';
		$data['pay_busness_email']  = '';
		$data['pay_currency'] 		= '';
		$data['payment_type']   	= $post['payment_type'];
		$data['auth_tx_key']   		= $post['auth_tx_key'];
		$data['auth_login_id'] 		= $post['auth_login_id'];
		}
		$data['calender_on_off']	= $post['calender_on_off'];
		$data['id']	= $post['cid'][0];
		$model = $this->getModel('configuration');
		if($model->store($data))
		{
		$msg = 'Updated Successfully';
		$url = 'index.php?option=com_camassistant';
		$this->setRedirect( $url, $msg );
		}
		else {
		$msg = 'Not updated';
		$url = 'index.php?option=com_camassistant';
		$this->setRedirect( $url, $msg );
		}
		//$model = $this->getModel('configuration');
	}

	// function cancel
	function cancel()
	{
		// Checkin the detail
		$model = $this->getModel('configuration');
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant' );
	}	
	
}

?>