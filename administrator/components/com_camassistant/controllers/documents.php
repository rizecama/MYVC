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

jimport('joomla.application.component.controller');

class documentsController extends JController
{

	function __construct( $default = array())
	{
		parent::__construct( $default );
		
	}
	function display()
	{
	parent::display();

	}
	function pdocs(){
//echo "<pre>"; print_r($_REQUEST); exit;
	$model = $this->getModel('documents');
	$result = $model->getpdocs();
	parent::display();
}
function remove()
	{

		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cids = implode( ',', $cid );
		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel('documents');
		if($res <= 0)
		{
			if(!$model->delete($cid)) {
				echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			}
			$msg='';
			$msg='Document Deleted Successfully';
		}
		$task=JRequest::getVar('task','');
		if($task=='sdocs')
		$this->setRedirect( 'index.php?option=com_camassistant&controller=documents&task=sdocs&Itemid=82',$msg);
		else
		$this->setRedirect( 'index.php?option=com_camassistant&controller=documents&task=pdocs&Itemid=82',$msg);
	 }
	
	function sdocs(){
	$model = $this->getModel('documents');
	$sdocs = $model->get('Data');
	parent::display();

	}
	
	function pfiles(){
	$post = JRequest::get('post');
	$mid = JRequest::getVar( 'mid','' );
	$pid = JRequest::getVar( 'pid','' );
//	echo $mid; echo $pid; exit;
	$model = $this->getModel('documents');
	$pfiles = $model->getpfiles();
	parent::display();
	}
	
	function addfolder(){
	JRequest::getVar( 'view','documents');
	$model = $this->getModel('documents');
	$categoriess = $model->getcategories();
	parent::display();
	}
	function savefolder(){
 
	$post = JRequest::get('post');
	$cat_id = JRequest::getVar( 'cat_id','' );
	$docTitle = JRequest::getVar( 'docTitle','' );
	$docTitle = preg_replace("/[&'`:;={}!@#$%^*(?)-+|]/"," ",$docTitle);	
	$docTitle = ereg_replace('/',' ',$docTitle);
	$docTitle = str_replace('.',' ',$docTitle);	
	$docTitle = str_replace(',',' ',$docTitle);	
	$docTitle = str_replace('[',' ',$docTitle);	
	$docTitle = str_replace(']',' ',$docTitle);	
	$docTitle = ereg_replace('-',' ',$docTitle);	
	$docTitle = ereg_replace('"',' ',$docTitle);	
	$docTitle = str_replace('\\',' ',$docTitle);		
	$docTitle = ereg_replace(' ','_',$docTitle);
	
	//print_r($_REQUEST['path']);  echo "<br><br>";
	if($_REQUEST['path']=='components/com_camassistant/doc/'){
//	echo "In if"; 
	$path1 = "components/com_camassistant/doc/".$docFoldername;
	$path = "components/com_camassistant/doc/".$docFoldername.$docTitle;
	}
	else {
	$path1 = $_REQUEST['path'];
	$path = $_REQUEST['path']."/".$docTitle;
	}
	//print_r($path1);echo "<br>";
		$dpath = JPATH_SITE;

	if(!is_dir($path1))
   	$path1 = $dpath."/".$path1;

	mkdir($path1,0777);
	if(is_dir($path))
	{
	$post['docPath'] = $path1;
	echo "Exists";
	}
	else {
//	echo "In esle"; exit;

	$paths = $dpath."/".$path;
	//print_r($paths); exit;
	mkdir($paths,0777);
	$post['docPath'] = $path;
	$post['property_manager_id'] = $_REQUEST['mid'];
	$post['property_id'] = $_REQUEST['pid'];
	$post['parent'] = $_REQUEST['parentid'];
	$post['docTitle'] = preg_replace("/[&:;=`{}'!@#$%^*(?)-+|]/","_",$post['docTitle']);
	$post['docTitle'] = ereg_replace('/',' ',$post['docTitle']);
	$post['docTitle'] = ereg_replace('"',' ',$post['docTitle']);
	$post['docTitle'] = ereg_replace('-',' ',$post['docTitle']);
	$post['docTitle'] = str_replace('.',' ',$post['docTitle']);
	$post['docTitle'] = str_replace(',',' ',$post['docTitle']);
	$post['docTitle'] = str_replace('[',' ',$post['docTitle']);
	$post['docTitle'] = str_replace(']',' ',$post['docTitle']);
	$post['docTitle'] = ereg_replace('"',' ',$post['docTitle']);	
	$post['docTitle'] = str_replace('\\',' ',$post['docTitle']);		
	$post['docTitle'] = ereg_replace(' ','_',$post['docTitle']);

	$model = $this->getModel('documents');
	$success = $model->store($post);
	$db =& JFactory::getDBO();
	$query = "SELECT property_name FROM #__cam_property where id =".$cat_id;
	$db->setQuery($query);
    $catname=$db->loadResult();
	$post['cat_name'] = $catname; 
	$success = $model->store1($post);
	if($success){
	?>
    <script type="text/javascript">	
	window.parent.location.reload();
	//window.parent.document.getElementById( 'sbox-window' ).close(); 
	</script>
<?php	}
	else{
	echo "Fail";
	}

}
exit;
	}
	
