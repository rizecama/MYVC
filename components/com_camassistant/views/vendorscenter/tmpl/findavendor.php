<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>camassistant</title>

<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo Juri::base(); ?>components/com_camassistant/skin/css/jquery1.css" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript">
G = jQuery.noConflict();
function addnewvendor(total)
{
window.location = 'index.php?option=com_camassistant&controller=vinvitations&Itemid=216';
}	
</script>

</head>
<?php 
$total_vendors = $this->total_vendors;

?>
 
<body>
<div class="newfindavendor">
<div class="findavendor_div"><p>You must have <strong>at least</strong> <span style="font-weight:bold;"><br/>5 Vendors</span> registered in<br/> order to access this feature</p>
<div class="progress_div">YOUR PROGRESS</div>
<div class="findavendorbox" >
<input type="text" name="invitecode" readonly= "readonly" value="<?php echo $total_vendors;?> Vendors Registered" >
</div>
<div align="center" class="add_findavendor_button"><a class="addvendorslist" href="javascript:void(0);" onclick="addnewvendor('<?php echo $total;?>')">INVITE YOUR VENDORS</a></div>
</div>
<div class="findavendorimage_div"><img src="templates/camassistant_left/images/findavendor-home.png" /></div>
</div>
<div class="findavendorinvitecode-main" style="clear:both;">
<div class="findavendorinvitecode"><strong>Why we require each user to register 5 Vendors:</strong></div>
<div class="whytofindavendor">One of the many benefits of MyVendorCener is that it's an open system.  This means that once a Vendor registers, their information is available to all of their clients, not just one.  Having an open system saves a Vendor time and money from having to repeat unnecessary registration procedures and/or paying additional fees for every property or client they work with.  Because of this advantage, MyVendorCenter must protect its Vendor-related database (Find A Vendor feature) from misuse. One way to do this is by requiring every user to assist in registering 5 unique Vendors* before searching for others, ensuring integrity and diversity within the MyVendorCenter community.  </div></div>
<div class="findavendorinvitecode-main">
<div class="howregistervendor"><strong>How to register your Vendors:</strong></div>
<div class="howregister_vendor">The first step to registering your Vendors is to invite them.  You can use your account to send each of your Vendors a personal email, with directions to register their company, by clicking on the "INVITE YOUR VENDORS" button above or "INVITE A VENDOR" button within the main menu to the left.  The invitation will include your unique Vendor Invite code for the Vendor to enter during registration, which will automatically add them to your "MY VENDORS" list. </div></div>
<div class="findavendorinvitecode-main">
<div class="trackcode"><strong>Keeping track of your invited Vendors:</strong></div>
<div class="trackcode_new">Once you succesfullly send an invitation to a Vendor, they will be listed in your "INVITED VENDORS" feature within the main menu to the left.  A registration status will be available for each Vendor you invite, and clicking on the "!" icon will send them another invite, if they have not registered yet.  Once a Vendor registers, they will be added to your total progress above.  When 5 new Vendors have been registered, this feature will be unlocked and you’ll be able to search for Vendors by name, industry, and/or area.</div></div>
<div class="note">* Each Vendor that registers has to be unique to the system.  This means they can’t be currently registered or registered under a different email address for the same company. </div>

