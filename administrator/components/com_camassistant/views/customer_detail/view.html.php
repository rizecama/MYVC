<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class customer_detailVIEWcustomer_detail extends JView
{
	function display($tpl = null)
	{
	
		global $mainframe, $option;	
   		 // Set ToolBar title
   		 JToolBarHelper::title(   JText::_( 'CUSTOMER MANAGER DETAIL' ), 'generic.png' );

		// Get URL, User,Model
		$uri 		=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$this->setLayout('form');
		$lists = array();
		$detail	=& $this->get('Data');
		//$model = $this->getModel('customer_detail');
		$cdata = & $this->get('companylist');
		
      //echo "<pre>"; print_r($detail);
    	// the new record ?  Edit or Create?
		$isNew		= ($detail[0]->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'THE DETAIL' ), $detail[0]->catname );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Set toolbar items for the page
		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		JToolBarHelper::title(   JText::_( 'customer' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::custom('lists','html.png','html.png','Control Panel',false);
		JToolBarHelper::save();
		JToolBarHelper::apply('apply');
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
		$states = & $this->get('states');
		//print_r(	$states );
	      $states1[0] = new stdClass();
			$states1[0]->value = "";
			$states1[0]->text = " Select State ";
			$states=array_merge($states1,$states);
			$this->assignRef('states', $states);
		$this->assignRef('lists',			$lists);
		$this->assignRef('detail',		$detail[0]);
		$this->assignRef('cdata',		$cdata);
		$this->assignRef('request_url',	$uri->toString());
				//Security questions///
			$model = $this->getModel('customer_detail');
			$questions = $model->getquestions();
			$allcodes = $model->getallcodes();
			$row1[0] = new stdClass();
			$row1[0]->value = "";
			$row1[0]->text = "-Select Question-";
			$questions=array_merge($row1,$questions);
			//echo "<pre>"; print_r($questions); 
			$this->assignRef('questions',$questions);
			$this->assignRef('codes',$allcodes);
			///Completed/
		$task = JRequest::getVar("task",'');
		if($task == 'addpayment'){
			$this->setLayout('addpayment');
			parent::display($tpl);
		}
		else if($task == 'editpayment'){
			$this->setLayout('editpayment');
			parent::display($tpl);
		}
		else{
			parent::display($tpl);
		}
	}

}

?>

