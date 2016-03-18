<style type="text/css">
.generaloptions  li {
  list-style-type: none;
  margin-top:7px;
  }
 .pre_general li {
  list-style-type: none;
  margin-top:7px;
  }
  .pre_auto li {
  list-style-type: none;
  margin-top:7px;
  }
  .pre_workers li {
  list-style-type: none;
  margin-top:7px;
  }
  .pre_umbrella li {
  list-style-type: none;
  margin-top:7px;
  }
  
</style>
<style type="text/css">
.checkbox, .radio {
	width: 19px;
	height: 18px;
	padding: 5px 1px 0 0;
	background: url(checkbox.png) no-repeat;
	display: block;
	clear: left;
	float: left;
}
.radio {
	background: url(radio.png) no-repeat;
}
.select {
	position: absolute;
	width: 158px; /* With the padding included, the width is 190 pixels: the actual width of the image. */
	height: 21px;
	padding: 0 24px 0 8px;
	color: #fff;
	font: 12px/21px arial,sans-serif;
	background: url(select.png) no-repeat;
	overflow: hidden;
}

</style>
<style>
#masktc {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxestc .windowtc {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxestc #submittc {  width:476px;  height:160px;  padding:10px;  background-color:#ffffff;}
#boxestc #submittc a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donetc {border:0 none;cursor:pointer;height:30px;padding:0; color:#000000; font-weight:bold; font-size:20px; float:right;}
#closetc {border:0 none;cursor:pointer;height:30px;padding:3px 0 0;float:left;}
</style>
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
window.onload = Custom.init;
</script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script>
	N = jQuery.noConflict();
	N(document).ready(function() {	
	N('.yui-accordion-toggle').click(function(e) {
		anchorid = N(this).attr('id');
		N('.yui-accordion-toggle span').removeClass('downimage');
		N('.yui-accordion-toggle span').addClass('leftimage');
		id = N(this).attr('rel');
		N('.formcontent').html('');
		
			if(N(this).hasClass('active')){
				N('#sowform_'+id).html('');
				N(this).removeClass('active');
				N('#'+anchorid+' span').removeClass('downimage');
				N('#'+anchorid+' span').addClass('leftimage');
			}
			else {
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getsowform", {industryid: ""+id+""}, function(data){
			N('#sowform_'+id).html(data);
			N('#sowform_'+id).slideDown('slow');
			Custom.init();
			});
			N(this).addClass('active');
			N('#'+anchorid+' span').removeClass('leftimage');
			N('#'+anchorid+' span').addClass('downimage');
		}
			
		});
		
	// To get the general liability insurance sub items
	N('#generalliability').live('click',function(e) {
		if(this.hasClass('active')){
				N('#generalliability').removeClass('active');	
				N('#generalliability_sub').slideUp('slow');		
				N('#generalliability_sub').html('');
		}
		else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getgeneralliability", {industryid: ""+id+""}, function(data){
				N('#generalliability_sub').html(data);
				N('#generalliability_sub').show('slow');
				N('#generalliability').addClass('active');
				N('.pre_general').html('');
				});
			}
	});
	//Completed	
	// To get the auto liability insurance sub items
	N('#autoliability').live('click',function(e) {
		if(this.hasClass('active')){
				N('#autoliability').removeClass('active');	
				N('#autoliability_sub').slideUp('slow');		
				N('#autoliability_sub').html('');
		}
		else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getautoliability", {industryid: ""+id+""}, function(data){
				N('#autoliability_sub').html(data);
				N('#autoliability_sub').show('slow');
				N('#autoliability').addClass('active');
				N('.pre_auto').html('');
				});
		}	
	});
	//Completed
	// To get the auto liability insurance sub items
	N('#workersliability').live('click',function(e) {
		if(this.hasClass('active')){
				N('#workersliability').removeClass('active');	
				N('#workersliability_sub').slideUp('slow');		
				N('#workersliability_sub').html('');
		}
		else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getworkliability", {industryid: ""+id+""}, function(data){
				N('#workersliability_sub').html(data);
				N('#workersliability_sub').show('slow');
				N('#workersliability').addClass('active');
				N('.pre_auto').html('');
				});
			}	
	});
	//Completed
	// To get the auto liability insurance sub items
	N('#umbrellaliability').live('click',function(e) {
		if(this.hasClass('active')){
				N('#umbrellaliability').removeClass('active');	
				N('#umbrellaliability_sub').slideUp('slow');		
				N('#umbrellaliability_sub').html('');
		}
		else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getumbrellaliability", {industryid: ""+id+""}, function(data){
				N('#umbrellaliability_sub').html(data);
				N('#umbrellaliability_sub').show('slow');
				N('#umbrellaliability').addClass('active');
				N('.pre_umbrella').html('');
				});
			}			
	});
	//Completed	
	// To get the auto liability insurance sub items
	N('#licensingliability').live('click',function(e) {
		if(this.hasClass('active')){
				N('#licensingliability').removeClass('active');	
				N('#licensingliability_sub').slideUp('slow');		
				N('#licensingliability_sub').html('');
		}
		else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getlicliability", {industryid: ""+id+""}, function(data){
				N('#licensingliability_sub').html(data);
				N('#licensingliability_sub').show('slow');
				N('#licensingliability').addClass('active');
				N('.pre_lic').html('');
				});
			}
	});
	//Completed	
	
	// To get the auto liability insurance sub items
	N('#errorsomissions').live('click',function(e) {
		if(this.hasClass('active')){
				N('#errorsomissions').removeClass('active');	
				N('#errorsomissions_sub').slideUp('slow');		
				N('#errorsomissions_sub').html('');
		}
		else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getomissions", {industryid: ""+id+""}, function(data){
				N('#errorsomissions_sub').html(data);
				N('#errorsomissions_sub').show('slow');
				N('#errorsomissions').addClass('active');
				N('.pre_omi').html('');
				});
			}
	});
	//Completed		
		
	N('#notself').click(function(e) {
		N('.yui-skin-sam').slideUp('slow');
		N('.secondoptionshow_1').hide();
		N('.secondoptionshow_2').hide();
		N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatepermission", {}, function(data){
				location.reload();
				});
	});
	
	N('#self').click(function(e) {
		N('.yui-skin-sam').slideDown('slow');
		N('.secondoptionshow_1').show();
		N('.secondoptionshow_2').hide();
		N(".checkcompliance" ).prop( "checked", false );
		N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=deletepermission", {}, function(data){
				location.reload();
				});
		
	});
	N('.editstandards').live('click',function(e) {
		N('.editoption').hide();
		
		N('#w9_lost').show();
		N('#generalliability_lost').show();
		N('#autoliability_lost').show();
		N('#workersliability_lost').show();
		N('#umbrellaliability_lost').show();
		N('#licensingliability_lost').show();
		N('#errorsomissions_lost').show();
		
		N('.lineitem_pan').css('pointer-events','');
		N('#specialreqs table span.checkbox').hide();
		N('.styled').show();
		N('.insuranceoptions').css('display','block');	
		N('.insurancedotline_text').css('display','block');	
			N('.removecertificate').show();
			//To check the industry have some standards or not 
			
			//Completed
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getgeneralliability", {industryid: ""+id+""}, function(data){
				var firstfivegli = data.substring(0,7);
				trimstringgli = trim(firstfivegli);
				if(trimstringgli == 'exist') {
					N('#generalliability_sub').html(data);
					N('#generalliability_sub').slideDown('slow');
					N('.pre_general').html('');
				}
			});
			
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getautoliability", {industryid: ""+id+""}, function(data){
				var firstfiveauto = data.substring(0,7);
				trimstringauto = trim(firstfiveauto);
				if(trimstringauto == 'exist') {
					N('#autoliability_sub').html(data);
					N('#autoliability_sub').slideDown('slow');
					N('.pre_auto').html('');
				}
			});
			
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getworkliability", {industryid: ""+id+""}, function(data){
				var firstfivework = data.substring(0,7);
				trimstringwork = trim(firstfivework);
				if(trimstringwork == 'exist') {
					N('#workersliability_sub').html(data);
					N('#workersliability_sub').slideDown('slow');
					N('.pre_workers').html('');
				}
			});
			
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getumbrellaliability", {industryid: ""+id+""}, function(data){
				var firstfiveumb = data.substring(0,7);
				trimstringumb = trim(firstfiveumb);
				if(trimstringumb == 'exist') {
					N('#umbrellaliability_sub').html(data);
					N('#umbrellaliability_sub').slideDown('slow');
					N('.pre_umbrella').html('');
				}
			});
			
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getlicliability", {industryid: ""+id+""}, function(data){
				var firstfivelic = data.substring(0,7);
				trimstringlic = trim(firstfivelic);
				if(trimstringlic == 'exist') {
					N('#licensingliability_sub').html(data);
					N('#licensingliability_sub').slideDown('slow');
					N('.pre_lic').html('');
				}					
			});
			
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getomissions", {industryid: ""+id+""}, function(data){
				var firstfiveomi = data.substring(0,7);
				trimstringomi = trim(firstfiveomi);
				if(trimstringomi == 'exist') {
					N('#errorsomissions_sub').html(data);
					N('#errorsomissions_sub').slideDown('slow');
					N('.pre_omi').html('');
				}					
			});
			
			
	});
	
	N('.editstandardsind').live('click',function(e) {
		N('#specialreqs').submit();
	});	
	N('.editstandardall').live('click',function(e) {
		N('#industryall').val('all');
		N('#specialreqs').submit();
	});	
		
	N('#workers_not').live('click',function(e) {
	N('.workers_sub').css('display','block');
	});	
	
	N('#workers_yes').live('click',function(e) {
	N('.workers_sub').css('display','none');
	});	

	N('.cancelbutton').live('click',function(e) {
		id = N('#industryall').val();
		N('.formcontent').html('');
		if(N(this).hasClass('active')){
				N('#sowform_'+id).html('');
				N(this).removeClass('active')
			}
			else {
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=getsowform", {industryid: ""+id+""}, function(data){
			N('#sowform_'+id).html(data);
			N('#sowform_'+id).slideDown('slow');
			Custom.init();
			});
			N(this).addClass('active');
		}
			
		});
		
		
		
		N('.checkcompliance').click(function(e) {
			if(N(".checkcompliance").is(':checked')) {
				weeks = N('input[name="weeks"]:checked').val();
				
				N(".weekdays_new").css('opacity',1);
				N(".weekdays_new").css('pointer-events','');
				N(".mail_permission" ).css('opacity',1);
				N(".mail_permission" ).css('pointer-events','');
				N('.secondoptionshow_2').show();
				if(!weeks){
				weeks = '4';
				N("#weekdays4" ).prop( "checked", true );
				}
				else{
				weeks = weeks;
				}
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatecompliance", {week: ""+weeks+""}, function(data){
				});
			}
			else{
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=deleteupdatecompliance",  function(data){
				});
				/*N(".weekdays_new" ).prop( "checked", false );
				N(".mail_permission" ).prop( "checked", false );
				N(".weekdays_new").css('opacity',0.5);
				N(".weekdays_new").css('pointer-events','none');
				N(".mail_permission" ).css('opacity',0.5);
				N(".mail_permission" ).css('pointer-events','none');*/
				N('.secondoptionshow_2').hide();
			}
		});
		
		N('.weekdays_new').click(function(e){
			if(N(".checkcompliance").is(':checked')) {
				weeks = N('input[name="weeks"]:checked').val();
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatecompliance", {week: ""+weeks+""}, function(data){
				});
			}
			else{
			alert("Please select checkbox 'Send Vendor Compliance Status Reports to Managers every' and select weeks.");
				N(".weekdays_new" ).prop( "checked", false );
				N(".mail_permission" ).prop( "checked", false );
				N(".weekdays_new").css('opacity',0.5);
				N(".weekdays_new").css('pointer-events','none');
				N(".mail_permission" ).css('opacity',0.5);
				N(".mail_permission" ).css('pointer-events','none');
			}
		});
		
		
		N('.mail_permission').click(function(e){
			if(N(".checkcompliance").is(':checked')) {
				if(N(this).is(':checked')) {
				manager = G(this).val();
				permission = '1';
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatemanager", {manager: ""+manager+"", permission: ""+permission+""}, function(data){
				});
				}
				else{
				manager = G(this).val();
				permission = '0';
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatemanager", {manager: ""+manager+"", permission: ""+permission+""}, function(data){
				});
				}
			}
			else{
			alert("Please select checkbox 'Send Vendor Compliance Status Reports to Managers every' and select weeks.");
			N(".weekdays_new" ).prop( "checked", false );
				N(".mail_permission" ).prop( "checked", false );
				N(".weekdays_new").css('opacity',0.5);
				N(".weekdays_new").css('pointer-events','none');
				N(".mail_permission" ).css('opacity',0.5);
				N(".mail_permission" ).css('pointer-events','none');
			}
		});
		
		N('.mail_vendors').click(function(e){
			if(N(this).is(':checked')) {
			vendor_type = G(this).val();
			permission = '1';
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatevendortype", {v_type: ""+vendor_type+"", permission: ""+permission+""}, function(data){
				});
			}
			else{
			vendor_type = G(this).val();
			permission = '0';
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatevendortype", {v_type: ""+vendor_type+"", permission: ""+permission+""}, function(data){
				});
			}
		});
		
		N('#editoption').live('click',function(){
		N('#aboutform').show();
		N('.detailsextra').hide();
		});
		
		N('#removecertificate').live('click',function(){
		 var conf = confirm("Are you sure you want to delete this document from the sample certificates?");
		 //id = N('#removecertificate').attr();
		 cid = N(this).attr('rel');
		 	if(conf == true){
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=removecert", {certid:""+cid+""}, function(data){
					if(data == 'success'){
						alert("Document has been removed from the list.");
						N('#certificate'+cid).hide();
					}
					else{
						alert("We are not able to delete the document pleae try once again. ");
					}
				});
			}
			else{
				
			}
		 });
		 
		
		//N('.termsandconditions body').css('font-size','14px');
		N(".termsandconditions").contents().find("body").css("font-size","14px");
		N(".termsandconditions").contents().find("body").css("font-family","Open Sans");
		N(".termsandconditions").css("height","250px"); 
		 
		
	});
	
	function openmenu(val)
	{
		if(document.getElementById("submenu"+val).style.display=="none")
		{
			document.getElementById("submenu"+val).style.display="";
		if(val==11)
			document.getElementById('req_id19').checked=true;
		if(val==12 && document.getElementById('sub_req_id3').checked==true)
			document.getElementById('liability'+val).style.display='';
		}
		else
		{
			document.getElementById("submenu"+val).style.display="none";
		}

	}
	
	

