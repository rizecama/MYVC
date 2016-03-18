<?php
$rfpno = JRequest::getVar('rfpno','');
$proposalid = JRequest::getVar('proposalid','');
$shareinfo = JRequest::getVar('shareinfo','');
$awardedto = JRequest::getVar('awardedto','');
$am = $this->vendorinfo;
$globals = $this->globals ;
$outinfo = $this->out_vendorinfo;

if( $awardedto == 'in' ){
	$task = 'awardedsuccess';
	$finalprice = $am[0]->proposal_total_price;
	}
else{
	$task = 'outsidevendorsuccess';	
	$finalprice = $outinfo->amount;
	}
//echo "<pre>";	 print_r($this->out_vendorinfo); echo "</pre>";

?>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script>
	N = jQuery.noConflict();
	N(document).ready(function() {	
	
	N('.award_laststep').click(function(){
		
				var maskHeight = N(document).height();
				var maskWidth = N(window).width();
				N('#maskshare').css({'width':maskWidth,'height':maskHeight});
				N('#maskshare').fadeIn(100);
				N('#maskshare').fadeTo("slow",0.8);
				var winH = N(window).height();
				var winW = N(window).width();
				N("#submitshare").css('top',  winH/2-N("#submitshare").height()/2);
				N("#submitshare").css('left', winW/2-N("#submitshare").width()/2);
				N("#submitshare").fadeIn(2000);
				N('.windowshare #doneshare').click(function (e) {
					N('#shareinfo').val('yes');
					e.preventDefault();
					N('#maskshare').hide();
					N('.windowshare').hide();
					N('.mail_save').submit();
					
				});
					N('.windowshare #closeshare').click(function (e) {
					N('#shareinfo').val('no');
					e.preventDefault();
					N('#maskshare').hide();
					N('.windowshare').hide();
					N('.mail_save').submit();
					
				});

		
	});
	N('.cancel_award').click(function(){
	rfpid = N('#rfpno').val();
	N.post("index2.php?option=com_camassistant&controller=rfpcenter&task=deleteeditmailtext", {rfpno: ""+rfpid+""}, function(data){
	window.location = 'index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125';	
	});
	});
	
	});
function getstandards(rfpid,vendorid,status){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=rfp&task=getcompliance&rfpid='+rfpid+'&vendorid='+vendorid+'&status='+status+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:700}}"))
	SqueezeBox.fromElement(el,options);
G("#sbox-window").addClass("newclasssate");	
}	

function unverified(vendorid,type){
if(type == 'unverified')
var height = '290';
else
var height = '230';
var el ='index.php?option=com_camassistant&controller=rfpcenter&task=vendortype&vendorid='+vendorid+'&type='+type;
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:"+height+"}}"))
SqueezeBox.fromElement(el,options);
}

function preferredcompliancebasic(vendorid,status){
el='<?php  echo Juri::base(); ?>index.php?option=com_camassistant&controller=vendorscenter&task=preferredcompliance&vendorid='+vendorid+'&status='+status+'';
	var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:700}}"))
	SqueezeBox.fromElement(el,options);
G("#sbox-window").addClass("newclasssate");	
}
	
</script>
<style>
#maskshare {  position:absolute;  left:0;  top:0;  z-index:9000;  background-color:#000;  display:none;}
#boxesshare .windowshare {  position:absolute;  left:0;  top:0;  width:1300px;  height:150px;  display:none;  z-index:9999;  padding:38px 10px 3px 10px;}
#boxesshare #submitshare {  width:550px;  height:250px;;  padding:20px;  background-color:#ffffff;}
#doneshare {  border: 0 none;  cursor: pointer;  float: right;  height: 30px;  margin: -31px -5px;  text-align: left;  width: 50%;}
#closeshare {  border: 0 none;  color: #000000;  cursor: pointer;  font-size: 20px;  font-weight: bold;  height: 30px;  margin: 1px 4px 0 0px;  text-align: right;  width: 50%;}

