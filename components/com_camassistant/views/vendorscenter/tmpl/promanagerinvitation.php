<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script language="JavaScript" type="text/javascript" src="components/com_camassistant/assets/wysiwyg_award.js"></script>
<script type="text/javascript">
  //Functio to verify taxid by sateesh on 03-08-11
H = jQuery.noConflict();
var site='<?php echo JURI::root();?>';
var path='<?php echo addslashes(JPATH_SITE);?>';
var countyCount = 0;
H(document).ready(function(){
H("#semdInvitation").click(function(e){
e.preventDefault();
		var form = document.inviteform;
		var email=H("#email").val();
		var ccemail=H("#ccemail").val();
		var property_name = H("#property_name").val();
		var subject = H("#subject").val();
		var ccemail_split = (ccemail).split('.com');	
		
		var s = ccemail_split;
		var re = /,/g;
		for( var c = 0; re.exec(s); ++c );
		var mail=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		if(!property_name || property_name == '0') {
		alert("Please select property");
		return false;
		}
		
		if(!email){
		alert("Please enter email");
		form.email.focus();
		return false;
		}
		if(mail.test(email)==false)
		 {
		 alert("Please enter a proper email address.");
		 form.email.focus();
		 return false;
		 }
		 if(!subject)
		 {
		 alert("Please enter your subject");
		 form.subject.focus();
		 return false;
		 }
		 if( H('#editable').val() == 'yes' ){
			alert("Please SAVE or CANCEL the above notification");
			return false;
		}
		/* if(property_name)
		 {
		 H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checkpropertylink", {property_id: ""+property_name+""}, function(data){
		if(data == 1){
		alert("Alerady This Property Linked");
		return false;
		}*/
		if(email)
		 {
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=checktoallemails", {mailid: ""+email+""}, function(data){
		if(data == 1){
		alert("Already user exists with this email");
		return false;
		}
		
		else
        {
     form.submit();
       }
		});
		 }
		/*if(email)
		{
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=usercheck", {mailid: ""+email+""}, function(data){
		var res = Number(data);
		if(data == 1){
		alert("already email exists");
		form.email.focus();
		}
		else
{	
if(ccemail.length > 0) {
if(ccemail_split != '' && c>1){
			for (var i =1; i < ccemail_split.length-1; i++)
			 {		
			   if(ccemail_split[i].charAt(0) != ";"){
				 alert('Please separate the CC Emails with Semi colon(;)');
				 form.ccemail.focus();
				 return false;  
				}
				else{
				form.submit();
				}	
			 }	
			}
}
else
{
form.submit();
}
}
		
	});
		}
		*/
		 
		 
		
				 
	});
	
H('.hidevendor').click(function(){

	vendorid = H(this).attr('rel');
	
		H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=hideinvitation", {hideid: ""+vendorid+""}, function(data){
		if(data){		
		window.location.reload();
		}
	});
	});
});

H('#editoption').live('click',function(){
 H('#editable').val('yes');
 H('#aboutform').show();
 H('.detailsextra').hide();
});

        H(".awardjob_mail").contents().find("body").css("font-size","13px");
		H(".awardjob_mail").contents().find("body").css("font-family","sans-serif");
		H(".awardjob_mail").css("height","200px"); 
		
	
H('#saveoption').live('click',function(){
      H('#editable').val('');
		H('textarea[rel="editor"]').each(function(){
		var n=H(this).attr('id');
		document.getElementById(n).value = document.getElementById("wysiwyg" + n).contentWindow.document.body.innerHTML;
		notesstrings = document.getElementById(n).value ;
		notesstrings = notesstrings.replace("’", "'");
		notesstrings = notesstrings.replace(/[^\u000A\u0020-\u007E]/g, ' ');
		document.getElementById(n).value = notesstrings ;
		});
		if (notesstrings.indexOf("{winning Bid}") < 0)
		{
			//pricepopupbox();
			//alert("Please don't remove the text {winning Bid} from the notification");
			H( "#aboutformsubmit" ).submit();
		}
		else{
		H( "#aboutformsubmit" ).submit();
		}
	});
	
