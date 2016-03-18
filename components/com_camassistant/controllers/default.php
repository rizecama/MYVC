<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>camassistant</title>
<?php  //echo '<pre>'; print_r($_REQUEST);
	$managertype = JRequest::getVar( 'managertype',''); 
	  $industrytype = JRequest::getVar( 'industrytype',''); 
	  
?>
<style>
#maskv {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesv .windowv {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesv #submitv {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesv #submitv a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donev {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
#closev { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}

</style>
<link href="cam.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
H(document).ready( function(){
H('#searchofrm').submit(function(){
var companyname = H("#companyname").val();
alert(companyname.length);
	if(companyname == '' || companyname == 'Enter Company Name'){
	alert("Please enter the company name");
	}
	else {
	H('#results').addClass('loader');
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkcompany", {cname: ""+companyname+""}, function(data){
		if(data) {
		H('#results').html(data).slideDown('slow');
		H('#results').removeClass('loader');
		}
		else{
		H('#results').removeClass('loader');
		}
	});
	}

return false; 

});

});

//To add the vendor as preferred vendor
function sendinvitation(id,email){
H('#companyid'+id).html('Adding...');
H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+id+"", emailid: ""+email+""}, function(data){
	if(data==' added'){
	H('#companyid'+id).html('Added');
	alert("Vendor added successfully");
	}
	if(data==' already'){
	H('#companyid'+id).html('Added');
	alert("This Vendor is already a Preferred Vendor. ");
	H('#companyid'+id).hide();
	}
	if(data=='fail'){
	alert("Not able to invite the vendor. Please contact support team. ");
	}
});

}
//To delete vendor from preferred vendors list
function deletevendor(vid){
L = jQuery.noConflict();
		L('body,html').animate({
				scrollTop: 250
				},800);
		var maskHeight = L(document).height();
		var maskWidth = L(window).width();
		L('#maskv').css({'width':maskWidth,'height':maskHeight});
		L('#maskv').fadeIn(100);
		L('#maskv').fadeTo("slow",0.8);
		var winH = L(window).height();
		var winW = L(window).width();
		L("#submitv").css('top',  '300');
		L("#submitv").css('left', '582');
		L("#submitv").fadeIn(2000);
		L('.windowv #donev').click(function (e) {
		e.preventDefault();
		L('#maskv').hide();
		L('.windowv').hide();
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=removevendor", {vendorid: ""+vid+""}, function(data){
		if(data==' removed'){
		H('#preferredvendors'+vid).hide();
		}
		else{
		alert("Not able to delete the vendor. Please contact support team. ");
		}
	});
		});
		L('.windowv #closev').click(function (e) {
		e.preventDefault();
		L('#maskv').hide();
		L('.windowv').hide();
		
		});

}
// To send the invitation
function invitevendor(){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=sendinvitation';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:550}}"))
SqueezeBox.fromElement(el,options);
}
//Function to get the values
function specific(val)
{
	//document.getElementById('managertype').value = val ;
	document.forms["selectform"].submit();
}
//Function to get the industry based records
function specindus(val)
{
	//document.getElementById('industrytype').value = val ;
	document.forms["selectform"].submit();
}
</script>
</head>

<body>

<br /><br />
<div id="add-vendor">
<div id="add-vendor-new">
<h3>+ ADD A NEW, PREFERRED VENDOR</h3>
(enter company name below)
<div class="new-search">

<form name="searchform" id="searchofrm" method="post">
<!--<img src="templates/camassistant_left/images/add-new-vendor-arrow.png"  alt="" />-->
<input name="companyname" id="companyname" type="text"  value="Enter Company Name" onclick="if(this.value == 'Enter Company Name') this.value='';" onblur="if(this.value == '') this.value ='Enter Company Name';" style="padding-left:3px;"/>
<input name="" type="submit" value="SEARCH" class="go-button" id="searchcompany" style="padding-left:4px; padding-right:3px;" />
</form>
</div>
<div class="clr"></div>

