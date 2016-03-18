<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>camassistant</title>
<?php  //echo '<pre>'; print_r($_REQUEST);
	error_reporting(0);
	$block = $this->block;	
	$managertype = JRequest::getVar( 'managertype',''); 
	$industrytype = JRequest::getVar( 'industrytype',''); 
	$statelist = $this->statelist; 
	$ownids = $this->own; 
	$globe = $this->global; 
	
?>
<link href="cam.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
H(document).ready( function(){
H('#searchofrm').submit(function(){
var companyname = H("#companyname").val();
companyname = companyname.trim();
	if(companyname == '' || companyname == 'Enter Company Name'){
	alert("Please enter the company name");
	}
	else if(companyname.length < 4){
	alert("Please enter at least 4 characters");	
	}
	else {
	H('#results').addClass('loader');
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkcompany", {cname: ""+companyname+""}, function(data){
		if(data) {
		//document.getElementById("preferred-vendorsfirst").style.marginTop="50px";
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
//H('#companyid'+id).html('Adding...');
H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+id+"", emailid: ""+email+""}, function(data){
	if(data==' added'){
	//H('#companyid'+id).html('Added');
	alert("Vendor added successfully");
	 //location.reload(); 
	 window.location = "index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=<?php echo $_REQUEST['Itemid']; ?>";
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
		//L("#submitv").css('top',  '300');
		//L("#submitv").css('left', '582');
		L("#submitv").css('top',  winH/2-L("#submitv").height()/2);
		L("#submitv").css('left', winW/2-L("#submitv").width()/2);
				
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

function includevendor(vid){
L = jQuery.noConflict();
var matches = [];
var matchese = [];
var counte = 0 ;
L(".coworkers:checked").each(function() {
    matches.push(this.value);
	counte++ ;
});
if(counte == '0'){
alert("Please make a selection to REMOVE the vendors.");
}
else {

		L('body,html').animate({
				scrollTop: 250
				},800);
		var maskHeight = L(document).height();
		var maskWidth = L(window).width();
		L('#maske').css({'width':maskWidth,'height':maskHeight});
		L('#maske').fadeIn(100);
		L('#maske').fadeTo("slow",0.8);
		var winH = L(window).height();
		var winW = L(window).width();
		//L("#submitv").css('top',  '300');
		//L("#submitv").css('left', '582');
		L("#submite").css('top',  winH/2-L("#submite").height()/2);
		L("#submite").css('left', winW/2-L("#submite").width()/2);
				
		L("#submite").fadeIn(2000);
		L('.windowe #donee').click(function (e) {
		e.preventDefault();
		L('#maske').hide();
		L('.windowe').hide();
			L(".coworkers:checked").each(function() {
			matchese.push(this.value);
			});
			matchese = matchese.join(',') ;
			
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=includevendor", {vendorid: ""+matchese+""}, function(data){
		if(data==' removed'){
		location.reload();
		}
		else{
		alert("Not able to exculde the vendor. Please contact support team. ");
		}
	});
		});
		L('.windowe #closee').click(function (e) {
		e.preventDefault();
		L('#maske').hide();
		L('.windowe').hide();
		
		});
}
}


function unsubscribevendor(){

L = jQuery.noConflict();
		L('body,html').animate({
				scrollTop: 250
				},800);
		var maskHeight = L(document).height();
		var maskWidth = L(window).width();
		L('#maskun').css({'width':maskWidth,'height':maskHeight});
		L('#maskun').fadeIn(100);
		L('#maskun').fadeTo("slow",0.8);
		var winH = L(window).height();
		var winW = L(window).width();
		//L("#submitv").css('top',  '300');
		//L("#submitv").css('left', '582');
		L("#submitun").css('top',  winH/2-L("#submitun").height()/2);
		L("#submitun").css('left', winW/2-L("#submitun").width()/2);
				
		L("#submitun").fadeIn(2000);
		L('.windowun #doneun').click(function (e) {
		e.preventDefault();
		L('#maskun').hide();
		L('.windowun').hide();
		});
}

function county(){

var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=rfp&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
if(data.length == '46'){
H("#divcounty").css("opacity",'0.5');
}
else{
H("#divcounty").css("opacity",'');
}
H("#divcounty").html(data);
H("#divcounty").val('<?php echo $_REQUEST['divcounty']; ?>');
}
});

}

function precounty(){
var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=rfp&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
if(data.length == '46'){
H("#divcounty").css("opacity",'0.5');
}
else{
H("#divcounty").css("opacity",'');
}
H("#divcounty").html(data);
H("#divcounty").val('<?php echo $_REQUEST['divcounty']; ?>');
}
});
document.forms["selectform"].submit();
}

