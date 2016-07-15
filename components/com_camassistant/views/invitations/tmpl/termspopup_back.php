<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="templates/camassistant_left/css/style.css" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="<?php echo Juri::base(); ?>components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
H = jQuery.noConflict();
	H(document).ready( function(){
		H('.decline').click(function(){

		});
		H('.accept').click(function(){
			alert("can");
		});
		
	});
</script>	
<body>
<?php 
$cname = JRequest::getVar("cname",'');
$status = JRequest::getVar("status",''); 
?>
<div id="i_bar_terms" style="margin-bottom:0px; margin-left:19px; margin-top:15px; width:608px; text-align:center;">
<div id="i_bar_txt_terms">
<span> <font style="font-weight:bold; color:#FFF;"><?php echo strtoupper($cname); ?></font></span>
</div></div>
<?php if($this->terms->aboutus){ ?>
<p style="text-align:justify; padding:11px 21px 10px 21px;">
<div class="masterterms">
<?php
echo html_entity_decode($this->terms->aboutus); ?>
</p>
</div>
<div class="clear"></div><div class="sepdashbutton" style="width:605px; margin-left: 20px;"></div><br/></div>
<?php if( $status == 'acc' ) { ?>
   <div class="accept"><img src='templates/camassistant_left/images/right-icon_vendor.png'/><div class="aceprt2">ACCEPTED</div><br><br></div>
    <?php } if( $status == 'dec' ) { ?>
     <div class="accept"><img src='templates/camassistant_left/images/close-icon_vendor.png'/><div class="aceprt3">DECLINED</div><br><br></div>
     <?php } if( $status == 'no' ) { ?>
<table cellpadding="0" cellspacing="0" style="margin-right:21px;" width="100%">
<tr><td>Full Name:</td><td><input type="text" name="firstname" placeholder="First" />&nbsp;&nbsp;<input type="text" name="lastname" placeholder="Last" /></td></tr>
<tr>
<td align="right"><a class="decline" rel="decline" href="index.php?option=com_camassistant&controller=invitations&task=updatedecline&masterid=<?php echo $this->terms->vendorid; ?>" style="margin-bottom:10px;"><img src="templates/camassistant_left/images/del.png" /></a></td>
<td align="left"><a class="accept" rel="accept" href="index.php?option=com_camassistant&controller=invitations&task=updateaccept&masterid=<?php echo $this->terms->vendorid; ?>" style="margin-left:10px;"><img src="templates/camassistant_left/images/acpt.png" /></a></td>
</tr>
<tr height="20"></tr>
</table><?php } ?>
<?php } else { ?>

<p style="text-align:justify; padding:11px 21px 10px 21px;">
There is no Terms & Conditions for this master...
</p>
<?php }

exit;
?>


</body>
</html>
