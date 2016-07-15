<?php
//restricted access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
// import html tooltips
JHTML::_('behavior.tooltip');

?>
<script type="text/javascript" src="../components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>

	<script language="javascript" type="text/javascript">
	G = jQuery.noConflict();
	function verifyuser(){
	inputString=G('#registration2').val();
	//alert(inputString);
		G.post("index2.php?option=com_camassistant&controller=customer_detail&tmpl=component&task=verfiryuser", {queryString: ""+inputString+""}, function(data){
                
		G('#testcode').html(data);
		});


	}

function verifyemail(email){
		if(email != '<?php echo $this->detail->email; ?>'){
		G.post("index2.php?option=com_camassistant&controller=customer_detail&task=verfiryemailid", {queryString: ""+email+""}, function(data){
		if(data == 'invalid'){
//		G('#user-email').html('<font color="#FF0000">This Email ID already exists. Please enter another Email ID.</font>');
		alert("This Email ID already exists. Please enter another Email ID.");
	//	document.adminForm.elements['username'].value = '';
		document.adminForm.elements['email'].value = '<?php echo $this->detail->email; ?>';
		return false;
		}
		});
	}
	}

	function verifytaxid(id,second){

		taxid1=document.adminForm.taxid1.value;
		taxid2=document.adminForm.taxid2.value;
		taxid3=document.adminForm.taxid3.value;
		if(taxid3){
		taxid=taxid1+'-'+second+'-'+taxid3;
		}
		else {
		taxid=taxid1+'-'+second;
		}
		if(id!=taxid){
		G.post("index2.php?option=com_camassistant&controller=customer_detail&task=verfirytaxid", {queryString: ""+taxid+"",queryString1: ""+id+""}, function(data){
		if(data == 'invalid'){
		G('#user-taxid').html('<font color="#FF0000">Federal TAX ID already exists. Please enter another Federal TAX ID.</font>');
		alert("Federal TAX ID already exists. Please enter another Federal TAX ID.");
		var fields = id.split(/-/);
		document.adminForm.taxid1.value = fields[0];
		document.adminForm.taxid2.value = fields[1];
		document.adminForm.taxid3.value = fields[2];
		return false;
		}

		});
		}
	}
		function submitbutton(pressbutton) {
		
			var form = document.adminForm;
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			re = /[0-9]/;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			//var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			// do field validation
			else if(pressbutton == 'apply' || pressbutton == 'save')
			 {
			 	 var fup = document.getElementById('image'); 
				 var fileName = fup.value; 
				 var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	 
				if (trim(form.taxid1.value) == "")
				 {

					alert( "You must provide tax id." );
					return false;
				 } else if (trim(form.taxid2.value) == "")
				 {

					alert( "You must provide tax id." );
					return false;
				 } else if (trim(form.comp_name.value) == "")
				 {

					alert( "You must provide company name." );
					return false;
				 }
				 else if (trim(form.mailaddress.value) == "")
				 {
					alert( "You must provide company mail address" );
					return false;
				 } else if (trim(form.city.value) == "")
				 {
					alert( "You must provide company city." );
					return false;
				 } else if (trim(form.state.value) == "")
				 {
					alert( "You must provide company state ." );
					return false;
				 } else if (trim(form.zipcode.value) == "")
				 {
					alert( "You must provide company zipcode ." );
					return false;
				 } else if (trim(form.cphone1.value) == "")
				 {
					alert( "You must provide company phone number ." );
					return false;
				 } else if (trim(form.email.value) == "")
				 {
					alert( "You must provide your email address ." );
					return false;
				 }  else if(reg.test(form.email.value) == false) {
                    //alert(trim(form.username.value));
                     alert('Invalid Email Address');
					 return false;
                 }  else if (trim(form.username.value) == "")
				 {
					alert( "You must provide your username ." );
					return false;
				 }  else if(reg.test(form.username.value) == false) {
                   
                     alert('Invalid username. Username must be Email Address');
					 return false;
                 } 
				 else if( form.username.value != form.email.value ){
				 	 alert('Both Username and Email must be same.');
				 	 return false;
				 }
				 /*else if(form.user_email.value != '') {
                     alert(form.user_email.value);

				 } */else if (form.password.value!=form.password2.value)
				 {
					alert( "Incorrect passwords ." );
					return false;
				 } else if (trim(form.fname.value) == "")
				 {
					alert( "You must provide first name ." );
					return false;
				 } else if (trim(form.lname.value) == "")
				 {
					alert( "You must provide last name ." );
					return false;
				 } else if (trim(form.phone1.value) == "")
				 {
					alert( "You must provide phone number ." );
					return false;
				 } else if (trim(form.question.value) == "")
				 {
					alert( "You must select the Question ." );
					return false;
				 } 
				 else if (trim(form.answer.value) == "")
				 {
					alert( "You must enter the answer ." );
					return false;
				 } 
				 else  if (trim(form.phone2.value) == "")
				 {
					alert( "You must provide phone number ." );
					return false;
				 } else  if (trim(form.phone3.value) == "")
				 {
					alert( "You must provide phone number ." );
					return false;
				 } 
				if(fileName != '')
					{
					if(ext != 'jpg' && ext != 'gif' && ext != 'jpeg' && ext != 'png' && ext != 'JPG' && ext != 'JPEG' )
						{ 
							alert("Image file must be a .gif, .jpg, or .png.");
							return false;
						}
						else{
							submitform( pressbutton );
						}
					}
			
				 if(form.password.value) {
				 	 if(form.password.value.length < 7){
						alert("Please enter password with atleast 7 characters");
						return false;
				  		}
				  	 else if(!re.test(form.password.value)) { 
						alert("password must contain at least one number (0-9)");
						return false;
					 }
					 else {
						submitform( pressbutton ); 
					 }
					} 
					
				 else
				 {
					submitform( pressbutton );
				 }
		     }
		}