</script>
<script type='text/javascript'>
function add_commas(arg,x) {
var id = arg.getAttribute('id');
N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=vendorinsstand_calc", {fieldvalue:""+x+""}, function(data){
	if(data != '0.00'){
		N('#'+id).val(data);
	}
	else{
		N('#'+id).val('');
	}
});
}

function addEventa2(id2){

			var arrlicen2=new Array();
			var ni2 = document.getElementById('newdiva2'+id2);
			var numi2 = document.getElementById('theValue');
			var num2 = (document.getElementById("theValue").value -1)+ 2;
			numi2.value = num2;
			var divIdName2 = "newSelector"+num2;
            newitem2='<table><tr><input type="hidden" name="old_docids[]" /><td><span id="delimg'+id2+''+num2+'" style="display:none" title="Remove From RFP"><img src="templates/camassistant_left/images/red.png" alt="delete" style="cursor:pointer;" onclick="javascript:deletelineupload('+id2+''+num2+','+num2+');"/></span>&nbsp;&nbsp;</td><td><span id="uploadfile'+id2+''+num2+'" style="float:left;width:auto;padding-right:5px; font-size:14px; color:#7AB800;"></span></td><input type="hidden" value=" " name="linetask_uploads_2'+id2+'[]" id="lineuploads'+id2+''+num2+'"  ></tr></table>';
			var newdiva2 = document.createElement('div');
			newdiva2.setAttribute("id",divIdName2);
			newdiva2.innerHTML = newitem2;
			ni2.appendChild(newdiva2);
			linetaskupload(id2+''+num2);
}

