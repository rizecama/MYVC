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
	
	
	N('#workers_not').live('click',function(e) {
	N('.workers_sub').css('display','block');
	});	
	
	N('#workers_yes').live('click',function(e) {
	N('.workers_sub').css('display','none');
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
				weeks = N('input[name="weeks"]:checked').val();
				N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatecompliance", {week: ""+weeks+""}, function(data){
				});
		});
		
		
		N('.mail_permission').click(function(e){
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
		
		N('.mail_pdf').click(function(e){
			if(N(this).is(':checked')) {
			vendor_type = G(this).val();
			permission = '1';
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatefiletype", {v_type: ""+vendor_type+"", permission: ""+permission+""}, function(data){
				});
			}
			else{
			vendor_type = G(this).val();
			permission = '0';
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatefiletype", {v_type: ""+vendor_type+"", permission: ""+permission+""}, function(data){
				});
			}
		});
		
		
		N('.include_documents').click(function(){
			if(N(this).is(':checked')) {
				N('.documents_specified').show();
				N('.documents_specified_specific').show();
				var data_val = '1';
			}
			else{
				N('.include_all').attr('checked', false);
				N('.include_few').attr('checked', false);
				N('.documents_specified').hide();
				N('.documents_specified_specific').hide();
				N('.documents_specified_ind').hide();
				var data_val = '0';
			}
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatedocuments", {documents: ""+data_val+""}, function(data){
				});
		});
		
		N('.include_emails').click(function(){
		
		if(N(this).is(':checked')) {
		uncheck =1;
		
		N('.add_field_button').show();
		N('.addanotheremail').show();
		N('.remove_field').show();
		N('.add_email').show();
		N('.reportemails').show();
		N('.specifyemailtext').show();
		N('.uncheckemails').show();
		N('.specifyemailtext').show();
		N('.deletepreemail').show();
		
		
		}
		else{
		uncheck =0;
	
		N('.add_field_button').hide();
		N('.remove_field').hide();
		N('.addanotheremail').hide();
		N('.add_email').hide();
		N('.reportemails').hide();
		N('.uncheckemails').hide();
		N('.specifyemailtext').hide();
		N('.deletepreemail').hide();
		
		}
		
		N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updateuncheck", {check: ""+uncheck+""}, function(data){
		
				});	
		
		});
	



     
       //initlal text box count
    N('.add_field_button').click(function(e){
	 var max_fields      = 10; //maximum input boxes allowed
       var wrapper         = N(".input_fields_wrap"); //Fields wrapper
     
      var x = 1;
      e.preventDefault();
        if(x == 1)
        {
		premail = N('#val_0').val();
			if(premail == ''){
			alert("Please enter the text box value");
			N('#val_0').focus();
			return false;
			}
			var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
			if(mail.test(premail)==false)
			{
			alert("Please enter the valid email");
			return false;
			}
			}
			else
			{
			 premail = N('#val_'+x).val();
			if(premail == ''){
			alert("text box value is not empty");
			N('#val_'+x).focus();
			return false;
			}
			var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
			if(mail.test(premail)==false)
			{
			alert("Please enter the valid email");
			return false;
			}
			   
			}	
			
         	N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=checkexectingmanageremail", {email: ""+premail+""}, function(data){
			if ( data == 1 )
			{
			       
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            N(wrapper).append('<div><input type="text" class="reportemails" id = "val_'+x+'" style="margin-top:10px; margin-left:0px;" name="mytext[]"/> <a href="javascript:void(0);" onclick="addemail('+x+')" id ="hidesave_'+x+'" class="newaddemail">SAVE</a><a href="javascript:void(0);" onclick="removeemail('+x+')" class="remove_field">REMOVE</a></div>');
			 N('.remove_field').show();
	        //N('.add_email').show();
			 N('.reportemails').show();
			   //add input box
        }
		}
		else
		alert('please save the above email');
		return false;	
		});

    });
   
    N(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
		
		if(x == 1 )
		email = N('#val_0').val();
		else
		email = N('#val_'+x).val();
		if(email){
		N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=deletepreemail", {email: ""+email+""}, function(data){
		
				});
			}		
		N(this).parent('div').remove(); x--;
    });
	
	

		
		N('.include_few').click(function(){
			if(N(this).is(':checked')) {
				N('.include_all').attr('checked', false);
				N('.inddocs').attr('checked', false);
				N('.documents_specified_ind').show();
				data_second = N(this).val();
			}
			else{
				N('.documents_specified_ind').hide();
			}
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatedocuments_second", {documents_second: ""+data_second+""}, function(data){
			});
		});
		N('.include_all').click(function(){
			if(N(this).is(':checked')){
			N('.include_few').attr('checked', false);
			N('.documents_specified_ind').hide();
			data_second = N(this).val();
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatedocuments_second", {documents_second: ""+data_second+""}, function(data){
			});
			}	
		});
		
		N('.inddocs').click(function(){
			//alert("can");
			if(N(this).is(':checked')){
				var selected_doc = N(this).attr('rel');
				var permit = '1';
			}
			else{
				var permit = '0';
				var selected_doc = N(this).attr('rel');
			}
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatedocuments_third", {document_type: ""+selected_doc+"", permit: ""+permit+""}, function(data){
			});
		});
		
		N('.add_phone').click(function(){
			if(N(this).is(':checked'))
			var phone = '1';
			else
			var phone = '0';
			N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=update_phone", {phonenumber: ""+phone+""}, function(data){
			});
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
		 N('.onoffswitch-checkbox').click(function(){
		 	 var check = N("#myonoffswitch").is(":checked");
			 if( check == true ){
			 	if( N("#myonoffswitch").val() == 'on' ){
					var swoff = 'on';
					N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updateswitchon", {off:""+swoff+""}, function(data){
						//location.reload();
						N('.total_block_no').show();
					});
				}
				else{
			 	getpopupbox();
				}
			 }
			 else{
			 	var swoff = 'off';
			 	N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updateswitchon", {off:""+swoff+""}, function(data){
						N('.total_block_no').hide();
					});
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
	
	function deleteemail(id){
	 N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=deleteemail", {id:""+id+""}, function(data){
	 if(data == 1)
	 location.reload();
});
	}
	
	
	
	
	function addemail(x){
	if( x == 0 )
	{
	email = N('#val_0').val();
	if(email == '')
	{
	alert("please select email");
	return false;
	}
	 var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
 if(mail.test(email)==false)
 {
 alert("Please enter the valid email");
 return false;
	}
 }
 else
 {
 email = N('#val_'+x).val();
 if(email == '')
	{
	alert("please select email");
	return false;
	}
	 var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
 if(mail.test(email)==false)
 {
 alert("Please enter the valid email");
 return false;
	}
 }
 alert(email);
 N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=checkexectingmanageremail", {email:""+email+""}, function(data){
 if(data == '1')
 {
alert('already email exits');
}
else
 {
 N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=updatemail", {email:""+email+""}, function(data){
 if(data == '1')
 {
if( x == 0 )	 
 N('#hidesave_0').hide();
else
 N('#hidesave_'+x).hide();
 }
 
});
}
});
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
    var pdfcsvval = N(".mail_pdf:checked").val();
	if( vendors == 'yes' && pdfcsvval == 'csvval')
	window.location = 'index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_report';
	else if( vendors == 'yes' && pdfcsvval == 'pdfval')
	window.open('index.php?option=com_camassistant&controller=rfpcenter&task=compliance_status_report_pdf', '_blank');
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
		window.location = 'index.php?option=com_camassistant&controller=rfpcenter&task=mastercompliance&Itemid=249';
		});
}
</script>
<style>
#maskexwr { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexwr .windowexwr {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexwr #submitexwr {  width:567px;  height:185px;  padding:10px;  background-color:#ffffff;}
#boxesexwr #submitexwr a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneexwr {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeexwr {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>
<script language="JavaScript" type="text/javascript" src="components/com_camassistant/assets/wysiwyg_terms.js"></script>

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
$otheremails = $this->otheremails ;

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

