<script>
var flag=0;
function toggleStatus1(divname,divid) {
G('#'+divname+divid).removeClass("ven_fade").addClass("");
G('#'+divname+divid+' :input').removeAttr('disabled');
G('#'+divname+divid+'_save_msg').css('display', 'block');
}
function submitform(pressbutton){
var form = document.adminForm;

	 if((pressbutton=='cancel'))
	 {
	     form.controller.value="vendorcompliances_details";
		 form.task.value = 'cancel';
	 }
	 else if(pressbutton=='save')
	 {
	   form.controller.value="vendorcompliances_details";
	   form.task.value = 'save_compliance';
	 }

	 form.submit();
}
function cenceleditdocs(){
document.getElementById('changes').value='no';
location.reload(); 
}

function show_popup(doc,val,evt)
{
var node = (evt.target) ? evt.target : ((evt.srcElement)?evt.srcElement : null );
evt = (evt) ? evt : ((event) ? event : null);

//alert(node.type);
//alert(node.title);
if(node.title == '' && node.type != 'file')
{
	if(G("#line_task_"+doc+val).attr("cnt_"+doc+val)==0)
	{
	//alert('hi');
	compliance_update();
	G("#line_task_"+doc+val).attr("cnt_"+doc+val,"1");
	}
}

}
function toggleStatus(divname,divid,docid) {
//alert(flag);
				//Cancel the link behavior
		//Get the A tag
		//Get the screen height and width
 	G('#old_'+divname+'_ids_'+divid).val(docid);
                if(divname=='W9_id'){
              var taskname='W9_id';
                } else {
              var taskname='old_'+divname+'_ids_'+docid;
                }
 	document.getElementById(taskname).disabled  = false;		
/* if(flag == 0)
		{
			var maskHeight = G(document).height();
			var maskWidth = G(window).width();
			//Set heigth and width to mask to fill up the whole screen
			G('#mask1').css({'width':maskWidth,'height':maskHeight});
			//transition effect
			G('#mask1').fadeIn(100);
			G('#mask1').fadeTo("slow",0.8);
			//Get the window height and width
			var winH = G(window).height();
			var winW = G(window).width();
			winh=winH/2;
			winw=winW/2;

			//Set the popup window to center
			G("#submit1").css('top',  winh);
			G("#submit1").css('left', winw);
			G("#submit1").fadeIn(2000);

			G('.window1 #done1').click(function (e) {
			//Cancel the link behavior
			e.preventDefault();
			G('#mask1').hide();
			G('.window1').hide();
			G('#'+divname+divid).removeClass("ven_fade").addClass("");
			G('#'+divname+divid+' :input').removeAttr('disabled');
			G('#'+divname+divid+'_save_msg').css('display', 'block');
			//G('#'+divname+divid+' a').attr('onclick','return true;');
			//G('#'+divname+divid+'_anc').css('display', 'block');
			//var inc = G('#old_OLN_ids').size();
			//G('#old_'+divname+'_ids[]').val(docid);
			flag = 1;
			G('#old_'+divname+'_ids_'+divid).val(docid);
			});
		}
		//var frm = document.vendor_proposal_form;
		//frm.submit_type.value = 'ITB';
		//frm.task.value = 'Proposal_save_as_ITB';
		//frm.submit();
*/
}




G(document).ready(function() {
	//if close button is clicked
	G('.window1 #close1').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		G('#mask1').hide();
		G('.window1').hide();
	});
	//if done button is clicked
	G('.window1 #done1').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		G('#mask1').hide();
		G('.window1').hide();

	});
});


function validate_data2()
{
var val = confirm("This will deactivate your Proposal Center and make you ineligible to receive RFP's until re-validation. This can take up to 3 days. If you need validation immediately please call 561-246-3830. Would you like to continue? ");
	if(val == false)
	{
	//document.getElementById('GLI_upld_cert_file').disabled  = true;
	return false ;
	}
	else
	{
	return ;
	}
	return;
}


G(document).ready(function() {
G('.todaydate').click(function(){
var id = G(this).attr('id');
var name = G(this).attr('name');
name = parseInt(name);
var date = '<?php echo date('m-d-Y')?>';
if(id == 'w9')
G('#w9_date_verified').val(date);

for(i=1; i<=name; i++) {
if(id == 'gli'+i)
{
var x = G("#GLI_date_verified"+i).val(date);
}
}
if(id == 'aip')
G('#aip_date_verified').val(date);
for(i=2; i<=name; i++) {
if(id == 'aip'+i)
{
var x = G("#aip_date_verified"+i).val(date);
}
}
for(i=1; i<=name; i++) {
if(id == 'wci'+i)
{
G("#WCI_date_verified"+i).val(date);
}
}
if(id == 'umb')
G('#UMB_date_verified').val(date);
for(i=2; i<=name; i++) {
if(id == 'umb'+i)
{
var x = G("#UMB_date_verified"+i).val(date);
}
}
if(id == 'oln')
G('#OLN_date_verified').val(date);
for(i=2; i<=name; i++) {
if(id == 'oln'+i)
{
var x = G("#OLN_date_verified"+i).val(date);
}
}
if(id == 'pln')
G('#PLN_date_verified').val(date);
for(i=2; i<=name; i++) 
{
if(id == 'pln'+i)
{
var x = G("#PLN_date_verified"+i).val(date);
}
}
if(id == 'wc')
G('#wc_date_verified').val(date);
for(i=2; i<=name; i++) {
if(id == 'wc'+i)
{
var x = G("#wc_date_verified"+i).val(date);
}
}
if(id == 'omi')
G('#OMI_date_verified').val(date);
for(i=2; i<=name; i++) {
if(id == 'omi'+i)
{
var x = G("#OMI_date_verified"+i).val(date);
}
}

});
 });

function OLN_modify_date(val,divid)
{
var d = new Date();
var curr_year = d.getFullYear();
var year = parseInt(curr_year)+parseInt(1);
var mystring = val;
var myarray = mystring.split("-");
//var modified_date = myarray[0]+'-'+myarray[1]+'-'+year;
var modified_date = myarray[0]+'-'+myarray[1]+'-'+myarray[2];
alert(modified_date);
document.getElementById("OLN_expdate"+divid).value = modified_date;
}
function PLN_modify_date(val,divid)
{
var d = new Date();
var curr_year = d.getFullYear();
var year = parseInt(curr_year)+parseInt(1);
var mystring = val;
var myarray = mystring.split("-");
//var modified_date = myarray[0]+'-'+myarray[1]+'-'+year;
var modified_date = myarray[0]+'-'+myarray[1]+'-'+myarray[2];
document.getElementById("PLN_expdate"+divid).value = modified_date;
}

	if(!OLN_compliance)
	OLN_compliance=1;
	if(!PLN_compliance)
	PLN_compliance=1;
	if(!GLI_compliance)
	GLI_compliance=1;
	if(!WCI_compliance)
	WCI_compliance=1;
	if(!AIP_compliance)
	AIP_compliance=1;
	
	if(!OLN_title)
	OLN_title=1;
	if(!PLN_title)
	PLN_title=1;
	if(!GLI_title)
	GLI_title=1;
	if(!WCI_title)
	WCI_title=1;
	if(!AIP_compliance)
	AIP_title=1;
	
