<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
?>
<script type="text/javascript">
function validate()
{

var x=document.forms["folderform"]["file"].value ;
var filext = x.substring(x.lastIndexOf(".")+1);
if(filext=='gif' || filext=='jpg' || filext=='png' || filext=='doc' || filext=='PNG' || filext=='JPG' || filext=='JPEG' || filext=='BMP' || filext=='psd' || filext=='bmp' || filext=='GIF' || filext=='doc' || filext=='docx' || filext=='pdf' || filext=='jpeg' || filext=='rtf' || filext=='xls' || filext=='ppt' || filext=='xlsx' || filext=='docx' || filext=='pptx'){
}
else{
alert("This file type cannot be uploaded");
return false;
}

if (x==null || x=="")
  {
  alert("Please upload the file");
  return false;
  }
} 
</script>

<div id="container_inner" align="center"  style=" padding-top:33px;">
<table cellpadding="0" cellspacing="0">
<tr class="table_blue_row"><td><font color="#79B700">Available file extensions to upload</font>	</td></tr>
<tr><td>
<?php $j=0;
for ($i=0; $i<count($this->efiles); $i++){
$efiles = $this->efiles[$i]; 
$filetypes=explode(',',$efiles->files);
foreach($filetypes as $type){
echo '<span style="float:left; width:50px; font-weight:bold; color:#21314D;">'.$type."</span>";
if(($j/5)=='1'){
echo"</br>";
}
$j++;
}
}
?></td></tr><tr height="30"></tr></table>
<form action="" method="post" name="folderform" enctype="multipart/form-data" onsubmit="return validate()">
<table cellpadding="0" cellspacing="0">
<tr>
<td><b>Select File Path:
</b></td>
<td style="padding-left:20px;"><input type="file" name="file" value="" /></td>
</tr>
<tr height="20"></tr>
<tr>
<td></td>
<td align="right">

<input type="image" src="images/submit_folder.png" />
<!--<input type="button" value="Submit" onclick="javascript: closepopup();">-->
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="documents" />
<?php if($_REQUEST['type'] == 'shared'){ ?>
<input type="hidden" name="task" value="sharingfiles" />
<input type="hidden" name="type" value="<?php echo $_REQUEST['type']; ?>" />
<input type="hidden" name="spath" value="<?php echo $_REQUEST['spath'].$_REQUEST['propertyname']; ?>" />
<?php } else{?>
<input type="hidden" name="task" value="ssavefile" />
<input type="hidden" name="spath" value="<?php echo $_REQUEST['spath']; ?>" />
<?php } ?>
<input type="hidden" name="spid" value="<?php echo $_REQUEST['spid']; ?>" />
<input type="hidden" name="smid" value="<?php echo $_REQUEST['smid']; ?>" />
<input type="hidden" name="parentid" value="<?php echo $_REQUEST['parentid']; ?>" />
<input type="hidden" name="propertyname" value="<?php echo $_REQUEST['propertyname']; ?>" />
</td>
</tr>

</table>
</form>
<?php exit; ?>
<div class="clear"></div>
</div>