function linetaskupload(id){
property_id = '1';
industry_id = '1';
mid = '1';
if((property_id)&&(industry_id)){
el='index2.php?option=com_camassistant&controller=rfpcenter&task=upload_select&taskid='+id+'&pid='+property_id+'&mid='+mid+' ';
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 700, y:330}}"))
SqueezeBox.fromElement(el,options);
}else{
alert('Please Select the industry.');
}
}

function deletelineupload(taskid,num){
var res = confirm("Are you sure you want to remove this file from sample certificates?");
if(res==true){
window.parent.document.getElementById('lineuploads'+taskid).value ='';
window.parent.document.getElementById('delimg'+taskid).style.display ='none';
window.parent.document.getElementById('uploadfile'+taskid).style.display ='none';
window.parent.document.getElementById('newSelector'+num).style.display ='none';
    }
}

function statusurl(vendors){
	if( vendors == 'yes' )
	window.open('index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_report','_blank');
	else
	getpopupbox();
}
function getpopupbox(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexwr').css({'width':maskWidth,'height':maskHeight});
		G('#maskexwr').fadeIn(100);
		G('#maskexwr').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexwr").css('top',  winH/2-G("#submitexwr").height()/2);
		G("#submitexwr").css('left', winW/2-G("#submitexwr").width()/2);
		G("#submitexwr").fadeIn(2000);
		G('.windowexwr #cancelexwr').click(function (e) {
		e.preventDefault();
		G('#maskexwr').hide();
		G('.windowexwr').hide();
		});
}
</script>
<style>
#maskexwr { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexwr .windowexwr {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexwr #submitexwr {  width:567px;  height:176px;  padding:10px;  background-color:#ffffff;}
#boxesexwr #submitexwr a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexwr {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexwr {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>
<script language="JavaScript" type="text/javascript" src="components/com_camassistant/assets/wysiwyg_terms.js"></script>