function showregtype()
{
var form1= document.registration;
//alert(form1.registration1.value);
document.getElementById('hidden_field1').value=form1.registration1.value;

if (form1.registration1.value=='P'){
document.getElementById('companylist').style.display='';
document.getElementById('image').style.display='none';
} else if (form1.registration1.value=='C'){
document.getElementById('companylist').style.display='none';
document.getElementById('image').style.display='';
//alert(form1.registration1.hidden1.value);
//alert(form1.registration2.value);

/*var e = document.getElementById('registration');
alert(e.value);
var a = e.options[e.selectedindex].value;
alert(a);
document.getElementById('registration').style.display='none';*/
}
}
 function isNumberKey(evt)
      {
        /* var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;*/
      }

function getwrongalert(){
	alert("There is NO balance amount to send to this MASTER.");
}
	</script>

<?php 
$task = JRequest::getVar("task",'');
//echo "<pre>"; print_r($this->detail); ?>

<div id="testcode"> </div>
<div id="registration">
<form name="registration" >
<?php if($task != 'createmaster'){ ?>
<table>
<tr>
<?php if ($this->detail->id){ ?>
<?php } else { ?>
<td width="300">
					<strong>Please Select Registration Type </strong>
						</td>
					<td >
			<select name="registration1" onChange="javascript:showregtype();" id="registration1">
			<option value="C">Cam Firm Admin Registration</option>
			<option value="P" >Property Manager Registration</option>
			</select>
	</td>
<?php } ?>
</tr></table>
<?php } ?>
</form></div>
<form name="companylist" >
<div id="companylist" style="display:none;">
<table>
<tr><td width="300"><strong>Please Select Company Name </strong></td><td>
<?php
$company[] = JHTML::_('select.option','',JText::_('Please Select Company'));
foreach( $this->cdata as $obj )
		{
			$firmnames = $obj->comp_name.'&nbsp;-&nbsp;&nbsp;&nbsp;'.$obj->name.',&nbsp;'.$obj->lastname ;
			$company[] = JHTML::_('select.option', $obj->cust_id, $firmnames);

		}


		$company = JHTML::_('select.genericlist',$company, 'registration2', 'style="width: 276px" onchange="verifyuser();" ' . $javascript , 'value', 'text', $this->_filter_company);
			echo $company;
?>


