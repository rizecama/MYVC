<?php
//restricted access
defined('_JEXEC') or die('Restricted access');
// import html tooltips
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
$statelist = $this->statelist; 
$businesslist = $this->businesslist; 
$awardrfps = $this->awardrfps;
$v_rating = $this->v_rating;
$usr = JFactory::getUser();
$countylist = $this->county; 
//echo "<pre>"; print_r($this->detail);
$db = JFactory::getDBO();
$sql = "SELECT C.camfirm_license_no, C.comp_name FROM #__vendor_inviteinfo as V LEFT JOIN #__cam_customer_companyinfo as C ON V.userid = C.cust_id WHERE V.vendortype = 'preferred' AND V.v_id=".$this->detail->user_id;
$db->Setquery($sql);
$res = $db->loadObjectList();
//code to get inhouse vendors list
$sql = "SELECT C.camfirm_license_no, C.comp_name FROM #__vendor_inviteinfo as V LEFT JOIN #__cam_customer_companyinfo as C ON V.userid = C.cust_id WHERE V.vendortype = 'inhouse' AND V.v_id=".$this->detail->user_id;
$db->Setquery($sql);
$inHouse_res = $db->loadObjectList();

//echo "<pre>"; print_r($inHouse_res);
for($i=0;$i<count($countylist);$i++)
{
	$countylistarr[$i]['id'] = $countylist[$i]->id;
	$countylistarr[$i]['county_name'] = $countylist[$i]->county_name;
}
?>
<script type="text/javascript">
    window.addEvent('domready', function(){ 
       var JTooltips = new Tips($$('.hasTip'), 
       { maxTitleChars: 50, fixed: false}); 
    });
</script>


	<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			var ccemail = (form.ccemail.value).split('.com');	
			
			var fileName = form.image.value; 
			var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
			var parts = fileName.split('.');
			//var length= parts.length;
			var len = parts.length;
			var t_phone = form.company_phone.value;
   			var count_phone = t_phone.replace(/\D/g, '').length;
			
			if(pressbutton!="cancel")
			{
			 if(form.name.value == '')
			 {
			 //alert('Please enter your name');
			 form.name.focus();
			 return false;
			 }
			 else if(form.lastname.value == '')
			 {
			 alert('Please enter lastname');
			 form.lastname.focus();
			 return false;
			 }
			/* else if(form.phone.value == '')
			 {
			 alert('Please enter you phone number');
			 form.phone.focus();
			 return false;
			 }*/
			  else if(form.email.value == '')
			 {
			 alert('Please enter your email ID');
			 form.email.focus();
			 return false;
			 }
			 var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
			 if(mail.test(form.email.value)==false)
			 {
			 alert("Please enter the valid email");
			 form.email.focus();
			 return false;
			 } 
			 
			 if(form.ccemail.value != ''){
			for (var i =1; i < ccemail.length-1; i++)
			 {			
			   if(ccemail[i].charAt(0) != ";"){
				 alert('Please separate the CC Emails with Semi colon(;)');
				 form.ccemail.focus();
				 return false;	   
				}
			 }	
			}
			
			 /* else if(form.email.value != '<?php //echo $this->detail->email; ?>'){
			  alert("This Email ID already exists. Please change the Email ID.");
			  form.email.focus();
			  return flase;
			    }*/
			 else if(form.company_name.value == '')
			 {
			 alert('Please enter your company name');
			 form.company_name.focus();
			 return false;
			 }
			 
			 /*else if(form.miles.value == '')
			 {
			 alert('Please enter service area');
			 form.miles.focus();
			 return false;
			 }*/
			 else if(form.tax_id.value == '')
			 {
			 alert('Please enter Federal Tax ID');
			 form.tax_id.focus();
			 return false;
			 }
			
			 else if(form.company_address.value == '')
			 {
			 alert('Please enter your mailing address');
			 form.company_address.focus();
			 return false;
			 }
			 else if(form.city.value == '')
			 {
			 alert('Please enter city');
			 form.city.focus();
			 return false;
			 }
			 else if(form.states.value == '0')
			 {
			 alert('Please select state');
			 form.states.focus();
			 return false;
			 }
			 
			 else if(form.zipcode.value == '')
			 {
			 alert('Please enter zipcode');
			 form.zipcode.focus();
			 return false;
			 }
			 else if(form.established_year.value == '')
			 {
			 alert('Please enter established year');
			 form.established_year.focus();
			 return false;
			 }
			 else if(form.company_phone.value == '' || count_phone != '10')
			 {
			 alert('Please enter correct(10 digits) company phone number');
			 form.company_phone.focus();
			 return false;
			 }
			 
		if(fileName != '')
			 {
				if((ext != 'jpg' && ext != 'gif' && ext != 'jpeg' && ext != 'png' && ext != 'JPG' && ext != 'JPEG' && ext != 'GIF' && ext != 'PNG')||(len>2))
				  { 
				  alert("Image file must be a .gif, .jpg, or .png.");
				  return false;
				  }
			  }
	  			 
			 /*else if(document.getElementById('in_house_vendor').checked == true)
			 {
				 if(form.in_house_parent_company.value == '')
				 {
				 alert('Please enter parent company name');
				 form.in_house_parent_company.focus();
				 return false;
				 }
				 else if(form.in_house_parent_company_FEIN.value == '')
				 {
					 alert('Please enter parent company Federal Tax ID number');
					 form.in_house_parent_company_FEIN.focus();
					 return false;
				 }
			 }*/
			 
			 if(form.password.value){
					re = /[0-9]/;
					if(form.password.value != form.password2.value){
						alert("Passwords do not match");
						return false;
				  	}
					if(form.password.value.length < 7){
						alert("Please enter password with atleast 7 characters");
						return false;
				  	}
				  	else if(!re.test(form.password.value)) { 
						alert("password must contain at least one number (0-9)");
						return false;
					 }
			}
			
			}
			
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			//var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			// do field validation
			else if(pressbutton == 'apply' || pressbutton == 'save')
			{
			
			tax_two=document.adminForm.elements['tax_id'].value;
			user=document.adminForm.elements['user_id'].value;
			email=document.adminForm.elements['email'].value;
			phone=document.adminForm.elements['company_phone'].value;
			taxid = tax_two;
			G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=verfirytaxid", {queryString: ""+taxid+"",userid: ""+user+""}, function(data){
			if(data != 'valid'){
			alert("Federal TAX ID already exists. Please enter another Federal TAX ID.");
			form.tax_id.focus();
			return false;
			}
			else if(data == 'valid'){
			G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=verfiryemailid", {queryString: ""+email+"",userid: ""+user+""}, function(data1){
		if(data1 == 'invalid'){
		alert("This Email ID already exists. Please enter another Email ID.");
		document.adminForm.elements['email'].value = '<?php echo $this->detail->email; ?>';
		return false;
		}
		else{
		//alert(phone);
				G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=verfiryphonenumber", {queryString: ""+phone+"",userid: ""+user+""}, function(pdata){
			//	alert(pdata);
				if(pdata == 'invalid' ){
				alert("This Phone Number is already being used by another member. Please use a different number or contact MyVendorCenter regarding this issue.");
				return false ;
				}
				else{
				form.task.value = 'save';
				setTimeout ( submitform( pressbutton ) , 5000 );
				}
				});
				
				
			}
		});
			}
			
			});
				    
					//submitform( pressbutton );
		     }
	 return;
		}
		
	</script>
    