<script type="text/javascript">
		
		G = jQuery.noConflict();
		G(function(){
		G('#saveoption').click(function(){
			G('body,html').animate({
			scrollTop: 250
			},800);
			var maskHeight = G(document).height();
			var maskWidth = G(window).width();
			G('#masktc').css({'width':maskWidth,'height':maskHeight});
			G('#masktc').fadeIn(100);
			G('#masktc').fadeTo("slow",0.8);
			var winH = G(window).height();
			var winW = G(window).width();
			G("#submittc").css('top',  winH/2-G("#submittc").height()/2);
			G("#submittc").css('left', winW/2-G("#submittc").width()/2);
			G("#submittc").fadeIn(2000);
			G('.windowtc #donetc').click(function (e) {
				e.preventDefault();
				G('#masktc').hide();
				G('.windowtc').hide();
				N('textarea[rel="editor"]').each(function(){
				var n=N(this).attr('id');
				document.getElementById(n).value = document.getElementById("wysiwyg" + n).contentWindow.document.body.innerHTML;
				notesstrings = document.getElementById(n).value ;
				notesstrings = notesstrings.replace("’", "'");
				notesstrings = notesstrings.replace(/[^\u000A\u0020-\u007E]/g, ' ');
				document.getElementById(n).value = notesstrings ;
				});
				G( "#aboutformsubmit" ).submit();
			});
			G('.windowtc #closetc').click(function (e) {
				e.preventDefault();
				G('#masktc').hide();
				G('.windowtc').hide();
				location.reload();
			});
	
		});
	
});
</script>

