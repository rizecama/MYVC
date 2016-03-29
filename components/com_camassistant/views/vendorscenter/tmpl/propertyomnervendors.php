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
#donereq {border:0 none; cursor:pointer; height:30px; margin-top:-31px; float:right; width:160px; }
#closereq { border:0 none; cursor:pointer; height:30px; margin:0 0 0 -8px; color:#000000; font-weight:bold; font-size:20px; width:200px;}

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
function deletevendor(){

L = jQuery.noConflict();
	
	


var matches = [];
var matchesa = [];
var countp = 0 ;
L(".preferredvendors:checked").each(function() {
    matches.push(this.value);
	countp++ ;
});
if(countp == '0'){
alert("Please make a selection to REMOVE the vendors.");
}
else {
		
		L(".preferredvendors:checked").each(function() {
				matchesa.push(this.value);
			});
		matchesa = matchesa.join(',') ;
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkvendorpre", {vendorid: ""+matchesa+""}, function(datares){
		datas = datares.trim();
		
			if( datas == 'cannot' ) {
				geterrorpopuptodelete();
			}	
			else{
				getnormalpopup(matchesa);
			}
		});
		
		
	}
}
function geterrorpopuptodelete(){
		var maskHeight = L(document).height();
		var maskWidth = L(window).width();
		L('#maskpl').css({'width':maskWidth,'height':maskHeight});
		L('#maskpl').fadeIn(100);
		L('#maskpl').fadeTo("slow",0.8);
		var winH = L(window).height();
		var winW = L(window).width();
		L("#submitpl").css('top',  winH/2-L("#submitpl").height()/2);
		L("#submitpl").css('left', winW/2-L("#submitpl").width()/2);
		L("#submitpl").fadeIn(2000);
		L('.windowpl #cancelpl').click(function (e) {
		e.preventDefault();
		L('#maskpl').hide();
		L('.windowpl').hide();
		});
	
}
function getnormalpopup(matchesa){
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
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=removevendor", {vendorid: ""+matchesa+""}, function(data){
				if(data==1){
				location.reload(); 
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

function excludevendor(){
L = jQuery.noConflict();
var matches = [];
var matchese = [];
var counte = 0 ;
L(".preferredvendors:checked").each(function() {
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
		L(".preferredvendors:checked").each(function() {
			matchese.push(this.value);
			});
			matchese = matchese.join(',') ;
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=excludevendor", {vendorid: ""+matchese+""}, function(data){
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
function basicrequest(from){
L = jQuery.noConflict();
var matches = [];
var matchesa = [];
var countp = 0 ;
var newid = null;
	
		L(".preferredvendors:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		L(".coworkers:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		L(".corporates:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
if(countp == '0'){
alert("Please select at least one Vendor to include in this request.");
}
else{
		L(".preferredvendors:checked").each(function() {
		matchesa.push(this.value);		
		});
		L(".coworkers:checked").each(function() {
		myString = this.value ;
		var myArray = myString.split('-');
		matchesa.push(myArray[0]);
		});
		L(".corporates:checked").each(function() {
		myString = this.value ;
		var myArray = myString.split('-');
		matchesa.push(myArray[0]);
		});
		
	matchesa = matchesa.join(',') ;
	L('#selected_vendors').val(matchesa)  ;		
	
	/*el='<?php  //echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=basicrequest';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 672, y:600}}"))
	SqueezeBox.fromElement(el,options);*/
		L = jQuery.noConflict();
		L('body,html').animate({
				scrollTop: 250
				},800);
		var maskHeight = L(document).height();
		var maskWidth = L(window).width();
		L('#maskreq').css({'width':maskWidth,'height':maskHeight});
		L('#maskreq').fadeIn(100);
		L('#maskreq').fadeTo("slow",0.8);
		var winH = L(window).height();
		var winW = L(window).width();
		//L("#submitv").css('top',  '300');
		//L("#submitv").css('left', '582');
		L("#submitreq").css('top',  winH/2-L("#submitreq").height()/2);
		L("#submitreq").css('left', winW/2-L("#submitreq").width()/2);
				
		L("#submitreq").fadeIn(2000);
		L('.windowreq #donereq').click(function (e) {
			//Validation part
			if( L('#property_id').val() == '' || L('#property_id').val() == '0' ){
				alert("Please select a Property from the list.");
				return false;
			}
			else if( L('#projectName').val() == '' ){
				alert("Please enter Reference name.");
				return false;
			}
			else if( L('#proposalDueDate').val() == '' ){
				alert("Please enter Requested Due Date.");
				return false;
			}
			else if( L('#scopeofwork').val() == '' ){
				alert("Please enter Scope of work.");
				return false;
			}
			else{
			//alert("can");
			L(document).ready(function (){
			L("#loading-div-background").show();
			});
			L('#basicrequest').submit();
			}
		e.preventDefault();
		L('#maskreq').hide();
		L('.windowreq').hide();
		});
		L('.windowreq #closereq').click(function (e) {
		e.preventDefault();
		L('#maskreq').hide();
		L('.windowreq').hide();
		});
		
}

}	


function inviteto_basicrequest(type,basics){
	L = jQuery.noConflict();
	var matches = [];
	var matchesa = [];
	var countp = 0 ;
	var newid = null;
		L(".preferredvendors:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		L(".corporates:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		L(".coworkers:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
		
	if(basics == 'no')
	var height = '250' ;
	else
	height = '320';
	if(countp == '0'){
		alert("Please select at least one Vendor to invite to an existing Basic Request");
	}
	else{
			L(".preferredvendors:checked").each(function() {
			matchesa.push(this.value);		
			});
			L(".corporates:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesa.push(myArray[0]);
			});
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesa.push(myArray[0]);
			});
		
		matchesa = matchesa.join(',') ;
		
		el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=getbasicrequests&vendors='+matchesa;
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
		SqueezeBox.fromElement(el,options);
	}
}

// Function to recommend vendors to other managers
function vendor_recommend(height){
	L = jQuery.noConflict();
	var matchesr = [];
	var matchesar = [];
	var countpr = 0 ;
	var newidr = null;
		L(".preferredvendors:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		L(".corporates:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		L(".coworkers:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		
	if(countpr == '0'){
		alert("Please select at least one Vendor to recommend.");
	}	
	else{
			L(".preferredvendors:checked").each(function() {
			matchesar.push(this.value);		
			});
			L(".corporates:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesar.push(myArray[0]);
			});
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesar.push(myArray[0]);
			});
		matchesar = matchesar.join(',') ;
		el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=getallpropertyownersrecommend&vendors='+matchesar;
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 600, y:330}}"))
		SqueezeBox.fromElement(el,options);
	}
}

// Function to send the mail to vendors
function vendor_mails(){
	L = jQuery.noConflict();
	var matchesr = [];
	var matchesar = [];
	var countpr = 0 ;
	var newidr = null;
		L(".preferredvendors:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		L(".corporates:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		L(".coworkers:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		
	if(countpr == '0'){
		alert("Please select at least one Vendor to send the mail.");
	}	
	else {
			L(".preferredvendors:checked").each(function() {
			matchesar.push(this.value);		
			});
			L(".corporates:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesar.push(myArray[0]);
			});
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesar.push(myArray[0]);
			});
		matchesar = matchesar.join(',') ;
		el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=sendmail_vendors&vendors='+matchesar;
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y: 530}}"))
		SqueezeBox.fromElement(el,options);
	}
}
function addEventa2(id2)
	{
			L = jQuery.noConflict();
			var arrlicen2=new Array();
			var ni2 = document.getElementById('newdiva2'+id2);
			var numi2 = document.getElementById('theValue');
			var num2 = (document.getElementById("theValue").value -1)+ 2;
			numi2.value = num2;
			var divIdName2 = "newSelector"+num2;
			minheight = L( '.windowreq' ).height() ;
            newitem2='<table><tr><input type="hidden" name="old_docids[]" /><td><span id="delimg'+id2+''+num2+'" style="display:none" title="Remove From RFP"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer;" onclick="javascript:deletelineupload('+id2+''+num2+','+num2+');"/></span></td><td><span id="uploadfile'+id2+''+num2+'" style="float:left;width:auto;padding-right:5px; font-size:14px; color:#8FD800;"></span></td><input type="hidden" value=" " name="linetask_uploads_2'+id2+'[]" id="lineuploads'+id2+''+num2+'"  ></tr></table>';
			var newdiva2 = document.createElement('div');
			newdiva2.setAttribute("id",divIdName2);
			newdiva2.innerHTML = newitem2;
			ni2.appendChild(newdiva2);
			/*nextheight = parseInt(minheight + 20) ;
			L('.windowreq').css('height',nextheight+'px');*/
			linetaskupload(id2+''+num2);
	}
	function linetaskupload(id){
		L = jQuery.noConflict();
		property_id = L('#property_id').val();
		if( L('#property_id').val() == '' || L('#property_id').val() == '0' )
			{
				alert('Please Select the Property.');
			}
		else
			{
				el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=rfp&task=upload_select&taskid='+id+'&pid='+property_id+'&mid='+<?php echo $user->id; ?>;
				var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 700, y:330}}"))
				SqueezeBox.fromElement(el,options);
			}
	}
	function deletelineupload(taskid,num){
		var res = confirm("Are you sure you want to remove this file from the RFP?");
			if(res==true){
				window.parent.document.getElementById('lineuploads'+taskid).value ='';
				window.parent.document.getElementById('delimg'+taskid).style.display ='none';
				window.parent.document.getElementById('uploadfile'+taskid).style.display ='none';
				window.parent.document.getElementById('newSelector'+num).style.display ='none';
			}
	}	
	
	H(document).ready( function(){
	H('.rejectrecommendations').click(function(){
		var recid = H(this).attr('rel');
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=rejectrecs", {Id: ""+recid+""}, function(data){
					location.reload();
				});	
	});
	H('.acceptrecommendations').click(function(){
		var totalid = H(this).attr('rel');
		var bothids = totalid.split('-');
		// To check the vendor is already in his list
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkiniteslist", {Id: ""+bothids[0]+""}, function(data){
			if(data == ' yes'){
				L = jQuery.noConflict();
				L('body,html').animate({
				scrollTop: 250
				},800);
				var maskHeight = L(document).height();
				var maskWidth = L(window).width();
				L('#maskvrec').css({'width':maskWidth,'height':maskHeight});
				L('#maskvrec').fadeIn(100);
				L('#maskvrec').fadeTo("slow",0.8);
				var winH = L(window).height();
				var winW = L(window).width();
				//L("#submitv").css('top',  '300');
				//L("#submitv").css('left', '582');
				L("#submitvrec").css('top',  winH/2-L("#submitvrec").height()/2);
				L("#submitvrec").css('left', winW/2-L("#submitvrec").width()/2);
				
				L("#submitvrec").fadeIn(2000);
				L('.windowvrec #closevrec').click(function (e) {
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=rejectrecs&from=accept", {Id: ""+bothids[1]+""}, function(data){
				location.reload();
				});
				e.preventDefault();
				L('#maskvrec').hide();
				L('.windowvrec').hide();
				});
			}
			else{
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+bothids[0]+""}, function(data){
				if(data){
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=rejectrecs&from=accept", {Id: ""+bothids[1]+""}, function(data){
				location.reload();
				});
				
				}
				});
		
			}
		});
				
		
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
</script>
</head>