// To send the invitation
function invitevendor(){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=sendinvitation';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:600}}"))
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
function speccounty(val)
{
	document.forms["selectform"].submit();
}

function sendupdateemail(email,companyname,id){
H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=sendupdateemail&Email="+email+"&cname="+companyname+"&vendorid="+id+"", {Email: ""+email+""}, function(data){
if(data == 1) {
alert("Mail sent successfully.");
}
else{
alert("Please send once again");
}
});
}
function unverified(vendorid,type){
if(type == 'unverified')
var height = '290';
else
var height = '230';
var el ='index.php?option=com_camassistant&controller=rfpcenter&task=vendortype&vendorid='+vendorid+'&type='+type;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
SqueezeBox.fromElement(el,options);
}

H(document).ready( function(){
	H('.acceptlink').click(function(){
		blocku = H(this).val();
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=blockvendors&block="+blocku+"", function(data){
		location.reload();
		});
	});
	
});

function getstandards(vendorid,status){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=preferredcompliance&vendorid='+vendorid+'&status='+status+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:700}}"))
	SqueezeBox.fromElement(el,options);
G("#sbox-window").addClass("newclasssate");	
}	
	
</script>
<style type="text/css">
#maske {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxese .windowe {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxese #submite {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxese #submite a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donee {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
#closee { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}
</style>
</head>

<body>

<br />
<div id="add-vendor">



<div id="results" class="companies">
</div>

<div class="clr"></div>

<div id="i_bar_terms_red">
<div id="i_bar_txt_terms_red">
<span> <font style="font-weight:bold; color:#FFF;">UNVERIFIED VENDORS</font></span>
</div></div>
<p style="font-size:13px;">Vendors who choose a basic membership will NOT have their Compliance Documents verified for accuracy by the MyVendorCenter compliance team and will appear as <font color="#FF0000">UNVERIFIED</font>. This means there is a chance the vendor has uploaded an incorrect document, expired policy, or provided incorrect information (i.e policy amount, types of coverage). We highly recommend you verify all information entered by these vendors manually before inviting them to projects. You can also choose to block unverified vendors from being invited to projects by your managers by selecting the option below.</p>
<br />
<div align="center"><input type="checkbox" <?php if( $block->block ) echo "checked='checked'";?> value="unve" class="acceptlink" name="accept"  style="margin-top: -1px; vertical-align: middle;" />
<span style="font-size: 15px; font-weight: bold;">Block Unverified Vendors</span></div>
<br /><br /><br />
<div class="clr"></div>



<div id="i_bar_terms_red">
<div id="i_bar_txt_terms_red">
<span> <font style="font-weight:bold; color:#FFF;">NON-COMPLIANT VENDORS</font></span>
</div></div>
<p style="font-size:13px;">Vendors who do not meet your compliance standards, set by choosing "Global Standards", will appear with a RED (Non-Compliant in all industries they serve) or ORANGE (Non-Compliant in some industries they serve) document icon. You can choose to block Non-Compliant Vendors from being invited to projects by your managers by selecting the option below.</p>
<br />
<div align="center"><input type="checkbox" <?php if( $block->block_complinace ) echo "checked='checked'";?> value="nonc" class="acceptlink" name="accept"  style="margin-top: -1px; vertical-align: middle;" />
<span style="font-size: 15px; font-weight: bold;">Block Non-Compliant Vendors</span></div>
<br /><br /><p style="border-bottom:2px dotted #c1c2c5;"></p><br /><br />