<style type="text/css">
/*iframe {
  height: 250px;
}*/
.termsbeforeedit  p {
  padding-bottom: 10px;
}
</style>
<?php
$industries = $this->industries ;
$pre_existing = $this->existingdata ;
$masteruser = $this->masterexist ;


$user=JFactory::getUser(); 

$db=&JFactory::getDBO();
$user=JFactory::getUser();
$query = "SELECT weeks,permission FROM  #__cam_master_email_compliance_status WHERE masterid=".$user->id;
$db->setQuery( $query );
$perinfo = $db->loadObject();
$weeks = $perinfo->weeks ;
$permissions = $perinfo->permission ;

$report_vendors = $this->reportsmsg ;

if( $permissions == 'yes' || $pre_existing == 'no' )
	$vendors_re = 'no';
else
	$vendors_re = 'yes';	


		
?>
<p style="height:20px;"></p>
<div class="clickhere_creport"><a href="javascript:void(0);" onclick="statusurl('<?php echo $vendors_re; ?>');" class="generate_compliancereport"></a></div>
<div id="topborder_row"> </div>
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">TERMS & CONDITIONS </font></span>
</div></div>
<div class="detailsextra">
<?php 
if($masteruser){
?>
<div class="termsbeforeedit"><?php echo html_entity_decode(str_replace('<br />','\n',$this->aboutus->aboutus)); ?> </div>
<?php } else { ?>
<p>To set terms & conditions that Vendors must agree to, please contact MyVendorCenter to set up a FREE Master Account. You may do this by sending an email to support@myvendorcenter.com or by calling 1-800-985-9243</p>
<?php } ?>


