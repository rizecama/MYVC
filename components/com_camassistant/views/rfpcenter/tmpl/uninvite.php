<link rel="stylesheet" href="<?PHP echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready( function(){ 
	
	H('.newreminder_continue').click(function(){
			var counte = 0 ;
			H(".allvendors:checked").each(function() {
			counte++ ;
			});
			if(counte == '0')
			{
			alert("Please make a selection to un-invite the vendors.");
			}
			else 
			{
			H("#rolloverimage").css('padding-top','50px');
			H("#rolloverimage").show();
			H(".buttons_uninvite").hide();
			H('#uninviteform').submit();
			}
	});
	
	H('.newcancel').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();		
	});
	H('.oknewsmall_noprps').click(function(){
	window.parent.document.getElementById( 'sbox-window' ).close();		
	});
	
});
</script>
<?php
$rfpid = JRequest::getVar('rfpid','');
//echo "<pre>"; print_r($this->drafts); echo "</pre>";
$drafts = $this->drafts ;
$any = JRequest::getVar('any','');
?>	
<form action="" method="post" name="uninviteform" id="uninviteform">
<div id="reminder">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;">UN-INVITE VENDORS</font></span>
</div></div>
<?php if($any == 'yes') { ?>
<div class="uninvited_firstdd_text">
<span>Please choose which Vendors you would like to un-invite</span>
<p class="bordertopclass">Note: Only Vendors who have not declined their invitation or submitted a proposal can be uninvited from a request.</p></div>
<div class="inputoptions">
<?php } 
else{ ?>
<div class="uninvited_firstdd_text" style="padding-top:11px;">
<span>Sorry, but none of the invited Vendors can be uninvited from this request</span>
<p class="bordertopclass">Note: Only Vendors who have not declined their invitation or submitted a proposal can be uninvited from a request.</p></div>
<div class="inputoptions" style="min-height:0px;">
<?php } ?>

<?php 
$dec = 0;
if($drafts){
	for( $d=0; $d<count($drafts); $d++ ){ 
			if( $drafts[$d]->declined == 'yes' ){
				$dec = $dec + 1 ;
			}
	}
}	
if( $dec == count($drafts) ){
}

else if( $dec != count($drafts) ) {
	if($drafts){
for( $i=0; $i<count($drafts); $i++ ){ 
		if( $drafts[$i]->declined != 'yes' ){
?>
<div class="inoutoptions_single">
<input type="checkbox" value="<?php echo $drafts[$i]->proposedvendorid; ?>" name="vendors[]" class="allvendors" />
<?php echo $drafts[$i]->company_name; ?>
</div>
<?php } 
			}
		}
		else { 
		//echo "<p style='margin-top:-6px;'>Sorry, but you don't have any invited Vendors who are eligible for being uninvited.</p>";
		}	 
	}
	
	?>
	</div>
<?php 
if( $dec == count($drafts) ){ ?>
<a id="" href="#" class="oknewsmall_noprps" style="margin-top:-14px;"></a>
<?php } 
else if( $dec != count($drafts) ) {
	if($drafts){	 ?>
<div class="buttons_uninvite">
<a class="newcancel" style="padding:0px; margin:0px;" href="javascript:void(0);"></a>
<a class="newreminder_continue" href="javascript:void(0);" style="padding:0px; margin:0px;"></a>
</div>
<?php } else { ?>
<a id="" href="#" class="oknewsmall_noprps" style="margin-top:-14px;"></a>
<?php } 
}
?>
<div id="rolloverimage" style="display:none;"></div>	
</div>
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="rfpcenter" name="controller" />
<input type="hidden" value="send_uninvite" name="task" />
<input type="hidden" value="<?php echo $rfpid; ?>" name="rfpid" id="rfp_id" />
</form>
<?php exit; ?>