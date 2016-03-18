<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
?>
<link href="<?php JPATH_SITE ?>templates/camassistant_left/css/style.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>

<script type="text/javascript">
H = jQuery.noConflict();
function validate()
{
var x= document.forms["folderform"]["image"].value;
x = x.replace("C:\\fakepath\\", "");
var filext = x.substring(x.lastIndexOf(".")+1);

var fup = document.getElementById('uploadfile');
var fileName = fup.value;
var filext = fileName.substring(fileName.lastIndexOf('.') + 1);

if(fileName){
var filesize = document.getElementById('uploadfile_origin');
var file_size = filesize.files[0].size;
}
if(fileName != '')
    {
		if(filext=='gif' || filext=='jpg' || filext=='JPG' || filext=='png' || filext=='PNG' || filext=='GIF' || filext=='jpeg' || filext=='JPEG'){
			if(file_size > '5000000')
					{
						window.parent.document.getElementById( 'sbox-window' ).close();
						window.parent.parent.getalert();
						return false;
					}
				else{
					document.forms["folderform"].submit();
				}	
		}
		else{
			alert("This file type cannot be uploaded");
			return false;
		}
	}	
else{
alert("This file type cannot be uploaded");
return false;
}

var node = document.getElementById('image');
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

function getreplaceimage(filenames){
var fileName = filenames.replace("C:\\fakepath\\", "");
document.getElementById('uploadfile').value = fileName;
}

</script>

<script type="text/javascript">
L = jQuery.noConflict();
L(document).ready( function(){      
	L(function()
    {
        L('#fileUpload').on('change',function ()
        {
            var filePath = L(this).val();
			var clean=filePath.split('\\').pop();
            console.log(clean);
			len = clean.length ;
			if(len > 25){
				textsend = clean.substring(0,25);
				textsend = textsend + '...' ;
				L('input[type="file"]').width('82');
				L('#file_val').html(textsend);

			}else{
			   L('input[type="file"]').width('82');
               L('#file_val').html(filePath);
			}
			

        });
    });
	
});
</script>
<div id="container_inner" style="padding-top:20px; min-height:0px;" align="center">
<table cellpadding="0" cellspacing="0" align="center">
<tr class="table_blue_row" style="text-align:center; background:none;"><td><font style="font-weight:bold;font-size:15px; font-family: arial; line-height:28px;" color=" #4d4d4d">UPLOAD YOUR COMPANY LOGO</font>	</td></tr>
<tr style="text-align:center;"><td>
<?php 
//$type = 'gif, jpg, JPG, png, PNG, gif, GIF, jpeg, JPEG';
$type = 'gif, jpg, JPG, png, PNG, gif, GIF, jpeg, JPEG, pdf, PDF';
echo '<div style="color:#4d4d4d; font-family: arial; font-size:13px; line-height:19px;">Note: Logo will appear on Proposal Reports and your Profile<br/>Compatible File Types: <span style="font-weight:bold; color: #4d4d4d;">gif - jpg - png</span></div>';
echo"</br>";
?></td></tr><tr height="30"></tr></table>

<form action="" method="post" name="folderform" enctype="multipart/form-data" onsubmit="return validate()">
<table cellpadding="0" cellspacing="0" align="center">
<tr style="text-align:right;">
<td align="center"><!--<input type="file" name="image" value="" id="fileUpload" /><span id="file_val"> </span>-->
<table style="width: 149px;"><tbody><tr><td width="150">
<input type="text" id="uploadfile" class="file_input_textbox" readonly="readonly" style="vertical-align: top; margin-top:3px;">
</td>
<td>
<div style="float: left;width:93px;" class="file_input_div2">
<input type="button" class="file_input_button2" style="margin-top:2px; right:0; width:93px;">
<input title="Upload Document"  type="file" id="uploadfile_origin" onchange="javascript: getreplaceimage(this.value);" name="image" class="file_input_hidden">
</div>
</td></tr></tbody></table>
</td>
</tr>
<tr height="45"></tr>
<tr>
<td align="right">
<a href="javascript:pclose();"><img style="cursor:pointer;" src="components/com_camassistant/assets/images/CancelButton2.gif"></a>
<input type="image" src="components/com_camassistant/assets/images/Uplaod2.png" />
</td>

<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="vendors" />
<input type="hidden" name="task" value="savelogofile" />

</td>
</tr>
</table>
</form>
<div class="clear"></div>
</div>
<!--<tr><td colspan="2">NOTE: THIS LOGO/IMAGE WILL DISPLAY ON PROPOSAL REPORTS AS A REPRESENTATION OF YOUR COMPANY. </td></tr>-->
<?php exit; ?>