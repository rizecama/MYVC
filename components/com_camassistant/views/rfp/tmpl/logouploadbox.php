<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>

<script type="text/javascript">
H = jQuery.noConflict();
function validate()
{
var x= document.forms["folderform"]["property_image"].value;
x = x.replace("C:\\fakepath\\", "");
var filext = x.substring(x.lastIndexOf(".")+1);
if(filext=='gif' || filext=='jpg' || filext=='JPG' || filext=='png' || filext=='PNG' || filext=='GIF' || filext=='jpeg' || filext=='JPEG'){
document.forms["folderform"].submit();
//window.parent.document.getElementById( 'sbox-window' ).close();
return false;
}
else{
alert("This file type cannot be uploaded");
return false;
}

var node = document.getElementById('property_image');
var check = node.files[0].fileSize;
if (x==null || x=="")
  {
  alert("Please upload the file");
  return false;
  }
} 
function pclose(){
window.parent.document.getElementById( 'sbox-window' ).close();
}
</script>
<div id="container_inner" style="padding-left:75px; padding-top:53px">
<table cellpadding="0" cellspacing="0">
<tr class="table_blue_row" style="text-align:center;"><td>
<font style="font-weight:bold;font-size:15px; font-family: arial; line-height:28px; margin-left:26px;" color=" #4d4d4d">UPLOAD YOUR PROPERTY PICTURE</font>	</td></tr>
<tr height="30"></tr></table>

<form action="" method="post" name="folderform" enctype="multipart/form-data" onsubmit="return validate()">
<table cellpadding="0" cellspacing="0">
<tr style="text-align:right;">
<td style="padding-left:10px"><input type="file" name="property_image" value="" /></td>
</tr>
<tr height="40"></tr>
<tr>
<td align="right">
<a href="javascript:pclose();"><img style="cursor:pointer;" src="components/com_camassistant/assets/images/CancelButton2.gif"></a>
<input type="image" src="components/com_camassistant/assets/images/Uplaod2.png" />
</td>

<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="savepropertyfile" />

</td>
</tr>
</table>
</form>
<div class="clear"></div>
</div>
<!--<tr><td colspan="2">NOTE: THIS LOGO/IMAGE WILL DISPLAY ON PROPOSAL REPORTS AS A REPRESENTATION OF YOUR COMPANY. </td></tr>-->
<?php exit; ?>