<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
//echo "this is default-3 file";
?>
<script type="text/javascript">
function validate()
{
var x=document.forms["folderform"]["docTitle"].value;
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
   else{
      window.parent.document.getElementById( 'sbox-window' ).close();
      document.forms["folderform"].submit();
  }
 
} 
</script>

<div id="container_inner"  style=" padding-top:40px;">
<form action="" method="post" name="folderform" onsubmit="return validate()">
<table cellpadding="0" cellspacing="0">
<tr>
<td>Folder Name:</td>
<td width="50"></td>
<td><input type="text" value="" name="docTitle" /></td>
</tr>
<tr height="20"></tr>
<tr>
<td></td>
<td width="100"></td>
<td>

<input type="image" src="templates/camassistant_inner/images/submit.png" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="documents" />
<input type="hidden" name="task" value="savefolder" />
<input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']; ?>" />
<input type="hidden" name="mid" value="<?php echo $_REQUEST['mid']; ?>" />
<input type="hidden" name="path" value="<?php echo $_REQUEST['path']; ?>" />
<input type="hidden" name="parentid" value="<?php echo $_REQUEST['parentid']; ?>" />
<input type="hidden" name="propertyname" value="<?php echo $_REQUEST['propertyname']; ?>" />

</td>
</tr>

</table>

</form>
<?php exit; ?>
<div class="clear"></div>
</div>