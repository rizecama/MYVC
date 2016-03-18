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
		G('#cancelpopup').click(function(){
			window.parent.document.getElementById( 'sbox-window' ).close();
		});
		G('#savecode').click(function(){
			code = G('#code').val();
			cost = G('#cost').val();
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
				G.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkcode", {newcode: ""+code+""}, function(data){
			
				if( G.trim(data) == 'yes' )
				{
					G( "#code" ).val('');
					existingcode();
					return false;
				}
				else{
						if(cost == 'None'){
							alert("Please select cost.");
							G( "#cost" ).focus();
							return false;
						}
						else if( (!renewtype || renewtype=='0') && cost != '0.00'){
							alert("Please select Renewal Period.");
							return false;
						}
						else{
						format_val(cost);	
						G("#rolloverimage").show();
						G("#buttons_uninvite").hide();
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
		G( "#code" ).focus();
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
	function getchanges(cost){
		if( cost == '0.00' ){
			G('.default').hide();
			G('select option[value="none"]').attr("selected",true);
			G('.annual').hide();
			G('.none').show();
		}
		else {
			G('.default').hide();
			G('.none').hide();
			G('select option[value="annual"]').attr("selected",true);
			G('.annual').show();
		}
		
	}	
</script>

<style>
#maskex { position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesex .windowex {  position:absolute;  left:0;  top:0;  width:350px;  height:150px;  display:none;  z-index:9999;  padding:20px;}
#boxesex #submitex {  width:450px;  height:190px;  padding:10px;  background-color:#ffffff;}
#boxesex #submitex a{ text-decoration:none; color:#000000; font-weight:bold; font-size:20px;}
#doneex {border:0 none;cursor:pointer;padding:0; color:#000000; font-weight:bold; font-size:20px; margin:0 auto; margin-top:6px;}
#closeex {border:0 none;cursor:pointer;height:30px;margin-left:59px;padding:0;float:left;}
</style>

<div id="i_bar_terms" style="margin:20px 20px 0px 20px; font-size:15px;">
<div id="i_bar_txt_terms" style="padding-top:7px;">
<span> <font style="font-weight:bold; color:#FFF;">CREATE A NEW CODE</font></span>
</div></div>
<p class="addcode_text">Please create your Preferred Vendor Code by filling in the required fields below. Once a Vendor purchases your code, they will be automatically added to your Preferred Vendors list. Each Vendor will be automatically charged per the "Renewal Period" you select below in order to remain a Preferred Vendor.</p>
<form action="#" method="post" id="addcodeform">
<div class="addingcodesform">
<ul class="adduls">
<li><label>
<div class="red-arrow-addcodes"><img src="templates/camassistant_left/images/arrow_preferred.png" alt=""></div>
<strong>Code</strong> (this will be entered by Vendor to purchase)</label><input type="text" name="code" id="code" value="" /></li>
<li>
<div class="red-arrow-addcodes"><img src="templates/camassistant_left/images/arrow_preferred.png" alt=""></div>
<label><strong>Cost</strong> (how much the Vendor will pay)</label>
<select name="cost" id="cost" onchange="getchanges(this.value);">
<option value="None">Select Cost</option>
<option value="0.00">$0</option>
<option value="25.00">$25</option>
<?php for( $c=30; $c<=200; $c = $c+5 ) { ?>
<option value="<?php echo $c.'.00' ?>">$<?php echo $c; ?></option>
<?php } ?>
</select>
</li>
<li>
<div class="red-arrow-addcodes"><img src="templates/camassistant_left/images/arrow_preferred.png" alt=""></div>
<label><strong>Renewal Period</strong> (how often Vendor will charged)</label>
<select name="renewtype" id="renewtype" class="renewtype_price">
<option value="0" class="default">Select Renewal Period</option>
<option value="none" class="none">None</option>
<option value="annual" class="annual">Annual</option>
</select>
</li>

<li class="vendorcompliance">
<div class="red-arrow-addcodes"><img src="templates/camassistant_left/images/arrow_preferred.png" alt=""></div>
<label><strong>Vendor Purchasing Requirements</strong></label>
<select name="reqs" id="reqs" class="purchase_reqs" style="font-size:13px;">
<option value="0">None</option>
<option value="1" style="font-size:13px;">Vendor must have Verified Compliance Documents</option>
</select>
</li>


<li id="buttons_uninvite">
<a id="cancelpopup" href="#" class="cancel_pcode_edit"></a>
<a id="savecode" href="#" class="save_pcode_edit"></a>
</li>
</ul>
</div>
<div id="rolloverimage" style="display:none;"></div>
<input type="hidden" name="option" value="com_camassistant">
<input type="hidden" name="controller" value="vendorscenter">
<input type="hidden" name="task" value="savecodeinfo">
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