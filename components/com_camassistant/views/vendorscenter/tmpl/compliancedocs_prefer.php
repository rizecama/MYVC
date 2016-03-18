<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<style type="text/css">

   body {
	font: 0.8em/21px arial,sans-serif;
}

.checkbox {
	width: 19px;
	height: 25px;
	padding: 0 5px 0 0;
	background: url(checkbox.png) no-repeat;
	display: block;
	clear: left;
	float: left;
}
</style>
<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<?php
$global = JRequest::getVar('global','');
$status = JRequest::getVar('status','');
if( $global )
	$global = $global ;
else
	$global = $status ; 
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
?>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>

<script type="text/javascript">
G = jQuery.noConflict();
function getcompliancedocs(status){
	G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=getinsurancestandards", {vendorid: ""+<?php echo $this->vendorid; ?>+"", status: ""+status+""}, function(data){
	G('#totalfeaturecompliance').html(data).slideDown('slow');
	window.onload = Custom.init;	
		});
		
}

G(document).ready( function(){
	G('.existing_code').click(function(){
		window.parent.document.getElementById( 'sbox-window' ).close();
	});
});
function accepted_terms(masterid,vendorid,type){
	G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=gettermsdata", {vendorid: ""+vendorid+"", masterid: ""+masterid+"", type: ""+type+""},function(data){
		if( type == 'acc' ){
			G('#returnmessage_accepted').html(data);
			getgreenpopup();
			}
		else if(type == 'dec'){
			G('#returnmessage_declined').html(data);
			getredpopup();
			}
		else{
			G('#returnmessage_notread').html(data);
			getgraypopup();
		}
		
	});
}

function getredpopup(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskex').css({'width':maskWidth,'height':maskHeight});
		G('#maskex').fadeIn(100);
		G('#maskex').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitex").css('top',  winH/2-G("#submitex").height()/2);
		G("#submitex").css('left', winW/2-G("#submitex").width()/2);
		G("#submitex").fadeIn(2000);
		G('.windowex #cancelex').click(function (e) {
		e.preventDefault();
		G('#maskex').hide();
		G('.windowex').hide();
		});
}

function getgreenpopup(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexg').css({'width':maskWidth,'height':maskHeight});
		G('#maskexg').fadeIn(100);
		G('#maskexg').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexg").css('top',  winH/2-G("#submitexg").height()/2);
		G("#submitexg").css('left', winW/2-G("#submitexg").width()/2);
		G("#submitexg").fadeIn(2000);
		G('.windowexg #cancelexg').click(function (e) {
		e.preventDefault();
		G('#maskexg').hide();
		G('.windowexg').hide();
		});
}	

function getgraypopup(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexgr').css({'width':maskWidth,'height':maskHeight});
		G('#maskexgr').fadeIn(100);
		G('#maskexgr').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexgr").css('top',  winH/2-G("#submitexgr").height()/2);
		G("#submitexgr").css('left', winW/2-G("#submitexgr").width()/2);
		G("#submitexgr").fadeIn(2000);
		G('.windowexgr #cancelexgr').click(function (e) {
		e.preventDefault();
		G('#maskexgr').hide();
		G('.windowexgr').hide();
		});
}	

</script>
<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}


#maskexg { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexg .windowexg {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexg #submitexg {  width:450px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxesexg #submitexg a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexg {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexg {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}

#maskexgr { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexgr .windowexgr {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexgr #submitexgr {  width:450px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxesexgr #submitexgr a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexgr {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexgr {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}


</style>