</td></tr></table>
</div>
</form>
<?php //echo "<pre>"; print_r($this->detail1); ?>
<?php if($this->detail->comp_id!='0' && $this->detail) { ?>
	<?php   $db		= &JFactory::getDBO();
			$query1 = "SELECT cust_id FROM #__cam_camfirminfo where id='".$this->detail->comp_id."'";
			$db->setQuery($query1);
			$cust_id= $db->loadResult();

			$query2 = "SELECT * FROM #__cam_customer_companyinfo where cust_id ='".$cust_id."'";
			$db->setQuery($query2);
			$result= $db->loadObjectlist();

			$query3 = "SELECT * FROM #__users where id ='".$this->detail->id."'";
			$db->setQuery($query3);
			$result1= $db->loadObjectlist();
			$this->detail1=$result1[0];
			//echo "<pre>"; print_r($this->detail1);
			$this->detail=$result[0];
			//echo "<pre>"; print_r($result);
			?>
<?php } else { ?>
<?php $this->detail=$this->detail; ?>
<?php } ?>
<?php
//echo '<pre>'; print_r($this->detail);
if($this->detail->phone==''){ $this->detail->phone=$this->detail1->phone; } else {
$this->detail->phone=$this->detail->phone; }
if($this->detail->cellphone==''){ $this->detail->cellphone=$this->detail1->cellphone; } else {
$this->detail->cellphone=$this->detail->cellphone; }
$comp_phno = explode('-',$this->detail->comp_phno);
$comp_alt_phno = explode('-',$this->detail->comp_alt_phno);
$camfirm_license_no = explode('-',$this->detail->camfirm_license_no);
$phone = explode('-',$this->detail->phone);
$cellphone = explode('-',$this->detail->cellphone);
?>
<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
		<?php /*?><table class="adminheading">
		<tr>
			<th class="content">
			customer: <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small>
			</th>
		</tr>
		</table><?php */?>

<?php //echo "<pre>"; print_r($this->detail1); ?>
 <input id="hidden_field1" name="hidden_field1" type="hidden" value="" />
		<table class="adminform" width="100%">
		<tr>
			<td width="60%" valign="top">
				<table>

				<tr>
					<td width="300">
					Management Firm Company Name:
					</td>
					<td >
					<input name="comp_name" id="comp_name" type="text" style="width:275px;" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo  $this->detail->comp_name; ?>" /><font color="red">(*)</font>
					</td>
				</tr>


					<tr>
						<td width="300">
						Federal Tax ID: 
						</td>
						<td colspan="2">
						<input name="taxid1" id="taxid1" type="text" style="width:30px; text-align:center;" value="<?php echo $camfirm_license_no[0]; ?>" onkeypress="return isNumberKey(event)" maxlength="2" /> -
						<input name="taxid2" id="taxid2" type="text" onkeypress="return isNumberKey(event)" style="width:100px; text-align:center;"  value="<?php echo $camfirm_license_no[1]; ?>" <?php if($this->detail->user_type=='13'){ ?> onblur="verifytaxid('<?php echo $this->detail->camfirm_license_no; ?>',this.value);" <?php } ?> maxlength="50"/>
					 - <input name="taxid3" id="taxid3" type="text" style="width:35px; text-align:center;" value="<?php echo $camfirm_license_no[2]; ?>" maxlength="10"/><br />	<label id="user-taxid"></label>
						</td>
					</tr>
				<?php /*?><tr>
					<td width="300">
					Property Management Firm/CAM Firm Licence #:
					</td>
					<td>
					<input name="tax_id1" id="tax_id1" type="text" style="width:275px;" value="<?php echo $this->detail->tax_id; ?>" />
					</td>
					</tr><?php */?>
					<tr>
					<td width="300">
				Management Firm Mailing Address:
					</td>
					<td><input name="mailaddress" id="mailaddress" type="text" style="width:275px;" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?> value="<?php echo $this->detail->mailaddress; ?>" />
					</td>
					</tr>
					<tr>
					<td width="300">
			City:
					</td>
					<td><input name="city" id="city" type="text" style="width:275px;" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo $this->detail->comp_city; ?>" />

					</td>
					</tr>
					<tr>
					<td width="300">
				State:
					</td>
					<td>
