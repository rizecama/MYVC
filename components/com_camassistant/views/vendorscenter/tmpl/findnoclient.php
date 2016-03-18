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
H('.yesinvitationtoclient').click(function () {
H( "#yesinvitationtoclient" ).submit();
//window.parent.document.getElementById( 'sbox-window' ).close();	

 });
 
H('.noinvitationtoclient').click(function () {
window.parent.document.getElementById( 'sbox-window' ).close();	
window.parent.location.reload();
 });
 
 });
 


</script>

<?php 
$propertyid = JRequest::getVar('pid','');
$boardmemeberid = JRequest::getVar('bid','');
$clientemail = JRequest::getVar('email','');
$title = JRequest::getVar('title','');

$db= JFactory::getDBO();
$user=JFactory::getUser();	
$propertyname = "SELECT property_name FROM #__cam_property where id='".$propertyid."'";
$db->setQuery( $propertyname );
$propertyname = $db->loadResult();

$clientid= "SELECT id FROM #__users where email='".$clientemail."'";
$db->setQuery( $clientid );
$clientid = $db->loadResult();

?>
<div id="sendinvitetonoclient">
<div id="i_bar_terms">
<div id="i_bar_txt_terms" style="padding-top:10px; font-size:14px;">
<span style="font-size:14px;"> <font style="font-weight:800; color:#FFF;">LINK WITH YOUR CLIENT</font></span>
</div></div>
<div class="findnoclientnew" style="padding-top:13px;">
<p class="client_found" align="center" style="font-size:15px; text-align: center; padding-left: 49px; padding-right:33px; width:478; line-height:20px;"><b>Client Found!</b> Are you sure you want to LINK your Client's account with <strong><?php echo str_replace('_',' ',$propertyname);?>?</strong></p>
<div id="topborderforclient"></div>
<p style="font-size:14px;padding-left:13px;text-align: left; max-width: 524px;">IMPORTANT: If you click YES, your Client will automatically be sent a confirmation to accept your request to LINK. If they accept, you will then be able to set client permissions with your "MY CLIENTS" page to begin collaborating.
</p>
</div>

<div class="linkinvitetoclient">
<form action=""  method="post" name="yesinvitationtoclient" id='yesinvitationtoclient' enctype="multipart/form-data" style="padding:0; margin:0;">

<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="vendorscenter" />
<input type="hidden" name="propertyname" value="<?php echo $propertyname;?>" />
<input type="hidden" name="propertyownerid" value="<?php echo $clientid;?>" />
<input type="hidden" name="task" value="sendinvitationtoclient" />
</form>
<div class="noinvitationtoclient"></div>
<div class="yesinvitationtoclient"></div>
</div>

<?php exit; ?>