<div id="preferred">
<form name="select_form" id="selectform" method="post" action="">
<div align="center">
<span style="color:#7AB800; font-weight:bold; text-align:center">OPTIONAL FILTERS</span>

<table cellspacing="0" cellpadding="0">
<tbody><tr height="15"></tr>
<tr><td>    
	  <select name="state" style="width:400px; margin-left:0px;" id="stateid" onchange="javascript:precounty();" >
			 <option value="0">All States</option>
			<?php
			for ($i=0; $i<count($statelist); $i++){
			$states = $statelist[$i];   ?>
			<option  value="<?php echo $states->state_id; ?>" <?php if($states->state_id==$_REQUEST['state']){ ?> selected="selected" <?php } ?> ><?php echo $states->state_name; ?> </option>
			<?php }  ?>
	  </select>
	  </td></tr>
	  <tr height="15"></tr>
	  <tr><td>
	  <select style="width: 400px; margin-left:0px;margin-right:5px; opacity:0.5" name="divcounty" id="divcounty" onchange="javascript:speccounty()" >
<option value="">Select County</option>
</select>
 <script type="text/javascript">
county();
</script>
</td></tr>
<tr height="15"></tr>
<tr><td>
    <select style="margin-left:0px; width:400px;margin-right:0px; word-wrap:normal;" name="industrytype" onchange="javascript:specindus('')">
      <option value="">All Industries</option>
	  <?php
	  for($i=0; $i<count($this->industries); $i++){
	  ?> 
<option <?php if($industrytype == $this->industries[$i]->id){ echo "selected"; } ?> value="<?php echo $this->industries[$i]->id; ?>"> <?php echo $this->industries[$i]->industry_name; ?>  </option>
	  <?php }
	  ?>
      </select>
	  </td></tr>
	  <tr height="50"></tr>
	<input type="hidden" name="option" value="com_camassistant" />
	<input type="hidden" name="controller" value="vendorscenter" />
	<input type="hidden" name="view" value="vendorscenter" />
	<input type="hidden" name="task" value="excludevendors" />
	<!--<input type="hidden" name="managertype" id="managertype" value="" />
	<input type="hidden" name="industrytype" id="industrytype" value="" />	-->
	</tbody></table>
	</div>
	</form>
	<p style="height:5px;"></p>
  <div id="preferred-vendorsfirst" class="breakclass" style="">
  <div id="i_bar_terms_red">
<div id="i_bar_txt_terms_red">
<span> <font style="font-weight:bold; color:#FFF;">EXCLUDED VENDORS</font></span>
</div></div>
	  
<div id="heading_vendors">
<div class="checkbox_vendor">SELECT</div>
<div class="company_vendor">COMPANY</div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor">COMPLIANCE STATUS</div>
</div>

    <div class="clr"></div>
    
    
  </div>
  
<?php 
$user =& JFactory::getUser();
$items = $this->items;
$firmids = $this->firmids ;