if($permission == 'yes' || $pre_existing == 'no')
$checked1 = "checked='checked'";
else
$checked2 = "checked='checked'";

$per = $this->permissions ;
//print_r($per);exit;
if( $per->report_switch == '1' && $permission != 'yes' && $pre_existing != 'no'){
	$active = 'checked';
	$disply = '';
	}
else{
	$active = '';
	$disply = 'none';
	}

if( $permissions == 'yes' || $pre_existing == 'no' )
	$value = 'off';
else
	$value = 'on';	

?>

<p style="height:20px;"></p>

<div class="newcode_main_manager creports">
<div class="creatcode_div"><p>Real-time Vendor compliance statuses sent directly to your inbox 
<span class="moreinfo_newone"><img src="templates/camassistant_left/images/arrow_master.png">
<a rel="{handler: 'iframe', size: {x: 670, y: 720}}" href="templates/camassistant_left/images/ComplianceStatusReport.png" class="modal" href="javascript:void(0);">View Example</a></span></p>
<div align="center" class="add_newcode_manager">
	<div class="onoffswitch">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" value="<?php echo $value; ?>" id="myonoffswitch" <?php echo $active; ?> />
    <label class="onoffswitch-label" for="myonoffswitch">
    <span class="onoffswitch-inner"></span>
    <span class="onoffswitch-switch"></span>
    </label>
    </div>