<table cellpadding="0" cellspacing="0" width="100%">
<tr height="5"></tr>
<?php if($user->user_type == '13' && $user->accounttype == 'master'){
?>
<tr>
<td width="10"><input style="margin-left:0px;" type="checkbox" <?php if($this->aboutus->termsconditions == '1') { ?> checked="checked" <?php }  ?> disabled="disabled" /></td><td>Require Vendors to agree to Terms & Conditions</td>
<td align="right">
<a id="editoption" href="javascript:void(0);"><strong><img src="templates/camassistant_left/images/EditMini.png" /></strong></a></td>
</tr>
<?php } ?>
</table>

</div>

<div id="aboutform" style="display:none;">
<form action="" method="post" id="aboutformsubmit">
<table cellpadding="0" cellspacing="0">
<tr><td colspan="3">
 <textarea rel="editor" name="aboutus" id="ctl00_CPHContent_txtComments" style="height:250px; margin-left:1px; width:667px;"><?php echo str_replace('<br />','\n',$this->aboutus->aboutus); ?></textarea>
 <script language="javascript1.2">
generate_wysiwyg('ctl00_CPHContent_txtComments');

</script>

 </td></tr>
 <tr height="5"></tr>
 <tr><td width="10"><input type="checkbox" value="1" style="margin-left:0px;" <?php if($this->aboutus->termsconditions == '1') { ?> checked="checked" <?php }  ?> name="termsconditions" /></td><td>Require Vendors to agree to Terms & Conditions</td><td align="right"><a href="javascript:void(0);" onClick="window.location.reload()" id="cancellink"><img src="templates/camassistant_left/images/CancelMini.png" /></a> <a id="saveoption" href="javascript:void(0);" style="font-weight:bold; color: #7ab800;"><img src="templates/camassistant_left/images/SaveMini.png" /></a></td></tr>
<tr height="10"></tr>
<tr><td style="color: #808080; font-size: 13px; padding-left: 9px; text-align: left;">
<span id="charcount">
<?php
//echo 500 - strlen($this->aboutus->aboutus). "</span> Characters Left";
?>

<!--<input type="submit" value="SAVE" style="float:right" />-->

</td></tr>
</table>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="saveaboutus" name="task">
<input type="hidden" value="<?php echo $this->aboutus->id; ?>" name="id">
</form>
</div>



<p style="height:60px;"></p>
<div id="i_bar_insurenace">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">INSURANCE & LICENSING </font></span>
</div></div>

<?php $user=JFactory::getUser();
		if($user->user_type == '13' && $user->accounttype == 'master'){
			$display_content = '';
		}
		else{
			$display_content = 'none';
		}	
		
 ?>
<table cellpadding="0" cellspacing="0" style="display:<?php echo $display_content; ?>">
<tr height="13"></tr>
<?php
$db=&JFactory::getDBO();
$user=JFactory::getUser();
$query = "SELECT weeks,permission FROM  #__cam_master_email_compliance_status WHERE masterid=".$user->id;
$db->setQuery( $query );
$perinfo = $db->loadObject();
$weeks = $perinfo->weeks ;
$permission = $perinfo->permission ;

if($weeks){
	$checked = 'checked="checked"';
}
else{
$checked = '';
$pointr = 'none';
$opacity = '0.5';
$weeks = '4';
$checked = 'checked="checked"';
}

if($permission == 'yes'){
$checked1 = "checked='checked'";
$disply = 'none';
}
else{
$checked2 = "checked='checked'";
$disply = '';
}
$per = $this->permissions ;
?>
<tr><td><input id="notself" style="margin-top:0px;" <?php  echo $checked1; ?> type="radio" value="notself" name="permission" class="first" /></td><td> <strong>- Allow Managers to set their own Vendor Insurance Standards</strong> </td></tr>
<tr height="5"></tr>
<tr><td><input id="self" <?php  echo $checked2; ?> type="radio" value="self" name="permission" class="second" style="margin-top:0px;" /></td><td><strong> - Choose company-wide Vendor Insurance Standards for your Managers (Recommended)</strong></td></tr>