<?php //echo '<pre>'; print_r($this->states); ?><?php

					if($this->detail1->user_type=='12'){ $disabled="disabled"; ?> <?php echo JHTML::_('select.genericlist', $this->states, 'state',  'size="1" style="width:275px;" '.$disabled.' class="inputbox " ', 'value', 'text', $this->detail->comp_state);?>
					<?php } else { ?>
					<?php echo JHTML::_('select.genericlist', $this->states, 'state',  'size="1" style="width:275px;" '.$disabled.' class="inputbox " ', 'value', 'text', $this->detail->comp_state);?>
					<?php } ?>
					<!--<input name="state" id="state" type="text" style="width:275px;" value="<?php echo $this->detail->comp_state; ?>" />-->
				</td>
					</tr>
					<tr>
					<td width="300">
				Zip Code (5 digit):
					</td>
					<td>
			<input name="zipcode" id="zipcode" type="text" style="width:275px;" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo $this->detail->comp_zip; ?>" maxlength="5" />
					</td>
					</tr>
					<tr>
					<td width="300">
				Main Company Phone Number:
					</td>
					<td><input name="cphone1" id="cphone1" type="text" style="width:30px; text-align: center" value="<?php echo $comp_phno[0]; ?>" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" maxlength="3" class="inputbox required validate-phone"/>)
 <input name="cphone2" type="text" id="cphone2" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>style="width:30px; text-align: center" value="<?php echo $comp_phno[1]; ?>" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" maxlength="3" /> -
 <input name="cphone3" type="text" id="cphone3" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>style="width:45px; text-align: center" value="<?php echo $comp_phno[2]; ?>" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');"  maxlength="4" />


				  &nbsp; &nbsp; Extension (optional):</td><td><input name="cext" id="cext" type="text" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>style="width:70px;" maxlength="4" value="<?php echo $this->detail->comp_extnno; ?>" /></td>
					</tr>
					<tr>
					<td width="300">
				Alt.Phone Number(optional):
					</td>
					<td width="300"><input name="caphone1" type="text" id="caphone1" style="width:30px; text-align: center" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo $comp_alt_phno[0]; ?>" maxlength="3"  class="inputbox required validate-phone"/>)
