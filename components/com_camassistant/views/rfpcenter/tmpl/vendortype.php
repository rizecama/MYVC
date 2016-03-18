<?php
$type = JRequest::getVar("type",'');
$vendorid = JRequest::getVar("vendorid",'');
$from = JRequest::getVar("from",'');

if( $type == 'unverified' || $type == 'un' ){
	$title_header = 'UNVERIFIED';
	$color = 'red';
}
else if( $type == 'nonc' ){
	$title_header = 'NON-COMPLIANT';
	$color = '#77b800';
}
else if( $type == 'both' ){
	$title_header = 'NON-COMPLIANT + UNVERIFIED';
	$color = '#77b800';
}
else{
	$title_header = 'VERIFIED';
	$color = '#77b800';
}

?>
<link rel="stylesheet" href="<?php echo juri::base(); ?>templates/camassistant_left/css/style.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
H(document).ready( function(){
H('#oknewsmall').click(function(){
window.parent.document.getElementById( 'sbox-window' ).close();		
});
H('.sendrequest').click(function(){
	requesttype = H(this).attr('rel');
//	alert(requesttype);
		if( requesttype == 'un' ){
			H('#tasktype').val('sendactivationrequest');
			H('#failtype').val(requesttype);
			}
		else if( requesttype == 'nonc' || requesttype == 'both'){
			H('#tasktype').val('sendacompliancerequest');
			H('#failtype').val(requesttype);
			}
	H("#rolloverimage").show();
	H('#unverifiedform').submit();
	H(".buttonfile").hide();
	
	/*H.post("index2.php?option=com_camassistant&controller=rfpcenter&task=sendactivationrequest", {vendorid: <?php echo $vendorid; ?>}, function(data){
		if( data ){
		window.parent.document.getElementById( 'sbox-window' ).close();					
		}
	});*/
});
	});
</script>
<div id="i_bar_terms" style="margin:20px 20px 10px; background:none repeat scroll 0 0 <?php echo $color; ?>">
<div id="i_bar_txt_terms" style="padding-top:8px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:bold; color:#FFF;"><?PHP echo $title_header; ?></font></span>
</div></div>

<div class="vendortypebody">
<?php if( $type == 'unverified' ) { ?>
<p>Please be aware that due to this vendor choosing an unverified account, the compliance documents entered by this vendor have NOT been verified for accuracy by the MyVendorCenter compliance team. This means there is a chance the vendor has uploaded one or more incorrect documents, expired policies, or provided incorrect information (i.e. policy amounts, types of coverage). We highly recommend you verify all documents and information entered by this vendor manually, or click the button below to ask this vendor to change their account to obtain a verified status.</p>
<br /><br /> 
<div class="buttonfile"><a href="javascript:void(0);" class="sendrequest" id="requestverified"></a></div>
<div id="rolloverimage" style="display:none;"></div>
<?php } 
else if( $type == 'un' ) { ?>
<p>This Vendor has been BLOCKED by your Company's Master Account holder because they have an account that does NOT include verified Compliance Documents. You may click the button below to request this Vendor change their account to become verified.</p>
<br /><br /> 
<div class="buttonfile"><a href="javascript:void(0);" class="sendrequest" id="requestverified"></a></div>
<div id="rolloverimage" style="display:none;"></div>
<?php } 
else if( $type == 'nonc' ){ ?>
	<p class="noncompliance">This Vendor has been blocked by the Master Account holder because they have elected to block all Non-Compliant Vendors.  You may click the button below to request this Vendor to become compliant with your company's Compliance Standards.</p>
	<br /><br /> 
	<div class="buttonfile"><a href="javascript:void(0);" class="sendrequest" id="requestcompliance"></a></div>
	<div id="rolloverimage" style="display:none;"></div>

<?php }
else if( $type == 'both' ){ ?>
	<p class="noncompliance">This Vendor has been blocked by the Master Account holder because they have elected to block all Non-Compliant and Unverified Vendors. You may click a button below to request this Vendor change their account to become Verified, meet your company's Compliance Standards, or both.</p>
	<br />
	<div class="buttonfile">
	<ul>
	<li><a href="javascript:void(0);" class="sendrequest" rel="un" id="requestverified"></a></li>
	<li><a href="javascript:void(0);" class="sendrequest" rel="nonc" id="requestcompliance"></a></li>
	<li><a href="javascript:void(0);" class="sendrequest" rel="both" id="requestverifiedcompliance"></a></li>
	</ul>
	</div>
	<div id="rolloverimage" style="display:none;"></div>

<?php }
else { ?>
<p>The compliance documents entered by this vendor have been verified for accuracy by the MyVendorCenter compliance team.</p>
<br /><br /> 
<div align="center"><a href="javascript:void(0);" class="" id="oknewsmall"></a></div>
<?php } ?>
</div> 
<?php
	if( $type == 'nonc' || $type == 'both' )
	$task = 'sendacompliancerequest';
	else
	$task = 'sendactivationrequest';
?>
<form name="unverifiedform" id="unverifiedform" method="post">
<input type="hidden" value="com_camassistant" name="option" />
<input type="hidden" value="rfpcenter" name="controller" />
<input type="hidden" value="<?php echo $task; ?>" name="task" id="tasktype" />
<input type="hidden" value="<?php echo $vendorid; ?>" id="vendorid" name="vendorid" />
<input type="hidden" value="<?php echo $from; ?>" id="from" name="from" />
<input type="hidden" value="<?php echo $type; ?>" id="failtype" name="fails" />
</form>
<?php 
exit; ?>