<body>

<br />
<div id="add-vendor">
<div id="results" class="companies">
</div>

<div class="clr"></div>

<div class="clr"></div>

<div id="recommendations">
<?php 
if($recommends){ for( $r=0; $r<count($recommends); $r++ ){?>
<div class="managerrecs">
	<div class="acceptrecs"><a href="javascript:void(0);" rel="<?php echo $recommends[$r]->vendorid.'-'.$recommends[$r]->id; ?>" class="acceptrecommendations" title="Add to your 'My Vendors' list"></a></div>
	<div class="recsname">
	<span><?php echo $recommends[$r]->sendername; ?></span> has recommended this Vendor to you:
	<h2> - <a class="profilerecs" href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $recommends[$r]->vendorid; ?>" target="_blank"><?php echo $recommends[$r]->vendorname; ?></a> - </h2>
	</div>
	<div class="rejectrecs"><a href="javascript:void(0);" rel="<?php echo $recommends[$r]->id; ?>" class="rejectrecommendations" title="Remove vendor recommendation"></a></div>
</div>
<?php } 
echo "<br /><br />"; 
}
?>
</div>

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
	  <tr class="height_county" height="15" style="display:none;"></tr>
	  <tr><td>
	  <select style="width: 400px; margin-left:0px;margin-right:5px; opacity:0.5; display:none;" name="divcounty" id="divcounty" onchange="javascript:speccounty()" >
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

