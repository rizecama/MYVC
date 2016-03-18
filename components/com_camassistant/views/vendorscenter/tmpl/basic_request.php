<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>camassistant</title>
<?php  //echo '<pre>'; print_r($_REQUEST);
error_reporting(0);
	$managertype = JRequest::getVar( 'managertype',''); 
	$industrytype = JRequest::getVar( 'industrytype',''); 
	$compliance_filter = JRequest::getVar( 'compliance',''); 
	$statelist = $this->statelist; 
	$ownids = $this->own; 
	$globe = $this->global; 
	$user=& JFactory::getuser();
	$basicjobs = $this->basisjobs ;
	if( count($basicjobs) > '0' )
	$basics = 'yes';
	else
	$basics = 'no';
	$permission = $this->permission ;
	
	$recommends = $this->recommends ;
	$countofmngrs = count($this->managers_recs);
	//echo $countofmngrs; 
	if( $countofmngrs == 0 )
		$height = '300';
	else if( $countofmngrs > 0 && $countofmngrs <= 6 )
		$height = '350';
	else
		$height = '370';
		

?>
<style>
#maskvrec {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvrec .windowvrec {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesvrec #submitvrec {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesvrec #submitvrec a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevrec {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
#closevrec { border:0 none; cursor:pointer; height:30px; color:#000000; font-weight:bold; font-size:20px; text-align:center;}

#maskv {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesv .windowv {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesv #submitv {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesv #submitv a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donev {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
#closev { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}

#maskun {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesun .windowun {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesun #submitun {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesun #submitun a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneun {border:0 none; cursor:pointer; height:30px; margin-left:-78px; margin-top:-11px; width:474px; float:left; }
#closeun { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}

#maske {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxese .windowe {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxese #submite {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxese #submite a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donee {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
#closee { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}

#maskreq {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesreq .windowreq {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
/*#boxesreq #submitreq {  width:789px;  height:640px;  padding:10px;  background-color:#ffffff;}*/
#boxesreq #submitreq {  width:789px;  height:610px;;  padding:10px;  background-color:#ffffff;}
#donereq {border:0 none; cursor:pointer; height:30px; margin-top:-31px; float:right; width:228px; }
#closereq { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:200px;}

#maskpl { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxespl .windowpl {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxespl #submitpl {  width:545px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxespl #submitpl a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donepl {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closepl {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

#maskvrecdone {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvrecdone .windowvrecdone {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesvrecdone #submitvrecdone {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesvrecdone #submitvrecdone a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevrecdone {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }

#maskvrecdonee {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvrecdonee .windowvrecdonee {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesvrecdonee #submitvrecdonee {  width:318px;  height:130px;  padding:10px;  background-color:#ffffff;}
#boxesvrecdonee #submitvrecdonee a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevrecdonee {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }


</style>
<link href="cam.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery.elastic.js"></script>

<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
//To add the vendor as preferred vendor
function sendinvitation(){
//H('#companyid'+id).html('Adding...');
var matchesc = [];
var matchesb = [];
var countc = 0 ;
H(".coworkers:checked").each(function() {
    matchesc.push(this.value);
	countc++ ;
});
if(countc == '0'){
alert("Please make a selection to ADD the vendors.");
}
else {
	H(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesb.push(myArray[1]);
			});
			matchesb = matchesb.join(',') ;
			
H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+matchesb+""}, function(data){
	
	if(data){
	location.reload();
	}
});
}
}


function sendinvitationcorporate(){
//H('#companyid'+id).html('Adding...');
var matchesc = [];
var matchesb = [];
var countc = 0 ;
H(".corporates:checked").each(function() {
    matchesc.push(this.value);
	countc++ ;
});
if(countc == '0'){
alert("Please make a selection to ADD the vendors.");
}
else {
	H(".corporates:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesb.push(myArray[1]);
			});
			matchesb = matchesb.join(',') ;
			
H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+matchesb+""}, function(data){
	
	if(data){
	location.reload();
	}
});
}
}

function excludecovendor(){
L = jQuery.noConflict();
var matches = [];
var matchesex = [];
var counte = 0 ;
L(".coworkers:checked").each(function() {
    matches.push(this.value);
	counte++ ;
});
if(counte == '0'){
alert("Please make a selection to EXCLUDE the vendors.");
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
			myString = this.value ;
			var myArray = myString.split('-');
			matchesex.push(myArray[0]);
			});
			matchesex = matchesex.join(',') ;
			
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=excludecovendor", {vendorid: ""+matchesex+""}, function(data){
		if(data==' removed'){
		location.reload();
		}
		else{
		alert("Not able to exculde the vendor. Please contact support team. ");
		}
	});
	//location.reload();
		});
		L('.windowe #closee').click(function (e) {
		e.preventDefault();
		L('#maske').hide();
		L('.windowe').hide();
		
		});
 }
}


//To delete vendor from preferred vendors list


