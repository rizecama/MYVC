<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright � 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
?>
<script type="text/javascript">
function view() 
{
	var chk = document.getElementsByName('chk1[]'); 
	var j = 0;
	for(var i=0; i < chk.length; i++){
	if(chk[i].checked){
	j++;
	id =chk[i].value; 
	}
	}
	if(j==0 || j>1){
  alert("Please select one property");
	}
	else {

	window.location.href = 'index.php?option=com_camassistant&controller=addproperty&task=view&Itemid=<?php echo $_REQUEST['Itemid']; ?>&pid='+id;
	}
}

function reasign() 
{
	var chk = document.getElementsByName('chk1[]'); 
	var j = 0;
	for(var i=0; i < chk.length; i++){
	if(chk[i].checked){
	j++;
	id =chk[i].value; 
	}
	}
	if(j==0 || j>1){
  alert("Please select one property");
	}
	else {
	
	window.location.href = 'index.php?option=com_camassistant&controller=addproperty&task=reasign&Itemid=<?php echo $_REQUEST['Itemid']; ?>&pid='+id;
	
	}
}
function deleteproperty() 
{
	var chk = document.getElementsByName('chk1[]'); 
	var j = 0;
	for(var i=0; i < chk.length; i++){
	if(chk[i].checked){
	j++;
	id =chk[i].value; 
	}
	}
	if(j==0 || j>1){
  alert("Please select one property");
	}
	else {
	O = jQuery.noConflict();
		//alert('hi');
		var maskHeight = O(document).height();
		var maskWidth = O(window).width();
		O('#maska').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		O('#maska').fadeIn(100);	
		O('#maska').fadeTo("slow",0.8);	
	
		//Get the window height and width
		
		var winH = O(window).height();
		var winW = O(window).width();
	
		//Set the popup window to center
		O("#submita").css('top',  winH/2-o("#submita").height()/2);
		O("#submita").css('left', winW/2-o("#submita").width()/2);

		//transition effect
		O("#submita").fadeIn(2000);
		 
		 //alert( e.preventDefault);
		
	//});
		
	O('.windowa #closea').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		O('#maska').hide();
		O('.windowa').hide();
	});	
	//if done button is clicked
	O('.windowa #donea').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		O('#maska').hide();
		O('.windowa').hide();
		//document.signoutform.submit();
		//alert(id);
		window.location.href = 'index.php?option=com_camassistant&controller=addproperty&task=remove&Itemid=<?php echo $_REQUEST['Itemid']; ?>&pid='+id;
	});		
	
	
//});
	//window.location.href = 'index.php?option=com_camassistant&controller=addproperty&task=remove&Itemid=<?php echo $_REQUEST['Itemid']; ?>&pid='+id;
	}
}
function specific(val)
{
		window.location.href = 'index.php?option=com_camassistant&controller=addproperty&task=specific&Itemid=<?php echo $_REQUEST['Itemid']; ?>&cid='+val;

}

