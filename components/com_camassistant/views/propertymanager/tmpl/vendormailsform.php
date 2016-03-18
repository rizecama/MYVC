<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.tooltip');	
?>
<link rel="stylesheet" href="templates/camassistant_left/css/general.css" type="text/css" />



<script language="javascript" type="text/javascript">
function fun_submimailsinfo()
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = document.camadminmailsform.preferedcc.value;
	var address1 = document.camadminmailsform.preferedbcc.value;
 	var frm=document.camadminmailsform;
	frm.controller.value='propertymanager';
	frm.task.value='update_camfirmadmin_emailsinfo';
	if(reg.test(address) == false) {
      alert('Prefered Vendor Invalid CC mail Address');
      return;
	  } else if(reg.test(address1) == false) {
      alert('Prefered Vendor Invalid BCC mail Address');
      return;
	  } else {
	  
     frm.submit();
	}
}

function fun_submimailsinfo1()
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address2 = document.camadminmailsform.inhousecc.value;
	var address3 = document.camadminmailsform.inhousebcc.value;
 	var frm=document.camadminmailsform;
	frm.controller.value='propertymanager';
	frm.task.value='update_camfirmadmin_emailsinfo';
	if(reg.test(address2) == false) {
      alert('In-house Vendor Invalid CC mail Address');
      return;
	  } else if(reg.test(address3) == false) {
      alert('In-house Vendor Invalid BCC mail Address');
      return;
	  } else {
	  
     frm.submit();
	}
}
</script>
<div id="vender_right">

<!-- sof bedcrumb -->

<!-- eof <div id="bedcrumb">
<ul>
<li class="home"><a href="#">Home  </a></li><li><a href="#"> Edit Default Vendor Emails</a> </li>
</ul>
</div>bedcrumb -->
<form name="camadminmailsform" method="post" action="">
<!-- sof dotshead -->
<div id="dotshead_blue">EDIT DEFAULT VENDOR EMAILS</div>
<!-- eof dotshead -->
<div id="i_bar">
<div id="i_bar_txt">
<span>PREFERRED VENDOR INVITATION EMAIL:      </span>
</div>
<div id="i_icon">
<a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=68&amp;Itemid=113">
<img src="images/info_icon2.png" alt="info" />
</a>
</div>
</div>

<!-- sof table pan -->


<!-- sof email pan -->
<div class="emails">
<div class="to">
<label>To:</label>
<input type="text" name="preferedto"  value="<?php echo $this->detail[0]->preferedto ?> " />
<div class="clear"></div>
</div>



<div class="cc">
<label>CC:</label>
<input type="text" name="preferedcc" value="<?php echo $this->detail[0]->preferedcc ?>" />
<div class="clear"></div>
</div>


<div class="bcc">
<label>BCC:</label>
<input type="text" name="preferedbcc" value="<?php echo $this->detail[0]->preferedbcc ?>" />
<div class="clear"></div>
</div>


<div class="subject">
<label>SUBJECT:</label>
<input type="text" name="preferedsubject" value="<?php echo $this->detail[0]->preferedsubject ?>" />
<div class="clear"></div>
</div>

<div class="pasege">

<?php
	$editor =& JFactory::getEditor();
	
		echo $editor->display( 'invite_prefered',  $this->detail[0]->invite_prefered , '100%', '200', '75', '20' ) ;
		?>

</div>
<div class="clear"></div>

	<img src="images/invitea.gif" name=""   onClick="fun_submimailsinfo()"/></div>
<!-- eof email pan -->

<br />

<!-- eof dotshead -->
<div id="i_bar">
<div id="i_bar_txt">
<span>IN-HOUSE VENDOR INVITATION EMAIL: </span>
</div>
<div id="i_icon">
<a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=69&amp;Itemid=113">
<img src="images/info_icon2.png" alt="info" />
</a>
</div>
</div>

<!-- sof table pan -->





<!-- sof email pan -->
<div class="emails">
<div class="to">
<label>To:</label>
<input type="text" name="inhouseto" value="<?php echo $this->detail[0]->inhouseto ?>" />
<?php /*?><input type="text" value="{RECIPIENT EMAIL ADDRESS}" /><?php */?>
<div class="clear"></div>
</div>



<div class="cc">
<label>CC:</label>
<input type="text" name="inhousecc" size="30" value="<?php echo $this->detail[0]->inhousecc ?>" />
<div class="clear"></div>
</div>


<div class="bcc">
<label>BCC:</label>
<input type="text" name="inhousebcc" value="<?php echo $this->detail[0]->inhousebcc ?>" />
<div class="clear"></div>
</div>


<div class="subject">
<label>SUBJECT:</label>
<input type="text" name="inhousesubject" value="<?php echo $this->detail[0]->inhousesubject ?>" />
<div class="clear"></div>
</div>

<div class="pasege">
<?php
	$editor =& JFactory::getEditor();
		echo $editor->display( 'invite_vinhouse',  $this->detail[0]->invite_vinhouse , '100%', '200', '75', '20' ) ;
		?>
</div>
<div class="clear"></div>

	<img src="images/inhousevender.gif" name=""   onClick="fun_submimailsinfo1()"/></div>
<!-- eof email pan -->

</div>
</div>
<input type="hidden" name="controller" value="propertymanager" />
<input type="hidden" name="task" value="camfirmadmin_emailsinfo" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="camfirmadmin_id" value="<?php echo $this->camfirmadmin;?>" />
<input type="hidden" name="company_id" value="<?php echo $this->comp_id;?>" />
<input type="hidden" name="id" value="<?php echo $this->detail[0]->id;?>" />
<input type="hidden" name="Itemid" value="<?php echo $_REQUEST['Itemid'];?>" />
</form>

</div>


