<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="templates/camassistant_left/css/style.css" type="text/css" />
</head>

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
<?php
echo html_entity_decode($this->terms->aboutus);
?>

</p>
<div class="clear"></div><div class="sepdashbutton" style="width:605px; margin-left: 20px;"></div><br/></div>
<?php if( $status == 'acc' ) { ?>
   <div class="accept"><img src='templates/camassistant_left/images/right-icon_vendor.png'/><div class="aceprt2">ACCEPTED</div></div>
    <?php } if( $status == 'dec' ) { ?>
     <div class="accept"><img src='templates/camassistant_left/images/close-icon_vendor.png'/><div class="aceprt3">DECLINED</div></div>
     <?php } if( $status == 'no' ) { ?>
<table cellpadding="0" cellspacing="0" align="right" style="margin-right:21px;">
<tr>
<td><a href="index.php?option=com_camassistant&controller=invitations&task=updatedecline&masterid=<?php echo $this->terms->vendorid; ?>"><img src="templates/camassistant_left/images/del.png" /></a></td>
<td><a href="index.php?option=com_camassistant&controller=invitations&task=updateaccept&masterid=<?php echo $this->terms->vendorid; ?>"><img src="templates/camassistant_left/images/acpt.png" /></a></td>
</tr>
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
