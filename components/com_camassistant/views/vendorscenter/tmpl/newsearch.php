<?php 
$user=& JFactory::getuser();
$countofmngrs = count($this->managers_recs);
	//echo $countofmngrs; exit; 
	if( $countofmngrs == 0 )
		$height = '300';
	else if( $countofmngrs > 0 && $countofmngrs <= 6 )
		$height = '350';
	else
		$height = '370';
		
?>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<style>
#maskun {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesun .windowun {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesun #submitun {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesun #submitun a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneun {border:0 none; cursor:pointer; height:30px; margin-left:-78px; margin-top:-11px; width:474px; float:left; }
#closeun { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}

</style>
<script type="text/javascript">
H = jQuery.noConflict();
function county(){
H("#divStates").show();
var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=addproperty&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
H("#divcounty").html(data);
}
});

var state = H("#stateid").val();
var county = H("#divcounty").val();
var industry = H("#industry").val();
//alert(state);
//alert(county);
//alert(industry);
if(state != '' && county != '' && industry != ''){
//H("#newsearch").show();
}
else{
}


}
function displayindustry(){
	H("#divindustries").show();
	
}

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
	H('body,html').animate({
		scrollTop: 250
		},800);
		
	H('#results').addClass('loader');
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkcompany", {cname: ""+companyname+""}, function(data){
		if(data) {
		 document.getElementById("preferred-vendorsfirst").style.marginTop="50px";
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

H('.sortelement').live("click",function(){
sort_data = H(this).attr('data');
var companyname = H("#companyname").val();
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkcompany&sort="+sort_data, {cname: ""+companyname+""}, function(data){
		if(data) {
		 document.getElementById("preferred-vendorsfirst").style.marginTop="50px";
		H('#results').html(data).slideDown('slow');
		H('#results').removeClass('loader');
		}
		else{
		H('#results').removeClass('loader');
		}
	});
	

}); 

H('.sortelementnewsearch').live("click",function(){
sort_data = H(this).attr('data');
var state = H("#stateid").val();
var county = H("#divcounty").val();
var industry = H("#industry").val();
H('#results').addClass('loader');
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checknewsearch&sort="+sort_data+"&state="+state+"&county="+county+"&ind="+industry+"", function(data){
		if(data) {
		H('#results').html(data).slideDown('slow');
		H('#results').removeClass('loader');
		}
		else{
		H('#results').removeClass('loader');
		}
	});
}); 




H("#industry").change(function(){
var state = H("#stateid").val();
var county = H("#divcounty").val();
var industry = H("#industry").val();
if(state != '' && county != '' && industry != ''){
H("#newsearch").show();
}
else{

}
});

H("#divcounty").change(function(){
var state = H("#stateid").val();
var county = H("#divcounty").val();
var industry = H("#industry").val();
if(state != '' && county != '' && industry != ''){
H("#newsearch").show();
}
else{
}
});

// To get the values with dropdowns serach
H('#newsearch').click(function(){
var state = H("#stateid").val();
var county = H("#divcounty").val();
var industry = H("#industry").val();
if(state == '') {
alert("please select the state");
return false;
}
if(county == '') {
alert("please select the County");
return false;
}
if(industry == '') {
alert("please select the industry");
return false;
}
H('#results').addClass('loader');
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checknewsearch&state="+state+"&county="+county+"&ind="+industry+"", function(data){
		if(data) {
		H('body,html').animate({
		scrollTop: 250
		},800);
		H('#results').html(data).slideDown('slow');
		H('#results').removeClass('loader');
		}
		else{
		H('#results').removeClass('loader');
		}
	});

return false; 

});

//Completed

H('#selectall_preferredvendors').live("click",function(){
		if( H("#selectall_preferredvendors").prop("checked") == true )
		H(".coworkers").attr("checked", true);
		else
		H(".coworkers").attr("checked", false);
	});
	
	
});