</style>

<p style="height:20px;"></p>
<div align="center"><img src="templates/camassistant_left/images/award_step3.png"></div>
<p style="height:30px;"></p>
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">SELECTED VENDOR</font></span>
</div></div>
<div id="heading_vendors_award">
<div class="company_vendor_award">COMPANY</div>
<div class="apple_vendor_award">APPLE RATING</div>
<div class="compliant_vendor_award">COMPLIANCE STATUS</div>
<div class="checkbox_vendor_award">PRICE</div>
</div>
<div id="preferredvendorsinvitations">
	<div class="search-panel-left_rfp_award company_vendor_award">
	<?php if( $awardedto == 'in' ){ ?>
	<ul>
	<li></li>
	<li><strong>
	<a href="index.php?option=com_camassistant&controller=vendors&task=vendordetailslayout&id=<?php echo $am[0]->proposedvendorid; ?>" target="_blank"><?php echo $am[0]->company_name; ?></a></strong></li>
	<li><?php echo $am[0]->name; ?> <?php echo $am[0]->lastname; ?>: <?php echo $am[0]->company_phone; ?>	<?php if($am[0]->phone_ext){ echo "&nbsp;Ext.".$am[0]->phone_ext; } ?></li>
	<li><?php echo $am[0]->city; ?>,&nbsp;<?php echo strtoupper($am[0]->statename); ?></li>
	<li><a style="color:gray; font-weight:normal"  href="mailto:<?php echo $am[0]->email; ?>?cc=support@myvendorcenter.com"><?php echo $am[0]->email; ?></a></li>
	</ul>
	<?php } else{ ?>
	<ul>
	<li></li>
	<li><strong><?php echo $outinfo->companyname; ?></strong></li>
	<li><?php echo $outinfo->contactname; ?>: <?php echo $outinfo->phonenumber; ?></li>
	<li><a style="color:gray; font-weight:normal"  href="mailto:<?php echo $outinfo->emailid; ?>"><?php echo $outinfo->emailid; ?></a></li>
	</ul>
	<?php } ?>
	</div>
	<div class="search-panel-right_rfp_award apple_vendor_award" style="padding-left:7px;">
	 <?php if( $awardedto == 'in' ){ ?>
	<img width="130" src="templates/camassistant_left/images/<?php echo $am[0]->rating; ?>" />
	<?php } else{ ?>
	N/A
	<?php } ?>
	</div>		
	<div class="search-panel-image_rfp_award compliant_vendor_award" style="padding-left:25px;">
	<?php 
	if($existing_stand == 'no'){
		$compliant_id = "nostandards";
		$images_text = 'N/A';
	}
	else {
		if($am[0]->special_requirements == 'fail') {
			$compliant_id = "noncompliant";
			$title = 'Non-Compliant';
		}
		else {
			$compliant_id = 'compliant';			
			$title = 'Compliant';
		}
	}	
	?>
	<?php if( $awardedto == 'in' ){ ?>
	<p align="center" style="color:; display:block; margin-bottom:7px; font-weight:bold; display:block !important;">
	<?php if($globals != 'fail'){ 
	if( $am[0]->jobtype == 'basic' ){ ?>
	<a href="javascript:void(0);" id="<?php echo $compliant_id; ?>" onclick="preferredcompliancebasic('<?php echo $am[0]->proposedvendorid; ?>','<?php echo $title; ?>');" title="<?php echo $title; ?>"><?php //echo $text; ?></a>
	<?php } else { ?>
	<a href="javascript:void(0);" id="<?php echo $compliant_id; ?>" onclick="getstandards('<?php echo $am[0]->rfpno; ?>','<?php echo $am[0]->proposedvendorid; ?>','<?php echo $title; ?>');" title="<?php echo $title ; ?>"><?php echo $images_text ; ?></a>
	<?php }
	} else {
	echo "N/A";
	}?>
	</p>
	
	<?php
	if( $am[0]->subscribe_type == 'free' ) { ?>
	<div class="unverifiedvendor_award"><a href="javascript:void(0);" onclick="unverified(<?php echo $am[0]->proposedvendorid; ?>,'unverified');" title="Click for more info">UNVERIFIED</a></div>
	<?php } else {  ?>
	<div class="verifiedvendor_award"><a href="javascript:void(0);" onclick="unverified(<?php echo $am[0]->proposedvendorid; ?>,'verified');" title="Click for more info">VERIFIED</a></div>
	<?php } ?>
	<?php } else{ ?>
	<br />N/A
	<?php } ?>
	</div>