G = jQuery.noConflict();
function callajaxcomp_OLN(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
	G("#addcompliance_PLN_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');

OLN_compliance++;
OLN_title++;
G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_OLN_form", {compliance: ""+OLN_compliance+"",OLN_title: ""+OLN_title+""}, function(data){
if(data.length >0) {
G("#addcompliance_OLN_loading").html('');
G("#addcompliance_OLN").append(data);
G("#OLN_license"+OLN_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}

}
function callajaxcomp_PLN(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
	G("#addcompliance_PLN_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');

PLN_compliance++;
PLN_title++;
G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_PLN_form", {compliance: ""+PLN_compliance+"",PLN_title: ""+PLN_title+""}, function(data){
//alert(data);
if(data.length >0) {
G("#addcompliance_PLN_loading").html('');
G("#addcompliance_PLN").append(data);
G("#PLN_license"+PLN_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}
}
function callajaxcomp_GLI(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
	G("#addcompliance_PLN_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');
GLI_compliance++;
GLI_title++;

G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_gli_form", {compliance: ""+GLI_compliance+"",GLI_title: ""+GLI_title+"",vendoridmain: ""+userid_comp+""}, function(data){
if(data.length >0) {
G("#addcompliance_GLI_loading").html('');
G("#addcompliance_GLI").append(data);
G("#GLI_name"+GLI_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}

}
function callajaxcomp_WCI(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
	G("#addcompliance_WCI_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');

WCI_compliance++;
WCI_title++;
G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_wci_form", {compliance: ""+WCI_compliance+"",WCI_title: ""+WCI_title+""}, function(data){
if(data.length >0) {
G("#addcompliance_WCI_loading").html('');
G("#addcompliance_WCI").append(data);
G("#WCI_name"+WCI_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}
}
function getconfirmbox(){
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskexc').css({'width':maskWidth,'height':maskHeight});
		G('#maskexc').fadeIn(100);
		G('#maskexc').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitexc").css('top',  winH/2-G("#submitexc").height()/2);
		G("#submitexc").css('left', winW/2-G("#submitexc").width()/2);
		G("#submitexc").fadeIn(2000);
		G('.windowexc #cancelexc').click(function (e) {
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
		location.reload();
		});
}

function callajaxcomp_AIP(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
AIP_compliance++;
AIP_title++;
G("#addcompliance_AIP_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');
G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_aip_form", {compliance: ""+AIP_compliance+"",AIP_title: ""+AIP_title+"",vendoridmain: ""+userid_comp+""}, function(data){
if(data.length >0) {
G("#addcompliance_AIP_loading").html('');
G("#addcompliance_AIP").append(data);
G("#AIP_name"+AIP_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}

}
function callajaxcomp_UMB(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
G("#addcompliance_UMB_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');
UMB_compliance++;
UMB_title++;

G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_umb_form", {compliance: ""+UMB_compliance+"",UMB_title: ""+UMB_title+""}, function(data){
if(data.length >0) {
G("#addcompliance_UMB_loading").html('');
G("#addcompliance_UMB").append(data);
G("#UMB_license"+UMB_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}
}
function callajaxcomp_OMI(){
editoption = G('#changes').val();
if( editoption == 'no' ){
	getconfirmbox();
	G('.windowexc #donetexc').click(function (e) {
	G("#addcompliance_OMI_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');
OMI_compliance++;
OMI_title++;

G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_omi_form", {compliance: ""+OMI_compliance+"",OMI_title: ""+OMI_title+""}, function(data){
if(data.length >0) {
G("#addcompliance_OMI_loading").html('');
G("#addcompliance_OMI").append(data);
G("#OMI_license"+OMI_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
	});	
}
else{
	alert("You must SAVE the document you're currently editing before editing/adding another document");
}

}

function callajaxcomp_WC(){
editoption = G('#changes').val();
	if( editoption == 'no' ){
		getconfirmbox();
		G('.windowexc #donetexc').click(function (e) {
		G("#addcompliance_WC_loading").html('<img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/final_loading_big.gif" />');
WC_compliance++;
WC_title++;

G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=ajax_compliance_wc_form", {compliance: ""+WC_compliance+"",WC_title: ""+WC_title+""}, function(data){
if(data.length >0) {
G("#addcompliance_WC_loading").html('');
G("#addcompliance_WC").append(data);
G("#WC_name"+WC_compliance).focus();
}
});
G('#changes').val('yes');
		e.preventDefault();
		G('#maskexc').hide();
		G('.windowexc').hide();
		});
	}
	else
	{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
}



//function to delete upld cert file
function del_upld_cert(type,file,table,suf,ID,daid)
{
 editoption = G('#changes').val();
  if( editoption == 'no' ){

	if(ID){
       var ID= ID;
        } else {
    var ID= document.getElementById('d'+suf+''+daid).value;
        }
		var userid = '<?PHP echo $userid; ?>';
G('#'+suf+daid).css('pointer-events', '');
G('#'+suf+daid).css('opacity', '1');
G('.'+suf+daid).css('display', '');
G('.'+daid+suf).css('display', 'none');
G('#'+suf+'_cert'+daid).css('display', 'block');
G('#'+suf+'_certhide'+daid).css('display', 'none');
G('#'+suf+'_add'+daid).css('display', 'block');
G('#'+suf+'_addhide'+daid).css('display', 'none');
G('#'+suf+'_idedit'+daid).val('yes');
G("#changes").val('yes');
G('.redstar_'+suf+daid).css('display', '');
// For GLI documents
G('.'+suf+'_'+daid).css('display', 'none');
G('#'+suf+'_end_date'+daid).css('display', '');
G('#'+suf+'_med'+daid).css('display', '');
G('#'+suf+'_policy_occurence'+daid).css('display', '');
G('#'+suf+'_injury'+daid).css('display', '');
G('#'+suf+'_policy_aggregate'+daid).css('display', '');
G('#'+suf+'_products'+daid).css('display', '');
G('#'+suf+'_damage'+daid).css('display', '');
G('#'+suf+'_aggregate'+daid).css('display', '');
G('#'+suf+'_each_claim'+daid).css('display', '');

if(suf == 'W9'){
		G('.attrInputs'+daid).removeAttr('disabled');
		G('.W9'+daid+'_check').removeAttr('disabled');
		G('.W9'+daid+'_pointers').css('pointer-events', '');
		G('.datanumber').hide();
	}

if(suf == 'GLI'){
		G('.attrInputs'+daid).removeAttr('disabled');
		G('.GLI'+daid+'_check').removeAttr('disabled');
		G('.GLI'+daid+'_pointers').css('pointer-events', '');
	}
	if(suf == 'aip'){
		G('.AIP_primary'+daid).removeAttr('disabled');
		G('.aip'+daid+'_pointers').css('pointer-events', '');
	}
	if(suf == 'WCI'){
		G('.WCI_sub'+daid).removeAttr('disabled');
		G('.WCI'+daid+'_pointers').css('pointer-events', '');
	}
	if(suf == 'OMI'){
		G('.OMI_sub'+daid).removeAttr('disabled');
		G('.OMI'+daid+'_pointers').css('pointer-events', '');
	}
//Completed
// For Commercial Vehicle Policy documents
G('#'+suf+'_bodily'+daid).css('display', '');
G('#'+suf+'_combined'+daid).css('display', '');
G('#'+suf+'_body_injury'+daid).css('display', '');
G('#'+suf+'_property'+daid).css('display', '');
//Completed
// For WCI documents
G('#'+suf+'_disease_policy'+daid).css('display', '');
G('#'+suf+'_each_accident'+daid).css('display', '');
G('#'+suf+'_disease'+daid).css('display', '');
//Completed
// For Umbrella documents
G('#'+suf+'_expdate'+daid).css('display', '');
G('#'+suf+'_aggregate'+daid).css('display', '');
G('#'+suf+'_occur'+daid).css('display', '');
//Completed
// For Professional documents
G('#'+suf+'_state'+daid).css('display', '');
G('#'+suf+'_type'+daid).css('display', '');
//Completed
//For W9 document
G('#ein_number').css('display', '');
}
else{
	alert("You must SAVE the document you're currently editing before editing another document");
}
		//var val = confirm("This will deactivate your Proposal Center and make you ineligible to receive RFP's until re-validation. This can take up to 3 days. If you need validation immediately please call 561-246-3830. Would you like to continue? ");
		/*var val = confirm("Are you sure you want to delete?");
		
	if(val == true)
	{
		G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=delete_upld_cert", {type: ""+type+"",filename: ""+file+"", tbl: ""+table+"" , suffix: ""+suf+"" ,id: ""+ID+"" , userid: ""+userid+"",daid: ""+daid+""}, function(data){
		if(data.length >0) {
		G("#msg_note").append(data);
		}
		});
	}*/
	//return;
}
function get_subcat(catid,sub_divid){
//alert(catid);
G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=get_subcat", {compliance: ""+PLN_compliance+"",PLN_title: ""+PLN_title+"",sub_divid: ""+sub_divid+"",catid: ""+catid+""}, function(data){
//alert(data);
if(data.length >0) {
G("#PLN_sub_cat"+sub_divid).html(data);
}
});
}

function del_from_db(tbl,docid)
{
G.post("index2.php?option=com_camassistant&controller=vendorcompliances_details&task=del_vendorcompliance_fromtbl", {tbl: ""+tbl+"",docid: ""+docid+""}, function(data){
if(data.length >0) {
alert('Deleted Successfully');
location.reload(); 
}
});
}

//function to delete OLN div
function del_callajaxcomp_OLN(tbl,docid,divid)
{
	var frm = document.adminForm;
	editoption = G('#changes').val();
	if( editoption == 'no' ){
	if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dOLN'+divid).value;
        }
         var r=confirm("Are you sure you want to delete this Occupational License");
		 }
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
if (r==true)
  {
	del_from_db(tbl,docid);
	G("div").remove("#line_task_OLN"+divid);
         document.getElementById('line_task_OLN'+divid).style.display='none';
	OLN_title = OLN_title-1;
	var id;
	for(id=2; id<=OLN_title; id++)
	{
	//alert('hello');
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	gtid = parseInt(id)+1;
	G("#OLN_"+gtid).html(id); //to change divid value
	G("#OLN_dv"+gtid).html(id);
	G("#OLN_no"+gtid).html(id); // to change license no  value
	G("#OLN_exp"+gtid).html(id); // to change expired date no  value
	G("#OLN_cc"+gtid).html(id);
	G("#OLN_st"+gtid).html(id);
	G("#line_task_OLN"+gtid).attr("id","line_task_OLN"+id);
	G("#OLN_"+gtid).attr("id","OLN_"+id);  // to replace div id
	G("#OLN_dv"+gtid).attr("id","OLN_dv"+id);
	G("#OLN_no"+gtid).attr("id","OLN_no"+id); // to replace span liscense  id
	G("#OLN_exp"+gtid).attr("id","OLN_exp"+id); // to replace span expdate  id
	G("#OLN_cc"+gtid).attr("id","OLN_cc"+id); // to replace span expdate  id
	G("#OLN_st"+gtid).attr("id","OLN_st"+id); // to replace span expdate  id
	G("#OLN_delete_"+gtid).attr("id","OLN_delete_"+id);
	G("#current_line_task_OLN_ids"+gtid).val(id);
	G("#current_line_task_OLN_ids"+gtid).attr("id","current_line_task_OLN_ids"+id);
	var db_docid = G('#old_line_task_OLN_ids_'+gtid).val();
	G("#OLN_delete_"+id).html('<a href="javascript:del_callajaxcomp_OLN(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	}
	else
	{
	G("#OLN_"+id).html(id); //to change divid no
	G("#OLN_dv"+id).html(id);
	G("#OLN_no"+id).html(id);  // to change license no
	G("#OLN_exp"+id).html(id);
	G("#OLN_cc"+id).html(id);
	G("#OLN_st"+id).html(id);
	G("#line_task_OLN"+id).attr("id","line_task_OLN"+id);
	G("#OLN_"+id).attr("id","OLN_"+id);
	G("#OLN_dv"+id).attr("id","OLN_dv"+id);
	G("#OLN_no"+id).attr("id","OLN_no"+id);
	G("#OLN_exp"+id).attr("id","OLN_exp"+id);
	G("#OLN_cc"+id).attr("id","OLN_cc"+id);
	G("#OLN_st"+id).attr("id","OLN_st"+id);
	G("#OLN_delete_"+id).attr("id","OLN_delete_"+id);
	G("#current_line_task_OLN_ids"+gtid).val(id);
	G("#current_line_task_OLN_ids"+gtid).attr("id","current_line_task_OLN_ids"+id);
	var db_docid = G('#old_line_task_OLN_ids_'+id).val();
	G("#OLN_delete_"+id).html('<a href="javascript:del_callajaxcomp_OLN(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	}

        }
    }
}
//function to delete PLN div
function del_callajaxcomp_PLN(tbl,docid,divid)
{
	var frm = document.adminForm;
	editoption = G('#changes').val();
	if( editoption == 'no' ){
	if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dPLN'+divid).value;
        }
        var r=confirm("Are you sure you want to delete this Professional License");
		}
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
    if (r==true)
     {
	del_from_db(tbl,docid);
	G("div").remove("#line_task_PLN"+divid);
        document.getElementById('line_task_PLN'+divid).style.display='none';
	PLN_title = PLN_title-1;
	var id;
	for(id=2; id<=PLN_title; id++)
	{
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	 gtid = parseInt(id)+1;
	G("#PLN_"+gtid).html(id); //to change divid value
	G("#PLN_dv"+gtid).html(id);
	G("#PLN_no"+gtid).html(id); // to change license no  value
	G("#PLN_exp"+gtid).html(id); // to change expired date no  value
	G("#PLN_lc"+gtid).html(id);
	G("#PLN_lt"+gtid).html(id);
	G("#PLN_st"+gtid).html(id);
	G("#line_task_PLN"+gtid).attr("id","line_task_PLN"+id);
	G("#PLN_"+gtid).attr("id","PLN_"+id);  // to replace div id
	G("#PLN_dv"+gtid).attr("id","PLN_dv"+id);
	G("#PLN_no"+gtid).attr("id","PLN_no"+id); // to replace span liscense  id
	G("#PLN_exp"+gtid).attr("id","PLN_exp"+id); // to replace span expdate  id
	G("#PLN_lc"+gtid).attr("id","PLN_cc"+id); // to replace span expdate  id
	G("#PLN_lt"+gtid).attr("id","PLN_cc"+id);
	G("#PLN_st"+gtid).attr("id","PLN_st"+id); // to replace span expdate  id
	G("#PLN_license"+gtid).attr("id","PLN_license"+id);
	G("#PLN_category"+gtid).attr("id","PLN_category"+id);
	G("#PLN_type"+gtid).attr("id","PLN_type"+id);
	G("#PLN_expdate"+gtid).attr("id","PLN_expdate"+id);
	G("#PLN_state"+gtid).attr("id","PLN_state"+id);
	G("#PLN_upld_cert"+gtid).attr("id","PLN_upld_cert"+id);
	G("#current_line_task_PLN_ids"+gtid).val(id);
	G("#current_line_task_PLN_ids"+gtid).attr("id","current_line_task_PLN_ids"+id);
	var db_docid = G('#old_line_task_PLN_ids_'+gtid).val();

	G("#PLN_delete_"+gtid).attr("id","PLN_delete_"+id);
	G("#PLN_delete_"+id).html('<a href="javascript:del_callajaxcomp_PLN(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	}
	else
	{
	G("#PLN_"+id).html(id); //to change divid no
	G("#PLN_dv"+id).html(id);
	G("#PLN_no"+id).html(id);  // to change license no
	G("#PLN_exp"+id).html(id);
	G("#PLN_lc"+id).html(id);
	G("#PLN_lt"+id).html(id);
	G("#PLN_st"+id).html(id);
	G("#line_task_PLN"+id).attr("id","line_task_PLN"+id);
	G("#PLN_"+id).attr("id","PLN_"+id);
	G("#PLN_dv"+id).attr("id","PLN_dv"+id);
	G("#PLN_no"+id).attr("id","PLN_no"+id);
	G("#PLN_exp"+id).attr("id","PLN_exp"+id);
	G("#PLN_lc"+id).attr("id","PLN_lc"+id);
	G("#PLN_lt"+id).attr("id","PLN_lt"+id);
	G("#PLN_st"+id).attr("id","PLN_st"+id);

	G("#PLN_license"+id).attr("id","PLN_license"+id);
	G("#PLN_category"+id).attr("id","PLN_category"+id);
	G("#PLN_type"+id).attr("id","PLN_type"+id);
	G("#PLN_expdate"+id).attr("id","PLN_expdate"+id);
	G("#PLN_state"+id).attr("id","PLN_state"+id);
	G("#PLN_upld_cert"+id).attr("id","PLN_upld_cert"+id);
	G("#current_line_task_PLN_ids"+id).val(id);
	G("#current_line_task_PLN_ids"+id).attr("id","current_line_task_PLN_ids"+id);
	var db_docid = G('#old_line_task_WCI_ids_'+id).val();
	G("#PLN_delete_"+id).attr("id","PLN_delete_"+id);
	G("#PLN_delete_"+id).html('<a href="javascript:del_callajaxcomp_PLN(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	}
	}
      }
}
function del_callajaxcomp_GLI(tbl,docid,divid)
{
	var frm = document.adminForm;
	editoption = G('#changes').val();
	if( editoption == 'no' ){
 	if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dGLI'+divid).value;
        }
        var r=confirm("Are you sure you want to delete this General Liability");
		}
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
	
if (r==true)
  {
	del_from_db(tbl,docid);
	G("div").remove("#line_task_GLI"+divid);
         document.getElementById('line_task_GLI'+divid).style.display='none';
	GLI_title = GLI_title-1;
	var id;
	for(id=2; id<=GLI_title; id++)
	{
	newid = parseInt(id)+1;
	if(id>=divid)
	{

	/* gtid = parseInt(id)+1;
	G("#GLI_"+gtid).html(id); //to change divid value
	G("#GLI_no"+gtid).html(id); // to change license no  value
	//to change field names
	G("#GLI_name"+gtid).attr("id","GLI_name"+id);
	G("#GLI_policy"+gtid).attr("id","GLI_policy"+id);
	G("#GLI_start_date"+gtid).attr("id","GLI_start_date"+id);
	G("#GLI_end_date"+gtid).attr("id","GLI_end_date"+id);
	G("#GLI_agent_first_name"+gtid).attr("id","GLI_agent_first_name"+id);
	G("#GLI_agent_last_name"+gtid).attr("id","GLI_agent_last_name"+id);
	G("#GLI_phone1"+gtid).attr("id","GLI_phone1"+id);
	G("#GLI_phone2"+gtid).attr("id","GLI_phone2"+id);
	G("#GLI_phone3"+gtid).attr("id","GLI_phone3"+id);
	G("#GLI_policy_aggregate"+gtid).attr("id","GLI_policy_aggregate"+id);
	G("#GLI_policy_occurence"+gtid).attr("id","GLI_policy_occurence"+id);
	G("#GLI_upld_cert"+gtid).attr("id","GLI_upld_cert"+id);
    //end of code
	G("#GLI_no"+id).attr("id","GLI_no"+id);
	G("#GLI_delete_"+gtid).attr("id","GLI_delete_"+id);
	G("#GLI_delete_"+id).html('<a href="javascript:del_callajaxcomp_GLI('+id+');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');*/
	gtid = parseInt(id)+1;
	G("#GLI_"+gtid).html(id); //to change divid value
	G("#GLI_dv"+gtid).html(id);
	G("#GLI_no"+gtid).html(id); // to change license no  value
	G("#GLI_pno"+gtid).html(id); // to change expired date no  value
	G("#GLI_d"+gtid).html(id);
	G("#GLI_ag"+gtid).html(id);
	G("#GLI_ph"+gtid).html(id);
	G("#line_task_GLI"+gtid).attr("id","line_task_GLI"+id);
	G("#GLI_"+gtid).attr("id","GLI_"+id);  // to replace div id
	G("#GLI_dv"+gtid).attr("id","GLI_dv"+id);
	G("#GLI_no"+gtid).attr("id","GLI_no"+id); // to replace span liscense  id
	G("#GLI_pno"+gtid).attr("id","GLI_pno"+id); // to replace span expdate  id
	G("#GLI_d"+gtid).attr("id","GLI_d"+id); // to replace span expdate  id
	G("#GLI_ag"+gtid).attr("id","GLI_ag"+id);
	G("#GLI_ph"+gtid).attr("id","GLI_ph"+id); // to replace span expdate  id

	G("#GLI_name"+gtid).attr("id","GLI_name"+id);
	G("#GLI_policy"+gtid).attr("id","GLI_policy"+id);
	G("#GLI_start_date"+gtid).attr("id","GLI_start_date"+id);
	G("#GLI_end_date"+gtid).attr("id","GLI_end_date"+id);
	G("#GLI_agent_first_name"+gtid).attr("id","GLI_agent_first_name"+id);
	G("#GLI_agent_last_name"+gtid).attr("id","GLI_agent_last_name"+id);
	G("#GLI_phone1"+gtid).attr("id","GLI_phone1"+id);
	G("#GLI_phone2"+gtid).attr("id","GLI_phone2"+id);
	G("#GLI_phone3"+gtid).attr("id","GLI_phone3"+id);
	var agre = G("#GLI_policy_aggregate"+gtid).val();
	var occ = G("#GLI_policy_occurence"+gtid).val();
	G("#GLI_policy_aggregate"+gtid).attr("id","GLI_policy_aggregate"+id);
	G("#GLI_policy_occurence"+gtid).attr("id","GLI_policy_occurence"+id);
	G("#GLI_upld_cert"+gtid).attr("id","GLI_upld_cert"+id);

	G("#GLI_delete_"+gtid).attr("id","GLI_delete_"+id);
	G("#GLI_aggregate_"+gtid).attr("id","GLI_aggregate_"+id);
	G("#GLI_occurence_"+gtid).attr("id","GLI_occurence_"+id);
	G("#current_line_task_GLI_ids"+gtid).val(id);
	G("#current_line_task_GLI_ids"+gtid).attr("id","current_line_task_GLI_ids"+id);
	var db_docid = G('#old_line_task_GLI_ids_'+gtid).val();

	G("#GLI_delete_"+id).html('<a href="javascript:del_callajaxcomp_GLI(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	G("#GLI_aggregate_"+id).html('<input type="text" name="GLI_policy_aggregate[]" id="GLI_policy_aggregate'+id+'" class="t_field" style="width:80px; color: #F00; text-align: center;" onKeyup="if(isNaN(this.value)) { alert(\'Please enter valid number\'); this.value=\'\'; }" onChange="javascript: add_commas(\'GLI_policy_aggregate\',this.value,'+id+');" value="'+agre+'" />');
	G("#GLI_occurence_"+id).html('<input type="text" name="GLI_policy_occurence[]" id="GLI_policy_occurence'+id+'" class="t_field" style="width:80px; color: #F00; text-align: center;" onKeyup="if(isNaN(this.value)) { alert(\'Please enter valid number\'); this.value=\'\'; }" onChange="javascript: add_commas(\'GLI_policy_occurence\',this.value,'+id+');" value="'+occ+'" />');
	}
	else
	{

	G("#GLI_"+id).html(id); //to change divid no
	G("#GLI_dv"+id).html(id);
	G("#GLI_no"+id).html(id);  // to change license no
	G("#GLI_pno"+id).html(id);
	G("#GLI_d"+id).html(id);
	G("#GLI_ag"+id).html(id);
	G("#GLI_ph"+id).html(id);
	G("#line_task_GLI"+id).attr("id","line_task_GLI"+id);
	G("#GLI_"+id).attr("id","GLI_"+id);
	G("#GLI_dv"+id).attr("id","GLI_dv"+id);
	G("#GLI_no"+id).attr("id","GLI_no"+id);
	G("#GLI_pno"+id).attr("id","GLI_pno"+id);
	G("#GLI_d"+id).attr("id","GLI_d"+id);
	G("#GLI_ag"+id).attr("id","GLI_ag"+id);
	G("#GLI_ph"+id).attr("id","GLI_ph"+id);
	G("#GLI_delete_"+id).attr("id","GLI_delete_"+id);

	G("#GLI_name"+id).attr("id","GLI_name"+id);
	G("#GLI_policy"+id).attr("id","GLI_policy"+id);
	G("#GLI_start_date"+id).attr("id","GLI_start_date"+id);
	G("#GLI_end_date"+id).attr("id","GLI_end_date"+id);
	G("#GLI_agent_first_name"+id).attr("id","GLI_agent_first_name"+id);
	G("#GLI_agent_last_name"+id).attr("id","GLI_agent_last_name"+id);
	G("#GLI_phone1"+id).attr("id","GLI_phone1"+id);
	G("#GLI_phone2"+id).attr("id","GLI_phone2"+id);
	G("#GLI_phone3"+id).attr("id","GLI_phone3"+id);
	var agre = G("#GLI_policy_aggregate"+id).val();
	var occ = G("#GLI_policy_occurence"+id).val();
	G("#GLI_policy_aggregate"+id).attr("id","GLI_policy_aggregate"+id);
	G("#GLI_policy_occurence"+id).attr("id","GLI_policy_occurence"+id);
	G("#GLI_upld_cert"+id).attr("id","GLI_upld_cert"+id);
	G("#GLI_aggregate_"+id).attr("id","GLI_aggregate_"+id);
	G("#GLI_occurence_"+id).attr("id","GLI_occurence_"+id);
	G("#current_line_task_GLI_ids"+id).val(id);
	G("#current_line_task_GLI_ids"+id).attr("id","current_line_task_GLI_ids"+id);
	var db_docid = G('#old_line_task_WCI_ids_'+id).val();
	G("#GLI_delete_"+id).html('<a href="javascript:del_callajaxcomp_GLI(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	G("#GLI_aggregate_"+id).html('<input type="text" name="GLI_policy_aggregate[]" id="GLI_policy_aggregate'+id+'" class="t_field" style="width:80px; color: #F00; text-align: center;" onKeyup="if(isNaN(this.value)) { alert(\'Please enter valid number\'); this.value=\'\'; }" onChange="javascript: add_commas(\'GLI_policy_aggregate\',this.value,'+id+');" value="'+agre+'" />');
	G("#GLI_occurence_"+id).html('<input type="text" name="GLI_policy_occurence[]" id="GLI_policy_occurence'+id+'" class="t_field" style="width:80px; color: #F00; text-align: center;" onKeyup="if(isNaN(this.value)) { alert(\'Please enter valid number\'); this.value=\'\'; }" onChange="javascript: add_commas(\'GLI_policy_occurence\',this.value,'+id+');" value="'+occ+'" />');

	/*G("#GLI_"+id).html(id); //to change divid no
	G("#GLI_no"+gtid).html(id); // to change license no  value
	//to change field names
	G("#GLI_name"+gtid).attr("id","GLI_name"+id);
	G("#GLI_policy"+gtid).attr("id","GLI_policy"+id);
	G("#GLI_start_date"+gtid).attr("id","GLI_start_date"+id);
	G("#GLI_end_date"+gtid).attr("id","GLI_end_date"+id);
	G("#GLI_agent_first_name"+gtid).attr("id","GLI_agent_first_name"+id);
	G("#GLI_agent_last_name"+gtid).attr("id","GLI_agent_last_name"+id);
	G("#GLI_phone1"+gtid).attr("id","GLI_phone1"+id);
	G("#GLI_phone2"+gtid).attr("id","GLI_phone2"+id);
	G("#GLI_phone3"+gtid).attr("id","GLI_phone3"+id);
	G("#GLI_policy_aggregate"+gtid).attr("id","GLI_policy_aggregate"+id);
	G("#GLI_policy_occurence"+gtid).attr("id","GLI_policy_occurence"+id);
	G("#GLI_upld_cert"+gtid).attr("id","GLI_upld_cert"+id);
    //end of code
	G("#GLI_no"+id).attr("id","GLI_no"+id);
	G("#GLI_delete_"+gtid).attr("id","GLI_delete_"+id);
	G("#GLI_delete_"+id).html('<a href="javascript:del_callajaxcomp_GLI('+id+');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');*/
	}
	}
      }
}
//function to delete WCI div
function del_callajaxcomp_WCI(tbl,docid,divid)
{
	var frm = document.adminForm;
	editoption = G('#changes').val();
	if( editoption == 'no' ){
	if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dWCI'+divid).value;
        }
        var r=confirm("Are you sure you want to delete this Workers Compensation Policy");
		}
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
	
if (r==true)
  {
	del_from_db(tbl,docid);
	G("div").remove("#line_task_WCI"+divid);
         document.getElementById('line_task_WCI'+divid).style.display='none';
	WCI_title = WCI_title-1;
	var id;
	for(id=2; id<=WCI_title; id++)
	{
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	 gtid = parseInt(id)+1;
	G("#WCI_"+gtid).html(id); //to change divid value
	G("#WCI_dv"+gtid).html(id);
	G("#WCI_no"+gtid).html(id); // to change license no  value
	G("#WCI_pno"+gtid).html(id); // to change expired date no  value
	G("#WCI_d"+gtid).html(id);
	G("#WCI_ag"+gtid).html(id);
	G("#WCI_ph"+gtid).html(id);
	G("#line_task_WCI"+gtid).attr("id","line_task_WCI"+id);
	G("#WCI_"+gtid).attr("id","WCI_"+id);  // to replace div id
	G("#WCI_dv"+gtid).attr("id","WCI_dv"+id);
	G("#WCI_no"+gtid).attr("id","WCI_no"+id); // to replace span liscense  id
	G("#WCI_pno"+gtid).attr("id","WCI_pno"+id); // to replace span expdate  id
	G("#WCI_d"+gtid).attr("id","WCI_d"+id); // to replace span expdate  id
	G("#WCI_ag"+gtid).attr("id","WCI_ag"+id);
	G("#WCI_ph"+gtid).attr("id","WCI_ph"+id); // to replace span expdate  id
	G("#WCI_delete_"+gtid).attr("id","WCI_delete_"+id);
	G("#current_line_task_WCI_ids"+gtid).val(id);
	G("#current_line_task_WCI_ids"+gtid).attr("id","current_line_task_WCI_ids"+id);
	var db_docid = G('#old_line_task_WCI_ids_'+gtid).val();
	G("#WCI_delete_"+id).html('<a href="javascript:del_callajaxcomp_WCI(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	}
	else
	{
	G("#WCI_"+id).html(id); //to change divid no
	G("#WCI_dv"+id).html(id);
	G("#WCI_no"+id).html(id);  // to change license no
	G("#WCI_pno"+id).html(id);
	G("#WCI_d"+id).html(id);
	G("#WCI_ag"+id).html(id);
	G("#WCI_ph"+id).html(id);
	G("#line_task_WCI"+id).attr("id","line_task_WCI"+id);
	G("#WCI_"+id).attr("id","WCI_"+id);
	G("#WCI_dv"+id).attr("id","WCI_dv"+id);
	G("#WCI_no"+id).attr("id","WCI_no"+id);
	G("#WCI_pno"+id).attr("id","WCI_pno"+id);
	G("#WCI_d"+id).attr("id","WCI_d"+id);
	G("#WCI_ag"+id).attr("id","WCI_ag"+id);
	G("#WCI_ph"+id).attr("id","WCI_ph"+id);
	G("#WCI_delete_"+id).attr("id","WCI_delete_"+id);
	G("#current_line_task_WCI_ids"+id).val(id);
	G("#current_line_task_WCI_ids"+id).attr("id","current_line_task_WCI_ids"+id);
	var db_docid = G('#old_line_task_WCI_ids_'+id).val();
	G("#WCI_delete_"+id).html('<a href="javascript:del_callajaxcomp_WCI(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>templates/camassistant_left/images/remove_file.gif" alt="Delete occupational License" width="66" height="22" /></a>');
	}
	}
       }
}
function del_callajaxcomp_WC(tbl,docid,divid)
{

editoption = G('#changes').val();
	if( editoption == 'no' ){
     if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dwc'+divid).value;
        }
	var r=confirm("Are you sure you want to delete this Workers Comp Exemption Form");
	}
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
	
if (r==true)
  {
        var frm = document.ComplianceFrm;
	del_from_db(tbl,docid);
	G("div").remove("#line_task_WC"+divid);
        document.getElementById('line_task_WC'+divid).style.display='none';
	WC_title = WC_title-1;
	var id;
	for(id=2; id<=WC_title; id++)
	{
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	 gtid = parseInt(id)+1;
	G("#WC_"+gtid).html(id); //to change divid value
	G("#WC_dv"+gtid).html(id);
	G("#WC_no"+gtid).html(id); // to change license no  value
	G("#WC_pno"+gtid).html(id); // to change expired date no  value
	G("#WC_d"+gtid).html(id);
	G("#WC_ag"+gtid).html(id);
	G("#WC_ph"+gtid).html(id);
	G("#line_task_WC"+gtid).attr("id","line_task_WC"+id);
	G("#WC_"+gtid).attr("id","WC_"+id);  // to replace div id
	G("#WC_dv"+gtid).attr("id","WC_dv"+id);
	G("#WC_no"+gtid).attr("id","WC_no"+id); // to replace span liscense  id
	G("#WC_pno"+gtid).attr("id","WC_pno"+id); // to replace span expdate  id
	G("#WC_d"+gtid).attr("id","WC_d"+id); // to replace span expdate  id
	G("#WC_ag"+gtid).attr("id","WC_ag"+id);
	G("#WC_ph"+gtid).attr("id","WC_ph"+id); // to replace span expdate  id
	G("#WC_delete_"+gtid).attr("id","WC_delete_"+id);
	G("#current_line_task_WC_ids"+gtid).val(id);
	G("#current_line_task_WC_ids"+gtid).attr("id","current_line_task_WC_ids"+id);
	var db_docid = G('#old_line_task_WCI_ids_'+gtid).val();
	G("#WC_delete_"+id).html('<a href="javascript:del_callajaxcomp_WC(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete occupational License" /></a>');
	}
	else
	{
	G("#WC_"+id).html(id); //to change divid no
	G("#WC_dv"+id).html(id);
	G("#WC_no"+id).html(id);  // to change license no
	G("#WC_pno"+id).html(id);
	G("#WC_d"+id).html(id);
	G("#WC_ag"+id).html(id);
	G("#WC_ph"+id).html(id);
	G("#line_task_WC"+id).attr("id","line_task_WC"+id);
	G("#WC_"+id).attr("id","WC_"+id);
	G("#WC_dv"+id).attr("id","WC_dv"+id);
	G("#WC_no"+id).attr("id","WC_no"+id);
	G("#WC_pno"+id).attr("id","WC_pno"+id);
	G("#WC_d"+id).attr("id","WC_d"+id);
	G("#WC_ag"+id).attr("id","WC_ag"+id);
	G("#WC_ph"+id).attr("id","WC_ph"+id);
	G("#WC_delete_"+id).attr("id","WC_delete_"+id);
	G("#current_line_task_WC_ids"+id).val(id);
	G("#current_line_task_WC_ids"+id).attr("id","current_line_task_WC_ids"+id);
	var db_docid = G('#old_line_task_WC_ids_'+id).val();
	G("#WC_delete_"+id).html('<a href="javascript:del_callajaxcomp_WC(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete occupational License" /></a>');
	}
	}
        }
}
function del_callajaxcomp_AIP(tbl,docid,divid)
{
   editoption = G('#changes').val();
	if( editoption == 'no' ){
     if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('daip'+divid).value;
        }
	var r=confirm("Are you sure you want to delete this Commercial Vehicle Policy Form ?");
	}
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
if (r==true)
  {
        var frm = document.ComplianceFrm;
	del_from_db(tbl,docid);
	G("div").remove("#line_task_AIP"+divid);
        document.getElementById('line_task_AIP'+divid).style.display='none';
	AIP_title = AIP_title-1;
	var id;
	for(id=2; id<=AIP_title; id++)
	{
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	 gtid = parseInt(id)+1;
	G("#AIP_"+gtid).html(id); //to change divid value
	G("#AIP_dv"+gtid).html(id);
	G("#AIP_no"+gtid).html(id); // to change license no  value
	G("#AIP_pno"+gtid).html(id); // to change expired date no  value
	G("#AIP_d"+gtid).html(id);
	G("#AIP_ag"+gtid).html(id);
	G("#AIP_ph"+gtid).html(id);
	G("#line_task_AIP"+gtid).attr("id","line_task_AIP"+id);
	G("#AIP_"+gtid).attr("id","AIP_"+id);  // to replace div id
	G("#AIP_dv"+gtid).attr("id","AIP_dv"+id);
	G("#AIP_no"+gtid).attr("id","AIP_no"+id); // to replace span liscense  id
	G("#AIP_pno"+gtid).attr("id","AIP_pno"+id); // to replace span expdate  id
	G("#AIP_d"+gtid).attr("id","AIP_d"+id); // to replace span expdate  id
	G("#AIP_ag"+gtid).attr("id","AIP_ag"+id);
	G("#AIP_ph"+gtid).attr("id","AIP_ph"+id); // to replace span expdate  id
	G("#AIP_delete_"+gtid).attr("id","AIP_delete_"+id);
	G("#current_line_task_AIP_ids"+gtid).val(id);
	G("#current_line_task_AIP_ids"+gtid).attr("id","current_line_task_AIP_ids"+id);
	var db_docid = G('#old_line_task_AIP_ids_'+gtid).val();
	G("#AIP_delete_"+id).html('<a href="javascript:del_callajaxcomp_AIP(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete occupational License" /></a>');
	}
	else
	{
	G("#AIP_"+id).html(id); //to change divid no
	G("#AIP_dv"+id).html(id);
	G("#AIP_no"+id).html(id);  // to change license no
	G("#AIP_pno"+id).html(id);
	G("#AIP_d"+id).html(id);
	G("#AIP_ag"+id).html(id);
	G("#AIP_ph"+id).html(id);
	G("#line_task_AIP"+id).attr("id","line_task_AIP"+id);
	G("#AIP_"+id).attr("id","AIP_"+id);
	G("#AIP_dv"+id).attr("id","AIP_dv"+id);
	G("#AIP_no"+id).attr("id","AIP_no"+id);
	G("#AIP_pno"+id).attr("id","AIP_pno"+id);
	G("#AIP_d"+id).attr("id","AIP_d"+id);
	G("#AIP_ag"+id).attr("id","AIP_ag"+id);
	G("#AIP_ph"+id).attr("id","AIP_ph"+id);
	G("#AIP_delete_"+id).attr("id","AIP_delete_"+id);
	G("#current_line_task_AIP_ids"+id).val(id);
	G("#current_line_task_AIP_ids"+id).attr("id","current_line_task_AIP_ids"+id);
	var db_docid = G('#old_line_task_AIP_ids_'+id).val();
	G("#AIP_delete_"+id).html('<a href="javascript:del_callajaxcomp_AIP(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete occupational License" /></a>');
	}
	}
        }
}

function del_callajaxcomp_UMB(tbl,docid,divid)
{
	editoption = G('#changes').val();
	if( editoption == 'no' ){
	if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dUMB'+divid).value;
        }
		var r=confirm("Are you sure you want to delete this Umbrella liability policy");
		}
		else{
			alert("You must SAVE the document you're currently editing before editing/adding another document");
		}
if (r==true)
  {
        var frm = document.ComplianceFrm;
	del_from_db(tbl,docid);
	G("div").remove("#line_task_UMB"+divid);
         document.getElementById('line_task_UMB'+divid).style.display='none';
	UMB_title = UMB_title-1;
	var id;
	for(id=2; id<=UMB_title; id++)
	{
	//alert('hello');
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	gtid = parseInt(id)+1;
	G("#UMB_"+gtid).html(id); //to change divid value
	G("#UMB_dv"+gtid).html(id);
	G("#UMB_no"+gtid).html(id); // to change license no  value
	G("#UMB_exp"+gtid).html(id); // to change expired date no  value
	G("#UMB_cc"+gtid).html(id);
	G("#UMB_st"+gtid).html(id);
	G("#line_task_UMB"+gtid).attr("id","line_task_UMB"+id);
	G("#UMB_"+gtid).attr("id","UMB_"+id);  // to replace div id
	G("#UMB_dv"+gtid).attr("id","UMB_dv"+id);
	G("#UMB_no"+gtid).attr("id","UMB_no"+id); // to replace span liscense  id
	G("#UMB_exp"+gtid).attr("id","UMB_exp"+id); // to replace span expdate  id
	G("#UMB_cc"+gtid).attr("id","UMB_cc"+id); // to replace span expdate  id
	G("#UMB_st"+gtid).attr("id","UMB_st"+id); // to replace span expdate  id
	G("#UMB_delete_"+gtid).attr("id","UMB_delete_"+id);
	G("#current_line_task_UMB_ids"+gtid).val(id);
	G("#current_line_task_UMB_ids"+gtid).attr("id","current_line_task_UMB_ids"+id);
	var db_docid = G('#old_line_task_UMB_ids_'+gtid).val();
	G("#UMB_delete_"+id).html('<a href="javascript:del_callajaxcomp_UMB(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete occupational License"  /></a>');
	}
	else
	{
	G("#UMB_"+id).html(id); //to change divid no
	G("#UMB_dv"+id).html(id);
	G("#UMB_no"+id).html(id);  // to change license no
	G("#UMB_exp"+id).html(id);
	G("#UMB_cc"+id).html(id);
	G("#UMB_st"+id).html(id);
	G("#line_task_UMB"+id).attr("id","line_task_UMB"+id);
	G("#UMB_"+id).attr("id","UMB_"+id);
	G("#UMB_dv"+id).attr("id","UMB_dv"+id);
	G("#UMB_no"+id).attr("id","UMB_no"+id);
	G("#UMB_exp"+id).attr("id","UMB_exp"+id);
	G("#UMB_cc"+id).attr("id","UMB_cc"+id);
	G("#UMB_st"+id).attr("id","UMB_st"+id);
	G("#UMB_delete_"+id).attr("id","UMB_delete_"+id);
	G("#current_line_task_UMB_ids"+gtid).val(id);
	G("#current_line_task_UMB_ids"+gtid).attr("id","current_line_task_UMB_ids"+id);
	var db_docid = G('#old_line_task_UMB_ids_'+id).val();
	G("#UMB_delete_"+id).html('<a href="javascript:del_callajaxcomp_UMB(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete Umbrella License" /></a>');
	}
	}
    }
}
function del_callajaxcomp_OMI(tbl,docid,divid)
{
	editoption = G('#changes').val();
	if( editoption == 'no' ){
	if(docid){
            var docid= docid;
        } else {
        var docid= document.getElementById('dOMI'+divid).value;
        }
        var r=confirm("Are you sure you want to delete this Errors Omissions Insurance policy");
		}
	else{
		alert("You must SAVE the document you're currently editing before editing/adding another document");
	}
if (r==true)
  {
        var frm = document.ComplianceFrm;
	del_from_db(tbl,docid);
	G("div").remove("#line_task_OMI"+divid);
         document.getElementById('line_task_OMI'+divid).style.display='none';
	OMI_title = OMI_title-1;
	var id;
	for(id=2; id<=OMI_title; id++)
	{
	//alert('hello');
	newid = parseInt(id)+1;
	if(id>=divid)
	{
	gtid = parseInt(id)+1;
	G("#OMI_"+gtid).html(id); //to change divid value
	G("#OMI_dv"+gtid).html(id);
	G("#OMI_no"+gtid).html(id); // to change license no  value
	G("#OMI_exp"+gtid).html(id); // to change expired date no  value
	G("#OMI_cc"+gtid).html(id);
	G("#OMI_st"+gtid).html(id);
	G("#line_task_OMI"+gtid).attr("id","line_task_OMI"+id);
	G("#OMI_"+gtid).attr("id","OMI_"+id);  // to replace div id
	G("#OMI_dv"+gtid).attr("id","OMI_dv"+id);
	G("#OMI_no"+gtid).attr("id","OMI_no"+id); // to replace span liscense  id
	G("#OMI_exp"+gtid).attr("id","OMI_exp"+id); // to replace span expdate  id
	G("#OMI_cc"+gtid).attr("id","OMI_cc"+id); // to replace span expdate  id
	G("#OMI_st"+gtid).attr("id","OMI_st"+id); // to replace span expdate  id
	G("#OMI_delete_"+gtid).attr("id","OMI_delete_"+id);
	G("#current_line_task_OMI_ids"+gtid).val(id);
	G("#current_line_task_OMI_ids"+gtid).attr("id","current_line_task_OMI_ids"+id);
	var db_docid = G('#old_line_task_OMI_ids_'+gtid).val();
	G("#OMI_delete_"+id).html('<a href="javascript:del_callajaxcomp_OMI(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete occupational License"  /></a>');
	}
	else
	{
	G("#OMI_"+id).html(id); //to change divid no
	G("#OMI_dv"+id).html(id);
	G("#OMI_no"+id).html(id);  // to change license no
	G("#OMI_exp"+id).html(id);
	G("#OMI_cc"+id).html(id);
	G("#OMI_st"+id).html(id);
	G("#line_task_OMI"+id).attr("id","line_task_OMI"+id);
	G("#OMI_"+id).attr("id","OMI_"+id);
	G("#OMI_dv"+id).attr("id","OMI_dv"+id);
	G("#OMI_no"+id).attr("id","OMI_no"+id);
	G("#OMI_exp"+id).attr("id","OMI_exp"+id);
	G("#OMI_cc"+id).attr("id","OMI_cc"+id);
	G("#OMI_st"+id).attr("id","OMI_st"+id);
	G("#OMI_delete_"+id).attr("id","OMI_delete_"+id);
	G("#current_line_task_OMI_ids"+gtid).val(id);
	G("#current_line_task_OMI_ids"+gtid).attr("id","current_line_task_OMI_ids"+id);
	var db_docid = G('#old_line_task_OMI_ids_'+id).val();
	G("#OMI_delete_"+id).html('<a href="javascript:del_callajaxcomp_OMI(\''+tbl+'\',\''+db_docid+'\',\''+id+'\');"><img src="<img src="<?php echo Juri::root(); ?>components/com_camassistant/assets/images/delete.jpg" alt="Delete Umbrella License" /></a>');
	}
	}
    }
}

 //function to get date diff
 function get_datediff(date1,date2)
 {
	var mystring = date1;
	var myarray = mystring.split("-");
	var date1 = myarray[2]+'-'+myarray[0]+'-'+myarray[1];
	var mystring2 = date2;
	var myarray2 = mystring2.split("-");
	var date2 = myarray2[2]+'-'+myarray2[0]+'-'+myarray2[1];
	var parts = date1.match(/(\d+)/g);
	var valide_date1 = new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
	var parts2 = date2.match(/(\d+)/g);
	var valide_date2 = new Date(parts2[0], parts2[1]-1, parts2[2]); // months are 0-based
	var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
	var diffDays = Math.abs((valide_date2.getTime() - valide_date1.getTime())/(oneDay));
	return diffDays;
 }
//function to save Alt form as Draft
function Alt_saveassubmit(doctype)
{

var frm = document.adminForm;
frm.submit_type.value = 'Submit';
frm.document_type.value = doctype;
frm.task.value = 'save_compliance';

 if(doctype == 'W9'){
	
 for(var w9=1; w9<=W9_title; w9++)
 {
  if(document.getElementById('W9_upld_cert'+w9).value == '')
		{
		  alert('Please Upload W9 Policy Document');
		 document.getElementById('W9_upld_cert'+w9).focus();
		 return ;
		}
	else{
	G(document).ready(function (){
	G("#loading-div-background").show();
	});
	frm.submit();
	}
 }
}
  for(var gli=1; gli<=GLI_title; gli++)
 {

 	var inputdate = document.getElementById('GLI_end_date'+gli).value ;
	glis = inputdate.split("-"); 
	glidate = glis[2] + "-" + glis[0] + "-" + glis[1] ;
	var glidate = new Date(glidate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);

    if(G('#GLI_idedit'+gli).val() == 'yes')
   {
	     if(document.getElementById('GLI_upld_cert'+gli).value == '')
		{
			
		  alert('Please Upload General Liability Policy Document');
		 document.getElementById('GLI_upld_cert'+gli).focus();
		 return ;
		}
	 else if(document.getElementById('GLI_end_date'+gli).value == '' || document.getElementById('GLI_end_date'+gli).value == '00-00-0000' || document.getElementById('GLI_end_date'+gli).value == '--')
	 {
	 alert('Please Enter General Liability Insurance Coverage End Date');
	 document.getElementById('GLI_end_date'+gli).focus();
	 return ;
	 }
	 else if( ( glis[2].length !=4 || glis[0] > 12 ))
	{
	 alert('Please enter the date inthe format of mm-dd-yyyy');
	 return ;
	}
 	 else if(document.getElementById('GLI_policy_occurence'+gli).value == '' || document.getElementById('GLI_policy_occurence'+gli).value == '0.00')
	 {
	 alert('Please Enter General Liability Each Occurrence');
	 document.getElementById('GLI_policy_occurence'+gli).focus();
	 return ;
	 }
	 else if(document.getElementById('GLI_policy_aggregate'+gli).value == '' || document.getElementById('GLI_policy_aggregate'+gli).value == '0.00')
	 {
	 alert('Please Enter General Liability General Aggregate');
	 document.getElementById('GLI_policy_aggregate'+gli).focus();
	 return ;
	 }
	 else if(G('#attrInputs'+gli+':checked').val() == '')
	 {
     alert('Select at least one option for General Aggregate Applies To.');
	 return ;
	 }
 	 else if(G("input[type=radio][name=GLI_applies"+(gli-1)+"]:checked").length == 0 ) 
		{  
		alert("Please check atleast one option to General Aggregate Applies To.");
		return ;
		}
		
		
	else if(glidate < currentDate){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
	G("#loading-div-background").show();
	});
	frm.submit();
	}
	
	 	
	 }
}

//General commercial vehicle policyInfo validations

 for(var aip=1; aip<=AIP_title; aip++)
 {
	
	var inputdate = document.getElementById('aip_end_date'+aip).value ;
	aips = inputdate.split("-"); 
	aipdate = aips[2] + "-" + aips[0] + "-" + aips[1] ;
	var aipdate = new Date(aipdate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);
	
 	//alert(G('#aip_idedit'+aip).val());
    if(G('#aip_idedit'+aip).val() == 'yes')
   {
    // if(document.getElementById('GLI_start_date'+gli).value != '' && document.getElementById('GLI_end_date'+gli).value != '')
	  if(document.getElementById('aip_upld_cert'+aip).value == '')
		{
		  alert('Please Upload Auto Insurance Policy Document');
		 document.getElementById('aip_upld_cert'+aip).focus();
		 return ;
		}
	 else if(document.getElementById('aip_end_date'+aip).value == '' || document.getElementById('aip_end_date'+aip).value == '00-00-0000' || document.getElementById('aip_end_date'+aip).value == '--')
	 {
	 alert('Please Enter Commercial Vehicle Policy expired date');
	 document.getElementById('aip_end_date'+aip).focus();
	 return ;
	 }
	 else if( ( aips[2].length !=4 || aips[0] > 12 ))
	{
	 alert('Please enter the date inthe format of mm-dd-yyyy');
	 return ;
	}
	 /*else if(document.getElementById('aip_combined'+aip).value == '' || document.getElementById('aip_combined'+aip).value == '0.00')
	 {
	 alert('Please Enter Commercial Vehicle Policy Combined Single Limit');
	 document.getElementById('aip_combined'+aip).focus();
	 return ;
	 }*/
	  
	 else if(aipdate < currentDate){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
		G("#loading-div-background").show();
		});
	frm.submit();
	}
	 
 }
}

//General WORKERS COMPENSATION / EMPLOYER`S LIABILITY POLICY Info validations
 for(var wci=1; wci<=WCI_title; wci++)
 {
 	
	var inputdate = document.getElementById('WCI_end_date'+wci).value ;
	wcis = inputdate.split("-"); 
	wcidate = wcis[2] + "-" + wcis[0] + "-" + wcis[1] ;
	var wcidate = new Date(wcidate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);


    if(G('#WCI_idedit'+wci).val() == 'yes')
   {
    // if(document.getElementById('GLI_start_date'+gli).value != '' && document.getElementById('GLI_end_date'+gli).value != '')
	 if(document.getElementById('WCI_upld_cert'+wci).value == '')
		{
		  alert('Please Upload Workers Liability Policy Document');
		 document.getElementById('WCI_upld_cert'+wci).focus();
		 return ;
		}
	 else if(document.getElementById('WCI_end_date'+wci).value == '' || document.getElementById('WCI_end_date'+wci).value == '00-00-0000' || document.getElementById('WCI_end_date'+wci).value == '--')
	 {
	 alert("Please click on the Date and select an Expiration Date or the 'Does Not Expire' option");
	 return ;
	 }
		
	 else if(wcidate < currentDate && inputdate != 'Does Not Expire' ){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
		G("#loading-div-background").show();
		});
	frm.submit();
	}
	
 }
}

//UMBRELLA LIABILITY POLICY Info validations
 for(var umb=1; umb<=UMB_title; umb++)
 {
 
	var inputdate = document.getElementById('UMB_expdate'+umb).value ;
	umbs = inputdate.split("-"); 
	umbdate = umbs[2] + "-" + umbs[0] + "-" + umbs[1] ;
	var umbdate = new Date(umbdate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);

 
   if(G('#UMB_idedit'+umb).val() == 'yes')
   {
	   if(document.getElementById('UMB_upld_cert'+umb).value == '')
		{
		  alert('Please Upload Umbrella Liability Policy Document');
		 document.getElementById('UMB_upld_cert'+umb).focus();
		 return ;
		} 
    // if(document.getElementById('GLI_start_date'+gli).value != '' && document.getElementById('GLI_end_date'+gli).value != '')
	else if(document.getElementById('UMB_expdate'+umb).value == '' || document.getElementById('UMB_expdate'+umb).value == '00-00-0000' || document.getElementById('UMB_expdate'+umb).value == '--')
	 {
	 alert('Please Enter UMBRELLA LIABILITY POLICY expired date.');
	 document.getElementById('UMB_expdate'+umb).focus();
	 return ;
	 }
	else if( ( umbs[2].length !=4 || umbs[0] > 12 ))
	{
	 alert('Please enter the date int he format of mm-dd-yyyy');
	 return ;
	}
 	 else if(document.getElementById('UMB_aggregate'+umb).value == '' || document.getElementById('UMB_aggregate'+umb).value == '0.00')
	 {
	 alert('Please Enter UMBRELLA LIABILITY POLICY Aggregate.');
	 document.getElementById('UMB_aggregate'+umb).focus();
	 return ;
	 }
	 else if(document.getElementById('UMB_occur'+umb).value == '' || document.getElementById('UMB_occur'+umb).value == '0.00')
	 {
	 alert('Please Enter UMBRELLA LIABILITY POLICY Each Occurrence.');
	 document.getElementById('UMB_occur'+umb).focus();
	 return ;
	 }
	    
	 else if(umbdate < currentDate){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
	G("#loading-div-background").show();
	});
	frm.submit();
	}
	
 }
}

 for(var omi=1; omi<=OMI_title; omi++)
 {
 
	var inputdate = document.getElementById('OMI_end_date'+omi).value ;
	
	omis = inputdate.split("-"); 
	omidate = omis[2] + "-" + omis[0] + "-" + omis[1] ;
	var omidate = new Date(omidate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);
   if(G('#OMI_idedit'+omi).val() == 'yes')
   {
	     if(document.getElementById('OMI_upld_cert'+omi).value == '')
		{
		  alert('Please Upload ERRORS OMISSIONS INSURANCE Policy Document');
		 document.getElementById('OMI_upld_cert'+omi).focus();
		 return ;
		}
    // if(document.getElementById('GLI_start_date'+gli).value != '' && document.getElementById('GLI_end_date'+gli).value != '')
	 else if(document.getElementById('OMI_end_date'+omi).value == '' || document.getElementById('OMI_end_date'+omi).value == '00-00-0000' || document.getElementById('OMI_end_date'+omi).value == '--')
	 {
	 alert('Please Enter ERRORS OMISSIONS INSURANCE expired date.');
	 document.getElementById('OMI_end_date'+omi).focus();
	 return ;
	 }
 	 else if(document.getElementById('OMI_aggregate'+omi).value == '' || document.getElementById('OMI_aggregate'+omi).value == '0.00')
	 {
	 alert('Please Enter ERRORS OMISSIONS INSURANCE Aggregate.');
	 document.getElementById('OMI_aggregate'+omi).focus();
	 return ;
	 }
	 else if(document.getElementById('OMI_each_claim'+omi).value == '' || document.getElementById('OMI_each_claim'+omi).value == '0.00')
	 {
	 alert('Please Enter ERRORS OMISSIONS INSURANCE Each Occurrence.');
	 document.getElementById('OMI_each_claim'+omi).focus();
	 return ;
	 }
	
	 else if(omidate < currentDate){
	
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{

	G(document).ready(function (){
		G("#loading-div-background").show();
		});
	frm.submit();
	}
	
 }
}

//PROFESSIONAL LICENSE Info validations
 for(var oln=1; oln<=OLN_title; oln++)
 {
 
	var inputdate = document.getElementById('OLN_expdate'+oln).value ;
	olns = inputdate.split("-"); 
	olndate = olns[2] + "-" + olns[0] + "-" + olns[1] ;
	var olndate = new Date(olndate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);
 
     if(G('#OLN_idedit'+oln).val() == 'yes')
   {
	    if(document.getElementById('OLN_upld_cert'+oln).value == '')
		{
		  alert('Please Upload Occupational License Document');
		 document.getElementById('OLN_upld_cert'+oln).focus();
		 return ;
		}
		else if(document.getElementById('OLN_expdate'+oln).value == '' || document.getElementById('OLN_expdate'+oln).value == '00-00-0000'  || document.getElementById('OLN_expdate'+oln).value == '--')
	 {
	 alert("Please click on the Date and select an Expiration Date or the 'Does Not Expire' option");
	 return ;
	 }
	
	else if(olndate < currentDate && inputdate != 'Does Not Expire' ){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
	G("#loading-div-background").show();
		});
	frm.submit();
	}
	
 }
}

//Bus. Tax Receipt / Occupational License Info validations
 for(var pln=1; pln<=PLN_title; pln++)
 {
 
	var inputdate = document.getElementById('PLN_expdate'+pln).value ;
	plns = inputdate.split("-"); 
	plndate = plns[2] + "-" + plns[0] + "-" + plns[1] ;
	var plndate = new Date(plndate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);

 
     if(G('#PLN_idedit'+pln).val() == 'yes')
   {
    // if(document.getElementById('GLI_start_date'+gli).value != '' && document.getElementById('GLI_end_date'+gli).value != '')
	if(document.getElementById('PLN_upld_cert'+pln).value == '')
		{
		  alert('Please Upload Professional License Document');
		 document.getElementById('PLN_upld_cert'+pln).focus();
		 return ;
		}
	 else if(document.getElementById('PLN_expdate'+pln).value == '' || document.getElementById('PLN_expdate'+pln).value == '00-00-0000' || document.getElementById('PLN_expdate'+pln).value == '--')
	 {
	 alert('Please Enter PROFESSIONAL LICENSE expired date.');
	 document.getElementById('PLN_expdate'+pln).focus();
	 return ;
	 }
	 else if( ( plns[2].length !=4 || plns[0] > 12 ))
	{
	 alert('Please enter the date in the format of mm-dd-yyyy');
	 return ;
	}
	 
	 else if(plndate < currentDate){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});

		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
	G("#loading-div-background").show();
		});
	frm.submit();
	}
	
 }
}