</div>
</div>
<div class="manimage_div"><img src="templates/camassistant_left/images/compilancereport.jpg"></div>
</div>




<div class="total_block_no" style="display:<?php echo $disply; ?>">
<div id="i_bar_terms" style="clear:both;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">COMPLIANCE REPORT OPTIONS</font></span>
</div></div>

<?php $user=JFactory::getUser();
		if(( $user->user_type == '13' && $user->accounttype == 'master') || $user->user_type == '16'){
			$display_content = '';
		}
		else{
			$display_content = 'none';
		}	
		
 ?>
<table cellpadding="0" cellspacing="0" style="display:<?php echo $display_content; ?>">
<tr height="13"></tr>

<tr><td></td><td> 
<table cellpadding="0" cellspacing="0" style="padding-left:5px;">
<tr class="secondoptionshow_1"  style="display:<?php //echo $disply; ?>"><td></td><td>Receive Vendor Compliance Status Reports every </td></tr> 
<tr><td></td><td>
<table cellpadding="0" cellspacing="0"  class="secondoptionshow_2"  style="display:<?php //echo $disply; ?>">

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

<tr><td>
<div><input type="checkbox" value="emails" class="include_emails" style="margin:0;" <?php if(count($otheremails)>0){ echo "checked='checked'" ;  } ?>>
</div></td>
<td><span>Other</span></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
 <?php if(count($otheremails)>0)
 $dis = 'block';
 else
 $dis = 'none';
 ?>
<div class="specifyemailtext" style="display:<?php echo $dis;?>">Please specify the email addreess to receive this reoprt </div></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<div class="input_fields_wrap">
<?php if(count($otheremails)>0) { 
for( $e=0; $e<count($otheremails); $e++)
{?>
   <div style="margin-top:8px;"><input type="text" name="mytext[]" id="val_0" readonly="readonly" class="uncheckemails" value ="<?php echo $otheremails[$e]->email;?>"><a href="javascript:void(0);" onclick="deleteemail(<?php echo $otheremails[$e]->id;?>)" class="deletepreemail">REMOVE</a></div>
 <?php } ?>

<?php  } else {?>
   <div style="margin-top:8px;"><input type="text" name="mytext[]" id="val_0" class="reportemails"><a href="javascript:void(0);" onclick="addemail(0)" id="hidesave_0" class="add_email">SAVE</a><a href="#" class="remove_field">REMOVE</a></div>
<?php }?>   
</div>
<?php if(count($otheremails)>0) {?>
<div style="margin-top:10px;"> <a class="add_field_button" style="display:block;">ADD ANOTHER</a></div>
<?php } ?>
<div style="margin-top:10px;"> <a class="add_field_button">ADD ANOTHER</a></div>
</td>
</tr>
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

<tr height="10"></tr>
<tr><td><input type="checkbox" style="margin:0px;" value="include" class="include_documents" <?php if($per->include_docs == '1'){ echo "checked='checked'" ;  } ?>></td><td>Include the Expiration Date for each Vendor's compliance documents</td></tr>

<?php
if( $per->include_docs == '1' )
	$display_f = '';
else
	$display_f = 'none';	
?>

<tr><td colspan="2"><table class="secondtable">
<tr class="documents_specified" style="display:<?php echo $display_f; ?>"><td><input type="radio" style="margin:0px;" value="all" class="include_all" name="document_spec" <?php if($per->how_docs == 'all'){ echo "checked='checked'" ;  } ?>></td><td>All documents</td></tr>
<tr class="documents_specified_specific" style="display:<?php echo $display_f; ?>"><td><input type="radio" style="margin:0px;" value="few" name="document_spec" class="include_few" <?php if($per->how_docs == 'few'){ echo "checked='checked'" ;  } ?>></td><td>Specific documents</td></tr>
</table></td></tr>