function sendinvitationcorporate(type){
//H('#companyid'+id).html('Adding...');
var matchesc = [];
var matchesb = [];
var countc = 0 ;
H(".coworkers:checked").each(function() {
    matchesc.push(this.value);
	countc++ ;
});
if(countc == '0'){
	if(type == 'add'){
		alert("Please make a selection to ADD the vendors.");
	}
	else{
		alert("Please make a selection to EXCLUDE the vendors.");
	}
}
else {
	
		if(type == 'exclude'){
				H('body,html').animate({
				scrollTop: 250
				},800);
				var maskHeight = H(document).height();
				var maskWidth = H(window).width();
				H('#maskes').css({'width':maskWidth,'height':maskHeight});
				H('#maskes').fadeIn(100);
				H('#maskes').fadeTo("slow",0.8);
				var winH = H(window).height();
				var winW = H(window).width();
				//L("#submitv").css('top',  '300');
				//L("#submitv").css('left', '582');
				H("#submites").css('top',  winH/2-H("#submites").height()/2);
				H("#submites").css('left', winW/2-H("#submites").width()/2);
						
				H("#submites").fadeIn(2000);
				H('.windowes #donees').click(function (e) {
				e.preventDefault();
				H('#maskes').hide();
				H('.windowes').hide();
				H(".coworkers:checked").each(function() {
				myString = this.value ;
				var myArray = myString.split('-');
				matchesb.push(myArray[1]);
				});
				matchesb = matchesb.join(',') ;
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+matchesb+"",actype: ""+type+""}, function(data){
				if(data){
				location.reload();
				}
				});
				});
				
				H('.windowes #closees').click(function (e) {
				e.preventDefault();
				H('#maskes').hide();
				H('.windowes').hide();
				});
		}
		else{ 
			H(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesb.push(myArray[1]);
			});
			matchesb = matchesb.join(',') ;
//			alert(type);
			H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+matchesb+"",actype: ""+type+""}, function(data){
			if(data){
			window.location = 'index.php?option=com_camassistant&controller=vendorscenter&task=mastermyvendors&Itemid=279';
			}
			});
			}
}

}


function sendpreferredvendor_invitation(type){
//H('#companyid'+id).html('Adding...');
var matchesc = [];
var matchesb = [];
var countc = 0 ;
H(".coworkers:checked").each(function() {
    matchesc.push(this.value);
	countc++ ;
});
if(countc == '0'){
	if(type == 'add'){
		alert("Please make a selection to ADD the vendors.");
	}
	else{
		alert("Please make a selection to EXCLUDE the vendors.");
	}
}
else {
	
		if(type == 'exclude'){
				H('body,html').animate({
				scrollTop: 250
				},800);
				var maskHeight = H(document).height();
				var maskWidth = H(window).width();
				H('#maskes').css({'width':maskWidth,'height':maskHeight});
				H('#maskes').fadeIn(100);
				H('#maskes').fadeTo("slow",0.8);
				var winH = H(window).height();
				var winW = H(window).width();
				//L("#submitv").css('top',  '300');
				//L("#submitv").css('left', '582');
				H("#submites").css('top',  winH/2-H("#submites").height()/2);
				H("#submites").css('left', winW/2-H("#submites").width()/2);
						
				H("#submites").fadeIn(2000);
				H('.windowes #donees').click(function (e) {
				e.preventDefault();
				H('#maskes').hide();
				H('.windowes').hide();
				H(".coworkers:checked").each(function() {
				myString = this.value ;
				var myArray = myString.split('-');
				matchesb.push(myArray[1]);
				});
				matchesb = matchesb.join(',') ;
				H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addpreferredvendor", {vendorid: ""+matchesb+"",actype: ""+type+""}, function(data){
				if(data){
				location.reload();
				}
				});
				});
				
				H('.windowes #closees').click(function (e) {
				e.preventDefault();
				H('#maskes').hide();
				H('.windowes').hide();
				});
		}
		else{ 
			H(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesb.push(myArray[1]);
			});
			matchesb = matchesb.join(',') ;
//			alert(type);
			prevendors = 1;
			H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addpreferredvendor", {vendorid: ""+matchesb+"",actype: ""+type+"",prevendor: ""+prevendors+""}, function(data){
			if(data){
			window.location = 'index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=242';
			}
			});
			}
}

}


