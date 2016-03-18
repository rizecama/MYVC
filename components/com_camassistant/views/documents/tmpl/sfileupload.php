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
var path= document.forms["folderform"]["spath"].value;
var x=document.forms["folderform"]["file"].value ;
x = x.replace("C:\\fakepath\\", "");
var filext = x.substring(x.lastIndexOf(".")+1);

var fileName = document.forms["folderform"]["spath"].value;
//var filext = fileName.substring(fileName.lastIndexOf('.') + 1);

if(fileName){
var filesize = document.getElementById('uploadfile_origin');
var file_size = filesize.files[0].size;
}


if(filext=='gif' || filext=='jpg' || filext=='JPG' || filext=='png' || filext=='PNG' || filext=='doc' || filext=='DOC' || filext=='psd' || filext=='PSD' || filext=='bmp' || filext=='BMP' || filext=='GIF' || filext=='docx' || filext=='DOCX' || filext=='pdf' || filext=='PDF' || filext=='jpeg' || filext=='JPEG' || filext=='rtf' || filext=='RTF' || filext=='xls' || filext=='XLX' || filext=='ppt' || filext=='PPT' || filext=='xlsx' || filext=='DOCX' || filext=='docx' || filext=='pptx' || filext=='PPTX'){


H.post("index2.php?option=com_camassistant&controller=documents&task=checkfile&mainpath="+path+"/", {uploadfile: ""+x+""}, function(data){
if(data == 'exists'){
var confirmb = confirm("Files already exists with that name.  Do you want to replace it?");
if(confirmb == true){
		if(file_size > '5000000'){
			window.parent.document.getElementById( 'sbox-window' ).close();
			window.parent.parent.getalert();
			return false;
		}
		else{
			document.getElementById("fileexists").value = data;
			document.forms["folderform"].submit();
			window.parent.document.getElementById( 'sbox-window' ).close();
		}
}
else{

}
}
else{
	if(file_size > '5000000'){
			window.parent.document.getElementById( 'sbox-window' ).close();
			window.parent.parent.getalert();
			return false;
	}
	else{
		document.getElementById("fileexists").value = '';
		document.forms["folderform"].submit();
		window.parent.document.getElementById( 'sbox-window' ).close();
	}	
}
});
return false;


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
<tr class="table_blue_row" style="text-align:center; background:none;"><td><font style="font-weight:bold;font-size:15px; font-family: arial; line-height:28px;" color=" #4d4d4d">Available file extensions to upload</font>	</td></tr>
<tr style="text-align:center;"><td>
<?php 
echo '<span style="color:#21314D; font-size:13px;">png, jpg, gif, jpeg, pdf, doc, rtf, xls, ppt, xlsx, docx, pptx, rtf';
/*for ($i=0; $i<count($this->efiles); $i++){
$efiles = $this->efiles[$i]; 
//echo $efiles->files;
$efiles = $this->efiles[$i]; 
$filetypes=explode(',',$efiles->files);
foreach($filetypes as $type){
echo '<span style="float:left; width:50px; font-weight:bold; color:#21314D; font-size:13px;">'.$type."</span>";
if(($j/5)=='1'){
echo"</br>";
}
$j++;
}
}*/
?>
</td></tr><tr height="30"></tr></table>
<form action="" method="post" name="folderform" enctype="multipart/form-data" onsubmit="return validate()">
<table cellpadding="0" cellspacing="0">
<tr style="text-align:right;">
<td align="center"><!--<input type="file" name="image" value="" id="fileUpload" /><span id="file_val"> </span>-->
<table style="width: 149px;"><tbody><tr><td width="150">
<input type="text" id="uploadfile" class="file_input_textbox" readonly="readonly" style="vertical-align: top; margin-top:3px;">
</td>
<td>
<div style="float: left;width:93px;" class="file_input_div2">
<input type="button" class="file_input_button2" style="margin-top:2px; right:0; width:93px;">
<input title="Upload Document"  type="file" id="uploadfile_origin" onchange="javascript: getreplaceimage(this.value);" name="file" class="file_input_hidden">
</div>
</td></tr></tbody></table>
</td>
</tr>
<tr height="20"></tr>

<tr>
<td align="right">
<a href="javascript:pclose();"><img style="cursor:pointer;" src="components/com_camassistant/assets/images/CancelButton2.gif"></a>
<input type="image" src="components/com_camassistant/assets/images/Uplaod2.png" />
</td>
</tr>


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
<input type="hidden" name="fileexists" value="" id="fileexists" />
</table>
</form>
<?php exit; ?>
<div class="clear"></div>
</div>
