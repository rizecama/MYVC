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
$ext = pathinfo($_REQUEST['file'], PATHINFO_EXTENSION);
$file = JRequest::getVar('file','');
$doc = JRequest::getVar('doc','');
$vendorid = JRequest::getVar('vendorid','');
?>
<div id="wrappermarket">
  <p style="height:13px;"></p>
<div style="margin: 4px 0px 0px -3px; text-align: center;" class="2GLI">
   <a onclick="goBack()" class="viewbuttons" href="#">CLOSE</a>
   <a style="background:none" class="viewbuttons" href="index.php?option=com_camassistant&controller=vendors&task=openrefdocs&filename=<?php echo $_REQUEST['file']; ?>&vendorid=<?php echo $vendorid; ?>">DOWNLOAD</a>
  </div>
  <p style="height:29px;"></p>
  <div id="vender_rightmarket">

<?php if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'PNG' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'bmp' || $ext == 'BMP' || $ext == 'gif' || $ext == 'GIF' ){   ?>
<img style="text-align:center; width:800px;" src="<?php echo $doc; ?>" />
<?php } 
 else if($ext == 'pdf') {
  ?>
<iframe src="<?php echo Juri::root(); ?><?php echo $doc; ?>?docId=456#toolbar=0" style="width:800px; height:1000px;" frameborder="0"></iframe>
<?php } 
 else if($ext == 'doc' || $ext == 'docx' || $ext == 'xls') {
?>
<iframe src="http://docs.google.com/viewer?url=<?php echo Juri::root(); ?><?php echo $doc; ?>&embedded=true" width="800" height="1000" style="border: none;"></iframe>
<?php } 
else { ?>
<iframe src="http://docs.google.com/viewer?url=<?php echo $path; ?>&embedded=true" width="800" height="1000" style="border: none;"></iframe>
<?php } ?>
</div>
</div>
<?PHP

exit;
?>