<?php
if( $per->how_docs == 'all' || $per->include_docs != '1' )
	$display_s = 'none';
else
	$display_s = '';	
?>
<tr><td colspan="2"><table class="thirdtable">
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="gl" rel="gli" class="inddocs" <?php if($per->gli == '1'){ echo "checked='checked'" ;  } ?>></td><td>General Liability</td></tr>
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="api" rel="api" class="inddocs" <?php if($per->api == '1'){ echo "checked='checked'" ;  } ?>></td><td>Commercial Auto</td></tr>
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="wc" rel="wc" class="inddocs" <?php if($per->wc == '1'){ echo "checked='checked'" ;  } ?>></td><td>Workers Compensation</td></tr>
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="umb" rel="umb" class="inddocs" <?php if($per->umb == '1'){ echo "checked='checked'" ;  } ?>></td><td>Umbrella</td></tr>
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="omi" rel="omi" class="inddocs" <?php if($per->omi == '1'){ echo "checked='checked'" ;  } ?>></td><td>Errors & Omissions </td></tr>
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="pln" rel="pln" class="inddocs" <?php if($per->pln == '1'){ echo "checked='checked'" ;  } ?>></td><td>Professional License</td></tr>
<tr class="documents_specified_ind" style="display:<?php echo $display_s; ?>"><td><input type="checkbox" style="margin:0px;" value="oln" rel="oln" class="inddocs" <?php if($per->oln == '1'){ echo "checked='checked'" ;  } ?>></td><td>Occupational License</td></tr>
</table></td></tr>

<tr height="10"></tr>
<tr><td><input type="checkbox" style="margin:0px;" value="add_phone" class="add_phone" <?php if($per->phone_number == '1'){ echo "checked='checked'" ;  } ?>></td><td>Include the Phone Number for each Vendor</td></tr>
<tr><td colspan="2"><p>Note: This unique identifier can be used to identify each Vendor for accounting purposes. You can also access each Vendor's profile page by simply adding the phone number after <u>www.myvendorcenter.com/vendor/</u>. <br />For example: if your Vendor's phone number is 555-555-1234, then you can access their profile page by going to <u>www.myvendorcenter.com/vendor/5555551234</u>.</p></td></tr>
</table>
<tr height="10"></tr>
<tr><td></td><td>Please select the desired file type to be included with every emailed Compliance Report </td></tr>
<tr><td colspan="2"><table style="margin-left:-7px;">
<tr ><td><input type="radio" value="pdfval"  id="mail_pdf" class="mail_pdf" name="pdfverification" <?php if($per->documenttype == '0'){ echo "checked='checked'" ;  } ?> ></td><td>PDF</td></tr>
<tr ><td><input type="radio"  value="csvval" id="mail_pdf1" class="mail_pdf" name="pdfverification" <?php if($per->documenttype == '1'){ echo "checked='checked'" ;  }  ?>></td><td>CSV</td></tr>

</table></td></tr>

</td></tr></table>

</td></tr></table>
<input type="hidden" id="test" class="test" value="test">
<div style="margin-top:20px;" id="topborder_row"> </div>
<div class="clickhere_creport"><a href="javascript:void(0);" onclick="statusurl('<?php echo $vendors_re; ?>');" class="generate_compliancereport"></a></div>

</div>

<?php
if(!$per){
$db=&JFactory::getDBO();
$user=JFactory::getUser();
$query5 = "INSERT INTO #__cam_master_compliancereport ( id , masterid , master, admin, dm, m, unverified, verified, nonc, compliant, report_switch, include_docs, how_docs, gli, api, wc, umb, omi, pln, oln, phone_number,documenttype) VALUES ( '' , '".$user->id."', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0','0');";
$db->setQuery( $query5 );
$res5=$db->query();
}
else{
}
?>







<div id="boxesexwr" style="top:576px; left:582px;">
<div id="submitexwr" class="windowexwr" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">You cannot turn on your Vendor Compliance Report feature because you have not set company-wide compliance standards. Please click the button below to set your company's unique Vendor compliance standards before turning this feature on.</p>
</div>
<div style="padding-top:18px;" align="center">
<div id="cancelexwr" name="doneexwr" value="Ok" class="set_standards"></div>
</div>
</div>
  <div id="maskexwr"></div>
</div>