<link rel="stylesheet" media="all" type="text/css" href="components/com_camassistant/skin/css/jquery1.css" />		
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
//Function to check the email id in the existing list by sateesh
 G = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var xhReq = createXMLHttpRequest();

function createXMLHttpRequest() 
{
	try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {}
	try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
	try { return new XMLHttpRequest(); } catch(e) {}
	alert("XMLHttpRequest not supported");
	return null;
}
var xhReq = createXMLHttpRequest();


function onSumResult() 
{
	if (xhReq.readyState != 0 && xhReq.readyState != 4)  { return; }
	var serverResponse = xhReq.responseText;
	//alert(serverResponse)
	document.getElementById(globvariable).innerHTML = serverResponse;
	//alert('dfg')
}
  //Functio to verify taxid
function verifyemail(email,userid1){
		if(email != '<?php echo $this->detail->email; ?>'){ 
		G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=verfiryemailid", {queryString: ""+email+"",userid: ""+userid1+""}, function(data){
		if(data == 'invalid'){
		alert("This Email ID already exists. Please enter another Email ID.");
		document.adminForm.elements['email'].value = '<?php echo $this->detail->email; ?>';
		return false;
		}
		});
	}
	}
	
//Function to verify taxid	
function verifytaxid(){
		tax_two=document.adminForm.elements['tax_id'].value;
		user=document.adminForm.elements['user_id'].value;
		taxid = tax_two;
		G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=verfirytaxid", {queryString: ""+taxid+"",userid: ""+user+""}, function(data){
		if(data == 'invalid'){
		alert("Federal TAX ID already exists. Please enter another Federal TAX ID.");
		//document.adminForm.elements['tax_id'].value = '';
		return false;
		}
		if(data == 'excluded'){
		alert("Federal TAX ID already excluded by some camfirms.");
		}
		});
	}	
	</script>
<!--Script by sateesh on 21-07-11-->
<script type="text/javascript">
 
		var divid = "countyId";
		var countyLen = 0;
		var sid;
		G(document).ready(function(){
		G("#addCounty").click(function(){
		var countyCnt=document.getElementsByName('county[]').length;
		//alert(countyLen);
		G("#divStates").append("<div id='"+divid+countyLen+"'> </div>");
		G("#"+divid+countyLen).css("padding-top","10px");
		id = G("#stateid").val();
		//countyLen++;
		G("#"+divid+countyLen).load('components/com_camassistant/helpers/common.php?id='+id+'&type=states&flag=1&path='+path+'&Fid='+divid+'&Len='+countyLen);
		countyLen++;
		});
		
		G(".statefield").change(function(){
		
		var countyCnt=document.getElementsByName('county[]').length;
		if(G("#county_ID"))
		{
		G("#county_ID").remove();
		}
		if(countyLen>0)
		{
		for(i=0;i<countyLen;i++)
		{
		G("#"+divid+i).remove();
		}
		countyLen=0;
		}
		G("#divStates").append("<div id='"+divid+countyLen+"'> </div>");
		G("#"+divid+countyLen).css("padding-top","10px");
		id = G("#stateid").val();
		G("#"+divid+countyLen).load('components/com_camassistant/helpers/common.php?id='+id+'&type=states&flag=0&path='+path+'&Fid='+divid+'&Len='+countyLen);
		countyLen++;
		});
		
		});
		
		function closecounty(county){
		countyLen = countyLen-1;
		G('#'+county).remove();
		countyLen++;
		}
		
		function deletecounty(countyid,userid,countyname){
		var result = confirm('Are you sure you want to delete '+countyname+' county?');	
		if(result == true){	
		G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=deletecounties&user="+userid+"&county="+countyid+"", function(data){
		alert(data);
		
		G("span#vendorcounties"+countyid).css("display","none");
		})}
		if(result == false) 
		{
		window.location.href;
		}
		 }
		function deletestate(stateid,userid,statename){
		var result = confirm('Are you sure you want to delete '+statename+' state and related counties?');	
		if(result == true){	
		G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=deletestates&user="+userid+"&state="+stateid+"", function(data){
		alert(data);
		
		G("span#vendorstates"+stateid).css("display","none");
		})}
		if(result == false) 
		{
		window.location.href;
		}
		 }
		function deleterating(id){
	G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=deleterating&rfpid="+id+"", function(data){
	if(data == 'success') {
	location.reload();
	}
		})
	}	 
	function undeleterating(id){
	G.post("index2.php?option=com_camassistant&controller=vendors_detail&task=undeleterating&rfpid="+id+"", function(data){
	if(data == 'success') {
	location.reload();
	}
		})
	} 
  </script>
