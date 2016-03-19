<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import VIEW object class
jimport( 'joomla.application.component.view' );

class vendors_detailViewvendors_detail extends JView
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
		$task = JRequest::getVar("task",'');
		if($task == industries_form)
		{
		$model = $this->getModel('vendors_detail');
		$industries = $model->getindustires(); 
		$this->assignRef('industries',$industries);
		$this->setLayout('industries_form');
		parent::display($tpl);
		}
		else 
		// set document title
		{
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Vendor') );
   
    	// Set ToolBar title
    	JToolBarHelper::title(   JText::_( 'Manage Vendors' ), 'generic.png' );
   		// Set toolbar items for the page
	    //JToolBarHelper::custom('camassistant','html.png','html.png','Control Panel',false);
		JToolBarHelper::save();
		JToolBarHelper::apply('apply');
		JToolBarHelper::cancel();
		$filter_order_req = JRequest::getWord('filter_order');
		if($filter_order_req == '')
		$filter_order = 'name';
		else
		$filter_order = $filter_order_req;
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir',	'asc',			'word' );
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
    	// Get URL
		$uri			=& JFactory::getURI();
		$model			=& $this->getModel();
		$detail			= & $this->get( 'Data');
		//echo "<pre>"; print_r($detail);
		$total			= & $this->get( 'Total');
		$pagination 	= & $this->get( 'Pagination' );
		$orderby		= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .',published';
        $search 		= JRequest::getWord('search');
		$lists['vendorslist'] =& $this->get( 'vendorslist' ) ;
		$filter_vendorslist		= JRequest::getWord('filter_vendorslist');
		$model = $this->getModel('vendors_detail');
		$industries_link = $model->getindustries_link();
		$states = $model->getstates(); 
//Modified by sateesh 
		$fill_industires = $model->fill_industires($detail[0]->user_id); 
		//Completed
		//save a reference into view	
		$this->assignRef('user',		JFactory::getUser());	
		$this->assignRef('states',		$states);
		$this->assignRef('fill_industires',		$fill_industires);
		$this->assignRef('lists',		$lists);    
		$this->assignRef('detail',		$detail[0]); 
		$this->assignRef('search',		$search);		
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('industries_link',	$industries_link);
		$this->assignRef('request_url',	$uri->toString());
		$this->assignRef('orderby',		$orderby);
		$this->assignRef('filter_vendorslist',	$filter_vendorslist);
		//To get the counties by sateesh
			$vendor_counties = $model->getvendorcounties($id);
			$this->assignRef('vendorcounties', $vendor_counties);
		//To get the vendor states
			$statelist = $model->getstatelist($detail[0]->user_id);
			$this->assignRef('statelist',$statelist);	
		//To statelist when adding new account by sateesh
			$model = $this->getModel('vendors_detail');
			$statelist = $model->getstatelist();
			$this->assignRef('statelist',$statelist);
		//TO get the vendor company state by sateesh on 22-07-11
			$businessstatelist = $model->getbusinessstatelist($detail[0]->user_id);
			$this->assignRef('businesslist',$businessstatelist);
		//TO get the vendor awarded rfps by sateesh on 27-03-13
			$awardrfps = $model->getawardedrfps($detail[0]->user_id);
			$this->assignRef('awardrfps',$awardrfps);	
		//TO get the vendor avarage rting by sateesh on 27-03-13
			$v_rating = $model->getavaragerating($detail[0]->user_id);
			$this->assignRef('v_rating',$v_rating);			
		//call parent display
				//Security questions///
			$model = $this->getModel('vendors_detail');
			$questions = $model->getquestions();
			$row1[0] = new stdClass();
			$row1[0]->value = "";
			$row1[0]->text = "-Select Question-";
			$questions=array_merge($row1,$questions);
			//echo "<pre>"; print_r($questions); 
			$this->assignRef('questions',$questions);
			///Completed/

		parent::display($tpl);
  		}
	}	
}
?>