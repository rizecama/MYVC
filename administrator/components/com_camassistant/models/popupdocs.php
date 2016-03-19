<?php
/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
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

jimport( 'joomla.application.component.model' );
class camassistantModelPopupdocs extends Jmodel
{
	function __construct(){
		parent::__construct();

	}
	function getProperty(){
        $property = array(); 
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
        $user_id = $user->get('id');
		$query = "SELECT id,property_name FROM #__cam_property where `property_manager_id` =".$user_id." and share=1";
		$db->setQuery($query);
        $properties=$db->loadObjectList();
		return $properties;
}
	function getShareproperty(){
        $shareproperty = array(); 
		$db =& JFactory::getDBO();
		$query = "SELECT id,property_name FROM #__cam_property where share = 0";
		$db->setQuery($query);
        $shareproperties=$db->loadObjectList();
		return $shareproperties;
}

}
class popupdocsModelpopupdocs extends Jmodel
{
function __construct()
	{
		parent::__construct();
 
        global $mainframe, $option;
 $db =& JFactory::getDBO();
 		$query = "SELECT pagecount FROM #__cam_filetype ";
		$db->setQuery($query);
        $count=$db->loadResult();
        // Get pagination request variables
       // $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	   	$limit=$count;
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 		 $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
  		
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
        // In case limit has been changed, adjust it
       // $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
///////no of fields per page//////////////////
		

///////no of fields per page//////////////////
       // $this->setState('limit', $count);
      //  $this->setState('limitstart', $limitstart);

		
	}
function getpdocs(){
        $pdocs = array(); 
		$db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        $user_id = $user->get('id');
		$query = "SELECT id,property_name,property_manager_id FROM #__cam_property where `property_manager_id` =".$user_id." and share=1"; 
		$db->setQuery($query);
        $pdocs=$db->loadObjectList();
		return $pdocs;
}
function getpfiles(){

        $pfiles = array(); 
		$db =& JFactory::getDBO();
		 $user =& JFactory::getUser();
        $user_id = $user->get('id');
		$query = "SELECT * FROM #__cam_propertydocs where parent=0 and `property_id` =".$_REQUEST['pid'];
		
		$db->setQuery($query);
        $pfiles=$db->loadObjectList();
		
		return $pfiles;
}

function getfileextensions(){
        $lfiles = array(); 
		$db =& JFactory::getDBO();
	$query = "SELECT files FROM #__cam_filetype";
	$db->setQuery($query);
    $lfiles=$db->loadObjectList();
		return $lfiles;
}


function store($data){
        // get the table
//		echo "<pre>"; print_r($data); exit;
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$row =& $this->getTable('propertydocs');
$row = JTable::getInstance('propertydocs','Table');


        // Bind the form fields to the invite table
        if (!$row->bind($data)) {
		
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
 
        // Make sure the hello record is valid
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
 
        // Store the web link table to the database
        if (!$row->store()) {

                $this->setError( $row->getErrorMsg() );
                return false;
        }
 
        return true;         

}
function store1($data){
//
        // get the table
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$row =& $this->getTable('pdocuments');
$row = JTable::getInstance('pdocuments','Table');


        // Bind the form fields to the invite table
        if (!$row->bind($data)) {
		
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
 
        // Make sure the hello record is valid
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
 
        // Store the web link table to the database
        if (!$row->store()) {

                $this->setError( $row->getErrorMsg() );
                return false;
        }
 
        return true;         

}

function store3($data){

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$row =& $this->getTable('propertydocs');
$row = JTable::getInstance('propertydocs','Table');
        if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->store()) {
                $this->setError($row->getErrorMsg());
                return false;
        }
        return true;
}
function getcategories(){
    $cats = array();
	$db =& JFactory::getDBO();
    $user =& JFactory::getUser();
    $user_id = $user->get('id');
	$query = "SELECT id,property_name FROM #__cam_property where `property_manager_id`=".$user_id." and `show`=1 and `share`=1 ";
	$db->setQuery($query);
    $cats=$db->loadObjectList();
	return $cats;
}
function getopenfiles($path){
/*$path=JPATH_SITE.DS.$path;
$path='D:\wamp\www\camassistant_new\components\com_camassistant\doc\Test1_56-5645645\prasad23';*/

$path = JPATH_SITE."/".$path;
$dir=dir($path);
while($filename=$dir->read()) {
if($filename!='.'&&$filename!='..')
{
if(strpos($filename,"."))
$data['files'][]=$filename;
else
$data['folders'][]= $filename;
}
}
$dir->close();

return $data;
}

function getcheck(){
	$db =& JFactory::getDBO();
	$query = "SELECT files FROM #__cam_filetype";
	$db->setQuery($query);
    $files=$db->loadResult();
	$sfiles = split(',', $files);
	$ext = explode('.', $_FILES['file']['name']);
$ext[1] =  strtolower($ext[1]);
if (in_array($ext[1],$sfiles))
  {
 return true;
  }
else
  { 
echo "Sorry!  The file type you attempted to upload is not allowed.  Please try again and note the allowed file types and extensions.<br>
If you continue to have problems or need help, please contact the CAMassistant Customer Support Team at 561-246-3830.";
  
//  exit;
  }
}

function getopen(){
//echo "<pre>"; print_r($_REQUEST); exit;
 		$filename = JRequest::getVar('title',''); 
		$path = JRequest::getVar('path',''); 
		if($filename == ''){
		$filename = JRequest::getVar('propertyname',''); 
		}
		if($filename == ''){
		$filename = JRequest::getVar('doc_title',''); 
		}
		if($filename){
		$arr = explode("/", $filename);
		} else {
		$arr = explode("/", $path);
		}
		$first = $arr[count($arr)-1];
		$foldername = JRequest::getVar('folder_name',''); 
		$path = JRequest::getVar('path','');
		if($path == '')	{
		$path = JRequest::getVar('spath','');
		}
		$path = JURI::root().$path; 
		$path = str_replace($filename,'',$path);
		$last = substr($path, -1);
		if($last == '/'){
		$doc_name = $path.$filename;
		}
		else{
		if($filename){
		$doc_name = $path."/".$filename;
		} else {
		$doc_name = $path;
		}
		}
		
		//print_r($doc_name); exit;
		header("content-type: application/octet-stream");		
		header("Content-Disposition: attachment; filename=".$first);
		readfile($doc_name);
		exit;


}
/////////////////////////////////////////////For shared documents///////////////////////////////
	function getcamfirmid(){
        $pfiles = array(); 
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
        $user_id = $user->get('id');
		
		$query = "SELECT camfirm_license_no,comp_name FROM #__cam_customer_companyinfo WHERE cust_id=".$user_id;
		$db->setQuery($query);
		$camfirmid = $db->loadObjectList();
		return $camfirmid;
	
	}

function _buildQuery()
	{
		 $sdocs = array(); 
		 $db =& JFactory::getDBO();
		 $user =& JFactory::getUser();
		 $usertype = $user->user_type;
         $user_id = $user->get('id');
		 
		 $query = "SELECT id FROM #__cam_camfirminfo WHERE cust_id=".$user_id;
		 $db->setQuery($query);
		 $id = $db->loadResult();
		 
		 $query = "SELECT cust_id FROM #__cam_customer_companyinfo WHERE comp_id=".$id;
	 	 $db->setQuery($query);
		 $custmors = $db->loadObjectList();
		 //echo "<pre>"; print_r($custmors); exit;
		 
		 if($usertype == 13){
		 $query = "SELECT property_id,sdocTitle,property_manager_id,parent_manager FROM #__cam_propertydocs where parent=0 AND (`property_manager_id` =".$user_id." OR parent_manager=".$user_id.") and type='shared'";
		 }
		 else{
		 $query = "SELECT property_id,sdocTitle,property_manager_id FROM #__cam_propertydocs where parent=0 AND `property_manager_id` =".$user_id." and type='shared'";
		 }
		
		 return $query;
	}
function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');

$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );

}

		return $this->_pagination;
	}
  
	function getTotal()
	{
		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	function getData()
	{

		//DEVNOTE: Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			 $query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
}
	function _buildContentOrderBy()
	{
			global $mainframe, $context;

	 $filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order',  'hotelname' );

		if(empty($filter_order))
		{
		$filter_order = 'hotelname';
		}
		else
		{
		$filter_order = $filter_order;
		}
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir','');		
		//DEVNOTE: all countries are in the same category(no category)  

		    $orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;
		return $orderby;

	}

function getsfiles(){
        $sfiles = array(); 
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
        $user_id = $user->get('id');

		$query = "SELECT * FROM #__cam_propertydocs where `parent`=0 and `property_manager_id` =".$user_id." and `property_id` =".$_REQUEST['spid'];
		$db->setQuery($query);
        $sfiles=$db->loadObjectList();
		return $sfiles;
}

function getscategories(){
        $acats = array(); 
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
        $user_id = $user->get('id');
		$query = "SELECT id,property_name FROM #__cam_property where `property_manager_id` =".$user_id." and `show`=1 and `share`=0 ";
		$db->setQuery($query);
        $scats=$db->loadObjectList();
		return $scats;
}

function sstore($data){
JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$row =& $this->getTable('propertydocs');
$row = JTable::getInstance('propertydocs','Table');
        if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->store()) {
                $this->setError( $row->getErrorMsg() );
                return false;
        }
        return true;
}
function sstore3($data){

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
$row =& $this->getTable('propertydocs');
$row = JTable::getInstance('propertydocs','Table');
        if (!$row->bind($data)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->check()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }
        if (!$row->store()) {
                $this->setError($row->getErrorMsg());
                return false;
        }
        return true;
}
function getsopenfiles($spath){
$spath = JPATH_SITE.'/'.$spath;
$sdir=dir($spath);

while($filename=$sdir->read()) {
if($filename!='.'&&$filename!='..')
{
if(strpos($filename,"."))
$data['files'][]=$filename;
else
$data['folders'][]= $filename;
}
}
$sdir->close();

return $data;
}

