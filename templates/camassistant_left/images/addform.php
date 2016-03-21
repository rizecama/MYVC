<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright � 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
//echo ' ';
$user = JFactory::getUser();
$usertype = $user->user_type;
$userid = $user->id;


?>
<script type="text/javascript">
function validate_data()
{
 var frm = document.addproperty;
 	var iChars = "#&";
	for (var i = 0; i < frm.property_name.value.length; i++) {
    if (iChars.indexOf(frm.property_name.value.charAt(i)) != -1) {
    alert ("You are not allowed to create the property containing "+iChars+".");
   return ;
        }
    }

 if(frm.property_name.value == '')
 {
 alert('Please enter property name');
 frm.property_name.focus();
 return ;
 }
 else if(frm.street.value == '')
 {
 alert('Please enter property address');
 frm.street.focus();
 return ;
 }
 else if(frm.city.value == '')
 {
 alert('Please enter city');
 frm.city.focus();
 return ;
 }
  else if(frm.state.value == '0'||frm.state.value == '')
 {
 
 alert('Please select state');
 frm.state.focus();
 return ;
 }
 else if(frm.divcounty.value == '0'||frm.divcounty.value == '')
 {
 
 alert('Please select County');
 frm.divcounty.focus();
 return ;
 }
 else if(frm.zip.value == '')
 {
 alert('Please enter zipcode');
 frm.zip.focus();
 return ;
 }
 else if(frm.tax_id1.value == '')
 {
 alert('Please enter the TaxID');
 frm.tax_id1.focus();
 return ;
 }
 else if(frm.tax_id2.value == '')
 {
 alert('Please enter the TaxID');
 frm.tax_id2.focus();
 return ;
 }
 else if(frm.units.value == '')
 {
 alert('Please enter the Number of Units');
 frm.units.focus();
 return ;
 }
 else{ 
 tax_two=document.addproperty.elements['tax_id1'].value;
		tax_seven=document.addproperty.elements['tax_id2'].value;
		taxid = tax_two+'-'+tax_seven;
		H.post("index2.php?option=com_camassistant&controller=addproperty&task=verfirytaxid", {queryString: ""+taxid+""}, function(data){
		
		if(data == 'invalid'){
		 var firstline = 'You have entered the Tax Identification for an Existing Property.  If this is your property please, contact your Administrator to have it reassigned to you.';
		 var secondline = 'If the property is not available to the Administrator, please call the CAMassistant Customer Support Team at 516-246-3830, and be prepared to provide a copy of the management agreement for the property to confirm your current status.';
		 var thirdline = firstline+'\n\n'+secondline;
 		alert(thirdline);
		document.addproperty.elements['tax_id1'].value = '';
		document.addproperty.elements['tax_id2'].value = '';
		return;
		}
	else{
	frm.submit();
	}
		});
		}	
 //return;
} 


function CurrencyFormatted(amount)
{
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
} // function CurrencyFormatted()