<?php if( $global != 'fail' && $global != '' ){ ?>
<script type="text/javascript">
getcompliancedocs('<?php echo $_REQUEST['status']; ?>');
</script>
<?php } else { ?>
<div class="null_cstatus">
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">COMPLIANCE STATUS</font></span>
</div></div>
<p>This Vendor does not have a Compliance Status because your company's Master Account holder has not set Company-Wide Compliance Standards. Please have the Master Account holder click on "COMPLIANCE STANDARDS" to correct this. If technical assistance is needed, please contact MyVendorCenter support at <a href="mailto:support@myvendorcenter.com"><strong>support@myvendorcenter.com</strong></a> or through online LIVE CHAT.</p>
<div align="center" style="padding-top:30px;">
<div class="existing_code" value="Ok" name="donerr" id="cancelrr"></div>
</div>
</div>

<?php exit; }  ?>
<script type="text/javascript">
var checkboxHeight = "25";
var radioHeight = "25";
var selectWidth = "190";

document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');

var Custom = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		for(a = 0; a < inputs.length; a++) {
			if((inputs[a].type == "checkbox" || inputs[a].type == "radio") && inputs[a].className.indexOf("styled") > -1) {
				span[a] = document.createElement("span");
				span[a].className = inputs[a].type;

				if(inputs[a].checked == true) {
					if(inputs[a].type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					}
				}
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				inputs[a].onchange = Custom.clear;
				if(!inputs[a].getAttribute("disabled")) {
					span[a].onmousedown = Custom.pushed;
					span[a].onmouseup = Custom.check;
				} else {
					span[a].className = span[a].className += " disabled";
				}
			}
		}
		inputs = document.getElementsByTagName("select");
		for(a = 0; a < inputs.length; a++) {
			if(inputs[a].className.indexOf("styled") > -1) {
				option = inputs[a].getElementsByTagName("option");
				active = option[0].childNodes[0].nodeValue;
				textnode = document.createTextNode(active);
				for(b = 0; b < option.length; b++) {
					if(option[b].selected == true) {
						textnode = document.createTextNode(option[b].childNodes[0].nodeValue);
					}
				}
				span[a] = document.createElement("span");
				span[a].className = "select";
				span[a].id = "select" + inputs[a].name;
				span[a].appendChild(textnode);
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				if(!inputs[a].getAttribute("disabled")) {
					inputs[a].onchange = Custom.choose;
				} else {
					inputs[a].previousSibling.className = inputs[a].previousSibling.className += " disabled";
				}
			}
		}
		document.onmouseup = Custom.clear;
	},
	pushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	check: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 0";
			element.checked = false;
		} else {
			if(element.type == "checkbox") {
				this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else {
				this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
				group = this.nextSibling.name;
				inputs = document.getElementsByTagName("input");
				for(a = 0; a < inputs.length; a++) {
					if(inputs[a].name == group && inputs[a] != this.nextSibling) {
						inputs[a].previousSibling.style.backgroundPosition = "0 0";
					}
				}
			}
			element.checked = true;
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className.indexOf("styled") > -1) {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else if(inputs[b].type == "checkbox" && inputs[b].className.indexOf("styled") > -1) {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className.indexOf("styled") > -1) {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} else if(inputs[b].type == "radio" && inputs[b].className.indexOf("styled") > -1) {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	},
	choose: function() {
		option = this.getElementsByTagName("option");
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<div id="totalfeaturecompliance"></div>

<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red; margin:6px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">DECLINED</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg" id="returnmessage_declined"></p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskex"></div>
</div>


<div id="boxesexg" style="top:576px; left:582px;">
<div id="submitexg" class="windowexg" style="top:300px; left:582px; border:6px solid #609e00; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 #609e00; margin:6px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ACCEPTED</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg" id="returnmessage_accepted"></p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelexg" name="doneexg" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskexg"></div>
</div>

<div id="boxesexgr" style="top:576px; left:582px;">
<div id="submitexgr" class="windowexgr" style="top:300px; left:582px; border:6px solid #609e00; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 gray; margin:6px;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">UNREAD</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg" id="returnmessage_notread"></p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelexgr" name="doneexgr" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskexgr"></div>
</div>


<?php 
exit;
?>
<script type="text/javascript">
window.onload = Custom.init;
</script>
</body>
</html>