<?php   if(!$idcnt)
$idcnt=0; ?>
<script language="javascript" type="text/javascript">
var id1 = <?php echo $idcnt;?>;
var id3;
var endid3;
var endid1;
function addEvent1()
{
	if(id1<7)
	{ 
		id1++;
		var ni = document.getElementById('myDiv');
		var numi = document.getElementById('thesValue');
		var num = (document.getElementById("thesValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "newSelect"+num;
		newitem="";
		newitem="<div class='row'> <span class='formLabel'>";
		newitem+="<label for='iddetails'><\/label>";
		newitem+="<span class='formControl'>";
		newitem+="<select class='statefield'  name='stateid[]' id='stateid"+id1+"' style='width: 252px;'><option value='0'>Please Select State</option><?php  foreach($statelist as $slist){?><option value='<?php echo $slist->state_id; ?>'><?php echo $slist->state_name; ?></option><?php } ?></select>";
		newitem+="<span class='formControl'>";
		newitem+="<div id='divStates' style='display:block'><br><div id='countyId_"+id1+"' style='padding-top:10px;'><select style='width: 252px;' name='county[]' id='county_ID"+id1+"' ><option value=''>Please Select County</option></select></div></div>";
		newitem+="</span>";
		newitem+="</div>";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		newdiv.innerHTML = newitem;
		ni.appendChild(newdiv);
	}
}
</script>
<!--Script by sateesh on 21-07-11 completed-->
<form action="<?php echo JRoute::_($this->request_url) ?>" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th class="content">
			Vendor: <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small>
			</th>
		</tr>
		</table>
		<table width="100%" class="adminform">
		<tr>
			<td width="60%" valign="top">
				<table>
				<tr>
					<th colspan="2">
					Vendor Details
					</th>
				</tr>
				<tr>
					<td width="270">
					Name:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="name"  class="inputbox" size="40" value="<?php echo $this->detail->name; ?>" maxlength="50" /> (*)
					</td>
				</tr>
				<tr>
					<td width="190">
					Last Name:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="lastname"  class="inputbox" size="40" value="<?php echo $this->detail->lastname; ?>" maxlength="50" /> (*)
					</td>
				</tr>
                <tr>
					<td width="190">
					Account Name:
					</td>
                    
                
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="username" <?php if($_REQUEST['task']=='edit'){ ?>readonly="readonly"  style="background-color:#DDDDDD;" <?php } ?> onblur="verifyemail(this.value,'')" class="inputbox" size="40" value="<?php echo $this->detail->username; ?>" maxlength="50" /> (*)
					</td>
				</tr>
				<tr>
					<td width="190">
					password:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="password"  class="inputbox" size="40" name="password"  type="password"   maxlength="50" /> (*)
					</td>
				</tr>
				<tr>
					<td width="190">
					Re-enter password:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="password"  class="inputbox" size="40" type="password" name="password2" id="password2"  maxlength="50" /> (*)
					</td>
				</tr>
				<!--<tr>
					<td width="130">
					Salutation:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<select name="salutation" style="width:180px;">
<option <?PHP //if($this->detail->salutation == 'Mr.'){?> selected="selected" <?PHP //} ?>>Mr.</option>
<option <?PHP //if($this->detail->salutation == 'Mrs.') {?> selected="selected" <?PHP //} ?>>Mrs.</option>
<option <?PHP //if($this->detail->salutation == 'Ms.') { ?> selected="selected" <?PHP //} ?>>Ms.</option>
</select>
					</td>
				</tr>-->
				<?php /*?><tr>
					<td width="130">
					Phone:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="phone" class="inputbox" size="40" value="<?php echo $this->detail->phone; ?>" maxlength="50" />(*)
					</td>
				</tr>
					<tr>
						<td class="key">
							<label for="alias">
								<?php echo JText::_( 'Extension' ); ?>:
							</label>
						</td>
						<td colspan="2">
							<input class="text_area" type="text" name="extension" id="extension" value="<?php echo $this->detail->extension; ?>" size="50" maxlength="4"  /> 
						</td>
					</tr><?php */?>
				<tr>
					<td width="130">
					Cell Phone:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="cellphone" class="inputbox" size="40" value="<?php echo $this->detail->cellphone; ?>" maxlength="50" />
					</td>
				</tr>
				<tr>
					<td>
					Email:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="email" id="email" value="<?php echo $this->detail->email; ?>" onblur="verifyemail(this.value,'<?php echo $this->detail->user_id ; ?>')" size="50" maxlength="255" /> (*)
                     <label id="user-email"></label>
					</td>
				</tr> 
				
				<tr height="20px">
					<th colspan="2">
					</th>
				</tr>
				<tr>
					<td>
					CC Emails:
					</td>
					<td title="This is a general description of the Category">
				<?php /*?><input class="text_area" type="text" name="ccemail" id="ccemail" value="<?php echo $this->detail->ccemail; ?>" onblur="verifyemail(this.value)" size="50" maxlength="255" /><?php */?> 
				<textarea name="ccemail" style="height:50px; width:216px;"><?php echo $this->detail->ccemail; ?></textarea>
				(*)
                     <label id="user-email"></label>
					</td>
				</tr>
				<tr>
					<th colspan="2">
					Company Details
					</th>
				</tr>
				<tr>
					<td width="130">
					Company Name:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text"  class="inputbox" name="company_name" size="100" value="<?php echo htmlentities($this->detail->company_name); ?>"  maxlength="1000" /> (*)
					</td>
				</tr>
				<tr>
					<td width="130">
					Company Website:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text"  class="inputbox" name="company_web_url" size="40" value="<?php echo $this->detail->company_web_url; ?>"  maxlength="50" />
					</td>
				</tr>
		<!--Added state and county by sateesh on 21-07-11	-->
      
      <?php if($_REQUEST['task'] == 'edit'){ ?>	
       <tr>
					<td width="130">Present business State:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<?php 
					//echo "<pre>"; print_r($this->businesslist);
					for ($j=0; $j<count($this->businesslist); $j++){ ?>
					<span id="vendorstates<?php echo $this->businesslist[$j]->state_id;?>"><?php echo $businesslist[$j]->state_name ;	 ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="color:red;" href="javascript:deletestate('<?php echo $this->businesslist[$j]->state_id;?>',<?php echo $this->detail->user_id; ?>,'<?php echo $this->businesslist[$j]->state_name;?>');">DELETE STATE</a></span>
						
					</td>
				</tr>
        <tr>
					<td width="130">
					Related Counties:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					 <?php for ($i=0; $i<count($this->vendorcounties); $i++){ 
					 if($businesslist[$j]->state_id == $this->vendorcounties[$i]->state_id){
					 ?>
				<span id="vendorstates<?php echo $this->businesslist[$j]->state_id;?>">	<span id="vendorcounties<?php echo $this->vendorcounties[$i]->county_id;?>"><?php echo $this->vendorcounties[$i]->County;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="vendorcounties<?php echo $this->vendorcounties[$i]->county_id;?>" href="javascript:deletecounty(<?php echo $this->vendorcounties[$i]->county_id;?>,<?php echo $this->detail->user_id; ?>,'<?php echo $this->vendorcounties[$i]->County;?>');">Remove this County from Vendor Business Area</a>
                <?php echo JHTML::tooltip('This is the name of the category as it appears to users.', 'Tooltip title', 'tooltip.png', '');
?>
                </span></span>
					<br />
					<?php } }?><br /><br /> <?php  }?>
					</td>
                           
				</tr>
                
		<?php } ?>
          <tr>
        <td>	
        <div class="signup" style="margin-top:10px;">
        <label>In what State are you licensed to do business? <span class="redstar">*</span></label>
        <!-- <select name="select2" id="select2" style=" width:252px;"> -->
        <select style="width:252px;" name="stateid[]" id="stateid" class="statefield">
        <option value="0">Please Select State</option>
        <option value="AllSTATES">All States</option>
        <?php  foreach($statelist as $slist) {  ?>
        <option value="<?php echo $slist->state_id; ?>"  ><?php echo $slist->state_name; ?></option>
        <?php } ?>
        </select>
        </div>
        

        
        <div class="signup">
        <label> Specify County/Counties: <span class="redstar">*</span> </label>
        <div id="divStates" style="display:block">
        <br />
        <select style="width: 252px;" name="county[]" id="county_ID" >
        <option value="">Please Select County</option>
        </select>
        </div>
        <a href="javascript:void(0);" id="addCounty" class="orange-links"><img src="images/addanothercountry.gif" alt="add country"  width="131" height="23" style="padding-top:10px;"/></a>
        <div class="clear"></div>
        </div>
        </td></tr>
        <tr><td>
        <div id="myDiv"></div><input name="thesValue" type="hidden" id="thesValue" value="0">
        <div align="right" style="padding-right:180px;"><span id="addEvent1"><a href="javascript:addEvent1();" class="normalhyperlink">Add State</a></span>
		<span style="display:none;" id="removeevent1"><a href="javascript: removeEvent1();" class="normalhyperlink"></a></span>	</div>
        </td></tr>
        <!--Added state and county by sateesh on 21-07-11 completed	-->
                <tr>
					<td width="130">
					Industries:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<?PHP echo $this->industries_link; ?> 
					</td>
				</tr>
				<tr>
					<td width="130"></td>
					<td><input type="text" class="inputbox" name="industries" readonly="readonly" id="industries" size="100" value="<?php echo $this->fill_industires; ?>" /> </td>
					</td> 
				</tr> 
				<tr>
					<td width="130">  
					Federal Tax ID#:
					</td> 
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="tax_id"  class="inputbox" size="40" value="<?php echo $this->detail->tax_id ?>" maxlength="50" onblur="verifytaxid();" /> (*)
					<label id="user-taxid"></label>
					</td>
				</tr>
				<tr>
					<td width="130">
					Mailing Address:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="company_address" id="company_address"  class="inputbox" size="40" value="<?php echo $this->detail->company_address ?>" maxlength="50"  /> (*)
					</td>
				</tr>
                <tr>
					<td width="130">
				
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="company_addresss" id="company_addresss"  class="inputbox" size="40" value="<?php echo $this->detail->company_addresss ?>" maxlength="50"  /> (*)
					</td>
				</tr>
				<tr>
					<td width="130">
					State:
					</td>
					<td title="This is the name of the Category as it will appear to users"><?PHP echo $this->states ?>
					(*)
					</td>
				</tr>
				<tr>
					<td width="130">
					City:
					</td>
					<td title="This is the name of the Category as it will appear to users">
					<input type="text" name="city" id="city"  class="inputbox" size="40" value="<?php echo $this->detail->city ?>" maxlength="50"  /> (*)
					</td>
				</tr>
					<tr>
						<td class="key">
							<label for="alias">
								Zip:
							</label>
						</td>
						<td colspan="2">
							<input class="text_area" type="text" name="zipcode" id="zipcode" value="<?php echo $this->detail->zipcode; ?>" size="50" maxlength="255"  /> (*)
						</td>
					</tr>
				<tr>
					<td>
					Year Established:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="established_year" id="established_year" value="<?php echo $this->detail->established_year; ?>" size="50" maxlength="255" /> (*)
					</td>
				</tr>
				<tr>
					<td>
					Company Phone #:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="company_phone" id="company_phone" value="<?php echo $this->detail->company_phone; ?>" size="50" maxlength="255" /> (*)
					</td>
				</tr>  
				<tr>
					<td>
					Ext:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="phone_ext" id="phone_ext" value="<?php echo $this->detail->phone_ext; ?>" size="50" maxlength="4" /> 
					</td>
				</tr> 
				<tr>
					<td>
					Alternate Phone #:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="alt_phone" id="alt_phone" value="<?php echo $this->detail->alt_phone; ?>" size="50" maxlength="255" /> 
					</td>
				</tr> 
				<tr>
					<td>
					Ext:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="alt_phone_ext" id="alt_phone_ext" value="<?php echo $this->detail->alt_phone_ext; ?>" size="50" maxlength="4" /> 
					</td>
				</tr>
				<tr>
					<td>
					Fax Number:
					</td>
					<td>
					<input class="text_area" type="text" name="faxid" id="faxid" value="<?php echo $this->detail->faxid; ?>" size="50" maxlength="12" /> 
					</td>
				</tr>
				<?php
				$fax_acc = $this->detail->fax_acc;
				if( ( $fax_acc == 'yes' || $fax_acc == '' ) && $this->detail->faxid != '--' && $this->detail->faxid )
				$checked_fax = 'checked="checked"';
				else
				$checked_fax = '';
				?>
				<tr><td colspan="2"><input type="checkbox" name="fax_acc" <?php echo $checked_fax; ?> /> I would also like to receive Project Invitation notifications via Fax</td></tr>
				<tr>
					<td>
					Preferred Vendor:
					</td>
					<td>
					<?PHP
					if(count($res)>0)
					{?>
					<table width="30%" border="0" cellpadding="1" cellspacing="1"/>
					<tr><td width="15%"><strong>Company Name </strong></td><td width="15%"><strong>Company License No </strong></td></tr>
					<?PHP 
					for($j=0; $j<count($res); $j++)
					{
					?><tr><td><?PHP echo $res[$j]->comp_name; ?></td><td><?PHP echo $res[$j]->camfirm_license_no; ?></td></tr>
					<?PHP
					}
					 ?>
					 </table>
					 <?PHP } else { echo 'Not a preferee';} ?>
					 </td>
					<?php /*?><input class="text_area" type="radio" name="preferred_vendors" id="preferred_vendors" <?php if($this->detail->preferred_vendors == 'yes') { ?> checked="checked" <?PHP } ?> value="yes" size="50" maxlength="255" />Yes  <input class="text_area" type="radio" name="preferred_vendors" id="preferred_vendors" <?php if($this->detail->preferred_vendors == 'No') { ?> checked="checked" <?PHP } ?> value="No" size="50" maxlength="255" />No <?php */?>
					</td>
				</tr>  
				<tr>
					<td>
					Inhouse Vendor:
					</td>
					<td>
					<?PHP
					if(count($inHouse_res)>0)
					{?>
					<table width="30%" border="0" cellpadding="1" cellspacing="1"/>
					<tr><td width="15%"><strong>Company Name </strong></td><td width="15%"><strong>Company License No </strong></td></tr>
					<?PHP 
					for($j=0; $j<count($inHouse_res); $j++)
					{
					?><tr><td><?PHP echo $inHouse_res[$j]->comp_name; ?></td><td><?PHP echo $inHouse_res[$j]->camfirm_license_no; ?></td></tr>
					<?PHP
					}
					 ?>
					 </table>
					<?PHP } else { echo 'No';} ?>
					 </td>
					<?php /*?><td title="This is a general description of the Category">
					<input class="text_area" type="radio" name="in_house_vendor" id="in_house_vendor" onclick="javascript: if(this.checked == true) { document.getElementById('show_content').style.display = 'block'; document.getElementById('show_content2').style.display = 'block';} else { document.getElementById('show_content').style.display = 'none'; document.getElementById('show_content2').style.display = 'none'; }" <?php if($this->detail->in_house_vendor == 'Yes') { ?> checked="checked" <?PHP } ?> value="Yes" size="50" maxlength="255" />Yes  <input class="text_area" type="radio" name="in_house_vendor" id="in_house_vendor" onclick="javascript: if(document.getElementById('in_house_vendor').checked == false) { document.getElementById('show_content').style.display = 'none'; document.getElementById('show_content2').style.display = 'none'; }" <?php if($this->detail->in_house_vendor == 'No') { ?> checked="checked" <?PHP } ?> value="No" size="50" maxlength="255" />No (*)
					</td><?php */?>
				</tr> 
				<?php /*?><tr id="show_content" <?php if($this->detail->in_house_vendor != 'Yes') { ?> style="display:none" <?PHP } ?> >
					<td style="float:left; width:270px;">
					Parent Company Name:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="in_house_parent_company" id="in_house_parent_company" value="<?php echo $this->detail->in_house_parent_company; ?>" size="50" maxlength="255" /> (*)
					</td>
				</tr>
				<tr id="show_content2" <?php if($this->detail->in_house_vendor != 'Yes') { ?> style="display:none" <?PHP } ?>>
					<td style="float:left; width:270px;">
					Parent Company Federal Tax ID#:
					</td>
					<td title="This is a general description of the Category">
					<input class="text_area" type="text" name="in_house_parent_company_FEIN" id="in_house_parent_company_FEIN" value="<?php echo $this->detail->in_house_parent_company_FEIN; ?>" size="50" maxlength="255" /> (*)
					</td>
				</tr> <?php */?>
				<tr>
					<td valign="top">
					image:
					</td>
					<td title="This is the company logo">
					<input type="file" name="image" /> <br/><br/><?php if($this->detail->image){ ?><span><img  src="<?PHP echo JURI::root().'components/com_camassistant/assets/images/vendors/resized/'. $this->detail->image ; ?>" /><input type="hidden" value="<?php echo $this->detail->image; ?>" name="img_name" /> <?php } ?>
					</td>
				</tr>
				<tr>
					<td>
					Publish:
					</td>
					<td title="">
					<input class="text_area" type="radio" name="published" id="published" <?php if($this->detail->published == '0') { ?> checked="checked" <?PHP } ?> value="0" size="50" maxlength="255" />Yes  <input class="text_area" type="radio" name="published" id="published" <?php if($this->detail->published == '1') { ?> checked="checked" <?PHP } ?> value="1" size="50" maxlength="255" />No 
					</td>
				</tr> 
				 
				 
				<tr>
					<td colspan="2"> <div class="form_checkbox">
<input name="interest_RFP_alerts" type="checkbox" <?php if($this->detail->interest_RFP_alerts == 'yes' || $this->detail->interest_RFP_alerts == 'on') { ?> checked="checked" <?PHP } ?> value="yes" />
I am interested in receiving Text Message RFP Alerts to my cell phone.</div>
					</td>
				</tr> 
				<?php /*?><tr><td>Rating :</td><td> <?PHP echo $rating=plgVotitaly($this->detail->user_id,$usr->id,$v_rating); ?> </td>
				</tr><?php */?>
 <tr>
					<td>
			Question:
					</td>
					<td>
				<?php echo JHTML::_('select.genericlist', $this->questions, 'question', null, 'value', 'text', $this->detail->question); ?>
					</td>
					</tr>
<tr>
					<td>
			Answer:
					</td>
					<td>
				<input name="answer" type="text" style="width:275px;" value="<?php echo $this->detail->answer; ?>" />
					</td>
					</tr>   
                     <tr>
					<td>
			Promo Code Used:
					</td>
					<td>
				<input name="promo_code" type="text" style="width:275px;" value="<?php echo $this->detail->promo_code; ?>" />
					</td>
					</tr>
					 
					<tr>
					<td>
			How did you hear about us? :
					</td>
					<td>
				<input name="hear" type="text" style="width:275px;" value="<?php echo $this->detail->hear; ?>" />
					</td>
					</tr>
                    <tr style="display:none;">
					<td>
			Subscription Plan :
					</td>
					<td>
					<?php 
					echo ucfirst ($this->detail->subscribe_type) ; ?>
<!--Basic Membership&nbsp;&nbsp;<input type="radio" <?php if($this->detail->subscribe_type == 'basic'){ echo "checked='checked'"; } ?> value="basic" id="basic" name="subscribe" class="subscribe" style="width:20px;" /><br />
Basic Membership + Public Profile&nbsp;&nbsp;<input type="radio" <?php if($this->detail->subscribe_type == 'public'){ echo "checked='checked'"; } ?> value="public" id="public" name="subscribe" class="subscribe" style="width:20px;" /><br />
Basic Membership + Sponsored Vendor&nbsp;&nbsp;<input type="radio" <?php if($this->detail->subscribe_type == 'sponsor'){ echo "checked='checked'"; } ?> value="sponsor" id="sponsor" name="subscribe" class="subscribe" style="width:20px;" /><br />
Basic Membership + Public Profile + Sponsored Vendor&nbsp;&nbsp;<input type="radio" <?php if($this->detail->subscribe_type == 'all'){ echo "checked='checked'"; } ?>value="all" id="all" name="subscribe" class="subscribe" style="width:20px;" /><br />-->

					</td>
					</tr>
					
                      				<tr><td></td></tr>
				</table>
			</td>
			<td width="40%" valign="top"><table cellpadding="0" cellspacing="0"><tr><br /><br />Vendor Notes<br /><textarea name="user_notes" style="width:400px; height:400px;"><?php echo html_entity_decode($this->detail->user_notes); ?></textarea></tr>
			<tr>
		<td><input type="checkbox" name="flag" value="flag" <?php if($this->detail->flag == 'flag') { ?> checked="checked" <?PHP } ?>  /><font color="#ff9900">Flag this account</font></td>
		</tr>
		<tr>
		<td><input type="checkbox" name="suspend" value="suspend" <?php if($this->detail->suspend == 'suspend') { ?> checked="checked" <?PHP } ?>  /><font color="red">Flag & suspend this account</font></td>
		</tr>
		<tr>
		<td><input type="checkbox" name="search" value="search" <?php if($this->detail->search == 'search') { ?> checked="checked" <?PHP } ?>  /><font color="red">Unsearchable</font></td>
		</tr>
		<tr height="30"><td></td></tr>
		<tr>
		<?php
		$subscribe = $this->detail->subscribe_admin ;
		$subsort = $this->detail->subscribe_sort ;
		
	if($subscribe == 'basic')
	$subscribe = 'Basic Membership';
	if($subscribe == 'public')
	$subscribe = 'Basic Membership + Compliance Verification';  
	if($subscribe == 'sponsor')
	$subscribe = 'Basic Membership + Compliance Verification';
	if($subscribe == 'all')
	$subscribe = 'Basic Membership + Compliance Verification + Sponsored Vendor';
		?>
		<td><strong>Subscription Plan:&nbsp;&nbsp; </strong><?php if($subscribe) { echo $subscribe ; } else { echo "Inactive"; } ?> </td>
		</tr>
		<?php $subscribe = $this->detail->subscribe_type ; ?>
		<tr>
		<td>Override:&nbsp;&nbsp;<select name="subscription">
		<option <?php if($subscribe == '0' || $adminsub == ''){ ?> selected="selected" <?php  } ?> value="0">Inactive</option>
		<option <?php if($subscribe == 'free'){ ?> selected="selected" <?php  } ?> value="4">Basic Membership</option>
		<option <?php if($subscribe == 'public'){ ?> selected="selected" <?php  } ?> value="3">Basic Membership + Compliance Verification</option>
		<option <?php if($subscribe == 'all'){ ?> selected="selected" <?php  } ?> value="1">Basic Membership + Compliance Verification + Sponsored Vendor</option>
		
		</select>
		</td>
		</tr>
		<tr height="30"><td></td></tr>
		<tr><td><strong>Overall Rating :</strong>
		<?php
		//To get the rating
		$ratecount = "SELECT V.apple FROM `#__cam_vendor_proposals` as U, `#__cam_rfpinfo` as V where U.proposedvendorid=".$this->detail->user_id." and V.apple!=0 and V.apple_publish=0 and U.proposaltype='Awarded' and U.rfpno = V.id ";
	$db->setQuery($ratecount);
	$count_vs=$db->loadObjectList();
	for($c=0; $c<count($count_vs); $c++){
	$total = $total + $count_vs[$c]->apple ;
	}
	$camrating = "SELECT camrating FROM `#__users` where id=".$this->detail->user_id."  ";
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
	?>
	<input type="text" value="<?php echo $rating; ?>" readonly="readonly"  />
		
	
		
		<?PHP //echo $rating=plgVotitaly($this->detail->user_id,$usr->id,$v_rating); ?> </td>
				</tr>
		<tr><td><strong>CAMassistant Rating:</strong>&nbsp;&nbsp;  <input type="text" value="<?php echo $this->detail->camrating; ?>" name="camrating"></td></tr>
		<tr height="10"><td></td></tr>
		<tr><td><strong>Manager Ratings</strong></td></tr>
		<br />
		<?php for($a=0; $a<count($awardrfps); $a++){  ?>
		<tr><td>
		<?php echo $awardrfps[$a]->projectName . '<br />RFP: #' . $awardrfps[$a]->id . '<br />' . $awardrfps[$a]->name . ' '. $awardrfps[$a]->lastname .'<br />' . $awardrfps[$a]->apple . '.00' ; ?><br />
		<strong>Comments:</strong>
		<?php
		$sql_comments = "SELECT comment FROM #__cam_rfp_ratings WHERE rfpid = ".$awardrfps[$a]->id." ";
		$db->Setquery($sql_comments);
		$comments = $db->loadResult();
		echo nl2br($comments);
		?>
		<?php if($awardrfps[$a]->apple_publish == '0'){?>
		<a id="showdelete<?php echo $awardrfps[$a]->id ; ?>" href="javascript:deleterating('<?php echo $awardrfps[$a]->id; ?>');">Delete</a>
		<?php } else { ?>
		<a id="hidedelete<?php echo $awardrfps[$a]->id ; ?>" href="javascript:undeleterating('<?php echo $awardrfps[$a]->id; ?>');"><font color="red">Undelete</font></a>
		<?php } ?>
		</td></tr>	
		<tr height="15"></tr>												
		<?php } ?>
		</tr>
		</tr>
		</table>
		</td>
		</tr>
		</table>
<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="user_id" value="<?php echo $this->detail->user_id; ?>" />
<input type="hidden" name="vendor_id" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="vendors_detail" />
</form>

<?PHP
/***************************************************** Rating Code *********************************************************/

function plgVotitaly( $user_id, $admin_id, $rfprating ) {

	global $my, $addScriptVotitalyPlugin, $user;
	
	$database = & JFactory::getDBO();
	$uri = & JFactory::getURI();
	$plugin = & JPluginHelper::getPlugin('content', 'ji_votitaly');
	$plgParams = new JParameter( $plugin->params );
	$show_stars = $plgParams->get('show_stars', 1);
	$star_description = $plgParams->get('star_description', '');
	$my->id = $admin_id;	
	$id = $user_id;
	$html = '';
	$document	=& JFactory::getDocument();
	$document->addScript('media/system/js/mootools.js');
	

			if(JPlugin::loadLanguage( 'plg_content_ji_votitaly' ) === false)
				JPlugin::loadLanguage( 'plg_content_ji_votitaly', JPATH_ADMINISTRATOR );		
	
			$id = $user_id;
			 $query = 'SELECT *' .
					' FROM #__content_rating' .
					' WHERE content_id 	 = '.(int) $id;
			$database->setQuery($query);
			$rating = $database->loadObject();
		
			if (!$rating)	{
				$rating_count = 0;
				$rating_sum   = 0;
				$average      = 0;
				$width        = 0;
				//$width   = 3.0 * 20;
			} else {
			    $rating_count = $rating->rating_count;
				$rating_sum = $rating->rating_sum;		
				$average = number_format(intval($rating_sum) / intval( $rating_count ),2);
				$width   = $average * 20;
			}
			
			$trans_star_description = _plgVotitaly_replaceDescString($star_description, $rating_count, $average);
			
			
			// +++++++++++++++++++++++++++++++++++++++
			// ++++++ Printing javascript code +++++++
			// +++++++++++++++++++++++++++++++++++++++
			$script='
<!-- VOTItaly Plugin v1.1 starts here -->
';

$script.='<link href="'.JURI::root().'plugins/content/ji_votitaly/css/votitaly.css" rel="stylesheet" type="text/css" />';	
$script.='<script type="text/javascript" src="'.JURI::root().'plugins/content/ji_votitaly/js/votitalyplugin.js"></script>';

$script.='
<script type="text/javascript">
'."
	window.addEvent('domready', function(){
	  var ji_vp = new VotitalyPlugin({
	  	submiturl: '".JURI::root()."plugins/content/ji_votitaly_ajax.php',
			loadingimg: '".JURI::root()."plugins/content/ji_votitaly/images/loading.gif',
			show_stars: ".($show_stars ? 'true' : 'false').",

			star_description: '".addslashes($star_description)."',		
			language: {
				updating: '".JText::_( 'VOTITALY_UPDATING')."',
				thanks: '".JText::_( 'VOTITALY_THANKS')."',
				already_vote: '".JText::_( 'VOTITALY_ALREADY_VOTE')."',
				votes: '".JText::_( 'VOTITALY_VOTES')."',
				vote: '".JText::_( 'VOTITALY_VOTE')."',
				average: '".JText::_( 'VOTITALY_AVERAGE')."',
				outof: '".JText::_( 'VOTITALY_OUTOF')."',
				error1: '".JText::_( 'VOTITALY_ERR1')."',
				error2: '".JText::_( 'VOTITALY_ERR2')."',
				error3: '".JText::_( 'VOTITALY_ERR3')."'
			}
	  });
	});
".'
</script>
<script type="text/javascript" src="'.JURI::root().'plugins/content/ji_votitaly/js/votitalyplugin.js"></script>
<!-- VOTItaly Plugin v1.1 ends here -->';		

			if(!$addScriptVotitalyPlugin){	
				$addScriptVotitalyPlugin = 1;
				JApplication::addCustomHeadTag($script);
			}
			// +++++++++++++++++++++++++++++++++++++++
			// +++++ /Printing javascript code +++++++
			// +++++++++++++++++++++++++++++++++++++++
						
// +++++++++++++++++++++++++++++++++++++++
// ++++++++ Printing html code +++++++++++
// +++++++++++++++++++++++++++++++++++++++
$html = '
<!-- Votitaly Plugin v1.1 starts here -->
<div class="votitaly-inline-rating" id="votitaly-inline-rating-'. $id .'">
	<div class="votitaly-get-id" style="display:none;">'. $id .'</div>
	<div class="customerid" style="display:none;">'.$my->id.'</div>
	<div class="adminside" style="display:none;">admin</div>
';

	$html .= '
	<div class="votitaly-inline-rating-stars" style="display:none">
	  <ul class="votitaly-star-rating">
	    <li class="current-rating" style="width:'. $width .'%;">&nbsp;</li>
	    <li><a title="1 '. JText::_( 'VOTITALY_STAR' ) .'" class="votitaly-toggler one-star">1</a></li>
	    <li><a title="2 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler two-stars">2</a></li>
	    <li><a title="3 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler three-stars">3</a></li>
	    <li><a title="4 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler four-stars">4</a></li>
	    <li><a title="5 '. JText::_( 'VOTITALY_STARS' ) .'" class="votitaly-toggler five-stars">5</a></li>
	  </ul>
	</div><br/>
	
	';
	if($rating->rating_sum == '' || $rfprating == '')  
	$rating->rating_sum = '4.0' ; 
	else $rating->rating_sum = $rfprating ; 
$html .= '<input type="text" name="rate" class="votitaly-toggler" id="adminrate" readonly="readonly" value="' .$rating->rating_sum.'" />';
$html .= '<div class="" >';
/*if ($show_votes || $show_average) {
	$html .= '('. 
		($show_votes ? $rating_count .' '. ($rating_count==1 ? JText::_( 'VOTITALY_VOTE' ) : JText::_( 'VOTITALY_VOTES' )) : '') .
		($show_votes && $show_average ? ', ' : '') .
		($show_average ? JText::_( 'VOTITALY_AVERAGE' ) .': '. $average .' '. JText::_( 'VOTITALY_OUTOF' ) : '') .
		')';
}
*/
//$html .= $trans_star_description;
$html .= '</div>';
$html .= '</div>';

// +++++++++++++++++++++++++++++++++++++++
// ++++++++ Printing html code +++++++++++
// +++++++++++++++++++++++++++++++++++++++	
	return $html;
}



function _plgVotitaly_replaceDescString( $string, $num_votes, $num_average ) 
{
	$patterns = array(
		'/{num_votes}/',
		'/{num_average}/',
		'/#LANG_VOTES/',
		'/#LANG_AVERAGE/',
		'/#LANG_OUTOF/',
	);
	$replacements = array( 
		$num_votes, 
		$num_average, 
		($num_votes==1 ? JText::_( 'VOTITALY_VOTE') : JText::_( 'VOTITALY_VOTES')),
		JText::_( 'VOTITALY_AVERAGE'),
		JText::_( 'VOTITALY_OUTOF')
	);
	
	return preg_replace($patterns, $replacements, $string);
}


?>