<tr height="15"></tr>
<tr><td>    
	  <select name="compliance" style="width:400px; margin-left:0px;" id="compliance" onchange="javascript:changecomplince();" >
			 <option value="0" <?php if($_REQUEST['compliance'] == '0'){ ?> selected="selected" <?php } ?>>All Compliance Statuses</option>
			 <option value="comp" <?php if($_REQUEST['compliance'] == 'comp'){ ?> selected="selected" <?php } ?>>Compliant</option>
			 <option value="noncomp" <?php if($_REQUEST['compliance'] == 'noncomp'){ ?> selected="selected" <?php } ?>>Non-Compliant</option>
	  </select>
	  </td></tr>
	  
<tr height="15"></tr>
<tr><td>    
	  <select name="verification" style="width:400px; margin-left:0px;" id="compliance" onchange="javascript:changeverification();" >
			 <option value="0" <?php if($_REQUEST['verification'] == '0'){ ?> selected="selected" <?php } ?>>All Verification Statuses</option>
			 <option value="ver" <?php if($_REQUEST['verification'] == 'ver'){ ?> selected="selected" <?php } ?>>Verified</option>
			 <option value="unver" <?php if($_REQUEST['verification'] == 'unver'){ ?> selected="selected" <?php } ?>>Unverified</option>
	  </select>
	  </td></tr>
	  
	  	  	  
	  <tr height="50"></tr>
	<input type="hidden" name="option" value="com_camassistant" />
	<input type="hidden" name="controller" value="vendorscenter" />
	<input type="hidden" name="view" value="vendorscenter" />
	<input type="hidden" name="task" value="vendorscenter" />
	<!--<input type="hidden" name="managertype" id="managertype" value="" />
	<input type="hidden" name="industrytype" id="industrytype" value="" />	-->
	</tbody></table>
	</div>
	</form>