<tr class="secondoptionshow_1"  style="display:<?php echo $disply; ?>"><td></td><td><p style="padding-left:7px;">IMPORTANT: Any Vendors that do NOT meet the minimum standards set below will appear as "Non-Compliant" for all other users associated with your account.</p></td></tr>
<tr height="10"></tr>
<tr><td></td><td>
<table cellpadding="0" cellspacing="0" style="padding-left:5px;">
<tr class="secondoptionshow_1"  style="display:<?php echo $disply; ?>"><td><input type="checkbox" value="1" name="yes" style="margin-top:3px;" class="checkcompliance" <?php echo $checked; ?> /></td><td>Receive Vendor  
<a rel="{handler: 'iframe', size: {x: 670, y: 720}}" id="compliancestatus_report" href="templates/camassistant_left/images/ComplianceStatusReport.png" class="modal" href="javascript:void(0);">Compliance Status Reports</a> every </td></tr> 
<tr><td></td><td>
<table cellpadding="0" cellspacing="0"  class="secondoptionshow_2"  style="display:<?php echo $disply; ?>">

<tr><td width="15"><input id="weekdays" class="weekdays_new" type="radio" value="24" name="weeks" <?php if($weeks == '24'){ echo 'checked="checked"'; } ?> style="margin:0px;" /></td><td>Day</td></tr>

<tr><td width="15"><input id="weekdays" class="weekdays_new" type="radio" value="1" name="weeks" <?php if($weeks == '1'){ echo 'checked="checked"'; } ?> style="margin:0px;" /></td><td>Week</td></tr>

<tr><td width="15"><input id="weekdays" class="weekdays_new" type="radio" value="2" name="weeks" <?php if($weeks == '2'){ echo 'checked="checked"'; } ?> style="margin:0px;" /></td><td>2 Weeks</td></tr>
<tr><td><input id="weekdays4" class="weekdays_new" type="radio" value="4" name="weeks" <?php if($weeks == '4'){ echo 'checked="checked"'; } ?> style="margin:0px;" /></td><td>4 Weeks</td></tr>
<tr><td><input id="weekdays" class="weekdays_new" type="radio" value="8" name="weeks" <?php if($weeks == '8'){ echo 'checked="checked"'; } ?> style="margin:0px;" /></td><td>8 Weeks</td></tr>
<tr height="10"></tr>
<tr><td colspan="2">Please select the type of Manager accounts that should receive these reports</td></tr>
<tr><td><input type="checkbox" id="mail_permission" class="mail_permission" value="master" name="master" style="margin:0px;" <?php if($per->master == '1' || !$per){ echo "checked='checked'" ;  } ?>  /></td><td>Master</td></tr>
<tr><td><input type="checkbox" id="mail_permission" class="mail_permission" value="admin" name="admin" style="margin:0px;" <?php if($per->admin == '1' || !$per){ echo "checked='checked'" ;  } ?> /></td><td>Admin</td></tr>
<tr><td><input type="checkbox" id="mail_permission" class="mail_permission" value="dm" name="dm" style="margin:0px;" <?php if($per->dm == '1' || !$per){ echo "checked='checked'" ;  } ?> /></td><td>District Manager</td></tr>
<tr><td><input type="checkbox" id="mail_permission" class="mail_permission" value="m" name="m" style="margin:0px;" <?php if($per->m == '1' || !$per){ echo "checked='checked'" ;  } ?> /></td><td>Standard Manager</td></tr>
</span>
<tr height="10"></tr>
<tr><td colspan="2">Which types of Vendors would you like included in your auto-generated reports?</td></tr>
<?php 
	if( $per->unverified == '0' && $per->verified == '0' && $per->nonc == '0' && $per->compliant == '0' ){
		$per->unverified = '1';
		$per->verified = '1';
		$per->nonc = '1';  
		$per->compliant = '1';
		}
?>

