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
$warranty = JRequest::getVar('warranty','');
$taskid = JRequest::getVar('taskid','');
?>
<script type="text/javascript">
function validate_data2()
{
var frm = document.Addnotesform;
var fup = document.getElementById('uploadfile');
var fileName = fup.value;

var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	 if(fileName != '')
    {
	 if(ext != 'png' && ext != 'PNG' && ext != 'jpg' && ext != 'JPG' && ext != 'gif' && ext != 'GIF' && ext !='jpeg' && ext != 'JPEG' && ext != 'pdf' && ext != 'PDF' && ext != 'doc' && ext != 'DOC' && ext != 'rtf' && ext != 'RTF' && ext != 'xls' && ext != 'XLS' && ext != 'ppt' && ext != 'PPT' && ext != 'xlsx' && ext != 'XLSX' && ext != 'docx' && ext != 'DOCX' && ext != 'pptx' && ext != 'PPTX')
	  {
	  alert("Invalid file extension, please select another file");
	  return false;
	  }
	 }
	return;
}
</script>
<?PHP

// Your custom code here
//echo "<pre>"; print_r($_REQUEST); exit;
$rebid	= JRequest::getVar('rebid','');
$Alt_bid = JRequest::getVar('Alt_bid','');
$Alt_Prp = JRequest::getVar('Alt_Prp','');
$act = JRequest::getVar('act','');
if($Alt_bid != '')
$is_Alt =  $Alt_bid;
else
$is_Alt =  $Alt_Prp;
?>
<link href="<?php echo JURI::root(); ?>administrator/templates/khepri/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo JURI::root(); ?>administrator/components/com_camassistant/editor/ed.js"></script>
<br />
<div style="float: right;"><a href="javascript:history.go(-1)"><img alt="info" src="<?php echo JURI::root(); ?>templates/camassistant_left/images/back.png"></a></div>
<form style="padding:0px; margin:0px;" action="index.php?option=com_camassistant&controller=proposals&task=save_uploadfile&rfp_id=1&warranty=<?php echo $warranty; ?>&taskid=<?php echo $taskid; ?> <?php //echo $_REQUEST['rfp_id']; ?>" method="post" name="Addnotesform" enctype="multipart/form-data">
<table style="padding:40px" border="0">
<tr class="table_blue_row"><td colspan="2"><font color="#79B700">Available file extensions to upload</font>	</td></tr>
<tr><td colspan="2">png, jpg, gif, jpeg, pdf, doc, rtf, xls, ppt, xlsx, docx, pptx</td></tr>
<tr height="30px"></tr>
<tr><td>Select File Path: </td><td style="padding-left:10px"><input type="file" name="uploadfile" id="uploadfile" /></td></tr>
<tr height="10px"><td colspan="2"></td></tr>
<tr><td align="right" colspan="2" style= "padding-right:15px"><!--<input type="submit" value="Submit" /> --> <input type="image" src="<?php echo JURI::root(); ?>templates/camassistant_inner/images/submit.png"  onclick="javascript: return validate_data2();"/> </td></tr></table>
<?php echo JHTML::_( 'form.token' ); ?>

<input type="hidden" name="rfp_id" value="<?PHP echo $_REQUEST['rfp_id']; ?>" />
<input type="hidden" name="vendorid" value="<?PHP echo $_REQUEST['vendorid']; ?>" />
<input type="hidden" name="task_id" value="<?PHP echo $_REQUEST['taskid']; ?>" />
<input type="hidden" name="spl" value="<?PHP echo $_REQUEST['spl']; ?>" />
<input type="hidden" name="Alt_bid" value="<?PHP echo $is_Alt; ?>" />
<input type="hidden" name="rebid" value="<?PHP echo $rebid; ?>" />
<input type="hidden" name="act" value="<?PHP echo $act; ?>" />
<?php //echo '<pre>'; print_r($_REQUEST); ?>
</form>
<?php exit; ?>
</body>
</html>
 