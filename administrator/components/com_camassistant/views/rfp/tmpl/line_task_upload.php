<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php JPATH_SITE ?>components/com_camassistant/editor/ed.js"></script>
<script type="text/javascript">
function fun(){
document.mailform.submit();
window.parent.document.getElementById( 'sbox-window' ).close(); 
}
</script>


<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
<div style="width:600px;">
<div style="width:295px; float:left; border-right:2px solid #6FAD00;border-bottom:3px solid #6FAD00;" >
<div class="head_greenbg2" >Upload file</div>

<div id="container_inner"  style=" padding-top:10px;">
<form action="" method="post" name="folderform" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="0" style="padding-left:30px;" >
<tr>
<td>Select File Path:</td>
</tr>
<tr>
<td  height="35" valign="middle"><input type="file" name="file" value="" /></td>
</tr>
<tr>
<td align="right"><input type="submit" value="Submit"  /></td></tr>
<!--<input type="button" value="Submit" onclick="javascript: closepopup();">-->

<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="documents" />
<input type="hidden" name="task" value="ssavefile" />
<input type="hidden" name="spid" value="7" />
<input type="hidden" name="smid" value="143" />
<input type="hidden" name="spath" value="components/com_camassistant/doc/" />
<input type="hidden" name="parentid" value="0" />
</td>
</tr>

</table>
</form>
</div>
</div>
<div style="width:301px; float:right; border-left:2px solid #6FAD00;border-bottom:3px solid #6FAD00;" >
<div class="head_greenbg2">Select The File Document Center</div>
<table width="100%" cellpadding="0" cellspacing="4">
  <tr class="table_green_row">
    <td width="62" align="center" valign="top">SELECT</td>
    <td width="456" align="left" valign="top">Name</td>
    <td width="141" align="center" valign="top">options</td>
    </tr>
  
  <?php 
  if(count($this->pfiles)){
//  print_r($this->pfiles);
for ($i=0; $i<count($this->pfiles); $i++){
$pfiles = $this->pfiles[$i]; 

$file = substr($pfiles->docTitle,-4,-3);
if($file!='.') {

?>
<tr class="table_blue_rowdots2">
    <td align="center" valign="bottom"><img src="images/folder_icon.png"  alt="folder" /></td>
    <td align="left" valign="middle"><?php print_r($pfiles->docTitle); ?>
</td>
<td>
<a href="index.php?option=com_camassistant&controller=documents&task=openfiles&pid=<?php print_r($pfiles->property_id); ?>&mid=<?php print_r($pfiles->property_manager_id); ?>&path=<?php print_r($pfiles->docPath); ?>">OPEN</a>

</td>
</tr>
<?php } } 


for ($i=0; $i<count($this->pfiles); $i++){
$pfiles = $this->pfiles[$i]; 

$file = substr($pfiles->docTitle,-4,-3);
if($file=='.') {

?>
<tr class="table_blue_rowdots2">
    <td align="center" valign="bottom"><img src="images/folder_icon.png"  alt="folder" /></td>
    <td align="left" valign="middle"><?php print_r($pfiles->docTitle); ?>
</td>
<!--<td><a href="<?php //print_r($pfiles->docPath);?>">OPEN</a></td>-->
<td><a href="index.php?option=com_camassistant&controller=documents&task=open&title=<?php print_r($pfiles->docTitle); ?>&path=<?php print_r($pfiles->docPath); ?> ">OPEN</a></td>


	

</tr>
<?php } } 
}
 else { ?>
<tr class="table_blue_rowdots2">
    <td align="center" valign="bottom"><img src="images/folder_icon.png"  alt="folder" /></td>
    <td align="left" valign="middle"><?php echo "No files in this folder"; ?></td>
</tr>
<?php } ?>
 <tr class="table_blue_rowdots2">
   <td align="center" valign="bottom">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   </tr>

</table></div>





</form>



</div>