<tr><td><input type="radio" id="mail_vendors" class="mail_vendors" value="unverified" name="verification" style="margin:0px;" <?php if($per->unverified == '1'){ echo "checked='checked'" ;  } ?>  /></td><td>Unverified</td></tr>
<tr><td><input type="radio" id="mail_vendors" class="mail_vendors" value="verified" name="verification" style="margin:0px;" <?php if($per->verified == '1'){ echo "checked='checked'" ;  } ?>  /></td><td>Verified</td></tr>

<tr><td><input type="radio" id="mail_vendors" class="mail_vendors" value="both_verified" name="verification" style="margin:0px;" <?php if( ($per->verified == '1' && $per->unverified == '1') || !$per ){ echo "checked='checked'" ;  } ?>  /></td><td>Both</td></tr>
<tr height="10"></tr>
<tr><td><input type="radio" id="mail_vendors" class="mail_vendors" value="nonc" name="compliance" style="margin:0px;" <?php if($per->nonc == '1'){ echo "checked='checked'" ;  } ?>  /></td><td>Non-Compliant</td></tr>
<tr><td><input type="radio" id="mail_vendors" class="mail_vendors" value="compliant" name="compliance" style="margin:0px;" <?php if($per->compliant == '1'){ echo "checked='checked'" ;  } ?>  /></td><td>Compliant</td></tr>
<tr><td><input type="radio" id="mail_vendors" class="mail_vendors" value="both_comp" name="compliance" style="margin:0px;" <?php if(($per->nonc == '1' && $per->compliant == '1' ) || !$per){ echo "checked='checked'" ;  } ?>  /></td><td>Both</td></tr>

</table>

</td></tr></table>

</td></tr></table>

<?php
if(!$per){
$db=&JFactory::getDBO();
$user=JFactory::getUser();
$query5 = "INSERT INTO #__cam_master_compliancereport ( id , masterid , master, admin, dm, m, unverified, verified, nonc, compliant ) VALUES (  '' , '".$user->id."', '1', '1', '1', '1', '1', '1', '1', '1' );";
$db->setQuery( $query5 );
$res5=$db->query();
}
else{
}
?>
<div style="margin-top:10px; display:<?php echo $display_content;?>" id="topborder_row"> </div>

<div class="yui-skin-sam" style="display:<?php echo $disply; ?>;">
<div id="wrapper1">
<ul id="mymenu1" style="margin: 0px; padding:0px;" class="yui-accordionview" role="tree">
<?php for($i=0; $i<count($industries); $i++){ ?>
<li class="yui-accordion-panel" style="list-style-type: none; padding: 1px;" role="presentation">
<a id="mymenu1-1-label<?php echo $i; ?>" tabindex="0" class="yui-accordion-toggle" role="treeitem" aria-expanded="false" rel="<?php echo $industries[$i]->value; ?>"><?php echo $industries[$i]->text; ?>
<span class="leftimage" role="presentation"></span>
</a>
</li>

<div id="<?php echo "sowform_".$industries[$i]->value;  ?>" class="formcontent"></div>
<?php } ?>
</ul></div></div>


<div id="boxestc" style="top:576px; left:582px;">
<div id="submittc" class="windowtc" style="top:300px; left:582px; border:6px solid #8FD800; position:fixed; font-size:13px;">
<div style="padding-top:10px; text-align:center"><font color="gray"><strong>WARNING:</strong> Changing your Terms & Condition will mark all Vendors as Non-Compliant until they ACCEPT your revised version.  An automatic email notification, informing them to agree to any revisions, will be sent to all Vendors who have previously agreed to the original version.</font>
</div>
<div style="padding-top:20px; text-align:center; width:240px; margin:0 auto;">
<div id="closetc" name="closetc" value="Cancel"><a class="cancel_newone" href="javascript:void(0);"></a></div>
<div id="donetc" name="donetc" value="Ok"><a class="ok_newone" href="javascript:void();"></a></div>
</div>
</div>
  <div id="masktc"></div>
</div>


<div id="boxesexwr" style="top:576px; left:582px;">
<div id="submitexwr" class="windowexwr" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">To generate a <strong>Compliance Status Report</strong>, you must set "company-wide Vendor Insurance Standards" under "INSURANCE & LICENSING".</p>
</div>
<div style="padding-top:18px;" align="center">
<div id="cancelexwr" name="doneexwr" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskexwr"></div>
</div>