//WORKERS COMP EXEMPTION Info validations
 for(var wc=1; wc<=WC_title; wc++)
 {
 
	var inputdate = document.getElementById('wc_end_date'+wc).value ;
	wcs = inputdate.split("-"); 
	wcdate = wcs[2] + "-" + wcs[0] + "-" + wcs[1] ;
	var wcdate = new Date(wcdate);
	
	var currentDate = new Date()
	var day = currentDate.getDate()
	var month = currentDate.getMonth() + 1
	var year = currentDate.getFullYear()
	var endDate = year + "-" + month + "-" + day ;
	var today_date = new Date(endDate);

 
     if(G('#wc_idedit'+wc).val() == 'yes')
   {
    // if(document.getElementById('GLI_start_date'+gli).value != '' && document.getElementById('GLI_end_date'+gli).value != '')
	  if(document.getElementById('wc_upld_cert'+wc).value == '')
		{
		  alert('Please Upload Workers Comp Excemption Document');
		 document.getElementById('wc_upld_cert'+wc).focus();
		 return ;
		}
	 else if(document.getElementById('wc_end_date'+wc).value == '' || document.getElementById('wc_end_date'+wc).value == '00-00-0000' || document.getElementById('wc_end_date'+wc).value == '--')
	 {
	 alert('Please Enter WORKERS COMP EXEMPTION expired date.');
	 document.getElementById('wc_end_date'+wc).focus();
	 return ;
	 }
	 else if( ( wcs[2].length !=4 || wcs[0] > 12 ))
	{
	 alert('Please enter the date in the format of mm-dd-yyyy');
	 return ;
	}
	  else if(wcdate < currentDate){
		G = jQuery.noConflict();
		G('body,html').animate({
		scrollTop: 250
		},800);
		var maskHeight = G(document).height();
		var maskWidth = G(window).width();
		G('#maskcd').css({'width':maskWidth,'height':maskHeight});
		G('#maskcd').fadeIn(100);
		G('#maskcd').fadeTo("slow",0.8);
		var winH = G(window).height();
		var winW = G(window).width();
		G("#submitcd").css('top',  winH/2-G("#submitcd").height()/2);
		G("#submitcd").css('left', winW/2-G("#submitcd").width()/2);
		G("#submitcd").fadeIn(2000);
		
		G('.windowcd #donecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		G(document).ready(function (){
		G("#loading-div-background").show();
		});
		frm.submit();
		});
		
	 	G('.windowcd #closecd').click(function (e) {
		e.preventDefault();
		G('#maskcd').hide();
		G('.windowcd').hide();
		
		});
		
	}
	else{
	G(document).ready(function (){
		G("#loading-div-background").show();
		});
	frm.submit();
	}
	
 }
}
//w9 Info validations
 /* if(frm.W9_upld_cert1.value == '')
	 {
	 alert('Please Upload W9 Document');
	 frm.W9_upld_cert1.focus();
	 return ;
	 } */