<br />
</div>


<div id="results" class="companies">
</div>

<div class="clr"></div>

<div class="clr"></div>

<div id="preferred">
  <div id="preferred-vendorsfirst">
  <form name="select_form" id="selectform" method="post" action="">
    <select name="managertype" >
      <option value="" id="" <?php if($managertype == ''){ echo "selected"; } ?> onclick="javascript:specific('')">Select Preferred Vendors</option>
      <option value="1" id="1" <?php if($managertype == '1'){ echo "selected"; } ?> onclick="javascript:specific('1')">My Preferred Vendors</option>
      <option value="2" id="2" <?php if($managertype == '2'){ echo "selected"; } ?> onclick="javascript:specific('2')">My Company Preferred Vendors</option>
      </select>
    <select style="margin-left:8px;" name="industrytype" onchange="javascript:specindus('')">
      <option value="">All Industries</option>
	  <?php
	  for($i=0; $i<count($this->industries); $i++){
	  ?> 
<option <?php if($industrytype == $this->industries[$i]->id){ echo "selected"; } ?> value="<?php echo $this->industries[$i]->id; ?>"> <?php echo $this->industries[$i]->industry_name; ?>  </option>
	  <?php }
	  ?>
      </select>
	<input type="hidden" name="option" value="com_camassistant" />
	<input type="hidden" name="controller" value="vendorscenter" />
	<input type="hidden" name="view" value="vendorscenter" />
	<input type="hidden" name="task" value="vendorscenter" />
	<!--<input type="hidden" name="managertype" id="managertype" value="" />
	<input type="hidden" name="industrytype" id="industrytype" value="" />	-->
	</form>
    <div class="clr"></div>
    <div class="preferredvendors-head">
      <h5>PREFERRED VENDORS</h5>
      </div>
    <div class="clr"></div>
    
  </div>
  
<?php 
$items = $this->items;
//echo "<pre>"; print_r($items);
if($items) {
foreach($items as $am ) {  ?> 
  <div id="preferredvendors<?php echo  $am->vid; ?>">
  <div id="preferredvendors">
   <div class="search-panel-middle">
      <a href="javascript:deletevendor(<?php echo  $am->vid; ?>);" class="pre-red"><strong><img src="templates/camassistant_left/images/minus-icon.png" /></strong></a><br />
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
    <div class="search-panel-left">
      <ul>
        <li><strong><?php echo $am->company_name; ?></strong></li>
        <li><?php echo $am->name . ' ' .$am->lastname; ?>: <?php echo $am->company_phone; ?>	Ext.<?php echo $am->phone_ext; ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a href="mailto:<?php echo $am->inhousevendors; ?>?cc=support@myvendorcenter.com"><?php echo $am->inhousevendors; ?></a></li>
        </ul>
      </div>
	 
    <div class="search-panel-right">
	<?php
	$db = & JFactory::getDBO();
	$rating = "SELECT rating_sum FROM #__content_rating where content_id =".$am->v_id;
			$db->Setquery($rating);
			$rating = $db->loadResult();
			if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'10.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'20.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'30.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'40.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';} ?>
			<img src="templates/camassistant_left/images/<?php echo $rate_image ?>" />
	</div>
    <div class="clr"></div>
  </div>
  </div>
    <?php } 
	} 
	else {  ?>
	<p align="center" style="margin-top:20px; font-weight:bold;">There are no vendors available in your list with this sorting.</p>
	<?php }
	?> 
</div>
</div>
</body>
</html>

<div id="boxesv" class="boxesv">
<div id="submitv" class="windowv" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">This Vendor will be REMOVED from your Vendor List</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">

<div id="closev" name="closep" value="Cancel"><img src="templates/camassistant_left/images/Cancel.gif" /></div>
<div id="donev"  name="donev" value="Ok"><img src="templates/camassistant_left/images/OK.gif" /></div>
</div>
</form>

</div>
  <div id="maskv"></div>
</div>