function resendinvitation(emailid,id){
	H('.resending_'+id).html('<img src="templates/camassistant_left/images/loading_icon.gif" />');
	H.post("index2.php?option=com_camassistant&controller=vendorscenter&task=resendinvitation", {email: ""+emailid+""}, function(data){
		if(data){	
		alert("Your invitation has been sent successfully.");			
		window.location.reload();
		}
	});
}	
function sortusers(){
	document.forms["newsortform"].submit();
}



	

	</script>

<script type="text/javascript">
H = jQuery.noConflict();
H(document).ready(function(){
H('#property_name').change(function(){
		if( H(this).val() != '0' )
		H( this ).prev().addClass( 'active' );
		else
		H( this ).prev().removeClass( 'active' );
	});
	
H('#email').keyup(function(){
		if( H(this).val() == '' )
		H( this ).prev().removeClass( 'active' );
		else
		H( this ).prev().addClass( 'active' );
	});
	H('#subject').keyup(function(){
		if( H(this).val() == '' )
		H( this ).prev().removeClass( 'active' );
		else
		H( this ).prev().addClass( 'active' );
	});
	
	
	});
</script>	
<link href="<?php JPATH_SITE ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<style>
#semdInvitation:hover{
opacity:0.8
}
</style>
<?php
/**
 * @version		1.0.0 cam assistant $
 * @package		cam_assistant
 * @copyright	Copyright © 2010 - All rights reserved.
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
$usertype = JRequest::getVar('usertype','');
$email = JRequest::getVar('email','');
$propertyid = JRequest::getVar('pid','');
$boardmemeberid = JRequest::getVar('bid','');
$db =& JFactory::getDbo(); 
$user =& JFactory::getUser(); 
$getemail="SELECT email FROM #__cam_board_mem WHERE id=".$boardmemeberid." AND property_name=".$propertyid."";
$db->setQuery( $getemail );
$getemail = $db->loadResult();

if($user->user_type == 11)
{ ?>
<div align="center" style="color:#0066FF; font-size:15px"> You are not authorized to view this page.</div>
<?php } else { ?>
<div id="bedcrumb" style="display:none">
<ul>
<br/>
<li class="home"><a href="index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112">Home</a> </li>
<li>Invitations</li>
<!--<li><a href="#">Proposals Under Review</a></li> -->
</ul>
</div>
<p style="height:20px;"></p>
<div id="i_bar">
<div style="width:600px; color:#fff; text-align:center; padding-left:37px; font-size:14px;" id="i_bar_txt"><strong>INVITE A CLIENT</strong>
</div>
<div id="i_icon">
<a href="index2.php?option=com_content&amp;view=article&amp;id=289&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" style="text-decoration: none;"><img src="templates/camassistant_left/images/info_icon2.png"> </a>
</div>
</div>

<form name="inviteform" id="inviteform" method="post" >
<div id="invite-popup" style="margin-top:20px; margin-left:17px;">

<!--<div class="invite-popup-main" style="width:695px;">
<div class="invite-popup">
<label>Email Address:</label><br />
<img width="10" height="20" src="templates/camassistant_left/images/red-arrow.jpg" alt=""><input type="text" value="" name="email" id="email" style="width:600px; margin-left:25px; color:gra
y;" />
</div>
</div>-->
<div class="newtestpopup">
<div class="invite-popup-main">
<div class="invite-popup-left-newone">

<div class="red-arrow-new">&nbsp;</div>
<?php 
$properties = $this->propertyList; 

?>
<select id="property_name" name="property_name" style="width:100%; height:38px; padding:5px; border: 1px solid #6d6d6d;">

	<?php
		for( $p=0; $p<count($properties); $p++ ){ 
		$property=str_replace('_',' ',$properties[$p]->text);
		$lenth = strlen($property);
		if($lenth > 60 )
		$propertynew = substr($property,'0','45').'...';
		else
		$propertynew = substr($property,'0','45');
		
		?>
		<option value="<?php echo $properties[$p]->value; ?>" title="<?php echo $property;?>"><?php echo $propertynew; ?></option>
		<?php }
	?>
	</select>
</div>
</div>

<div class="invite-popup-main">
<div class="invite-popup-left-newone">
<label><span style="padding-right: 29px;">EMAIL</span></label>
<div class="red-arrow-new">&nbsp;</div>

<input type="text" style="max-width: 238px; padding-left:88px; width: 100%; color:gray; margin-right: 10px; height: 29px;"  id="email" name="email" value="<?php echo $getemail;?>">
</div>
</div>

<div class="invite-popup-main">
<div class="invite-popup-left-newone">
<label><span style="padding-right: 50px;">CC</span></label>
<input type="text"  id="ccemail" name="ccemail"  style="max-width: 238px; padding-left:88px; width: 100%; color:gray; margin-right: 10px; height: 29px;" >
</div>
</div>

<div class="invite-popup-main" style="color:gray;">
<div class="invite-popup-left-newone">
<label><span>SUBJECT</span></label>
<div class="red-arrow-new">&nbsp;</div>
<input  type="text"  id="subject" name="subject" style="max-width: 238px; padding-left:88px; color:gray; height: 29px;  margin-right: 11px; width: 100%;">
</div>
  
</div>
</div>

<?php 
$message =$this->mailtext;

 ?>
 
<div class="detailsextra">
<br />
<div class="managerjobmailedit"><?php echo ($this->mailtext); ?> 
<div id="topborder_row" style=" margin-right: 10px;margin-top: 24px;"></div>
    
<table cellpadding="0" cellspacing="0" width="100%" class="awardjob_table">
<tr>
<td align="right">
<a id="editoption" href="javascript:void(0);" class="editoption_award"><strong><img src="templates/camassistant_left/images/EditMini.png" /></strong></a></td>
</tr>

</table>
</div>
</div>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="vendorscenter" name="controller">
<input type="hidden" value="<?php echo $_REQUEST['accept']; ?>" name="accept">
<input type="hidden" value="sendinvitation" name="task">
</form>

</div>
<div class="clear"></div>
<div id="aboutform" style="display:none;">
<form action="" method="post" id="aboutformsubmit">
<table cellpadding="0" cellspacing="0">
<tr><td colspan="3">
 <textarea rel="editor" name="mailtext" id="awardjob_mail" ><?php echo $message; ?></textarea>
<script language="javascript1.2">
generate_wysiwyg('awardjob_mail');
</script>

 </td></tr>
 <tr height="5"></tr>
 <tr><td align="right"><a href="javascript:void(0);" onClick="window.location.reload()" id="cancellink"><img src="templates/camassistant_left/images/CancelMini.png" /></a> <a id="saveoption" href="javascript:void(0);" style="font-weight:bold; color: #7ab800;"><img src="templates/camassistant_left/images/SaveMini.png" /></a></td></tr>
<tr height="10"></tr>
<tr><td style="color: #808080; font-size: 13px; padding-left: 9px; text-align: left;">
</td></tr>
</table>
<input type="hidden" value="com_camassistant" name="option">
<input type="hidden" value="vendorscenter" name="controller">
<input type="hidden" value="save_awardedemail" name="task">
<input type="hidden" value="" id="editable" />
</form>
</div>
<div style="width:643px; margin-left:12px;" align="center">
<table align="center"><tr><td>
<a href="index.php?option=com_camassistant&controller=rfpcenter&task=dashboard&Itemid=125" class="propertyowner_cancelinvitation margintop"></a>
</td>
<td>
<a href="javascript:void(0);" id="semdInvitation" class="semdInvitation"></a>
</td>
</tr></table>
</div>



	<?php } ?>
	
	
<div class="clear"></div>
<div style="margin-top:20px;" id="topborder_row"></div>
<div id="add-vendor-new">
<div class="new-searchfilerts">
<div align="center" class="optional_filters">OPTIONAL FILTERS</div>
<form name="newsortform" id="newsortform" method="post">
<select onchange="javascript:sortusers();" style="width:330px;" name="usertype">
<option value="">All Clients</option>
<option value="uv" <?php if( $usertype == 'uv' ) echo 'selected="selected"';?> >Unregistered Clients</option>
<option value="rv" <?php if( $usertype == 'rv' ) echo 'selected="selected"';?>>Registered Clients</option>
</select>
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="controller" value="vendorscenter" />
</form>
</div>
</div>
<div class="clear"></div>
	<div id="i_bar_gray">
<div id="i_bar_terms_rfp">
<div id="i_bar_txt_terms_rfp">
<span> <font style="font-weight:bold; color:#FFF; font-size:14px;">INVITED CLIENTS</font></span>
</div></div>

    
</div>

	<?php
	$sort = JRequest::getVar('sort','');
	if($sort == 'asc' || $sort == ''){
	$sort = 'desc';
	$id = 'compliant_desc';
	}
	else{
	$sort = 'asc';
	$id = 'compliant_asc';
	}
	?>
	
<div class="table_pannel">
<div class="table_panneldiv">
<table width="100%" cellspacing="4" cellpadding="0" class="titleheadings">
  <tbody><tr class="table_green_row" style="text-transform:none;">
<td width="222" valign="middle" align="left">
<a id="<?php echo $id; ?>" href="index.php?option=com_camassistant&controller=vendorscenter&Itemid=216&sort=<?php echo $sort ; ?>&usertype=<?php echo $usertype; ?>">EMAIL ADDRESS</a>
</td>
<td width="91" valign="middle" align="center">SENT ON</td>
<td width="110" valign="middle" align="center">STATUS</td>
<td width="57" valign="middle" align="right">HIDE</td>
  </tr>
</tbody></table>
<table width="99%" cellspacing="4" cellpadding="0" style="margin:0px 4px">
<?php
$vendors = $this->vendors ;
//print_r($vendors);exit;
 for($i=0; $i<count($vendors); $i++){ 
 	if( $usertype == 'uv' ){
		if( $vendors[$i]->status == 'accepted' )
		$display = 'none';
		else
		$display = '';
	}
	if( $usertype == 'rv' ){
		if( $vendors[$i]->status != 'accepted' )
		$display = 'none';
		else
		$display = '';
	}
 ?>
<tr id="table_blue_rowdots345406" class="table_blue_rowdots" style="height:45px; display:<?php echo $display; ?>">
<td width="222" valign="middle" align="left" style="padding-top:1px;"><?php echo $vendors[$i]->email; ?></td>
<td width="91" valign="middle" align="center" style="padding-top:3px;"><?php 
$date_sent = explode(' ',$vendors[$i]->date);
$expdate = explode('-',$date_sent[0]);
echo $expdate[1].'/'.$expdate[2].'/'.$expdate[0]; ?></td>
<td width="110" valign="middle" align="center" style="padding-top:3px;">
<?php 
if($vendors[$i]->status == 'accepted'){
echo "Registered";
}
else{ ?>
Unregistered<br /><a class="resending_<?php echo $vendors[$i]->id; ?>" href="javascript:void(0);" onclick="resendinvitation('<?php echo $vendors[$i]->email; ?>',<?php echo $vendors[$i]->id; ?>);">(Resend Invite)</a>
<?php }
?></td>
<td width="57" valign="middle" align="right" style="padding-top:3px;">
<a title="Hide from list" class="hidevendor" href="javascript:void(0);" rel="<?php echo $vendors[$i]->id; ?>-<?php echo $vendors[$i]->email; ?>"><img src="templates/camassistant_left/images/Hide.png" alt="delete" style="margin-right:6px;"></a>
</td>
</tr>
<?php } ?>

</table>
</div>
</div>
</div>
	<?php
	//echo "<pre>"; print_r($this->vendors);
	?>
	
	