<div class="search-panel-middlepre_award checkbox_vendor_award">
	<?php if( $awardedto == 'in' ){ ?>
	<a class="priceaward" href="index.php?option=com_camassistant&controller=rfpcenter&task=vendor_proposal_preview_tomanager&Alt_Prp=<?php echo $am[0]->Alt_bid; ?>&Proposal_id=<?php echo $am[0]->id; ?>&vendor_id=<?php echo $am[0]->proposedvendorid; ?>&rfp_id=<?php echo $am[0]->rfpno; ?>&job=<?php echo $am[0]->jobtype; ?>" target="_blank"><strong><?php echo "$". number_format($am[0]->proposal_total_price,2); ?></strong></a>
	<?php } else{ ?>
	<br /><?php echo "$". number_format($outinfo->amount,2); ?>
	<?php } ?>
		
      </div>	  
	  
    <div class="clr"></div>
  </div>
<p style="height:30px;"></p>
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;">AWARD NOTIFICATION TO VENDOR</font></span>
</div></div>
<div class="detailsextra">
<div class="awardjobmailedit"><?php echo html_entity_decode(str_replace('{devider}','',$this->message)); ?> 
</div>


</div>
<div class="mainformbuttons">
<a href="javascript:void(0);" class="cancel_award"></a>
<a href="javascript:void(0);" class="award_laststep"></a>
</div>
<form class="mail_save" method="post">
<input type="hidden" name="rfpno" value="<?php echo $rfpno; ?>" id="rfpno" />
<input type="hidden" name="proposalid" value="<?php echo $proposalid; ?>" />
<input type="hidden" name="shareinfo" id="shareinfo" value="" />
<input type="hidden" name="awardedto" value="<?php echo $awardedto; ?>" />
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="rfpcenter" name="controller">
<input type="hidden" value="<?php echo $task; ?>" name="task">
<input type="hidden" value="<?php echo number_format($finalprice,2); ?>" name="v_price">

</form>


<div id="boxesshare" class="boxesshare">
<div id="submitshare" class="windowshare" style="top:300px; left:582px; border:6px solid #609e00; position:fixed;">
<div id="i_bar_terms">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">UNAWARDED VENDORS</font></span>
</div></div>
<p align="center" style="color:gray; font-size:14px; border-bottom:2px dotted; text-align:justify; padding-bottom:25px;">Would you like to include the <strong>High, Low, and Awarded proposal amounts</strong> in the rejection email to the participating Vendors who were <strong>not</strong> awarded this project?</p>
<span style="border-bottom:dotted 2px gray;"></span>
<p align="center" style="color:gray; font-size:13px; padding-top:7px; text-align:justify;"><strong>Note:</strong> This information can be used by the Vendors to provide more competitive pricing in the future. Also, only the dollar amounts will be shared. No Vendor names or total number of Vendors participating will be included.</p>
<div style="padding-top:30px; text-align:center;">
<form name="edit" id="edit" method="post">
<div id="closeshare" name="closeshare" value="Cancel"><a href="javascript:void(0);" class="noawardjob"></a></div>
<div id="doneshare"  name="doneshare" value="Ok"><a href="javascript:void(0);" class="yesawardjob"></a></div>
</div>
</form>

</div>
  <div id="maskshare"></div>
</div>