function county(){
var state = H("#stateid").val();
if(state != '0'){
H('.height_county').show();
H('#divcounty').show();
}
else
{
H('.height_county').hide();
H('#divcounty').hide();

}
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

function changecomplince(){
document.forms["selectform"].submit();
}
function changeverification(){
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
function getcompstatus(vendorid,status){
	if( status == 'fail' )
		height = '240';
	else
		height = '800';	
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=preferredcompliance&vendorid='+vendorid+'&status='+status+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
	SqueezeBox.fromElement(el,options);
	}
// Function to recommend vendors to other managers
// Function to send the mail to vendors
	
	H(document).ready( function(){
	
	H('.cancel_basic').click(function(){
	window.location.assign("index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125");
	});
	H('#selectall_preferredvendors').click(function(){
		if( H("#selectall_preferredvendors").prop("checked") == true )
		H(".preferredvendors").attr("checked", true);
		else
		H(".preferredvendors").attr("checked", false);
	});
	
	H('#selectall_corporates').click(function(){
		if( H("#selectall_corporates").prop("checked") == true )
		H(".corporates").attr("checked", true);
		else
		H(".corporates").attr("checked", false);
	});
	
	H('#selectall_coworkers').click(function(){
		if( H("#selectall_coworkers").prop("checked") == true )
		H(".coworkers").attr("checked", true);
		else
		H(".coworkers").attr("checked", false);
	});
	
	H('.open_request').click(function(){
		//H('#preferred').hide();
	});
	H('.personal_request').click(function(){
		H('#preferred').show();
		//H('#cancel_basic').show();
	});
	
	H('.continue_basic').click(function(){
		if (!H('input[name=open]:checked').val() && !H('input[name=personal]:checked').val() ) {  
			 geterrorpopup();      
		}
		else{
		
	var matches = [];
	var matchesa = [];
	var countp = 0 ;
		H(".preferredvendors:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		H(".coworkers:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		H(".corporates:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
	if(countp == '0' && H('input[name=personal]:checked').val() == 'personal' && H('input[name=open]:checked').val() != 'open' ){
		alert("Please select at least one Vendor to include in this request.");
	}
	else{
		H(".preferredvendors:checked").each(function() {
		matchesa.push(this.value);		
		});
		H(".coworkers:checked").each(function() {
		myString = this.value ;
		var myArray = myString.split('-');
		matchesa.push(myArray[0]);
		});
		H(".corporates:checked").each(function() {
		myString = this.value ;
		var myArray = myString.split('-');
		matchesa.push(myArray[0]);
		});
		matchesa = matchesa.join(',') ;
		H('#selected_vendors').val(matchesa)  ;	
		H('#basicrequest_form').submit();	
		}
	}
	});
	
	});

function unverified(vendorid,type){
	if(type == 'unverified')
	var height = '290';
	if(type == 'nonc')
	var height = '245';
	if(type == 'both')
	var height = '350';
	else
	var height = '270';
var el ='index.php?option=com_camassistant&controller=rfpcenter&task=vendortype&vendorid='+vendorid+'&type='+type;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 670, y:"+height+"}}"))
SqueezeBox.fromElement(el,options);
}


function senderrormsg(){
	alert("This Vendor has been Blocked by your Company's Master Account holder");
}
	
function getstandards(vendorid,status){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=preferredcompliance&vendorid='+vendorid+'&status='+status+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:700}}"))
	SqueezeBox.fromElement(el,options);
	if( status == 'Compliant' )
	G("#sbox-window").addClass("newclasssate_green");	
	else
	G("#sbox-window").addClass("newclasssate");	
}	
function getpopupbox(){
	L('body,html').animate({
	scrollTop: 250
	},800);
	var maskHeight = L(document).height();
	var maskWidth = L(window).width();
	L('#maskvrecdone').css({'width':maskWidth,'height':maskHeight});
	L('#maskvrecdone').fadeIn(100);
	L('#maskvrecdone').fadeTo("slow",0.8);
	var winH = L(window).height();
	var winW = L(window).width();
	L("#submitvrecdone").css('top',  winH/2-L("#submitvrecdone").height()/2);
	L("#submitvrecdone").css('left', winW/2-L("#submitvrecdone").width()/2);
	
	L("#submitvrecdone").fadeIn(2000);
	L('.windowvrecdone #closevrecdone').click(function (e) {
	
		e.preventDefault();
		L('#maskvrecdone').hide();
		L('.windowvrecdone').hide();
	});
}
function geterrorpopup(){
	H('body,html').animate({
	scrollTop: 250
	},800);
	var maskHeight = H(document).height();
	var maskWidth = H(window).width();
	H('#maskvrecdonee').css({'width':maskWidth,'height':maskHeight});
	H('#maskvrecdonee').fadeIn(100);
	H('#maskvrecdonee').fadeTo("slow",0.8);
	var winH = H(window).height();
	var winW = H(window).width();
	H("#submitvrecdonee").css('top',  winH/2-H("#submitvrecdonee").height()/2);
	H("#submitvrecdonee").css('left', winW/2-H("#submitvrecdonee").width()/2);
	
	H("#submitvrecdonee").fadeIn(2000);
	H('.windowvrecdonee #closevrecdonee').click(function (e) {
		e.preventDefault();
		H('#maskvrecdonee').hide();
		H('.windowvrecdonee').hide();
	});
}
function getopenpopuptext(){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=openinvitation_text';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 560, y:240}}"))
	SqueezeBox.fromElement(el,options);
}
function getpersonalpopuptext(){
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=personalinvitation_text';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 560, y:260}}"))
	SqueezeBox.fromElement(el,options);
}

</script>
</head>

<body>

<br />
<div id="add-vendor">
<div id="results" class="companies">
</div>

<div class="clr"></div>
<form method="post" name="basicrequest_form" id="basicrequest_form" action="index.php?option=com_camassistant&controller=rfp&task=invited_basicrfp&Itemid=242">
<div class="toppart_header">
<ul class="toppart_ul">
<li><img src="templates/camassistant_left/images/fir_step_basic.png" /></li>
<li class="basic_heading">How would you like to invite Vendors to participate in your request?</li>
</ul>
<ul class="input_options">
<li><input type="checkbox" name="open" value="open" class="open_request" /> - <span>Open Invitation:</span> I would like my request to be open to ALL interested Vendors<span class="openinfo"> (<a href="javascript:void(0);" onclick="javascript:getopenpopuptext();">more info</a>)</span></li>
<li><input type="checkbox" name="personal" value="personal" class="personal_request" /> - <span class="closeinfo">Personal Invitation:</span> I would like to select specific Vendors to invite to my request<span> (<a href="javascript:void(0);" onclick="javascript:getpersonalpopuptext();">more info</a>)</span> </li>
</ul>
</div>
<?php 
$db = & JFactory::getDBO();
$user = & JFactory::getUser();
if($user->user_type == '16')
{
?>

<div id="preferred" style="display:none;">
<p>Please select which Vendors should receive a Personal Invitation to<br /> participate in your new request</p>
  <?php 
	if($user->user_type == '13' && $user->accounttype == 'master') 
	$textshows =  "Remove from Corporate Preferred Vendors";
	else
	$textshows =  "Remove from My Vendors ";

	
	$user =& JFactory::getUser();
	if($user->accounttype != 'master'){
	 ?>
	<p style="height:50px;"></p>
	<div style="" class="breakclass" id="preferred-vendorsfirst">
  <?php /*?><div class="preferredvendors-head">
      <h5 style="float:left; background-image:none;">CORPORATE PREFERRED VENDORS</h5>
	  <a style="text-decoration: none;" mce_style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113"><img style="float:right;" src="/dev/templates/camassistant_left/images/preferred-arrow.jpg"> </a>
	<div class="clr"></div>  
      </div><?php */?>
	  
	 <div id="i_bar_yellow" style=" background: #e6b613; box-shadow: 1px 2px 1px #808080; height: 34px; margin-bottom: 10px; text-align: center;">
<div id="i_icon">
<a style="text-decoration: none;" mce_style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113"><img src="templates/camassistant_left/images/info_icon2.png" style="float:right;"> </a>
</div>
    <div id="i_bar_txt" style="text-align:center;  padding:8px 0 0 35px;">
<span><font style="font-weight:bold; color:#fff;">CORPORATE PREFERRED VENDORS</font></span></div>
</div>
	

	<?php 
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	
	if( $sort == 'asc' && $type == 'corporate' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'corporate' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}
	?>
		  
	 <div id="heading_vendors">
<div class="checkbox_vendor"><input type="checkbox" value="" name="selectall" id="selectall_corporates" />SELECT</div> 
<div class="company_vendor">
<a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=242&type=corporate&sort=<?php echo $sort ; ?>">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor" style="padding-left:3px;">COMPLIANCE STATUS</div>
</div> 
	  
<div class="clr"></div>
</div>
<div class="totalvendorspre_preferred">
<?php 
$vendor_first = $this->items ;
if($vendor_first){
	foreach($vendor_first as $vvv){
		$first_vendors[] = $vvv->id;
	}
}

//echo "<pre>"; print_r($first_vendors); echo "<pre>";
//echo "<pre>"; print_r($this->corporate); echo "<pre>";
$corporate = $this->corporate ;
$count_c_mgr = 0;
 if($corporate) {
foreach($corporate as $am ) {  
	if($ownids){
				if ( in_array($am->v_id, $ownids) )
				  {
				  $display = '' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}
	if($first_vendors){
				if ( in_array($am->v_id, $first_vendors) )
				  {
				  $display = '' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}	
	if( $am->subscribe_type == 'free' && $am->unverified == 'hide' )
		$display_block1 = 'none';
	else
		$display_block1 = '';	

	if( ( $am->final_status == 'fail' || $am->final_status == 'medium') && $am->block_nonc == 'hide' )
		$display_nonc = 'none';
	else
		$display_nonc = '';



	if( $compliance_filter == 'comp' )
		{
			if( $am->final_status != 'success' )
			$display_comp = 'none';
			else
			$display_comp = '';
		}
	else if( $compliance_filter == 'noncomp' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium' || !$am->final_status )
			$display_noncomp = '';
			else
			$display_noncomp = 'none';
		}
		
				
		if( $display == 'none' || $display_block1 == 'none' || $display_comp == 'none' || $display_noncomp == 'none' || $display_nonc =='none' ){
			$final_disp = 'none';
			$count_c_mgr ++;
		}
		else{
			$final_disp = '';
		}

?> 
<?php 
if( $final_disp != 'none' )
$list_vendors[] = $am->vid;
?>
<div id="preferredvendors<?php echo  $am->vid; ?>" style="display:<?php echo $final_disp; ?>">
   <div id="preferredvendorsinvitations">
   <div class="search-panel-middlepre checkbox_vendor">
     
	  <?php 
	  if( $am->subscribe_type == 'free' && $am->unverified == 'hide' ){ ?>
	  <a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
	  else{ ?>
	  <input type="checkbox" value="<?php echo  $am->vid; ?>-<?php echo  $am->v_id; ?>" name="corporates" class="corporates<?php echo $final_disp; ?>" />
	  <br />
	  <?php } ?>
	  
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
     <div class="search-panel-left_rfp company_vendor">
      <?php //if($am->subscribe == 'yes'){ ?>
	  <ul>
        <li><strong>
		<img src="templates/camassistant_left/images/star-icon.png" title="Corporate Preferred Vendor" /><a style="margin-left:2px;" href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name . ' ' .$am->lastname; ?> <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo "&nbsp;Ext.&nbsp;".$am->phone_ext; } else { echo ""; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="font-weight:normal; color:gray;" class="miniemails" href="mailto:<?php echo $am->inhousevendors; ?>">Email</a></li>
        </ul>
		<?php //} ?>
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
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
				if($permission == 'yes'){
					$text = "N/A";
					$id = 'nostandards';
				}
				else{
					if($am->final_status == 'fail' || $am->termsandc == 'fail') {
					//$text = "NON-COMPLIANT";
					$id = 'noncompliant';
					$title = 'Non-Compliant';
					}
					else if($am->final_status == 'success'){
					//$text = "COMPLIANT";
					$id = 'compliant';
					$title = 'Compliant';
					}
					else if($am->final_status == 'medium'){
					//$text = "COMPLIANT & NON-COMPLIANT";
					$id = 'mediumcompliant';
					$title = 'Compliant & Non-Compliant';
					}
				}			
			?>
				
		<div class="search-panel-image_rfp compliant_vendor" style="padding-left:16px;">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
		  <?php  if($globe != 'fail'){ ?>
			<a href="javascript:void(0);" onclick="getstandards('<?php echo $am->v_id; ?>','<?php echo $title; ?>');" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			<?php } else { ?>
			<a id="nostandards" href="javascript:void(0);" onclick="javascript:getcompstatus(<?php echo $am->v_id; ?>,'<?php echo $globe; ?>');" title="No Standards">N/A</a>
			<?php }?>

<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
			
			 </p>
	  </div>
	  	
    <div class="clr"></div>
  </div>
  </div>
   <?php } 
	}   
	if( $count_c_mgr == count($corporate) || !$corporate ){ ?>
	<p align="center" style="margin-top:20px; font-weight:bold;">There are no vendors available on this list with this sorting.</p>
	<?php }
	?>
	</div>

	<?php 
	}
?>

  
<?php 
$items = $this->items;
$firmids = $this->firmids ;
$managers = $this->pertyownermanagers;
$count_corporate = 0;
for($i = 0; $i<count($managers); $i++)
{
		$managerid = $managers[$i]->property_manager_id;
		$db =& JFactory::getDBO();
	    $managerinfo = "SELECT name,lastname from #__users where id ='".$managerid."' ";
		$db->setQuery($managerinfo);
		$managername = $db->loadObject();
 ?>
 <p style="height:50px;"></p>
  <div id="preferred-vendorsfirst" class="breakclass" style="">
	  
<?php if($user->user_type == '16' ){ ?>
 <div id="i_bar_yellow" style=" background: #e6b613; box-shadow: 1px 2px 1px #808080; height: 34px; margin-bottom: 10px; text-align: center;">
 <?php } else { ?>
 <div id="i_bar">
 <?php } ?>
<div id="i_icon">
<a href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" mce_style="text-decoration: none;" style="text-decoration: none;"><img src="templates/camassistant_left/images/info_icon2.png" style="float:right;"> </a>
</div>
    <div id="i_bar_txt" style="text-align:center; padding:8px 0 0 35px;">
<span>


<span><font style="font-weight:bold; color:#fff;"><strong><?php echo $managername->name.'&nbsp;'.$managername->lastname ?></strong></font></span>

</span></div>
</div>

<?php 
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	
	if( $sort == 'asc' && $type == 'preferred' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'preferred' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}
	?>
	
	
	
	  
	  
	  <div id="heading_vendors">
<div class="checkbox_vendor"><input type="checkbox" value="" name="selectall" id="selectall_preferredvendors" />SELECT</div>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=242&type=preferred&sort=<?php echo $sort ; ?>">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor" style="padding-left:3px;">COMPLIANCE STATUS</div>
</div>
<?php


$star_vendors = $this->corporate ;
if($star_vendors){
	foreach($star_vendors as $star){
		$stars[] = $star->v_id;
	}
}

?>
 <p style="height:3px;"></p>
   <div class="clr"></div>
  </div>
  <div class="totalvendorspre_preferred">
 <?php
foreach($items as $am ) {  
		
	if( $am->userid == $managerid ) {
	

		if($user->user_type == '13' && $user->accounttype == 'master') {
			if( $am->subscribe_type == 'free' && $am->unverified == 'hide' )
				$display_block = 'none';
			else
				$display_block = '';
				
			if( ($am->final_status == 'fail' || $am->final_status == 'medium') && $am->block_nonc == 'hide' )
				$display_nonc = 'none';
			else
				$display_nonc = '';
		}
		else{
			$display_nonc = '';
			$display_block = '';
		}

	if( $compliance_filter == 'comp' )
		{
			if( $am->final_status != 'success' )
			$display_comp = 'none';
			else
			$display_comp = '';
		}
	else if( $compliance_filter == 'noncomp' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium'  || !$am->final_status)
			$display_noncomp = '';
			else
			$display_noncomp = 'none';
		}
			
if( $display_block == 'none' || $display_comp == 'none' ||  $display_noncomp == 'none' || $display_nonc == 'none'){		
	$final_display = 'none';
	$count_corporate ++ ;
	}
else{
	$final_display = '';	
	}
?> 

<?php
	$checkbox = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && ( $am->final_status == 'fail' || $am->final_status == 'medium') ){
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->final_status == 'success' ){
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && ( $am->final_status == 'fail' || $am->final_status == 'medium') ){
			$args = 'nonc';
			}
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium' ){
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	

?>		 
	<?php 
	if( $final_display != 'none' )
	$list_vendors[] = $am->vid;
	?>  
	  
  <div id="preferredvendors<?php echo  $am->vid; ?>" style="display:<?php echo $display; ?><?php echo $final_display; ?>">
  <div id="preferredvendorsinvitations">
   <div class="search-panel-middlepre checkbox_vendor">
      <?php 
	  if( $am->subscribe_type == 'free' && $am->unverified == 'hide' && $user->accounttype == 'master'){ ?>
	  <a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
	  else if( $checkbox != 'show' ) {  ?>
	  <a href="javascript:unverified(<?php echo $am->v_id; ?>,'<?php echo $args; ?>');" style="margin-left:-17px;"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php  } 
      else if($managertype != '2'){ ?>
	  <input type="checkbox" value="<?php echo  $am->vid; ?>" name="preferred" class="preferredvendors<?php echo $final_display; ?>" style="margin-left:-15px;" />
	   <?php } 
	  else { ?>
	  <a title="Add to My Vendors" href="javascript:sendinvitation(<?php echo  $am->v_id; ?>,'<?php echo $am->inhousevendors; ?>');" class="pre-red"><strong><img src="templates/camassistant_left/images/addicon.png" /></strong></a>
	  <?php } ?>
	  <br />
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
    <div class="search-panel-left_rfp company_vendor">

	   <ul>
        <li>
		
		<?php 
		$user =& JFactory::getUser();
		if (in_array($am->id, $stars)){ ?>
		<img src="templates/camassistant_left/images/star-icon.png"  title="Corporate Preferred Vendor" />
		<?php }
		else{
		}
		?><strong><a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name . ' ' .$am->lastname; ?> <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo "&nbsp;Ext.&nbsp;".$am->phone_ext; } else { echo ""; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ;  
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="font-weight:normal; color:gray;" class="miniemails" href="mailto:<?php echo $am->inhousevendors; ?>">Email</a></li>
        </ul>
	  
	  
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
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
				if($permission == 'yes'){
					$text = "N/A";
					$id = 'nostandards';
				}
				else{
					if($am->final_status == 'fail' || $am->termsandc == 'fail') {
					//$text = "NON-COMPLIANT";
					$id = 'noncompliant';
					$title = 'Non-Compliant';
					$text_status = 'Non-Compliant';
					}
					else if($am->final_status == 'success'){
					//$text = "COMPLIANT";
					$id = 'compliant';
					$title = 'Compliant';
					$text_status = 'Compliant';
					}
					else if($am->final_status == 'medium'){
					//$text = "COMPLIANT & NON-COMPLIANT";
					$id = 'mediumcompliant';
					$title = 'Compliant & Non-Compliant';
					$text_status = 'Compliant and Non-Compliant';
					}
				}
				?>

	<div class="search-panel-image_rfp compliant_vendor" style="padding-left:16px;">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
		 <?php  if($globe != 'fail'){ ?>
			<a href="javascript:void(0);" onclick="getstandards('<?php echo $am->id; ?>','<?php echo $text_status; ?>');" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			<?php } else { ?>
			<a id="nostandards" href="javascript:void(0);" onclick="javascript:getcompstatus(<?php echo $am->id; ?>,'<?php echo $globe; ?>');" title="No Standards">N/A</a>
			<?php 
			}?>		

<?php    
if( $am->subscribe_type == 'free'  || $am->subscribe_type=='' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
				
			 </p>
	  </div>
	  
	  
    <div class="clr"></div>
  </div>
  </div>
    <?php } 
	 	

	} ?>
	
</div>
<?php }
 ?>

	</div>
	
	

	

</div>
<?php } else { ?>

<div id="preferred" style="display:none;">
<p>Please select which Vendors should receive a Personal Invitation to<br /> participate in your new request</p>
  <div id="preferred-vendorsfirst" class="breakclass" style="">
	  
<?php if($user->user_type == '13' && $user->accounttype == 'master'){ ?>
 <div id="i_bar_yellow" style=" background: #e6b613; box-shadow: 1px 2px 1px #808080; height: 34px; margin-bottom: 10px; text-align: center;">
 <?php } else { ?>
 <div id="i_bar">
 <?php } ?>
<div id="i_icon">
<a href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" mce_style="text-decoration: none;" style="text-decoration: none;"><img src="templates/camassistant_left/images/info_icon2.png" style="float:right;"> </a>
</div>
    <div id="i_bar_txt" style="text-align:center; padding:8px 0 0 35px;">
<span>

<?php 
$user =& JFactory::getUser();
if($user->user_type == '13' && $user->accounttype == 'master') 
echo "<font style='font-weight:bold; color:#fff;'>CORPORATE PREFERRED VENDORS</font>";
else
echo "<font style='font-weight:bold;'>MY VENDORS</font>";
?>
</span></div>
</div>

<?php 
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	
	if( $sort == 'asc' && $type == 'preferred' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'preferred' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}
	?>
	
	
	
	  
	  
	  <div id="heading_vendors">
<div class="checkbox_vendor"><input type="checkbox" value="" name="selectall" id="selectall_preferredvendors" />SELECT</div>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=242&type=preferred&sort=<?php echo $sort ; ?>">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor" style="padding-left:3px;">COMPLIANCE STATUS</div>
</div>
<?php


$star_vendors = $this->corporate ;
if($star_vendors){
	foreach($star_vendors as $star){
		$stars[] = $star->v_id;
	}
}

?>
 <p style="height:3px;"></p>
   <div class="clr"></div>
  </div>
  <div class="totalvendorspre_preferred">
<?php 
$items = $this->items;
$firmids = $this->firmids ;
//echo "<pre>"; print_r($items); echo "</pre>";
$count_corporate = 0;
if($items) {
foreach($items as $am ) {  

		if($user->user_type == '13' && $user->accounttype == 'master') {
			if( $am->subscribe_type == 'free' && $am->unverified == 'hide' )
				$display_block = 'none';
			else
				$display_block = '';
				
			if( ($am->final_status == 'fail' || $am->final_status == 'medium') && $am->block_nonc == 'hide' )
				$display_nonc = 'none';
			else
				$display_nonc = '';
		}
		else{
			$display_nonc = '';
			$display_block = '';
		}

	if( $compliance_filter == 'comp' )
		{
			if( $am->final_status != 'success' )
			$display_comp = 'none';
			else
			$display_comp = '';
		}
	else if( $compliance_filter == 'noncomp' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium'  || !$am->final_status)
			$display_noncomp = '';
			else
			$display_noncomp = 'none';
		}
			
if( $display_block == 'none' || $display_comp == 'none' ||  $display_noncomp == 'none' || $display_nonc == 'none'){		
	$final_display = 'none';
	$count_corporate ++ ;
	}
else{
	$final_display = '';	
	}
?> 

<?php
	$checkbox = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && ( $am->final_status == 'fail' || $am->final_status == 'medium') ){
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->final_status == 'success' ){
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && ( $am->final_status == 'fail' || $am->final_status == 'medium') ){
			$args = 'nonc';
			}
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium' ){
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	

?>		 
	<?php 
	if( $final_display != 'none' )
	$list_vendors[] = $am->vid;
	?>  
	  
  <div id="preferredvendors<?php echo  $am->vid; ?>" style="display:<?php echo $display; ?><?php echo $final_display; ?>">
  <div id="preferredvendorsinvitations">
   <div class="search-panel-middlepre checkbox_vendor">
      <?php 
	  if( $am->subscribe_type == 'free' && $am->unverified == 'hide' && $user->accounttype == 'master'){ ?>
	  <a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
	  else if( $checkbox != 'show' ) {  ?>
	  <a href="javascript:unverified(<?php echo $am->v_id; ?>,'<?php echo $args; ?>');" style="margin-left:-17px;"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php  } 
      else if($managertype != '2'){ ?>
	  <input type="checkbox" value="<?php echo  $am->vid; ?>" name="preferred" class="preferredvendors<?php echo $final_display; ?>" style="margin-left:-15px;" />
	   <?php } 
	  else { ?>
	  <a title="Add to My Vendors" href="javascript:sendinvitation(<?php echo  $am->v_id; ?>,'<?php echo $am->inhousevendors; ?>');" class="pre-red"><strong><img src="templates/camassistant_left/images/addicon.png" /></strong></a>
	  <?php } ?>
	  <br />
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
    <div class="search-panel-left_rfp company_vendor">

	   <ul>
        <li>
		
		<?php 
		$user =& JFactory::getUser();
		if (in_array($am->id, $stars)){ ?>
		<img src="templates/camassistant_left/images/star-icon.png"  title="Corporate Preferred Vendor" />
		<?php }
		else{
		}
		?><strong><a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name . ' ' .$am->lastname; ?> <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo "&nbsp;Ext.&nbsp;".$am->phone_ext; } else { echo ""; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ;  
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="font-weight:normal; color:gray;" class="miniemails" href="mailto:<?php echo $am->inhousevendors; ?>">Email</a></li>
        </ul>
	  
	  
		
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
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
				if($permission == 'yes'){
					$text = "N/A";
					$id = 'nostandards';
				}
				else{
					if($am->final_status == 'fail' || $am->termsandc == 'fail') {
					//$text = "NON-COMPLIANT";
					$id = 'noncompliant';
					$title = 'Non-Compliant';
					$text_status = 'Non-Compliant';
					}
					else if($am->final_status == 'success'){
					//$text = "COMPLIANT";
					$id = 'compliant';
					$title = 'Compliant';
					$text_status = 'Compliant';
					}
					else if($am->final_status == 'medium'){
					//$text = "COMPLIANT & NON-COMPLIANT";
					$id = 'mediumcompliant';
					$title = 'Compliant & Non-Compliant';
					$text_status = 'Compliant and Non-Compliant';
					}
				}
				?>

	<div class="search-panel-image_rfp compliant_vendor" style="padding-left:16px;">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
		 <?php  if($globe != 'fail'){ ?>
			<a href="javascript:void(0);" onclick="getstandards('<?php echo $am->id; ?>','<?php echo $text_status; ?>');" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			<?php } else { ?>
			<a id="nostandards" href="javascript:void(0);" onclick="javascript:getcompstatus(<?php echo $am->id; ?>,'<?php echo $globe; ?>');" title="No Standards">N/A</a>
			<?php 
			}?>		

<?php    
if( $am->subscribe_type == 'free'  || $am->subscribe_type=='' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
				
			 </p>
	  </div>
	  
	  
    <div class="clr"></div>
  </div>
  </div>
    <?php } 
	} 
	if( $count_corporate == count($items) || !$items ) {  ?>
	<p align="center" style="margin-top:20px; font-weight:bold;">There are no vendors available on this list with this sorting.</p>
	<?php }
	?> 
	</div>
	
	<?php 
	if($user->user_type == '13' && $user->accounttype == 'master') 
	$textshows =  "Remove from Corporate Preferred Vendors";
	else
	$textshows =  "Remove from My Vendors ";

	
	$user =& JFactory::getUser();
	if($user->accounttype != 'master'){
	 ?>
	<p style="height:50px;"></p>
	<div style="" class="breakclass" id="preferred-vendorsfirst">
  <?php /*?><div class="preferredvendors-head">
      <h5 style="float:left; background-image:none;">CORPORATE PREFERRED VENDORS</h5>
	  <a style="text-decoration: none;" mce_style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113"><img style="float:right;" src="/dev/templates/camassistant_left/images/preferred-arrow.jpg"> </a>
	<div class="clr"></div>  
      </div><?php */?>
	  
	 <div id="i_bar_yellow" style=" background: #e6b613; box-shadow: 1px 2px 1px #808080; height: 34px; margin-bottom: 10px; text-align: center;">
<div id="i_icon">
<a style="text-decoration: none;" mce_style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113"><img src="templates/camassistant_left/images/info_icon2.png" style="float:right;"> </a>
</div>
    <div id="i_bar_txt" style="text-align:center;  padding:8px 0 0 35px;">
<span><font style="font-weight:bold; color:#fff;">CORPORATE PREFERRED VENDORS</font></span></div>
</div>
	

	<?php 
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	
	if( $sort == 'asc' && $type == 'corporate' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'corporate' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}
	?>
		  
	 <div id="heading_vendors">
<div class="checkbox_vendor"><input type="checkbox" value="" name="selectall" id="selectall_corporates" />SELECT</div> 
<div class="company_vendor">
<a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=242&type=corporate&sort=<?php echo $sort ; ?>">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor" style="padding-left:3px;">COMPLIANCE STATUS</div>
</div> 
	  
<div class="clr"></div>
</div>
<div class="totalvendorspre_preferred">
<?php 
$vendor_first = $this->items ;
if($vendor_first){
	foreach($vendor_first as $vvv){
		$first_vendors[] = $vvv->id;
	}
}

//echo "<pre>"; print_r($first_vendors); echo "<pre>";
//echo "<pre>"; print_r($this->corporate); echo "<pre>";
$corporate = $this->corporate ;
$count_c_mgr = 0;
 if($corporate) {
foreach($corporate as $am ) {  
	if($ownids){
				if ( in_array($am->v_id, $ownids) )
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}
	if($first_vendors){
				if ( in_array($am->v_id, $first_vendors) )
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}	
	if( $am->subscribe_type == 'free' && $am->unverified == 'hide' )
		$display_block1 = 'none';
	else
		$display_block1 = '';	

	if( ( $am->final_status == 'fail' || $am->final_status == 'medium') && $am->block_nonc == 'hide' )
		$display_nonc = 'none';
	else
		$display_nonc = '';



	if( $compliance_filter == 'comp' )
		{
			if( $am->final_status != 'success' )
			$display_comp = 'none';
			else
			$display_comp = '';
		}
	else if( $compliance_filter == 'noncomp' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium' || !$am->final_status )
			$display_noncomp = '';
			else
			$display_noncomp = 'none';
		}
		
				
		if( $display == 'none' || $display_block1 == 'none' || $display_comp == 'none' || $display_noncomp == 'none' || $display_nonc =='none' ){
			$final_disp = 'none';
			$count_c_mgr ++;
		}
		else{
			$final_disp = '';
		}
?> 
<?php 
if( $final_disp != 'none' )
$list_vendors[] = $am->vid;
?>
<div id="preferredvendors<?php echo  $am->vid; ?>" style="display:<?php echo $final_disp; ?>">
   <div id="preferredvendorsinvitations">
   <div class="search-panel-middlepre checkbox_vendor">
     
	  <?php 
	  if( $am->subscribe_type == 'free' && $am->unverified == 'hide' ){ ?>
	  <a href="javascript:senderrormsg();"><img src="templates/camassistant_left/images/Block2.png" /></a>
	  <?php }
	  else{ ?>
	  <input type="checkbox" value="<?php echo  $am->vid; ?>-<?php echo  $am->v_id; ?>" name="corporates" class="corporates<?php echo $final_disp; ?>" />
	  <br />
	  <?php } ?>
	  
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
     <div class="search-panel-left_rfp company_vendor">
      <?php //if($am->subscribe == 'yes'){ ?>
	  <ul>
        <li><strong>
		<img src="templates/camassistant_left/images/star-icon.png" title="Corporate Preferred Vendor" /><a style="margin-left:2px;" href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am->id; ?>" target="_blank"><?php echo $am->company_name; ?></a></strong></li>
        <li><?php echo $am->name . ' ' .$am->lastname; ?> <?php echo $am->company_phone; ?>	<?php if($am->phone_ext){ echo "&nbsp;Ext.&nbsp;".$am->phone_ext; } else { echo ""; } ?></li>
		<?php
		$db = & JFactory::getDBO();
	$statecode  = "SELECT code from #__cam_vendor_states where id=".$am->state." " ; 
	$db->setQuery($statecode);
	$statea = $db->loadResult(); 
	?>
        <li><?php echo $am->city; ?>,&nbsp;<?php echo strtoupper($statea); ?></li>
        <li><a style="font-weight:normal; color:gray;" class="miniemails" href="mailto:<?php echo $am->inhousevendors; ?>">Email</a></li>
        </ul>
		<?php //} ?>
      </div>
	 
    <div class="search-panel-right_rfp apple_vendor">
	<?php
	$db = & JFactory::getDBO();
	$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$am->id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	//To get the CAMA rAting
		$camratingf = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
		$db->setQuery($camratingf);
		$cam_ratingf = $db->loadResult();
		
	if($count_vs){
		for($c=0; $c<count($count_vs); $c++){
		$total = $total + $count_vs[$c]->apple ;
		}
		$camrating = "SELECT camrating FROM `#__users` where id=".$am->id."  ";
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
				if($permission == 'yes'){
					$text = "N/A";
					$id = 'nostandards';
				}
				else{
					if($am->final_status == 'fail' || $am->termsandc == 'fail') {
					//$text = "NON-COMPLIANT";
					$id = 'noncompliant';
					$title = 'Non-Compliant';
					}
					else if($am->final_status == 'success'){
					//$text = "COMPLIANT";
					$id = 'compliant';
					$title = 'Compliant';
					}
					else if($am->final_status == 'medium'){
					//$text = "COMPLIANT & NON-COMPLIANT";
					$id = 'mediumcompliant';
					$title = 'Compliant & Non-Compliant';
					}
				}			
			?>
				
		<div class="search-panel-image_rfp compliant_vendor" style="padding-left:16px;">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
		  <?php  if($globe != 'fail'){ ?>
			<a href="javascript:void(0);" onclick="getstandards('<?php echo $am->v_id; ?>','<?php echo $title; ?>');" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			<?php } else { ?>
			<a id="nostandards" href="javascript:void(0);" onclick="javascript:getcompstatus(<?php echo $am->v_id; ?>,'<?php echo $globe; ?>');" title="No Standards">N/A</a>
			<?php }?>

<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $am->v_id; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>
			
			 </p>
	  </div>
	  	
    <div class="clr"></div>
  </div>
  </div>
   <?php } 
	}   
	if( $count_c_mgr == count($corporate) || !$corporate ){ ?>
	<p align="center" style="margin-top:20px; font-weight:bold;">There are no vendors available on this list with this sorting.</p>
	<?php }
	?>
	</div>

	<?php 
	}
?>

  <p style="height:50px;"></p>

	
	<?php /*?><div class="preferredvendors-head">
      <h5 style="float:left; background-image:none;">CO-WORKER PREFERRED VENDORS</h5>
	  <a href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" mce_style="text-decoration: none;" style="text-decoration: none;"><img src="templates/camassistant_left/images/preferred-arrow.jpg" style="float:right;"> </a>
	<div class="clr"></div>  
      </div><?php */?>
	<?php 
	$sort = JRequest::getVar('sort','');
	$type = JRequest::getVar('type','');
	
	if( $sort == 'asc' && $type == 'coworker' ){
	$id = 'compliant_desc' ;
	$sort = 'desc';
	}
	else if( $sort == 'desc' && $type == 'coworker' ){
	$id = 'compliant_asc' ;
	$sort = 'asc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_nosort' ;
	}
	?>

	  
	  <div id="i_bar">
<div id="i_icon">
<a href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" mce_style="text-decoration: none;" style="text-decoration: none;"><img src="templates/camassistant_left/images/info_icon2.png" style="float:right;"> </a>
</div>
    <div id="i_bar_txt" style="text-align:center;  padding:8px 0 0 35px;">
<span><font style="font-weight:bold;">CO-WORKER VENDORS</font></span></div>
</div>

	  
	  <div id="heading_vendors">
<div class="checkbox_vendor"><input type="checkbox" value="" name="selectall" id="selectall_coworkers" />SELECT</div>
<div class="company_vendor"><a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=242&type=coworker&sort=<?php echo $sort ; ?>">COMPANY</a></div>
<div class="apple_vendor">APPLE RATING</div>
<div class="compliant_vendor" style="padding-left:3px;">COMPLIANCE STATUS</div>
</div>
<div class="totalvendorspre_preferred"> 

  <?php //echo "<pre>"; print_r($firmids); echo "</pre>"; ?>
	  <?php
	  if(!$corporate)
	  $corporate = '';
	  else
	  $corporate = $corporate;
	  
if($corporate){
	foreach($corporate as $cor){
		$corporates[] = $cor->v_id;
	}
}
	  if(!$corporates)
	  $corporates[] = '';
	  else
	  $corporates[] = $corporates;
	  
$count_coworkers = 0;
	  if($firmids) {
foreach($firmids as $am ) {  
	if($ownids || $corporates){
			if($user->accounttype != 'master'){
				if ( in_array($am->v_id, $ownids) || in_array($am->id, $corporates) )
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}
			else{
				if ( in_array($am->v_id, $ownids) )
				  {
				  $display = 'none' ;
				  }
				else
				  {
				  $display = '' ;
				  }
			}	  
					}


	if( $compliance_filter == 'comp' )
		{
			if( $am->final_status != 'success' )
			$display_comp = 'none';
			else
			$display_comp = '';
		}
	else if( $compliance_filter == 'noncomp' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium'  || !$am->final_status )
			$display_noncomp = '';
			else
			$display_noncomp = 'none';
		}

		if( $display == 'none' || $display_comp == 'none' || $display_noncomp == 'none' ){
			$final_disp = 'none';
			$count_coworkers ++ ;
		}
		else{
			$final_disp = '';
		}	
					
?> 
<?php 
if( $final_disp != 'none' )
$list_vendors[] = $am->vid;
?>
  <div id="preferredvendors<?php echo  $am->vid; ?>" style="display:<?php echo $final_disp; ?>">
  <div id="preferredvendorsinvitations">
   <div class="search-panel-middlepre checkbox_vendor">
     <?php
	 if($am->v_id)
	 $v_id = $am->v_id ;
	 else
	 $v_id = $am->id ;
		 ?>
		 
<?php
	$checkbox = '';
	$args = '';
	if( $am->unverified == 'hide' && $am->block_nonc == 'hide' )
		{
			if( $am->subscribe_type == 'free' && ( $am->final_status == 'fail' || $am->final_status == 'medium') ){
			//$popupfunction = 'nonverified_nonc';
			$args = 'both';
			}
			else if( $am->subscribe_type == 'free' && $am->final_status == 'success' ){
			//$popupfunction = 'unverified';
			$args = 'un';
			}
			else if( $am->subscribe_type != 'free' && ( $am->final_status == 'fail' || $am->final_status == 'medium') ){
			//$popupfunction = 'verified_nonc';
			$args = 'nonc';
			}
			else{
			$checkbox = 'show';
			}
			
		}
	else if( $am->unverified == 'hide' )
		{
			if( $am->subscribe_type == 'free' ){
			//$popupfunction = 'unverified';
			$args = 'un';
			}
			else{
			$checkbox = 'show';
			}
		}
	else if( $am->block_nonc == 'hide' )
		{
			if( $am->final_status == 'fail' || $am->final_status == 'medium' ){
			//$popupfunction = 'verified_nonc';
			$args = 'nonc';
			}	
			else {
			$checkbox = 'show';	
			}
		}	
	else {
		$args = '';
		$checkbox = 'show';	
	}	
?>		 
	  <?php if( $checkbox != 'show' )	{ ?>
	  <a href="javascript:unverified(<?php echo $am->id; ?>,'<?php echo $args; ?>');" style="margin-left:-17px;"><img src="templates/camassistant_left/images/Block2.png" /></a>
	 <?php } else { ?>
	  <input type="checkbox" value="<?php echo  $am->vid; ?>-<?php echo  $v_id; ?>" name="coworkers" class="coworkers<?php echo $final_disp; ?>" />
	  <br />
	  <?php } 
	  $checkbox = '';
	  ?>
	<span id="removing<?php echo  $am->vid; ?>" style="color:#6DAA00; font-weight:bold;"></span>
      </div>
     <div class="search-panel-left_rfp company_vendor">
     
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
        <li><a style="font-weight:normal; color:gray;" class="miniemails" href="mailto:<?php echo $am->inhousevendors; ?>">Email</a></li>
        </ul>
		
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
				if($permission == 'yes'){
					$text = "N/A";
					$id = 'nostandards';
				}
				else{
					if($am->final_status == 'fail' || $am->termsandc == 'fail') {
					//$text = "NON-COMPLIANT";
					$id = 'noncompliant';
					$title = 'Non-Compliant';
					}
					else if($am->final_status == 'success'){
					//$text = "COMPLIANT";
					$id = 'compliant';
					$title = 'Compliant';
					}
					else if($am->final_status == 'medium'){
					//$text = "COMPLIANT & NON-COMPLIANT";
					$id = 'mediumcompliant';
					$title = 'Compliant & Non-Compliant';
					}
				}
			?>
		<div class="search-panel-image_rfp compliant_vendor" style="padding-left:16px">
	  	  <p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; padding-right:0px;">
		  <?php 
		  if($am->v_id)
		  $vidc = $am->v_id;
		  else
		  $vidc = $am->id;
			?>
		  <?php  if($globe != 'fail'){ ?>
			<a href="javascript:void(0);" onclick="getstandards('<?php echo $vidc; ?>','<?php echo $title; ?>');" id="<?php echo $id; ?>" title="<?php echo $title; ?>"><?php echo $text; ?></a>
			<?php } else { ?>
			<a id="nostandards" href="javascript:void(0);" onclick="javascript:getcompstatus(<?php echo $vidc; ?>,'<?php echo $globe; ?>');" title="No Standards">N/A</a>
			<?php }
			
			?>
<?php
if( $am->subscribe_type == 'free' ) { ?>
<div class="unverifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $vidc; ?>,'unverified');" title="">UNVERIFIED</a></div>
<?php } else {  ?>
<div class="verifiedvendor"><a href="javascript:void(0);" onclick="unverified(<?php echo $vidc; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
<?php } ?>			
			 </p>
	  </div>
	  
    <div class="clr"></div>
  </div>
  </div>
    <?php } 
	} 
	if($count_coworkers == count($firmids) || !$firmids){ ?>
	<p align="center" style="margin-top:20px; font-weight:bold;">There are no vendors available on this list with this sorting.</p>
	<?php }
	?> 
	</div>
	<?php
	if($user->user_type == '13' && $user->accounttype == 'master') 

	$textshows_co =  "Add to Corporate Preferred Vendors";
	else
	$textshows_co =  "Add to My Vendors";
	
?>

</div>
</div>

<?php } ?>
</body>
</html>
<?php 
$vendor_ids = implode(',',$list_vendors); ?>
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="rfp" name="controller" />
<input type="hidden" value="invited_basicrfp" name="task" />
<input type="hidden" value="<?php echo $vendor_ids; ?>" name="allvendors" class="allvendors" />
<input type="hidden" value="" name="selected_vendors" id="selected_vendors" />
<div class="basic_new11">
<div align="center"  id="cancel_basic"><a href="javascript:void(0);" class="cancel_basic"></a></div>	
<div align="center"><a href="javascript:void(0);" class="continue_basic"></a></div>
</div>
</form>
<div id="loading-div-background">
  <div id="loading-div" class="ui-corner-all">
    <img style="height:32px;width:32px;margin:30px;" src="templates/camassistant_left/images/loading_icon.gif" alt="Loading.."/><br>Please wait while your request is being submitted.
  </div>
</div>

<div id="boxesvrecdonee" class="boxesvrecdonee">
<div id="submitvrecdonee" class="windowvrecdonee" style="top:300px; left:582px; border:6px solid red; position:fixed;">
<br/>
<p align="center" style="color:gray; font-size:14px;">You must choose either 'Open Invitation' or 'Personal Invitation' to continue.</p>
<div class="recoommend_alert">
<div id="closevrecdonee" name="closeprecdonee" value="Cancel" class="ok_newone_recom_gray"></div>
</div>
</div>
<div id="maskvrecdonee"></div>
</div>