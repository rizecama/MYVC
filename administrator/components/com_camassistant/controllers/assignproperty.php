<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import CONTROLLER object class
jimport( 'joomla.application.component.controller' );
 
class AssignpropertyController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		
	}
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}

	function display() {
		parent::display();
	}
		function reasign(){
		JRequest::getVar( 'view','assignproperty');
		parent::display();

	}
	function save_reassign()
	{

	$db=JFactory::getDBO();
	$post=JRequest::get('post');
	$custidnew = JRequest::getVar( 'newcustid','' );
	$custid = JRequest::getVar( 'custid','' );	
	if($custidnew) {
	$post['newcustid'] = $custidnew;
	}
	else{
	$post['newcustid'] = $custid;
	}

	$present = JRequest::getVar( 'present','' );
	$query_type = "SELECT user_type FROM #__users where id=".$post['newcustid']."";
	$db->setQuery($query_type);
	$type = $db->loadResult();
	
	if($type==12){
	$query = "SELECT comp_id FROM #__cam_customer_companyinfo where cust_id=".$post['newcustid']."";
	$db->setQuery($query);
	$comp_id = $db->loadResult();
	$query = "SELECT cust_id FROM #__cam_camfirminfo WHERE id=".$comp_id;
	$db->setQuery($query);
	$creator = $db->loadResult();
	$camfirmid = $creator;
	}
	else {
	$query = "SELECT id FROM #__cam_camfirminfo where cust_id=".$post['newcustid']."";
	$db->setQuery($query);
	$comp_id = $db->loadResult();
	$camfirmid = 0;	
	}
	$sql_reassign="UPDATE #__cam_property  SET property_manager_id='".$post['newcustid']."',camfirmid=".$camfirmid.",company_id=".$comp_id." where id=".$post['pid'];
	
	$db->setQuery($sql_reassign);
	$res=$db->query(); 

	$sql_docs="UPDATE #__cam_propertydocs  SET property_manager_id='".$post['newcustid']."' where property_id=".$post['pid'];
	$db->setQuery($sql_docs);
	$res=$db->query(); 
	
 	$update_rfpinfo="UPDATE #__cam_rfpinfo  SET cust_id='".$post['newcustid']."' where property_id=".$post['pid']." and cust_id=".$present."";
	$db->setQuery($update_rfpinfo);
	$res=$db->query(); 
	
	
	?>
	<script type="text/javascript">
	window.parent.document.getElementById( 'sbox-window' ).close();
	window.parent.location.href = 'index.php?option=com_camassistant&controller=Assignproperty';
	alert("Property assigned successfully.");
	</script>
<?php 
}
//function to re assign the property
/*	function save_reassign()
	{
	$db=JFactory::getDBO();
	$post=JRequest::get('post');
	$custid = JRequest::getVar( 'custid','' );
	$query_type = "SELECT user_type FROM #__users where id=".$custid."";
	$db->setQuery($query_type);
	$type = $db->loadResult();
	
	if($type==12){
	$query = "SELECT comp_id FROM #__cam_customer_companyinfo where cust_id=".$post['custid']."";
	$db->setQuery($query);
	$comp_id = $db->loadResult();
	$query = "SELECT cust_id FROM #__cam_camfirminfo WHERE id=".$comp_id;
	$db->setQuery($query);
	$creator = $db->loadResult();
	$camfirmid = $creator;
	}
	else {
	$query = "SELECT id FROM #__cam_camfirminfo where cust_id=".$post['custid']."";
	$db->setQuery($query);
	$comp_id = $db->loadResult();
	$camfirmid = 0;	
	}
	$sql_reassign="UPDATE #__cam_property  SET property_manager_id='".$post['custid']."',camfirmid=".$camfirmid." where id=".$post['pid'];
	$db->setQuery($sql_reassign);
	$res=$db->query(); 

	$sql_docs="UPDATE #__cam_propertydocs  SET property_manager_id='".$post['custid']."' where property_id=".$post['pid'];
	$db->setQuery($sql_docs);
	$res=$db->query(); 
	?>
	<script type="text/javascript">
	window.parent.document.getElementById( 'sbox-window' ).close();
	window.parent.location.href = 'index.php?option=com_camassistant&controller=Assignproperty';
	alert("Property assigned successfully.");
	</script>
<?
}
*///Completed
function getallmanagers(){

$db=JFactory::getDBO();	
		$cid = JRequest::getVar( 'companyid','' );	
		$mans = "SELECT u.name,u.lastname,u.id from #__cam_customer_companyinfo as v, #__users as u where v.comp_id=".$cid." and u.id=v.cust_id";
		$db->setQuery($mans);
		$mans = $db->loadObjectList();

$cams = "SELECT u.name,u.lastname,u.id from #__cam_camfirminfo as v, #__users as u where v.id=".$cid." and u.id=v.cust_id";
		$db->setQuery($cams);
		$camfirm = $db->loadObjectList();

$all_managers = array_merge($mans,$camfirm);

$properties1 = "<select name='newcustid'>";

	$where="";
	for($s=0; $s<count($all_managers);$s++){
			$where = $where."<option value=".$all_managers[$s]->id.">".$all_managers[$s]->name.' '.$all_managers[$s]->lastname. "</option>";
			}


$all = $properties1.$where."</select>";
echo $all; exit;


}
	function updateproperty(){
		$db=JFactory::getDBO();	
		$pid = JRequest::getVar( 'property_id','' );
		$type =JRequest::getVar( 'type','' );
		if( $type == 'unhide' )
		$sql_reassign="UPDATE #__cam_property  SET publish='0' where id=".$pid;
		else
		$sql_reassign="UPDATE #__cam_property  SET publish='1' where id=".$pid;
		
		$db->setQuery($sql_reassign);
		$res=$db->query(); 
		exit;
	}
}
?>