<input name="caphone2" type="text" id="caphone2" style="width:30px; text-align: center" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo $comp_alt_phno[1]; ?>" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" maxlength="3" /> -
<input name="caphone3" type="text" id="caphone3" style="width:45px; text-align: center" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo $comp_alt_phno[2]; ?>" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" maxlength="4" />

					 &nbsp; &nbsp; Extension (optional):</td><td><input name="caext" id="caext" type="text" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>style="width:70px;" maxlength="4" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" value="<?php echo $this->detail->comp_alt_extnno; ?>" /></td>
					</tr>
					<tr>
					<td width="300">
				Company website (opt.):
					</td>
					<td>
					<input name="website" id="website" type="text" style="width:275px;" <?php if($this->detail1->user_type=='12'){ ?> readonly='readonly' <?php }  ?>value="<?php echo $this->detail->comp_website; ?>" />

					</td>
					</tr>
					<?php //echo "<pre>"; print_r($this->detail1); ?>
					<tr>
					<td width="300">
			Upload your Company logo (optional):<br/>(image file must be jpg,gif or png)
					</td>
					<td width="330">
                    <?php //echo "<pre>"; print_r($this->detail1); ?>
					<?php if($this->detail->user_type=='13' || $this->detail1->user_type==13 || !$this->detail->user_type || !$this->detail1->user_type) {  ?>
				<input name="image" type="file" id="image" style="width:275px;" value="<?php echo  $this->detail->comp_logopath; ?>"/><?php } ?>
				<?php $siteURL = JURI::root(); ?>
				<?php //echo "<pre>"; print_r($this->detail); ?>
				<?php 	$path2= $siteURL."components/com_camassistant/assets/images/properymanager/";
			if($this->detail->comp_logopath==''){
			$path1='noimage.gif';
			} else {
				$path1=$this->detail->comp_logopath;
			}
			$image=$path2.$path1;
       //print_r($image);
	   $image = str_replace(' ','%20',$image);
		 	 $apath= getimagesize($image);

		  	$height_orig=$apath[1];
			$width_orig=$apath[0];
			$aspect_ratio = (float) $height_orig / $width_orig;
			$thumb_width =100;
			$thumb_height = round($thumb_width * $aspect_ratio);

		?></td><td><?php if($this->detail->comp_logopath) {  ?>
<img width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" src="<?php echo $siteURL ?>components/com_camassistant/assets/images/properymanager/<?php echo $this->detail->comp_logopath ; ?>" /><?php } ?>
			<input type="hidden" name="hidden_image" value="<?php echo $this->detail->comp_logopath; ?>" /></td>
					</tr>
					<tr>
					<td width="300">
				Notification Email Address
					</td>
					<td width="300"><input name="email" id="email" type="text" style="width:275px;" class="inputbox required validate-email" value="<?php if($this->detail->email==''){ echo $this->detail1->email; } else { echo $this->detail->email; } ?>" onblur="verifyemail(this.value)"/>
					<label id="user-email"></label>
				</td>
					</tr>
					<tr>
					<td width="300">
				Username
					</td>
					<td width="300"><input name="username" id="username" type="text" style="width:275px;" class="inputbox required validate-email" value="<?php if($this->detail->username==''){ echo $this->detail1->username; } else { echo $this->detail->username; } ?>" onblur="verifyemail(this.value)"/>
					<label id="user-email"></label>

				</td>
					</tr>
					<tr>
					<td width="300">
			Enter desired password:
					</td>
					<td width="300">
				<input name="password" type="password" style="width:275px;" class="inputbox required validate-password" value="" />
					</td>
					</tr>
					<tr>
					<td width="300">
			Re-enter password:
					</td>
					<td width="300">
<input name="password2" type="password" style="width:275px;" value="" />					</td>
					</tr>
					<tr>
					<!--<td width="300">
			Salutation:
					</td>-->
					<?php //echo "<pre>"; print_r($this->detail->salutation); ?>
					<!--<td>
<select name="salutation" style="width:282px;">
<option value="Mr" <?php //if(($this->detail->salutation=='Mr')||($this->detail1->salutation=='Mr')){ ?> selected="selected" <?php //} ?> >Mr</option>
<option value="Mrs" <?php //if(($this->detail->salutation=='Mrs')||($this->detail1->salutation=='Mrs')){ ?> selected="selected" <?php //} ?>>Mrs</option>
<option value="Ms" <?php //if(($this->detail->salutation=='Ms')||($this->detail1->salutation=='Ms')){ ?> selected="selected" <?php //} ?>>Ms</option>
</select>					</td>-->
					</tr>
					<tr>
					<td width="300">
			Your Name:
					</td>
					<td width="300">
<input name="fname" type="text" style="width:123px;" value="<?php if($this->detail->name==''){ echo $this->detail1->name; } else { echo $this->detail->name; } ?>"  class="inputbox required validate-fname"/><font color="red">(*)</font>&nbsp;&nbsp;
&nbsp;<input name="lname" type="text" style="width:127px;" value="<?php if($this->detail->lastname==''){ echo $this->detail1->lastname; } else { echo $this->detail->lastname; } ?>"  class="inputbox required validate-lname"/><font color="red">(*)</font>
					</td>
					</tr>
					<tr>
					<td>
			Your Phone:
					</td>
					<td width="300">
			(<input name="phone1" type="text" style="width:30px; text-align: center" value="<?PHP echo $phone[0]; ?>" maxlength="3" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" class="inputbox required validate-phone"/>)
 <input name="phone2" type="text" style="width:30px; text-align: center" value="<?PHP echo $phone[1]; ?>" maxlength="3" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');"/> -
 <input name="phone3" type="text" style="width:45px; text-align: center" value="<?PHP echo $phone[2]; ?>" maxlength="4" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');"/>
					 &nbsp; &nbsp; Ext:  &nbsp; &nbsp;<input name="ext" type="text" style="width:82px;" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" value="<?php if($this->detail->extension==''){ echo $this->detail1->extension; } else { echo $this->detail->extension; } ?>" maxlength="4" /></td>
					</tr>
					<tr>
					<td>
			Your Cell Phone:
					</td>
					<td width="300">
			(<input name="mphone1" id="mphone1" type="text" style="width:30px; text-align: center" value="<?PHP echo $cellphone[0]; ?>" maxlength="3" onkeyup="moveOnMax(this,'mphone2')" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');"/ >)
 <input name="mphone2" id="mphone2" type="text" style="width:30px; text-align: center" value="<?PHP echo $cellphone[1]; ?>" onkeyup="moveOnMax(this,'cphone3')" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" maxlength="3"/> -
 <input name="mphone3" id="mphone3" type="text" style="width:45px; text-align: center" value="<?PHP echo $cellphone[2]; ?>" onkeydown="if(isNaN(this.value)) alert('Please enter valid number');" maxlength="4" /></td>
					</tr>
                    <tr>
					<td width="300">
			Question:
					</td>
					<td width="300">
					<?php if($this->detail->question==''){ $this->detail->question=$this->detail1->question; } else { $this->detail->question= $this->detail->question; } ?>
				<?php echo JHTML::_('select.genericlist', $this->questions, 'question', null, 'value', 'text', $this->detail->question ); ?><font color="red">(*)</font>
					</td>
					</tr>
					<tr>
					<td width="300">
			Answer:
					</td>
					<td width="300">
				<input name="answer" type="text" style="width:275px;" value="<?php if($this->detail->answer==''){ echo $this->detail1->answer; } else { echo $this->detail->answer; } ?>" /><font color="red">(*)</font>
					</td>
					</tr>
					<tr>
					<td width="300">
			How did you hear about us? :
					</td>
					<td width="300">
				<input name="hear" type="text" style="width:275px;" value="<?php if($this->detail->hear==''){ echo $this->detail1->hear; } else { echo $this->detail->hear; } ?>" />
					</td>
					</tr>
					<!--<tr>
						<td width="120" class="key" title="Click to change the state of the Category">
							<?php echo JText::_( 'Published' ); ?>:
						</td>
						<td>
							<?php echo $this->lists['published']; ?>
						</td>
					</tr>-->
					<?php if(($this->detail1->registerDate)||($this->detail->registerDate)) { ?>
					<tr>
				<td width="120" class="key" title="Click to change the state of the Category">
							<?php echo JText::_( 'Register Date' ); ?>:
						</td>
						<td>
							<?php echo $this->detail->registerDate; ?><?php echo $this->detail1->registerDate; ?>
						</td>
					</tr>
				<?php } ?>
				</table>
			</td>
			<td width="40%" valign="top"><table cellpadding="0" cellspacing="0"><tr><td>
			<br /><br />Manager Notes<br /><textarea name="user_notes" style="width:400px; height:400px;"><?php if($this->detail->user_notes==''){ echo html_entity_decode($this->detail1->user_notes); } else { echo html_entity_decode($this->detail->user_notes); } ?></textarea>
	<?php //echo "<pre>"; print_r($this->detail1);
if($this->detail->user_type){
$usertype=$this->detail->user_type;
$id=$this->detail->id;
} else {
$usertype=$this->detail1->user_type;
$id=$this->detail1->id;
}
?>
			<!--To get the all managers notes-->
			<?php
			$db		= &JFactory::getDBO();
			$firmid = $camfirm_license_no[0].'-'.$camfirm_license_no[1];
			$query_usernotes = "SELECT u.user_notes,u.name,u.lastname,u.id,u.user_type,u.dmanager FROM #__users as u, #__cam_customer_companyinfo as v where v.camfirm_license_no ='".$firmid."' and u.id = v.cust_id and u.user_notes!='' ";
			$db->setQuery($query_usernotes);
			$result_notes= $db->loadObjectlist();

			for($n=0; $n<count($result_notes); $n++){
			if($id != $result_notes[$n]->id){
			if($result_notes[$n]->user_type == 13)   $label = "Camfirm Manager Name:";
			if($result_notes[$n]->user_type == 12)   $label = "Manager Name:";
			if($result_notes[$n]->dmanager == 'yes') $label = "District Manager Name:";
			echo "<br><b><font color='red'>".$label."</font> <font color='green'>".$result_notes[$n]->name.' '.$result_notes[$n]->lastname.'</b></font><br>';
			echo html_entity_decode($result_notes[$n]->user_notes).'<br>';
			}
			}

			?>
			</td></tr>
			<?php
		if( $this->detail->suspend == 'suspend' || $this->detail1->suspend == 'suspend' ){
			$suspend = 'suspend' ;
		}
		else{
			$suspend = '' ;
		}
		if($this->detail->flag == 'flag' || $this->detail1->flag == 'flag'){
			$flag = 'flag' ;
		}
		else{
			$flag = '' ;
		}
		?>
			<tr>
		<td><input type="checkbox" name="flag" value="flag" <?php if($flag == 'flag') { ?> checked="checked" <?PHP } ?>  /><font color="#ff9900">Flag this account</font></td>
		</tr>
		<tr>
		<td><input type="checkbox" name="suspend" value="suspend" <?php if($suspend == 'suspend') { ?> checked="checked" <?PHP } ?>  /><font color="red">Flag & suspend this account</font></td>
		</tr>
		<?php if($this->detail->user_type == 13 && $this->detail->accounttype == 'master') { ?>
		<tr>
		<td><input type="checkbox" name="search" value="search" <?php if($this->detail->search == 'search') { ?> checked="checked" <?PHP } ?>  /><font color="red">Hide this Master</font></td>
		</tr>
		<?php } ?>
		
		<tr height="20"></tr>
		<tr>
		<?php //echo "<pre>"; print_r($this->detail); echo "</pre>"; ?>
		<td>Invite Code: &nbsp;&nbsp;<input type="text" name="manager_invitecode" value="<?php echo $this->detail1->manager_invitecode.$this->detail->manager_invitecode;  ?>"  /></td>
		</tr>
		<?php if($this->detail->user_type == 13 && $this->detail->accounttype == 'master') { ?>
		<tr height="20"></tr>
		<tr>
		<td colspan="2">Preferred Vendor Codes:</td>
		</tr>
		<?php 
		$codes = $this->codes;
		for( $c=0; $c<count($codes); $c++ ){ ?>
		<tr><td colspan="2"><strong><?php echo $codes[$c]->code ; ?></strong></td></tr>
		<tr><td colspan="2">Total Earned: $<?php 
		if (strpos($codes[$c]->balance,'.') !== false)
		echo $codes[$c]->total_earned ;
		else
		echo $codes[$c]->total_earned.'.00' ; 
		?></td></tr>
		<tr><td colspan="2">Balance: $<?php 
		if (strpos($codes[$c]->balance,'.') !== false)
		echo $codes[$c]->balance ; 
		else 
		echo $codes[$c]->balance.'.00' ; 
		
		?></td></tr>
		<?php if( $codes[$c]->balance > '0' ) { ?> 
		<tr><td colspan="2">Payments: <a class="modal" rel="{handler: 'iframe', size: {x: 680, y: 400}}" href="index.php?option=com_camassistant&controller=customer_detail&task=addpayment&codeid=<?php echo $codes[$c]->id; ?>&masterid=<?php echo $_REQUEST[cid][0]; ?>&bal=<?php echo $codes[$c]->balance; ?>">(<font color="#77b800">Add Payment</font>)</a></td></tr>
		<?php } else { ?>
		<tr><td colspan="2">Payments: <a href="javascript:void(0)" onclick="getwrongalert();">(<font color="#77b800">Add Payment</font>)</a></td></tr>
		<?php }
		?>
		<?php 
		$checks = $codes[$c]->checks_served;
			for( $ck=0; $ck<count($checks); $ck++ ){
			$balance = $codes[$c]->balance + $checks[$ck]->tf_money ;
			 ?>
			<tr>
			<td><?php echo "Amount: $".$checks[$ck]->tf_money.' | Check#: '.$checks[$ck]->checkid; ?> ( <a class="modal" rel="{handler: 'iframe', size: {x: 680, y: 400}}" href="index.php?option=com_camassistant&controller=customer_detail&task=editpayment&codeid=<?php echo $codes[$c]->id; ?>&payid=<?php echo $checks[$ck]->id; ?>&checkid=<?php echo $checks[$ck]->checkid; ?>&amount=<?php echo $checks[$ck]->tf_money; ?>&masterid=<?php echo $_REQUEST[cid][0]; ?>&bal=<?php echo $balance; ?>"><font color="#FF0000">EDIT</a></font> ) </td>
			</tr>
			<?php } ?>
			<tr height="20"></tr>
		<?php } ?>
		<?php } ?>
		</table></td>
		</tr>
		
		</table>
<?php //echo "<pre>"; print_r($this->detail1);
if($this->detail->user_type){
$usertype=$this->detail->user_type;
$id=$this->detail->id;
} else {
$usertype=$this->detail1->user_type;
$id=$this->detail1->id;

}

?>
<?php
if($task == 'createmaster' || $this->detail->accounttype!='')
$accounttype = 'master';
else
$accounttype = '';
?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="hidden_field" value="<?php echo $usertype; ?>" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="accounttype" value="<?php echo $accounttype; ?>" />
<input type="hidden" name="controller" value="customer_detail" />
</form>