<?php 
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
	  
	 <div id="i_bar_terms">
<div id="i_icon">
<a style="text-decoration: none;" mce_style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=250&amp;Itemid=113"><img src="templates/camassistant_left/images/info_icon2.png" style="float:right;"> </a>
</div>
    <div id="i_bar_txt" style="text-align:center;  padding:8px 0 0 35px;">
<span><font style="font-weight:bold; color:#fff;">MY VENDORS</font></span></div>
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
//echo "<pre>"; print_r($corporate); echo "<pre>";
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
        <li><a style="font-weight:normal; color:gray;" class="miniemails" href="mailto:<?php echo $am->inhousevendors.  '?cc=' .$am->ccemail; ?>">Email</a></li>
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
	<?php if($corporate) { ?>
	<div align="center" style="margin-top:17px;">
	<a title="Add to My Vendors" class="addicon" href="javascript:sendinvitationcorporate();"></a>
	<a title="Email Vendor(s)" class="vendor_mails" href="javascript:vendor_mails();"></a>
	<a title="Create a new Basic Request" class="basicrequest" href="javascript:basicrequest('cor');"></a>
	<a title="Invite Vendor(s) to existing Basic Request" class="basicrequest_invite" href="javascript:inviteto_basicrequest('cor','<?php echo $basics; ?>');"></a>
	<a title="Recommend to Co-Workers" class="vendor_recommend" href="javascript:vendor_recommend(<?php echo $height; ?>);"></a>
	
	</div>
	<?php } ?>
	
	<?php 
	}
?>



	
<?php


$star_vendors = $this->corporate ;

