<title>MyVendorCenter.com</title>
<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
function goBack()
  {
  window.close();
  }
</script>
<?php
$db = JFactory::getDBO();
$user	= JFactory::getUser();
$id = JRequest::getVar('id','');
if($id){
$user	= JFactory::getUser($id);
$task = 'view_upld_cert_vendorprofile';
}
else{
$user->id = $user->id ;
$task = 'view_upld_cert';
}
$ext = pathinfo($_REQUEST['file'], PATHINFO_EXTENSION);
$file = JRequest::getVar('file','');
$doc = JRequest::getVar('doc','');
		$sql = "SELECT tax_id FROM #__cam_vendor_company   WHERE user_id=".$user->id;
		$db->setQuery($sql);
		$tax_id = $db->loadResult();
		$vendorname = $user->name.'_'.$user->lastname.'_'.$tax_id;
		$vendorname = str_replace(' ','_',$vendorname);
		$path = JURI::root().'components/com_camassistant/assets/images/vendorcompliances/'.$vendorname.'/'.$doc.'/'.$file;
		
?>
<div id="wrappermarket">
  <p style="height:13px;"></p>
<div style="margin: 4px 0px 0px -3px; text-align: center;" class="2GLI">
   <a onclick="goBack()" class="viewbuttons" href="#">CLOSE</a>
   
   <a style="background:none" class="viewbuttons" href="index.php?option=com_camassistant&controller=vendors&task=<?php echo $task; ?>&doc=<?PHP echo $doc; ?>&filename=<?PHP echo $file; ?>&id=<?php echo $user->id; ?>">DOWNLOAD</a>
  </div>
  <p style="height:29px;"></p>
  <div id="vender_rightmarket">

<?php 
if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'PNG' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'bmp' || $ext == 'BMP' || $ext == 'gif' || $ext == 'GIF'){   ?>
<img style="text-align:center; width:800px;" src="<?php echo $path; ?>" />
<?php } 
 else if($ext == 'pdf') {
 echo "can";
  ?>
<iframe src="<?php echo $path; ?>?docId=456#toolbar=0" style="width:800px; height:1000px;" frameborder="0"></iframe>
<?php } 
 else if($ext == 'doc' || $ext == 'docx' || $ext == 'xls') {
?>
<iframe src="http://docs.google.com/viewer?url=<?php echo $path; ?>&embedded=true" width="800" height="1000" style="border: none;"></iframe>
<?php } 
else { ?>
<iframe src="http://docs.google.com/viewer?url=<?php echo $path; ?>&embedded=true" width="800" height="1000" style="border: none;"></iframe>
<?php } ?>
</div>
</div>
<?PHP

exit;
?>