//echo "<pre>"; print_r($items);
if($items) {
foreach($items as $am ) {  
?> 
  <div id="preferredvendors<?php echo  $am->vid; ?>" style="display:<?php echo $display; ?>">
  <div id="preferredvendorsinvitations">
   <div class="search-panel-middlepre checkbox_vendor">
  
   <input type="checkbox" value="<?php echo  $am->vid; ?>" name="coworkers" class="coworkers" />
      
	  <br />
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
    <div class="search-panel-left_rfp company_vendor">
      <?php
	  if($am->subscribe != 'yes'){ ?>
	   <ul style="margin-top: 11px;">
        <li><strong><a href="javascript:unsubscribevendor();"><?php echo $am->company_name; ?></a></strong></li>
		<li>This Vendor's contact information is unavailable due to an expired account. <strong><a class="notsubscribedvebndors" href="javascript:sendupdateemail('<?php echo $am->inhousevendors; ?>','<?php echo $am->company_name; ?>','<?php echo  $am->v_id; ?>')">CLICK HERE</a></strong> to request an update.</li>
		</ul>
	   <?php } else {  ?>
	   <ul>
        <li><strong><a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name . ' ' .$am->lastname; ?> <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo "&nbsp;Ext.&nbsp;".$am->phone_ext; } else { echo ""; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a class="miniemails" href="mailto:<?php echo $am->inhousevendors; ?>?cc=support@camassistant.com">Email</a></li>
        </ul>
	  <?php  }
	  ?>
	  
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->v_id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->v_id."  ";
		$db->setQuery($camrating);
		$cam_rating = $db->loadResult();
		
		if($cam_rating) {
		$total = $total + $cam_rating ;
		$count = count($count_vs) + 1;
		$avgrating = $total  / $count;	
		$rating =  round($avgrating, 1); 
		}
		else {
		$avgrating = $total  / count($count_vs);	
		$rating =  round($avgrating, 1); 
		}
	}
	else if($cam_ratingf){
	$rating = round($cam_ratingf, 1); 
	}
	else{
	$rating = 4 ;
	}
	
	if ($rating > 0 && $rating <= 0.50)
			{ $rate_image = $rateimage.'5.png';  $rating='0.5'; }
			elseif ($rating > 0.50 && $rating <= 1.00)
			{ $rate_image = $rateimage.'10.png'; $rating='1'; }
			elseif ($rating > 1.00 && $rating <= 1.50)
			{ $rate_image = $rateimage.'15.png'; $rating='1.5';}
			elseif ($rating > 1.50 && $rating <= 2.00)
			{ $rate_image = $rateimage.'20.png'; $rating='2';}
			elseif ($rating > 2.00 && $rating <= 2.50)
			{ $rate_image = $rateimage.'25.png'; $rating='2.5';}
			elseif ($rating > 2.50 && $rating <= 3.00)
			{ $rate_image = $rateimage.'30.png'; $rating='3';}
			elseif ($rating > 3.00 && $rating <= 3.50)
			{ $rate_image = $rateimage.'35.png'; $rating='3.5';}
			elseif ($rating > 3.50 && $rating <= 4.00)
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			elseif ($rating > 4.00 && $rating <= 4.50)
			{ $rate_image = $rateimage.'45.png'; $rating='4.5';}
			elseif ($rating > 4.50 && $rating <= 5.00)
			{ $rate_image = $rateimage.'50.png'; $rating='5';}
			else
			{ $rate_image = $rateimage.'40.png'; $rating='4';}
			$total = 0;

	?>
			<img width="130" src="components/com_camassistant/assets/images/rating/vendorrating/<?php echo $rate_image; ?>" />
			
	</div>
	
	<?php
				
				if($am->final_status == 'fail') {
				//$text = "NON-COMPLIANT";
				$id = 'noncompliant';
				$title = 'Non-Compliant';
				}
				else if($am->final_status == 'success'){
				///$text = "COMPLIANT";
				$id = 'compliant';
				$title = 'Compliant';
				}
				
			?>
	<div class="search-panel-image_rfp compliant_vendor">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
		 <?php  if($globe != 'fail'){ ?>
		<a href="javascript:void(0);" onclick="getstandards('<?php echo $am->id; ?>','<?php echo $title; ?>');" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			
			<?php } else {
			echo "N/A";
			}?>			
			 </p>

<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
			 
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
	
	<?php if($items){ ?>
	<div align="center" style="margin-top:17px;">
	 <a href="javascript:includevendor();" class="delete"></a>
	 </div>
	<?php } ?>
	
</div></div>



<div id="boxese" class="boxese">
<div id="submite" class="windowe" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">This Vendor will no longer be blocked and will be allowed to participate in your Managers' projects</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="closee" name="closee" value="Cancel"><img src="templates/camassistant_left/images/cancel.gif" /></div>
<div id="donee"  name="donee" value="Ok"><img src="templates/camassistant_left/images/ok.gif" /></div>
</div>
</form>

</div>
  <div id="maske"></div>
</div>