</script>
<style>
#maska {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxesa .windowa{
  position:absolute;
  left:0;
  top:0;
  width:450px;
  height:200px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxesa #submita {
   width:450px; 
  height:200px;
  padding:10px;
  background-color:#ffffff;
}
#donea {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
#closea {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
</style>
<?php
$user = JFactory::getUser();
if(!$user->id){
echo "<span class='blueheads'>You need to login to access this page</span>";
}
else {
$usertype = $user->user_type;
if($usertype == '11'){
echo "No permission";
} else {
?>

<div id="vender_right">

<!-- sof bedcrumb -->
<div id="bedcrumb">
<ul>
<li class="home"><a href="index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125">Home</a></li><li><a href="#">Add or Edit Property</a> </li>
</ul>
</div>
<!-- eof bedcrumb -->

<!-- sof dotshead -->
<div id="dotshead_blue">ADD OR EDIT A PROPERTY </div>
<!-- eof dotshead -->
<div id="i_bar">
<div id="i_bar_txt">
<?php if($usertype == '13'){  ?>

<form name="specificform" id="specificform" method="post" >
<select style="width: 276px;" name="cust" onchange="javascript:specific(this.value)">
<option value="0">Showing All</option>
<?php 
for ($i=0; $i<count($this->custmers); $i++){
$custmers = $this->custmers[$i];
?>
<option value="<?php echo $custmers->id; ?>" <?php if($_REQUEST['cid']==$custmers->id) echo "selected";?>><?php echo $custmers->lastname.",".$custmers->name; ?> </option>
<?php }echo "</select>"; } ?>
</form>


</div>
<div id="i_icon">
<?php  if ($user->user_type=='12') { ?>
<a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=59&amp;Itemid=113"><img src="templates/camassistant_left/images/info_icon2.png" /> </a>
<?php } else { ?>
<a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=79&amp;Itemid=113"><img src="templates/camassistant_left/images/info_icon2.png" /> </a>
<?php } ?>
</div>
</div>

<!-- sof table pan -->
<div class="table_pannel">
<div class="table_panneldiv">
<table width="100%" cellpadding="0" cellspacing="4">
  <tr class="table_green_row">
    <td width="62" align="center" valign="top">SELECT</td>
    <td width="167" align="center" valign="top">PROPERTY NAME</td>
    <td width="203" align="center" valign="top">ADDRESS</td>
    <td width="98" align="center" valign="top">CITY</td>
    <td width="123" align="center" valign="top">MANAGER</td>
  </tr>
  
  
  <?php 
for ($i=0; $i<count($this->properties); $i++){
$properties = $this->properties[$i];

//echo "<pre>"; print_r($properties);  
?>
<tr class="table_blue_rowdots">
    <td width="62" align="center" valign="top"><input type="checkbox" value='<?php echo $properties->id; ?>' name="chk1[]" id="chk1[]" /></td>
    <td align="left" valign="middle"><?php echo $properties->property_name?></td>
    <td align="left" valign="top"><?php echo $properties->street?></td>
    <td align="left" valign="top"><?php echo $properties->city?></td>
    <td align="center" valign="middle"><?php echo $properties->lastname.",&nbsp;".$properties->name;?></td>
  </tr>
 <?php
}
?>
<tr class="table_blue_rowdots">
   <td width="62" align="center" valign="top">&nbsp;</td>
   <td align="left" valign="middle">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   <td align="left" valign="top">&nbsp;</td>
   <td align="center" valign="middle">&nbsp;</td>
</tr>
<tfoot>
		<td colspan="9">
		<?php if($this->properties){ ?>
<?php if($_REQUEST['viewall']!='all'){ ?>
<a href="index.php?option=com_camassistant&controller=addproperty&viewall=all&Itemid=<?php echo $_REQUEST['Itemid'];?>" ><img src="templates/camassistant_left/images/view_all.gif" border="0"/></a>
<?php } ?>
<?php if ($_REQUEST['viewall']=='all') { ?>
<a href="index.php?option=com_camassistant&controller=addproperty&Itemid=<?php echo $_REQUEST['Itemid'];?>" ><img src="templates/camassistant_left/images/back.png" border="0" /></a>
<?php } }
?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</td>
	</tfoot>
</table>
</div>
</div>
<br/>
<!-- eof table pan -->
<div class="table_bottomlinks">
<ul>
<li  style=" background:none;"><a href="#" onclick="view();" >View/Edit Property </a></li>
<li><a href="#" onclick="deleteproperty();" id="deleteproperty" >Remove Property</a> </li>
<?php if($usertype == '13'){  ?><li><a href="#" onclick="reasign();" > Reassign Property </a></li><?php } ?> 

</ul>
<a href="index.php?option=com_camassistant&controller=addproperty&task=addproperty&Itemid=<?php echo $_REQUEST['Itemid']; ?>">
<img src="templates/camassistant_left/images/addaproperty.gif" alt="add a property" width="169" height="49" align="right" />
</a></div>
</div>
<?php } }?>

<div id="boxesa">		
<div id="submita" class="windowa">		
<form name="edit" id="edit" method="post">
<table width="100%" cellspacing="4" cellpadding="0">
  <tbody><tr class="table_green_row">
    <td valign="top" align="center">REMOVE PROPERTY CONFIRMATION</td>
     </tr>
	 <tr><td>This feature is available if your company is no longer working with this association.  If you prefer to have another manager within your organization manage this Property, you should NOT remove this Property  and instead select the " Reassign Property " option.   Are you sure you want to remove this property? </td></tr>
	 <tr><td align="center"><table><tr><td width="100"><div id="donea" name="donea" value="Ok" style="font-weight:bold;"><img src="templates/camassistant/images/yes.gif" /></div></td><td align="left"><div id="closea" name="closea" value="Cancel" style="font-weight:bold;"><img src="templates/camassistant/images/No.gif" /></div></td></tr></table></td></tr>
	 </tbody></table>

</form>
</div>
  <div id="maska"></div>
</div>