function sendinvitation(id,email){
//H('#companyid'+id).html('Adding...');
H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=addvendor", {vendorid: ""+id+"", emailid: ""+email+""}, function(data){
	if(data==' added'){
	alert("Vendor added successfully");
	H('.search-panel'+id).hide();
//	window.location = "index.php?option=com_camassistant&controller=vendorscenter&task=vendorscenter&view=vendorscenter&Itemid=<?php echo $_REQUEST['Itemid']; ?>";
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

	function getcompstatus(vendorid,globals,status){
	L = jQuery.noConflict();
	if( globals == 'fail' )
		height = '240';
	else
		height = '600';
	el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=preferredcompliance&vendorid='+vendorid+'&global='+globals+'&status='+status+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
	SqueezeBox.fromElement(el,options);
	L("#sbox-window").addClass("newclasssate");	
	}
	function senderrormsg(){
	alert("This Vendor has been Blocked by your Company's Master Account holder");
	}
	
	function basicrequest(from){
	L = jQuery.noConflict();
	var matches = [];
	var matchesa = [];
	var countp = 0 ;
	var newid = null;
		
		
		if(from == 'pre') {	
			L(".coworkers:checked").each(function() {
				matches.push(this.value);
				countp++ ;
			});
		}
		
			
	
	if(countp == '0'){
	alert("Please select at least one Vendor to include in this request.");
	}
	else{
		if(from == 'pre') {
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesa.push(myArray[0]);
			});
		}
				
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
	if(type == 'pre') {
		L(".coworkers:checked").each(function() {
			matches.push(this.value);
			countp++ ;
		});
	}
	//if(basics == 'no'){
		//alert("You do NOT have any BASIC requests created to invite these Vendors to");
//	}
	if(basics == 'no')
	var height = '250' ;
	else
	height = '320';
	
	if(countp == '0'){
		alert("Please select at least one Vendor to invite to an existing Basic Request");
	}
	else{
		if(type == 'pre') {
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesa.push(myArray[0]);
			});
		}
		matchesa = matchesa.join(',') ;
		el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=getbasicrequests&from=search&vendors='+matchesa;
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
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
            newitem2='<table><tr><input type="hidden" name="old_docids[]" /><td><span id="delimg'+id2+''+num2+'" style="display:none" title="Remove From RFP"><img src="<?php echo Juri::base(); ?>templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer;" onclick="javascript:deletelineupload('+id2+''+num2+','+num2+');"/></span></td><td><span id="uploadfile'+id2+''+num2+'" style="float:left;width:auto;padding-right:5px; font-size:14px; color:#8FD800;"></span></td><input type="hidden" value=" " name="linetask_uploads_2'+id2+'[]" id="lineuploads'+id2+''+num2+'"  ></tr></table>';
			var newdiva2 = document.createElement('div');
			newdiva2.setAttribute("id",divIdName2);
			newdiva2.innerHTML = newitem2;
			ni2.appendChild(newdiva2);
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
				var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 700, y:450}}"))
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
	// Function to recommend vendors to other managers
function vendor_recommend(){
	L = jQuery.noConflict();
	var height = <?php echo $height; ?>;
	var matchesr = [];
	var matchesar = [];
	var countpr = 0 ;
	var newidr = null;
		L(".coworkers:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		
	if(countpr == '0'){
		alert("Please select at least one Vendor to recommend.");
	}	
	else{
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesar.push(myArray[0]);
			});
		matchesar = matchesar.join(',') ;
		el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=getallmanagersrecommend&from=search&vendors='+matchesar;
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
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
		L(".coworkers:checked").each(function() {
			matchesr.push(this.value);
			countpr++ ;
		});
		
	if(countpr == '0'){
		alert("Please select at least one Vendor to send the mail.");
	}	
	else {
			L(".coworkers:checked").each(function() {
			myString = this.value ;
			var myArray = myString.split('-');
			matchesar.push(myArray[0]);
			});
		matchesar = matchesar.join(',') ;
		el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=sendmail_vendors&from=search&vendors='+matchesar;
		var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y: 530}}"))
		SqueezeBox.fromElement(el,options);
	}
}