	function openfiles(){

	JRequest::getVar('view','documents');
	parent::display();

	}
	function addfile(){
	JRequest::getVar( 'view','documents');
 	parent::display();
	}
	
	function savefile(){
	$post = JRequest::get('post');
	$dest = JRequest::getVar( 'path','');
	jimport('joomla.filesystem.file');
////For checking file extension/////////////
	$model = $this->getModel('documents');
	$check = $model->getcheck();
////For checking file extension/////////////	
	$dest = $dest."/";
	$dest = JPATH_SITE."/".$dest;
	$_FILES['file']['name'] = str_replace($ext,$ext1,$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace(' ','_',$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace('&','_',$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace('#','_',$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace('%','_',$_FILES['file']['name']);
	
	$copied = copy($_FILES["file"]["tmp_name"],$dest.$_FILES['file']['name']);
	if($copied){
	//echo "In If"; exit;
 	$post['property_manager_id'] = $_REQUEST['mid'];
 	$post['property_id'] = $_REQUEST['pid'];
	$post['docPath'] = $_REQUEST['path']."/".$_FILES['file']['name'];
 	$post['docTitle'] = $_FILES['file']['name'];
	$post['parent'] = $_REQUEST['parentid'];	
	$model = $this->getModel('documents');
	$res = $model->store3($post);
	?>
	<script type="text/javascript">	
				window.parent.location.reload();
				//window.parent.document.getElementById( 'sbox-window' ).close(); 
				</script>
	<?php
	} else{
	echo "File is not uploaded please try again.";
	}
exit;
}
////////////////////////////////////////Shared docs////////////////////////////////////
	function sfiles(){
//print_r($_REQUEST['spid']); exit;
	$model = $this->getModel('documents');
	$sfiles = $model->getsfiles();
	parent::display();
	}


	function saddfolder(){

	JRequest::getVar( 'view','documents');
	$model = $this->getModel('documents');
	$scategoriess = $model->getscategories();
	
 	parent::display();
	}
	
	
	function ssavefolder(){	
	$post = JRequest::get('post');
	$cat_id = JRequest::getVar( 'cat_id','' );
	$sdocTitle = JRequest::getVar( 'sdocTitle','' );	
	$sdocTitle = preg_replace("/[&'!@#$%^*()-+|]/"," ",$sdocTitle);
	$sdocTitle = ereg_replace('/',' ',$sdocTitle);
	$sdocTitle = ereg_replace('"',' ',$sdocTitle);
	$sdocTitle = ereg_replace('-',' ',$sdocTitle);
	$sdocTitle = ereg_replace(' ','_',$sdocTitle);
	
	$spath = JRequest::getVar( 'spath','' );
	$spid = JRequest::getVar( 'spid','' );	
	$smid = JRequest::getVar( 'smid','' );


//	print_r($_REQUEST['spath']);  echo "<br><br>"; 

	if($_REQUEST['spath']=='components/com_camassistant/doc/'){
	echo "In if"; 
	$path1 = "components/com_camassistant/doc/".$docFoldername;	
	$path = "components/com_camassistant/doc/".$docFoldername.$sdocTitle;
	}
	else {
	$path1 = $_REQUEST['spath'];	
	$path = $_REQUEST['spath']."/".$sdocTitle;
	}
//print_r($path1);echo "<br>";print_r($path); exit;
$dpath = JPATH_SITE;
	if(!is_dir($path1))
	$path1 = $dpath."/".$path1;
	mkdir($path1,0777);
	if(is_dir($path))
	{
	$post['docPath'] = $path1;
	echo "Exists";
	}
	else {
	$paths = $dpath."/".$path;
	mkdir($paths,0777);
	$post['docPath'] = $path;
	$post['property_manager_id'] = $smid;
	$post['property_id'] = $spid;
	$post['sdocTitle'] = preg_replace("/[&'!@#$%^*()-+|]/"," ",$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace('/',' ',$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace('"',' ',$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace('-',' ',$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace(' ','_',$post['sdocTitle']);

	$model = $this->getModel('documents');
	$success = $model->sstore($post);
	$db =& JFactory::getDBO();
	$query = "SELECT property_name FROM #__cam_property where id =".$cat_id;
	$db->setQuery($query);
    $catname=$db->loadResult();
	$post['cat_name'] = $catname; 
	$success = $model->store1($post);
	if($success){
	?>
	<script type="text/javascript">	
	window.parent.location.reload();
	</script>
	<?php
	}
	else{
	echo "Please add one more time";
	}
exit;
}
}
	function saddfile(){
	//echo "iam ehre<pre>";
	//print_r($_REQUEST);exit;
	JRequest::getVar( 'view','documents');
 	parent::display();
	}

		//Function to upload the sharing files sateesh on 25-07-11
	function sharedfiles(){
	$post = JRequest::get('post');
	$sdocTitle = JRequest::getVar( 'sdocTitle','' );	
	$sdocTitle = preg_replace("/[&'!@#$%^*(?)-+|]/"," ",$sdocTitle);
	$sdocTitle = ereg_replace('/',' ',$sdocTitle);
	$sdocTitle = ereg_replace('"',' ',$sdocTitle);
	$sdocTitle = ereg_replace('-',' ',$sdocTitle);
	$sdocTitle = ereg_replace(' ','_',$sdocTitle);
	$spath = JRequest::getVar( 'spath','' );
	$smid = JRequest::getVar( 'smid','' );	
	$type = JRequest::getVar( 'type','' );	
	
	$db =& JFactory::getDBO();
	$query_type = "SELECT user_type FROM #__users WHERE id=".$smid;
	$db->setQuery($query_type);
	$usertype = $db->loadResult();
	
	if($spath=='components/com_camassistant/doc/sharedfiles/'){
	//echo "In if"; 
	$path1 = "components/com_camassistant/doc/sharedfiles/".$docFoldername;	
	$path = "components/com_camassistant/doc/sharedfiles/".$docFoldername.$sdocTitle;
	}
	else {
	$path1 = $spath;	
	$path1 = $spath."/".$sdocTitle;
	}
	
	if($usertype == 13){
	$post['parent_manager'] = '0';
	}
	else{
	$db =& JFactory::getDBO();
	$query = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$smid;
	$db->setQuery($query);
	$comp_id = $db->loadResult();
		
	$query = "SELECT U.id FROM #__users as U, #__cam_camfirminfo as V  where V.id  =".$comp_id." and U.id= V.cust_id"  ;
	$db->setQuery($query);
    $camfirmid=$db->loadResult();
	$post['parent_manager'] = $camfirmid;
	}
//	echo $path1; exit;
	$dpath = JPATH_SITE;
	$path1 = $dpath.'/'.$path1;
	
	if(!is_dir($path1))
	mkdir($path1,0777);
	if(is_dir($path))
	{
	$post['docPath'] = $path1;
	echo "This folder name is already existing please try again";
	exit;
	}
	else {
	mkdir($path,0777);
	$post['docPath'] = $path;
	$post['property_manager_id'] = $smid;
	$post['property_id'] = $spid;
	$post['type'] = $type;
	$post['sdocTitle'] = preg_replace("/[&'!@#$%^*(?)-+|]/"," ",$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace('/',' ',$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace('-',' ',$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace('"',' ',$post['sdocTitle']);
	$post['sdocTitle'] = ereg_replace(' ','_',$post['sdocTitle']);
	$model = $this->getModel('documents');
	$success = $model->sstore($post);
	$db =& JFactory::getDBO();
	$query = "SELECT property_name FROM #__cam_property where id =".$cat_id;
	$db->setQuery($query);
    $catname=$db->loadResult();
	$post['cat_name'] = $catname; 

	$success = $model->store1($post);
	if($success){
	?>
	<script type="text/javascript">	
    window.parent.location.reload();
    //window.parent.document.getElementById( 'sbox-window' ).close(); 
    </script>
	<?php 	}	else{
	echo "Please add one more time";
	}
	exit;
	}
	
		}
		
	function sharingfiles(){
	$post = JRequest::get('post');
	$dest = JRequest::getVar( 'spath','');
	$parentid = JRequest::getVar( 'parentid','');
	$spid = JRequest::getVar( 'spid','');
	$smid = JRequest::getVar( 'smid','');
	$spath = JRequest::getVar( 'spath','');
	$shared = JRequest::getVar( 'shared','');
	jimport('joomla.filesystem.file');
	$model = $this->getModel('documents');
	$check = $model->getcheck();
	// For checking extension...///	
	$_FILES['file']['name'] = ereg_replace(' ','_',$_FILES['file']['name']);
	$dest = $dest."/";
	$dpath = JPATH_SITE;
	$dest = $dpath.'/'.$dest;
	if(!is_dir($dest))
	mkdir($dest,0777);
	
	$copied = copy($_FILES["file"]["tmp_name"],$dest.$_FILES['file']['name']);
	if($copied){
 	$post['property_manager_id'] = $smid;
 	$post['property_id'] = $spid;
	$post['docPath'] = $spath."/".$_FILES['file']['name'];
 	$post['sdocTitle'] = $_FILES['file']['name'];
	$post['sdocTitle'] = ereg_replace(' ','_',$post['sdocTitle']);	
	$post['parent'] = $parentid;
	$post['shared'] = $shared;
		if($usertype == 13){
	$post['parent_manager'] = '0';
	}
	else{
	$db =& JFactory::getDBO();
	$user = JFactory::getUser();  
	$query = "SELECT comp_id FROM #__cam_customer_companyinfo WHERE cust_id=".$user->id;
	$db->setQuery($query);
	$comp_id = $db->loadResult();
		
	$query = "SELECT U.id FROM #__users as U, #__cam_camfirminfo as V  where V.id  =".$comp_id." and U.id= V.cust_id"  ;
	$db->setQuery($query);
    $camfirmid=$db->loadResult();
	$post['parent_manager'] = $camfirmid;
	}
	
	$model = $this->getModel('documents');
	$res = $model->store3($post);
	?>
	<script type="text/javascript">	
    window.parent.location.reload();
    </script>
	<?php  } else{
	echo "<font color='red'>File uploading has failed</font>";
	}
	exit(0);
}
//Function to upload the sharing files by sateesh on 25-07-11 completed

	function ssavefile(){
	$post = JRequest::get('post');
	$dest = JRequest::getVar( 'spath','');
	jimport('joomla.filesystem.file');
	$model = $this->getModel('documents');
	$check = $model->getcheck();
// For checking extension...///	
	$dest = JPATH_SITE."/".$dest;
	$dest = $dest."/";
	$_FILES['file']['name'] = ereg_replace(' ','_',$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace('&','_',$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace('#','_',$_FILES['file']['name']);
	$_FILES['file']['name'] = ereg_replace('%','_',$_FILES['file']['name']);
	
	$copied = copy($_FILES["file"]["tmp_name"],$dest.$_FILES['file']['name']);
	if($copied){
 	$post['property_manager_id'] = $_REQUEST['smid'];
 	$post['property_id'] = $_REQUEST['spid'];
	$post['docPath'] = $_REQUEST['spath']."/".$_FILES['file']['name'];
 	$post['sdocTitle'] = $_FILES['file']['name'];	
	$post['sdocTitle'] = ereg_replace(' ','_',$post['sdocTitle']);	
	$post['parent'] = $_REQUEST['parentid'];	
	$model = $this->getModel('documents');
	$res = $model->store3($post);
	echo "<font color='red'>File has been uploaded successfully</font>";
	echo '<script language="javascript">window.parent.location.reload();window.parent.document.getElementById( "sbox-window" ).close();</script>';
	?>
	<?php  } else{
	echo "<font color='red'>File uploading was failed</font>";
	}
	exit(0);
}

	function sopenfiles(){
	JRequest::getVar('view','documents');
	parent::display();
	}

	function delete(){
//	echo "This is delete function"; exit;
	$model = $this->getModel('documents');
	$res = $model->getdelete($post);
	parent::display();
	}
	
	function open(){

	$model = $this->getModel('documents');
	$open = $model->getopen($post);
	parent::display();
	
	}
	function managers(){
	$model = $this->getModel('documents');
	$open = $model->getmanagers($post);
	parent::display();
	}
	//function to go for Camassistant Control Panel(Prasad 12 Jan 11)
	function lists()
	{
		// Panel 
		$this->setRedirect( 'index.php?option=com_camassistant&controller=camassistant' );
	}
	function back()
	{
		// Back 
		echo '<script language="javascript">alert("")history.go(-1);</script>';
	}
////////////////////////////////////////Shared docs Completed////////////////////////////////////

//function to delete files 


function deletefiles(){

$propertyid = JRequest::getVar( 'propertyid','' );	
$name = JRequest::getVar( 'name','' );	
$documentid = JRequest::getVar( 'id','' );	
$path = JRequest::getVar( 'path','' );	
$filepath = JPATH_SITE."/".$path.'/'.$name ;
$deletefile_s = unlink($filepath);
if($deletefile_s){
	$db =& JFactory::getDBO();
	$query = "DELETE FROM #__cam_propertydocs  WHERE id =".$documentid." AND property_id=".$propertyid." AND docTitle='".$name."' ";  
	$db->setQuery($query);
	$result = $db->query();
	if($result) {
	echo "success";
	}
}
else{
echo "failed";
}
exit;
}

function deletesecond(){

$mid = JRequest::getVar( 'mid','' );	
$name = JRequest::getVar( 'name','' );	
$path = JRequest::getVar( 'path','' );	
$filepath = JPATH_SITE."/".$path.'/'.$name ;
$deletefile_s = unlink($filepath);

if($deletefile_s){
	$db =& JFactory::getDBO();
	$query = "DELETE FROM #__cam_propertydocs  WHERE property_manager_id=".$mid." AND docTitle='".$name."' ";  
	$db->setQuery($query);
	$result = $db->query();
	if($result) {
	echo "success";
	}
}
else{
	echo "failed";
}
exit;
}

function viewbasicfile(){	
		$db =& JFactory::getDBO();
		$filename = JRequest::getVar('filename','');
		$path = JRequest::getVar('filepath','');
		$rfpid = JRequest::getVar('rfpid','');
		$user = JFactory::getUser();
		
		// To  get property name ansd tax id
			$query_pinfo = "SELECT u.property_id, v.property_name, v.tax_id, u.cust_id FROM #__cam_property as v, #__cam_rfpinfo as u WHERE u.id=".$rfpid." and u.property_id=v.id ";
			$db->setQuery($query_pinfo);
			$pinfo = $db->loadObject();
			$prop_path = str_replace(' ','_',$pinfo->property_name).'_'.$pinfo->tax_id ;
		//Completed
		if($user->user_type == '11'){
			$useridmain = $pinfo->cust_id ;
		}
		else{
			$useridmain = $user->id ;
		}
		// To get manager tax id
			$taxinfo = "SELECT camfirm_license_no, comp_name FROM #__cam_customer_companyinfo WHERE cust_id=".$useridmain." ";
			$db->setQuery($taxinfo);
			$userdata = $db->loadObject();
		//Completed	
		
		$pos = strpos($path, $userdata->camfirm_license_no);
		
		if ($pos == true) {
			$path = "components/com_camassistant/doc/".$path;
		}
		else{
			$path = "components/com_camassistant/doc/".$prop_path."/".$path;		
		}
		
		$path = JURI::root().$path; 
		$doc_name = $path;
		
		header("content-type: application/octet-stream");		
		header("Content-Disposition: attachment; filename=".$filename);
		readfile($doc_name);
		exit;
	}	

}
?>