if($star_vendors){
	foreach($star_vendors as $star){
		$stars[] = $star->v_id;
	}
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
<span><font style="font-weight:bold; color:#fff; text-transform:uppercase;"><strong><?php echo $managername->name.'&nbsp;'.$managername->lastname ?></strong></font></span>

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
	
	
</body>
</html>

<div id="boxesv" class="boxesv">
<div id="submitv" class="windowv" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">This Vendor will be REMOVED from your Vendor List</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">

<div id="closev" name="closep" value="Cancel"><img src="templates/camassistant_left/images/cancel.gif" /></div>
<div id="donev"  name="donev" value="Ok"><img src="templates/camassistant_left/images/ok.gif" /></div>
</div>
</form>

</div>
  <div id="maskv"></div>
</div>

<div id="boxesun" class="boxesun">
<div id="submitun" class="windowun" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">The Profile Page for this Vendor is not available due to an expired account.</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="doneun"  name="doneun" value="Ok"><img src="templates/camassistant_left/images/OK.gif" /></div>
</div>
</form>

</div>
  <div id="maskun"></div>
</div>


<div id="boxese" class="boxese">
<div id="submite" class="windowe" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">This Vendor will be BLOCKED from participating in any of your Managers' projects</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="closee" name="closee" value="Cancel"><img src="templates/camassistant_left/images/cancel.gif" /></div>
<div id="donee"  name="donee" value="Ok"><img src="templates/camassistant_left/images/ok.gif" /></div>
</div>
</form>

</div>
  <div id="maske"></div>
</div>

<div id="boxesreq" class="boxesreq">
<div id="submitreq" class="windowreq" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed; overflow-y:scroll;">
<div style="padding:10px 10px 12px; text-align:center;">
<form name="basicrequest" id="basicrequest" method="post">
<div class="light_box">
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">BASIC REQUEST</font></span>
</div></div>


<div class="list_box">
<ul>
<li>
<label>Select Property</label>
<?php 
$properties = $this->properties ;
 ?>
	<select id="property_id" name="property_id" style="width:101%; height:32px; padding:5px;">
	<option value="0">Please select property</option>
	<?php
		for( $p=0; $p<count($properties); $p++ ){ ?>
		<option value="<?php echo $properties[$p]->id; ?>"><?php echo str_replace('_',' ',$properties[$p]->property_name); ?></option>
		<?php }
	?>
	</select>
</li>
<li>
<label>Reference Name for this Request</label>
<input type="text" name="projectName" id="projectName"  />
</li>
<li>
<label>Requested Due Date</label>
<input type="text" name="proposalDueDate" readonly="readonly" id="proposalDueDate" />
</li>
<script type="text/javascript">
H = jQuery.noConflict();
H('#proposalDueDate').datetimepicker({
			dateFormat: 'mm-dd-yy',
			//minDate: '10D',
			minDate: '0D',
			//minDate: 'new',
			 timeFormat: 'hh:00',
			 hour: 12,
			 minute: 00,
			changeYear: true,changeMonth:true,
});

H("#proposalDueDate").click(function () {
			 var someDate = new Date();
			var numberOfDaysToAdd = 7;
			someDate.setDate(someDate.getDate() + numberOfDaysToAdd); 
			var dd = someDate.getDate();
			var mm = someDate.getMonth() + 1;
			var y = someDate.getFullYear();
			var newdate = mm + '-'+ dd + '-'+ y + '12:00';
			 H('#proposalDueDate').datetimepicker('setDate', newdate);
                  });
				  
</script>
<li class="text_areabox">
<label>Scope of Work (SOW)</label>
<textarea name="jobnotes" id="scopeofwork"></textarea>
<span id='upload_file10' style="float:left;width:auto;padding-right:5px; margin-top:5px; padding-left:2px;"><a class="upload_new_files_rfp" href="javascript:addEventa2('10');">
<p style="height:10px;"></p></a></span>
<span id="delimg10" style="display:none" title="Remove From RFP"><img src="templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer; margin-top:13px;" onclick="javascript:deletelineupload_line(10);"  /></span>
<div class="clear"></div>
<div id="newdiva210" style="margin-top:10px;"></div>
<input name="hidden" type="hidden" id="theValue" value="0">
<input name="hidden" type="hidden" id="idval" value="0">

</li>
<div id="topborder_row"></div>
<li class="buttons_basic"> 
<div id="closereq" name="closereq" value="Cancel"> <a class="cancel_basci_submit" href="javascript:void(0);"></a></div>
<div id="donereq"  name="donereq" value="Ok"><a class="submit_basci_submit" href="javascript:void(0);"></a></div>
</li>
</ul>
</div>
</div>
</div>
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="rfp" />
<input type="hidden" name="task" value="submit_rfp" />
<input type="hidden" name="rfp_type" value="rfp" />
<input type="hidden" name="basicrequest" value="basicrequest" />
<input type="hidden" name="selected_vendors" id="selected_vendors" value="" />
</form>

</div>
  <div id="maskreq"></div>
</div>


<div id="boxesvrec" class="boxesvrec">
<div id="submitvrec" class="windowvrec" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">This Vendor already exists in your "My Vendors" list"</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="closevrec" name="closeprec" value="Cancel"><img src="templates/camassistant_left/images/OK.gif" /></div>
</div>
</form>
</div>
<div id="maskvrec"></div>
</div>

<div id="loading-div-background">
  <div id="loading-div" class="ui-corner-all">
    <img style="height:32px;width:32px;margin:30px;" src="templates/camassistant_left/images/loading_icon.gif" alt="Loading.."/><br>Please wait while your request is being submitted.
  </div>
</div>


<div id="boxespl" style="top:576px; left:582px;">
<div id="submitpl" class="windowpl" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="wrongrequestmsg_remove">This Vendor has purchased an active Preferred Vendor Code.  As a result, you cannot remove them from the Corporate Preferred Vendor list. Once you cancel a code, you may then manually remove any Vendors who purchased that code from this list.</p>
</div>
<div style="padding-top:20px;" align="center">
<div id="cancelpl" name="donepl" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskpl"></div>
</div>


<div id="boxesvrecdone" class="boxesvrecdone">
<div id="submitvrecdone" class="windowvrecdone" style="top:300px; left:582px; border:6px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray; font-size:13px;">Vendor(s) recommended successfully</p>
<div class="recoommend_alert">
<div id="closevrecdone" name="closeprecdone" value="Cancel" class="ok_newone_recom"></div>
</div>
</div>
<div id="maskvrecdone"></div>
</div>