function unverified(vendorid,type){
if(type == 'unverified')
var height = '290';
if(type == 'both')
var height = '350';
else
var height = '245';
var el ='index.php?option=com_camassistant&controller=rfpcenter&task=vendortype&from=newsearch&vendorid='+vendorid+'&type='+type;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
SqueezeBox.fromElement(el,options);
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
<style type="text/css">
#maskes {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxeses .windowes {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxeses #submites {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxeses #submites a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donees {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }
#closees { border:0 none; cursor:pointer; height:30px; margin:0 0 0 8px; color:#000000; font-weight:bold; font-size:20px; width:172px;}

#maskreq {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesreq .windowreq {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesreq #submitreq {  width:789px;  height:610px;  padding:10px;  background-color:#ffffff;}
#donereq {border:0 none; cursor:pointer; height:30px; margin-top:-31px; float:right; width:160px; }
#closereq { border:0 none; cursor:pointer; height:30px; margin:0 0 0 -8px; color:#000000; font-weight:bold; font-size:20px; width:200px;}

#maskvrecdone {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesvrecdone .windowvrecdone {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesvrecdone #submitvrecdone {  width:318px;  height:117px;  padding:10px;  background-color:#ffffff;}
#boxesvrecdone #submitvrecdone a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donevrecdone {border:0 none; cursor:pointer; height:30px; margin-left:-17px; margin-top:-29px; width:474px; float:left; }

</style>
<?php
$statelist = $this->statelist;
$industries = $this->indus;
?>
<BR />
<div id="add-findvendor">
<div id="add-findvendor-new">
<div class="newsearch_vendor">
<h3>SEARCH BY COMPANY NAME</h3>
<form method="post" id="searchofrm" name="searchform">
<div class="new-search">
<input type="text" style="padding-left:3px; font-weight:normal;" onblur="if(this.value == '') this.value ='Enter Company Name';" onclick="if(this.value == 'Enter Company Name') this.value='';" value="Enter Company Name" id="companyname" name="companyname">
</div>
<div class="new-search"><input type="submit"  id="searchcompany"  value="SEARCH" name=""></div>
</form>
</div>
<div class="clr"></div>

</div>
<div id="add-vendor-newa">
<div class="newsearch_vendor">
<h3>SEARCH BY AREA + INDUSTRY</h3>
<div class="new-search">

<form method="post" id="newsearchofrm" name="newsearchform">
<select name="state" id="stateid" style="width:260px; margin-bottom:20px;" onchange="javascript:county();">
<option value="">Select State</option>
<?php  foreach($statelist as $slist) {  ?>
<option value="<?php echo $slist->state_id; ?>"><?php echo $slist->state_name; ?></option>
<?php } ?>

</select>
<div id="divStates" >
<select name="state" style="width:260px; margin-bottom:20px;" id="divcounty" onchange="javascript:displayindustry();"><option value="">Select County</option></select>
</div>

<div id="divindustries">
<select name="state" style="width:260px;" id="industry">
<option value="">Select Industry</option>
<?php  foreach($industries as $indus) {  ?>
<option value="<?php echo $indus->id; ?>"><?php echo $indus->industry_name; ?></option>
<?php } ?>
</select>
</div>
<div class="new-search" id="newsearch"><input type="submit"  id="searchcompany"  value="SEARCH" name=""></div>
</form>
</div>
</div>
<div class="clr"></div>

<br>
</div>
</div>
<p style="height:45px;"></p>

<div id="results" class="companies">
</div>

<div id="preferred-vendorsfirst" class="breakclass" style="">
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

<div id="boxeses" class="boxeses">
<div id="submites" class="windowes" style="top:300px; left:582px; border:4px solid #8FD800; position:fixed;">
<br/>
<p align="center" style="color:gray;">This Vendor will be BLOCKED from participating in any of your Managers' projects</p>
<div style="padding-top:20px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="closees" name="closees" value="Cancel"><img src="templates/camassistant_left/images/cancel.gif" /></div>
<div id="donees"  name="donees" value="Ok"><img src="templates/camassistant_left/images/ok.gif" /></div>
</div>
</form>

</div>
  <div id="maskes"></div>
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
	<select id="property_id" name="property_id" style="width:498px; height:32px; padding:5px;">
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
			//ampm: true,

 /*beforeShowDay: function (date) {
        if (date.getDay() == 0 || date.getDay() == 1 || date.getDay() == 6) {
                    return [false, ''];
                } else {
                    return [true, ''];
                }

     }*/

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
<span id="delimg10" style="display:none" title="Remove From RFP"><img src="templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer;" onclick="javascript:deletelineupload_line(10);"  /></span>
<div class="clear"></div>
<div id="newdiva210"></div>
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
<input type="hidden" name="from" value="invite" />
</form>

</div>
  <div id="maskreq"></div>
</div>

<div id="loading-div-background">
  <div id="loading-div" class="ui-corner-all">
    <img style="height:32px;width:32px;margin:30px;" src="templates/camassistant_left/images/loading_icon.gif" alt="Loading.."/><br>Please wait while your request is being submitted.
  </div>
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