function getdelete(){

$spid = JRequest::getVar( 'spid','' );	
$title = JRequest::getVar( 'title','' );	
$smid = JRequest::getVar( 'smid','' );	
$spath = JRequest::getVar( 'spath','' );	
$db =& JFactory::getDBO();

		 $user =& JFactory::getUser();
        $usertype = $user->get('user_type');
//print_r($usertype); exit;
if($usertype == '16'){
		$query = "DELETE FROM #__cam_propertydocs  WHERE property_manager_id =".$smid." AND property_id=".$spid." AND sdocTitle='".$title."'";  
$db->setQuery($query);
$result = $db->query();
if($result){
$path = $spath;


        if (!$path) {
                // Bad programmer! Bad Bad programmer!
                JError::raiseWarning(500, 'JFolder::delete: ' . JText::_('Attempt to delete base directory') );
                return false;
        }
 
        // Initialize variables
        jimport('joomla.client.helper');
        $ftpOptions = JClientHelper::getCredentials('ftp');
 
        // Check to make sure the path valid and clean
        $path = JPath::clean($path);
 
        // Is this really a folder?
        if (!is_dir($path)) {
                JError::raiseWarning(21, 'JFolder::delete: ' . JText::_('Path is not a folder'), 'Path: ' . $path);
                return false;
        }
 
        // Remove all the files in folder if they exist
        $files = JFolder::files($path, '.', false, true, array());
        if (!empty($files)) {
                jimport('joomla.filesystem.file');
                if (JFile::delete($files) !== true) {
                        // JFile::delete throws an error
                        return false;
                }
        }
 
        // Remove sub-folders of folder
        $folders = JFolder::folders($path, '.', false, true, array());
        foreach ($folders as $folder) {
                if (is_link($folder)) {
                        // Don't descend into linked directories, just delete the link.
                        jimport('joomla.filesystem.file');
                        if (JFile::delete($folder) !== true) {
                                // JFile::delete throws an error
                                return false;
                        }
                } elseif (JFolder::delete($folder) !== true) {
                        // JFolder::delete throws an error
                        return false;
                }
        }
 
        if ($ftpOptions['enabled'] == 1) {
                // Connect the FTP client
                jimport('joomla.client.ftp');
                $ftp = &JFTP::getInstance(
                        $ftpOptions['host'], $ftpOptions['port'], null,
                        $ftpOptions['user'], $ftpOptions['pass']
                );
        }
 
        // In case of restricted permissions we zap it one way or the other
        // as long as the owner is either the webserver or the ftp
        if (@rmdir($path)) {
                $ret = true;
        } elseif ($ftpOptions['enabled'] == 1) {
                // Translate path and delete
                $path = JPath::clean(str_replace(JPATH_ROOT, $ftpOptions['root'], $path), '/');
                // FTP connector throws an error
                $ret = $ftp->delete($path);
        } else {
                JError::raiseWarning(
                        'SOME_ERROR_CODE',
                        'JFolder::delete: ' . JText::_('Could not delete folder'),
                        'Path: ' . $path
                );
                $ret = false;
        }
//        return $ret;

/*jimport('joomla.filesystem.file');
$files = JFolder::files( $dir_delete, '.', true, true );
				foreach( $files as $file )
	$result = 	JFile::delete( $file );
*/

   if ($ret) {
         echo "Directory deleted successfully.", "\n";
   }else {
        echo "Could not delete the directory.", "\n";
   }   }
}
else {
echo "You have no permission to delete the files"; 

 }


}
function getdeletefile(){
 // Initialize variables
 
$spid = JRequest::getVar( 'spid','' );	
$title = JRequest::getVar( 'title','' );	
$smid = JRequest::getVar( 'smid','' );	
echo $file = JRequest::getVar( 'spath','' );	
$db =& JFactory::getDBO();

        jimport('joomla.client.helper');
        $FTPOptions = JClientHelper::getCredentials('ftp');
 
        if (is_array($file)) {
                $files = $file;
        } else {
                $files[] = $file;
        }
 
        // Do NOT use ftp if it is not enabled
        if ($FTPOptions['enabled'] == 1)
        {
                // Connect the FTP client
                jimport('joomla.client.ftp');
                $ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);
        }
 
        foreach ($files as $file)
        {
                $file = JPath::clean($file);
 
                // Try making the file writeable first. If it's read-only, it can't be deleted
                // on Windows, even if the parent folder is writeable
                @chmod($file, 0777);
 
                // In case of restricted permissions we zap it one way or the other
                // as long as the owner is either the webserver or the ftp
                if (@unlink($file)) {
                        // Do nothing
                } elseif ($FTPOptions['enabled'] == 1) {
                        $file = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $file), '/');
                        if (!$ftp->delete($file)) {
                                // FTP connector throws an error
                                return false;
                        }
                } else {
                        $filename       = basename($file);
                        JError::raiseWarning('SOME_ERROR_CODE', JText::_('Delete failed') . ": '$filename'");
                        return false;
                }
        }
 
        return true;


}


/////////////////////////////////////////////Shared documents Completed ///////////////////////////////
}
?>