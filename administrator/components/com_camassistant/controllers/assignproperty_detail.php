<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

class assignproperty_detailController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask( 'apply',		'save' );
	}

	// function edit
	function edit()
	{
		JRequest::setVar( 'view', 'assignproperty_detail' );
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar( 'hidemainmenu', 1);
		parent::display();
		$model = $this->getModel('assignproperty_detail');
		$model->checkout();
	}
      
      
	// function save

	function save()
	{
		
		$db=JFactory::getDBO();
		$post = JRequest::get('post');
		
		$task = JRequest::getVar("task",'');
		$tax_id1 = JRequest::getVar("tax_id1",'');
		$tax_id2 = JRequest::getVar("tax_id2",'');

		if($tax_id2){
		$data['tax_id']	= $tax_id1.'-'.$tax_id2;
		}
		else{
		$data['tax_id']	= $tax_id1;
		}
		
		$data['property_name'] = JRequest::getVar("property_name",'');
		$data['street'] = JRequest::getVar("street",'');
		$data['city'] = JRequest::getVar("city",'');
		$data['state'] = JRequest::getVar("state",'');
		$data['divcounty'] = JRequest::getVar("divcounty",'');
		$data['zip'] = JRequest::getVar("zip",'');
		$data['share'] = JRequest::getVar("share",'');
		$data['units'] = JRequest::getVar("units",'');
		
		$data['company_id'] = JRequest::getVar("company_id",'');
		$data['id']	= $_REQUEST['cid'][0];
		$data['cc'] = '';
		$data['property_manager_id']= JRequest::getVar("property_manager_id",'');
		$data['camfirmid'] = JRequest::getVar("custmors",'');
		$data['createtime'] = date('Y-m-d H:i:s');
		
		if($tax_id2 == ''){
		$data['pro_type'] = 'single';
		}
		else{
		$data['pro_type'] = 'ass';
		}
		//echo "<pre>"; print_r($data); exit;
		if($data['camfirmid']){
		$data['property_manager_id']= JRequest::getVar("custmors",'');
		$data['camfirmid'] = JRequest::getVar("property_manager_id",'');
		}
		else{
		$data['property_manager_id']= JRequest::getVar("property_manager_id",'');
		$data['camfirmid'] = JRequest::getVar("custmors",'');
		}
		
		$type = "SELECT user_type FROM #__users WHERE id=".$data['property_manager_id'];
		$db->setQuery($type);
		$u_type = $db->loadResult();
		
		if($u_type == 12) {
		$comapny = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$data['property_manager_id'];
		$db->setQuery($comapny);
		$companyid = $db->loadResult();
		}
		if($u_type == 13) {
		$comapny = "SELECT id FROM #__cam_camfirminfo  WHERE cust_id=".$data['property_manager_id'];
		$db->setQuery($comapny);
		$companyid = $db->loadResult();
		}
		$data['company_id'] = $companyid;

//////////To update the document center
		$newproperty = $data['property_name'];
		$newproperty = preg_replace("/[&:;=`{}'!@#$%^*(?)-+|]/","_",$newproperty);
		$newproperty = str_replace('\\','_',$newproperty);
		$newproperty = str_replace('/','_',$newproperty);
		$newproperty = ereg_replace('/','_',$newproperty);
		$newproperty = str_replace('.','_',$newproperty);	
		$newproperty = str_replace(',','_',$newproperty);	
		$newproperty = str_replace('[','_',$newproperty);	
		$newproperty = str_replace(']','_',$newproperty);	
		$newproperty = ereg_replace('-','_',$newproperty);	
		$newproperty = ereg_replace('"','_',$newproperty);	
		$newproperty = str_replace('\\','_',$newproperty);		
		$newproperty = str_replace(' ','_',$newproperty);
		$data['property_name'] = $newproperty;
		
		$default = 'components/com_camassistant/doc/';
		$before_details = "SELECT property_name,tax_id FROM #__cam_property WHERE  id='".$data['id']."'  ";
		$db->setQuery($before_details);
		$beforefiles = $db->loadObject();
		$before_pname = $beforefiles->property_name;
		
		$before_pname = preg_replace("/[&:;=`{}'!@#$%^*(?)-+|]/","_",$before_pname);
		$before_pname = str_replace('\\','_',$before_pname);
		$before_pname = str_replace('/','_',$before_pname);
		$before_pname = ereg_replace('/','_',$before_pname);
		$before_pname = str_replace('.','_',$before_pname);	
		$before_pname = str_replace(',','_',$before_pname);	
		$before_pname = str_replace('[','_',$before_pname);	
		$before_pname = str_replace(']','_',$before_pname);	
		$before_pname = ereg_replace('-','_',$before_pname);	
		$before_pname = ereg_replace('"','_',$before_pname);	
		$before_pname = str_replace('\\','_',$before_pname);		
		$before_pname = str_replace(' ','_',$before_pname);
		//this is for copying
		$oldpath_rename = JPATH_SITE.'/'.$default.$before_pname.'_'.$beforefiles->tax_id; 
		$newpath_rename = JPATH_SITE.'/'.$default.$newproperty.'_'.$data['tax_id'];
		rename($oldpath_rename,$newpath_rename);
		//completed 
		
		//this is for updating
		$oldpath = $default.$before_pname.'_'.$beforefiles->tax_id; 
		$newpath = $default.$newproperty.'_'.$data['tax_id'];
		//completed 
		 
		
		//update the paths with chnaged propertyname and new taxid
		$paths = "SELECT * FROM #__cam_propertydocs WHERE  property_id='".$data['id']."' and property_manager_id=".$data['property_manager_id']."  ";
		$db->setQuery($paths);
		$docpaths = $db->loadObjectList();
	//	echo "<pre>"; print_r($docpaths); exit;
		for($p=0;$p<count($docpaths); $p++){
		$docpath = $default.$newproperty.'_'.$data['tax_id'];
		$docpath = str_replace(' ','_',$docpath);

		$docpath = str_replace($oldpath,$newpath,$docpaths[$p]->docPath);

		$sql_path="UPDATE #__cam_propertydocs  SET docPath='".$docpath."' where id=".$docpaths[$p]->id." and property_id=".$data['id']." and property_manager_id=".$data['property_manager_id']."";

		
		$db->Setquery($sql_path);
		$db->query();
		}

		//Completed
		//Completed
				
		$model = $this->getModel('assignproperty_detail');
		if($model->store($data))
		{
		$msg = 'Property Updated Successfully';
		$url = 'index.php?option=com_camassistant&controller=assignproperty&filter_order='.$_REQUEST['filter_order'].'';
		$this->setRedirect( $url, $msg );
		}
		else {
		$msg = 'Property Not Updated';
		$url = 'index.php?option=com_camassistant&controller=assignproperty';
		$this->setRedirect( $url, $msg );
		}
	}
	function remove()
	{
		
		
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
       
		/***************end of code Case 3. Retailers assigned as primary categories************/
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('assignproperty_detail');
/*		if($res <= 0)
		{
		
*/			
		$model->delete($cid) ;
			$msg='Property Deleted Successfully';
		/*}*/
		/*else	
        $msg = $catnames.' cannot  be removed as they contain Retailers as a primary reference.';
		if($msg == 'Industry Deleted Successfully')
		header("Location: index.php?option=com_camassistant&controller=category&msg=deleted");
		else*/
		$this->setRedirect( 'index.php?option=com_camassistant&controller=assignproperty',$msg);
	}
	
	// function cancel

	function cancel()
	{
		// Checkin the detail
		$model = $this->getModel('assignproperty_detail');
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_camassistant&controller=assignproperty' );
	}	
	function ajaxcounty(){

$state = $_REQUEST['State'];
$db=JFactory::getDBO();
$countie = "SELECT * FROM #__cam_counties WHERE State='".$state."' ORDER BY County ";
		$db->setQuery($countie);
		$db->Query();
		$counties = $db->loadObjectList(); ?>
<option value="" >Please Select County</option>

		 	<?php
			foreach($counties as $county)
			{
			echo"<option value=".$county->id.">".$county->County."</option>";
			} 
		exit; 
	}
	//Verify taxid
	function verfirytaxid()
	{

		$db =& JFactory::getDBO();
		$Taxid=$_POST['queryString'];
		$propertyid = $_REQUEST['pid'];
		if ($Taxid != "" && $propertyid != '' )
		{
	 	$query_Taxid="SELECT id FROM #__cam_property  WHERE id !=".$propertyid." and tax_id='".$Taxid."' and publish='0' ";
		$db->setQuery( $query_Taxid );
		$result_tax = $db->loadResult();
		if($result_tax){
		$data="invalid"; 
		 }
		}
		else{
			$query_Taxid="SELECT id FROM #__cam_property  WHERE tax_id='".$Taxid."' and publish='0' ";
			$db->setQuery( $query_Taxid );
			$result_tax = $db->loadResult();
			if($result_tax){
			$data="invalid"; 
			 }
		}
		echo $data;
		exit;
   }
	//Completed
	function manager(){
		$userid = $_REQUEST['userid'];
		$db=JFactory::getDBO();
		$query = "SELECT id FROM #__cam_camfirminfo WHERE cust_id=".$userid;
		$db->setQuery($query);
		$id = $db->loadResult(); 
		$query = "SELECT U.cust_id,V.name,V.lastname FROM #__cam_customer_companyinfo as U, #__users as V  WHERE V.user_type=12 and U.cust_id=V.id and U.comp_id=".$id;
		$db->setQuery($query);
		$custmors = $db->loadObjectList();
		?>
		<option value="" >Please Select Manager</option>
		<?php
		foreach($custmors as $cust)
		{
		echo"<option value=".$cust->cust_id.">".$cust->name.'&nbsp;'.$cust->lastname."</option>";
		} 
		exit; 
		
	}
}

?>