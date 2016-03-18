<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
?>
<script type="text/javascript">
function validate()
{
var x=document.forms["folderform"]["sdocTitle"].value;
/*var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
for (var i = 0; i < x.length; i++) {
    if (iChars.indexOf(x.charAt(i)) != -1) {
    alert ("You are not allowed to create the folders containing "+iChars+".");
    return false;
        }
    }*/

if (x==null || x=="")
  {
  alert("Please enter the folder name");
  return false;
  }
} 
</script>

<div id="container_inner"  style=" padding-top:40px;">
<form action="" method="post" name="folderform" onsubmit="return validate()">
<table cellpadding="0" cellspacing="0">
<tr>
<td>Folder Name:</td>
<td width="50"></td>
<td><input type="text" value="" name="sdocTitle" /></td>
</tr>
<tr height="20"></tr>
<tr>
<td></td>
<td width="100"></td>
<td>

<input type="image" src="templates/camassistant_inner/images/submit.png" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="documents" />
<?php if($_REQUEST['type'] == 'shared'){ ?>
<input type="hidden" name="task" value="sharedfiles" />
<input type="hidden" name="type" value="<?php echo $_REQUEST['type']; ?>" />
<input type="hidden" name="spath" value="<?php echo $_REQUEST['spath'].$_REQUEST['propertyname']; ?>" />
<?php } else{?>
<input type="hidden" name="task" value="ssavefolder" />
<input type="hidden" name="spath" value="<?php echo $_REQUEST['spath']; ?>" />
<?php } ?>
<input type="hidden" name="parent" value="<?php echo $_REQUEST['parentid']; ?>" />
<input type="hidden" name="spid" value="<?php echo $_REQUEST['spid']; ?>" />
<input type="hidden" name="smid" value="<?php echo $_REQUEST['smid']; ?>" />


</td>
</tr>

</table>

</form>
<?php exit; ?>
<div class="clear"></div>
</div>