function CommaFormatted(amount)
{
	var delimiter = ",";
	var a = amount.split('.',2)
	var d = a[1];
	var i = parseInt(a[0]);
	if(isNaN(i)) { return ''; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	var n = new String(i);
	var a = [];
	while(n.length > 3)
	{
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}
	if(n.length > 0) { a.unshift(n); }
	n = a.join(delimiter);
	if(d.length < 1) { amount = n; }
	else { amount = n + '.' + d; }
	amount = minus + amount;
	amount = amount.split('.',2)
	amount = amount[0];
	return amount;
	
} // function CommaFormatted()

function unitsno()
{
	var s = new String();
	s = CurrencyFormatted(document.addproperty.units.value);
	s = CommaFormatted(s);
	document.addproperty.units.value = s;
}

 function moveOnMax(field,nextFieldID){
  if(field.value.length >= field.maxLength){
  document.getElementById(nextFieldID).focus();
  G("#"+divid+countyLen).load(site+'components/com_camassistant/helpers/common.php?id='+id+'&type=states&flag=1&path='+path+'&Fid='+divid+'&Len='+countyLen);
  
  }
}

</script>
<script type="text/javascript">
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var xhReq = createXMLHttpRequest();
var countyCount = 0;
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
function county(){
var state = H("#stateid").val();
H.post("index2.php?option=com_camassistant&controller=addproperty&task=ajaxcounty", {State: ""+state+""}, function(data){
if(data.length >0) {
H("#divcounty").html(data);
}
});

}
  </script>
  
  <script language="javascript" type="text/javascript">
  G = jQuery.noConflict();
function format_val(id,fieldname,fieldvalue){	
G.post("index2.php?option=com_camassistant&controller=proposals&task=vendor_proposal_edit_format_val", {id: ""+id+"",fieldname: ""+fieldname+"",fieldvalue:""+fieldvalue+""}, function(data){
//alert(data);
if(data.length >0) {
var x= fieldname+id;
G("#"+id).val(data);
//E("#task_price1").val(data); 
}
});
}
function add_commas(x,id)
{
	var val = parseFloat(x).toFixed(2)+'',
      rgx = /(\d+)(\d{3}[\d,]*\.\d{2})/;
  while (rgx.test(val)) {
    val = val.replace(rgx, '$1' + ',' + '$2');
  }
document.getElementById(id).value = val;
}
</script>
  <script type="text/javascript">
  
  //Functio to verify taxid by sateesh on 01-08-11
function verifytaxid(){

		tax_two=document.addproperty.elements['tax_id1'].value;
		tax_seven=document.addproperty.elements['tax_id2'].value;
		taxid = tax_two+'-'+tax_seven;
		H.post("index2.php?option=com_camassistant&controller=addproperty&task=verfirytaxid", {queryString: ""+taxid+""}, function(data){
		
		if(data == 'invalid'){
		 var firstline = 'You have entered the Tax Identification for an Existing Property.  If this is your property please, contact your Administrator to have it reassigned to you.';
		 var secondline = 'If the property is not available to the Administrator, please call the CAMassistant Customer Support Team at 516-246-3830, and be prepared to provide a copy of the management agreement for the property to confirm your current status.';
		 var thirdline = firstline+'\n\n'+secondline;
 		alert(thirdline);
		document.addproperty.elements['tax_id1'].value = '';
		document.addproperty.elements['tax_id2'].value = '';
		return false;
		}
	else{
	
	}
		});
	}
  //Functio to verify taxid by sateesh on 01-08-11 completed	
	</script>
<?php
if($usertype == '11'){
echo "No permission";
} else {
?>
<br />
<div id="vender_right">

<!-- sof bedcrumb -->
<div id="bedcrumb" style="display:none">
<ul>
<li class="home"><a href="index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125">Home  </a></li><li><a href="index.php?option=com_camassistant&controller=addproperty&Itemid=75"> Add/Edit A Property or Association Board  </a> </li> <li>Add A Property</li>
</ul>
</div>
<!-- eof bedcrumb -->

<!-- sof dotshead -->
<!-- eof dotshead -->
<div id="i_bar">
<div id="i_bar_txt">
<span><strong>ADD A PROPERTY</strong>   </span>
</div>
<div id="i_icon"><a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=79&amp;Itemid=113"><img src="templates/camassistant_left/images/info_icon2.png" /> </a></div>
</div>

<!-- sof table pan -->
<form action="index.php" method="post" name="addproperty" style="padding:0px; margin:0px;" >
<div class="table_pannel">
<div id="propertin_pop"><label>Property Association Tax ID Number:<span class="redstar">*</span></label>
<p style=" padding:0px; margin:0px; padding-bottom:10px;"></p>
<div class="clear"></div>
<div>
<input id="tax_id1" name="tax_id1" type="text" style="width:30px; text-align:center;" value="" maxlength="2" /> -
<input id="tax_id2" name="tax_id2" type="text" style="width:90px; text-align:center;" value="" maxlength="7" /><br />
        <label id="user-email"></label>
</div>
<div class="signup">
<label>Number of Units:<span class="redstar">*</span> </label>
<input id="units" name="units" type="text" style="width:100px;" value="" onblur="unitsno()"/>
<?php /*?><input id="units" name="units" type="text" style="width:100px;" value="" onblur=""="javascript:format_val('units','units',this.value)" onchange="javascript:format_val('units','units',this.value)"  /><?php */?>
</div>
<div class="clear"></div>
</div>
<div class=""> 



</div>


  <div id="signup-form">

<div class="signup">
<label>Property Association Name:<span class="redstar">*</span> </label>
<input name="property_name" type="text" style="width:275px;" />
</div>


<div class="signup">
<label>Property Address:<span class="redstar">*</span></label>
<input name="street" type="text" style="width:275px;" value=""/>
</div>

<div class="signup">
<label>City:<span class="redstar">*</span></label>
<input name="city" type="text" style="width:275px;" value="" />
</div>

<div class="signup">
<label>State:<span class="redstar">*</span> </label>
<select name="state" style="width:282px;" id="stateid" onchange="javascript:county();" >
<option value="">Select State</option>
  <?php 
for ($i=0; $i<count($this->states); $i++){
$states = $this->states[$i];
?>
<option value="<?php echo $states->state_id?>"><?php echo $states->state_name?></option>
<?php } ?>
</select>
</div>
<div class="signup">
<label>Please Select County:<span class="redstar">*</span> </label>
<select style="width: 252px;" name="divcounty" id="divcounty" >
<option value="">Please Select County</option>
</select>
</div>
<div class="signup">
<label>Zip Code:<span class="redstar">*</span> </label>
<input name="zip" type="text" style="width:275px;" value="" maxlength="5"/>
</div>
<!--<div class="signup">
<label>Add Board Member:<span class="redstar">*</span> </label>
<select name="bmember" style="width:282px;">
  <?php 
//for ($i=0; $i<count($this->bmembers); $i++){
//$bmembers = $this->bmembers[$i];
?>
<option value="<?php //echo $bmembers->id; ?>"><?php //echo $bmembers->firstname.",&nbsp;".$bmembers->lastname?></option>
<?php //} ?>
</select>
</div>-->

<div class="clear"></div>

<div class="signup">
<br  />
<div id="share">
<strong>CC: this Property`s Proposals to:</strong><br />

</div>(separate multiple emails with a comma)
<label>
<?php //echo $this->bmembers1; ?>
  <textarea name="cc" cols="37" rows="2" class="other_tfield" id="addmembers"></textarea>
</label>
	
</div>
<div class="signup" style="margin-top:80px;">
<div id="" style="color:gray; border:1px dashed #B8B9BC">NOTE: By default, CAMassistant.com shares the high, low, and awarded proposal prices with the un-awarded vendors who respond to RFPs for this property. This helps the vendors to improve their proposal pricing in the future.<br /><br />
<div><input type="checkbox" value="1" name="share">&nbsp;Turn off this feature for this property</div>
</div>
</div>
<div class="clear"></div>
</div>




<div class="clear"></div><br /><br /><br />

<div id="topborder_row" align="right">
<!--<a href="#"><img src="templates/camassistant_left/images/discardchanges.gif" alt="discard changes" width="182" height="48" /></a>-->
<input type="hidden" name="controller" />
<a href="index.php?option=com_camassistant&controller=addproperty&Itemid=75"><img src="templates/camassistant_left/images/CancelButton.gif" alt="Discard Property" /></a>
<a href="javascript: validate_data();"><img src="templates/camassistant_left/images/saveproperty.gif" alt="add property" /></a></div>
<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" name="usertype" value="<?php echo $usertype; ?>" />
<input type="hidden" name="controller" value="addproperty" />
<input type="hidden" name="task" value="saveproperty" />
<input type="hidden" name="view" value="addproperty" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="Itemid" value="75" />
</form>

<div class="clear"></div>
</div>
</div>
<!-- eof table pan -->

</div>

<?php } ?>