/*if(frm.i_agree.checked == false)
	{
		alert('Please accept terms and conditions.');
		frm.i_agree.focus();
		return;
	}*/
frm.submit_type.value = 'Submit';
frm.document_type.value = doctype;
frm.task.value = 'save_compliance';
}



</script>

<style>
#maskexc { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesexc .windowexc {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesexc #submitexc {  width:510px;  height:215px;  padding:10px;  background-color:#ffffff;}
#boxesexc #submitexc a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#donetexc {border: 0 none; cursor: pointer; height: 30px; padding: 0; color: #000000; font-weight: bold; font-size: 20px; float: right;}
#cancelexc {border: 0 none; cursor: pointer; height: 30px; padding: 3px 0 0; float: left;}
</style>
<style>
 #mask1 .Centered
{
  width:100%;
  position:fixed;
  top:50%;
  left:45%;
}
#mask1 {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}

#boxes1 .window1 {
  position:absolute;
  left:0;
  top:0;
  width:350px;
  height:150px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxes1 #submit1 {
  width:326px;
  height:209px;
  padding:10px;
  background-color:#ffffff;
}
#boxes1 #submit1 a{
 text-decoration:none;
 color:#000000;
 font-weight:bold;
 font-size:20px;
}
#done1 {
border:0 none;
float:left;
height:30px;
margin:0;
padding-left:64px;
}
/*background:url(<?php echo Juri::root(); ?>templates/camassistant/images/yes.gif) no-repeat;
*/

#close1 {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
 color:#000000;
 font-weight:bold;
 font-size:20px;
}

</style>
