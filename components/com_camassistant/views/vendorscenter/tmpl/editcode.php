<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<?php
$company_css = '<link rel="stylesheet" href="'.$this->baseurl.'/templates/camassistant_left/css/style.css" type="text/css" />';
echo $company_css;
$from = JRequest::getVar('from','');
?>
<script type="text/javascript">
G = jQuery.noConflict();
	G(document).ready(function(){
		G('#current').val('');
		G('#cancelpopup_vendor').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#savecode').click(function(){
			code = G('#code').val();
			cost = G('#cost').val();
			codeid = G('#codeid').val();
			renewtype = G('#renewtype').val();
		
			if(!code){
				alert("Please enter code.");
				G( "#code" ).focus();
				return false;
			}
			else if (code.match(/\s/g)){
				alert('Please remove spaces and enter the code again.');
				}
			else if(code){
				G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkeditcode&codeid="+codeid+"", {newcode: ""+code+""}, function(data){
			
				if( G.trim(data) == 'yes' )
				{
					existingcode();
					return false;
				}
				else{
						if(!cost){
							alert("Please enter cost.");
							G( "#cost" ).focus();
							return false;
						}
						else if(!renewtype || renewtype=='0'){
							alert("Please select Renewal Period.");
							return false;
						}
						else{
						format_val(cost);	
						G('#addcodeform').submit();
						}
				}
				});
			}
		 	
			 
		});
	});
	
	function existingcode(){
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

	function format_val(fieldvalue){
	var i=0;
	var ValidData="0123456789.,";
	var Data=fieldvalue;
	if(fieldvalue != "")
		for(i=0;i<Data.length;i++)
		{
			if(ValidData.indexOf(Data.charAt(i))==-1)
			{
				if( i == 0 ){
				alert ("Please enter numerals and decimal point only.");
				return false;
				}
				
			}
			else{
				G.post("index2.php?option=com_camassistant&controller=proposals&task=vendor_proposal_edit_format_val", {fieldvalue:""+fieldvalue+""}, function(data){
				if(data.length >0) {
				G("#cost").val(data);
				}
				});
			}
		}
	
	
	}	
</script>
<script type="text/javascript">
G = jQuery.noConflict();
G(document).ready(function () {

G('#code').keyup(function(){
if( G(this).val() == '' )
		G( this ).prev().addClass( 'active' );
		else
		G( this ).prev().removeClass( 'active' );
		
});
});
</script>

<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>
<?php
$codeinfo = $this->codeinfo;
?>
<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">EDIT CODE</font></span>
</div></div>
<p class="addcode_text">You may edit the "Code" and "Vendor Purchasing Requirements" only. If you'd like to revise the "Cost" or "Renewal Period", you'll need to create a new code and have your Vendors repurchase to agree to the new conditions.</p>
<form action="#" method="post" id="addcodeform">
<div class="addingcodesform">
<ul class="adduls">
<li><label class="green-arrow-addcodes">
<strong>Code</strong> (this will be entered by Vendor to purchase)</label><input type="text" name="code" id="code" value="<?php echo $codeinfo->code; ?>" /></li>
<li>

<label class="green-arrow-addcodes"><strong>Cost</strong> (how much the Vendor will pay)</label>
<select name="cost" id="cost" disabled="disabled">
<option value="None" <?php if( $codeinfo->cost == 'None' ) { echo "selected"; } ?>>Select Cost</option>
<option value="0.00" <?php if( $codeinfo->cost == '0.00' ) { echo "selected"; } ?>>$0</option>
<option value="25.00" <?php if( $codeinfo->cost == '25.00' ) { echo "selected"; } ?>>$25</option>
<?php for( $c=30; $c<=200; $c = $c+5 ) { ?>
<option value="<?php echo $c.'.00' ?>" <?php if( $codeinfo->cost == $c.'.00' ) { echo "selected"; } ?>>$<?php echo $c; ?></option>
<?php } ?>
</select>

</li>
<li>
<label class="green-arrow-addcodes"><strong>Renewal Period</strong> (how often Vendor will be charged)</label>
<select name="renewtype" id="renewtype" disabled="disabled">
<option value="0">Select Renewal Period</option>
<option <?php if( $codeinfo->renewtype == 'none' ) { echo "selected"; } ?> value="none">None</option>
<option <?php if( $codeinfo->renewtype == 'annual' ) { echo "selected"; } ?> value="annual">Annual</option></select>
</li>

<li class="vendorcompliance">

<label class="green-arrow-addcodes"><strong>Vendor Purchasing Requirements</strong></label>
<select name="reqs" id="reqs" class="purchase_reqs" style="font-size:13px;">
<option <?php if( $codeinfo->purchase_reqs == '0' ) { echo "selected"; } ?> value="0">None</option>
<option <?php if( $codeinfo->purchase_reqs == '1' ) { echo "selected"; } ?> value="1" >Vendor must have Verified Compliance Documents</option>
</select>
</li>

<li>
<a id="cancelpopup_vendor" href="javascript:void(0);" class="cancel_pcode_edit"></a>
<a id="savecode" href="javascript:void(0);" class="save_pcode_edit"></a></li>
</ul>
</div>
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="vendorscenter">
<input type="hidden" name="task" value="savecodeinfo">
<input type="hidden" name="action" value="update">
<input type="hidden" name="codeid" id="codeid" value="<?php echo $codeinfo->id; ?>">
<input type="hidden" name="createdate" value="<?php echo $codeinfo->created_date; ?>">
<input type="hidden" name="renewtype" value="<?php echo $codeinfo->renewtype; ?>">
<input type="hidden" name="cost" value="<?php echo $codeinfo->cost; ?>">
</form>

<div id="boxesex" style="top:576px; left:582px;">
<div id="submitex" class="windowex" style="top:300px; left:582px; border:6px solid red; position:fixed">
<div id="i_bar_terms" style="background:none repeat scroll 0 0 red;">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">ERROR</font></span>
</div></div>
<div style="text-align:justify"><p class="existcodemsg">The Code you entered already exists in our system. Please enter a new code and try again.</p>
</div>
<div style="padding-top:30px;" align="center">
<div id="cancelex" name="doneex" value="Ok" class="existing_code_preferred"></div>
</div>
</div>
  <div id="maskex"></div>
</div>

<?php
exit;
?>