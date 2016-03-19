<?php 
//restricted access
defined('_JEXEC') or die('Restricted access');

?>
<link href="<?php  echo Juri::root(); ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/editor/ed.js"></script>
<script type="text/javascript">
<?php /*?>function fun(){

window.parent.document.getElementById( 'sbox-window' ).close(); 
window.parent.parent.location.reload();
document.mailform.submit();
}
<?php */?>
</script>

<?php //echo 'anand'; ?>
<form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
<br/><div class="head_greenbg2" style="font-weight:bold; padding-top:8px; color:#FFFFFF;">RFP Reject Mail</div><br/><br/>

<div class="form_row"><div class="form_text">Recipient:</div><label></label><input type="email" style="width: 300px;" name="recipient" value="<?php echo $_REQUEST['email']; ?>"><div class="clear"></div></div>
<div class="form_row"><div class="form_text">Subject:</div><label></label><input type="text" style="width: 300px;" name="subject" value="Reject RFP"><div class="clear"></div></div>
<div class="form_row_button">
<div class="form_text">&nbsp;</div>
<div id="txt_box">
<?php 
/* to get the mail id */
$db=&JFactory::getDBO();
		$sql = "SELECT introtext FROM #__content   where id=197"; 
		$db->Setquery($sql);
		$introtext=$db->loadResult();
		$fullname=$_REQUEST['name'].' '.$_REQUEST['lastname'];
		$introtext = str_replace('{Manager Name}',$fullname,$introtext);
		//$tags = array("<p>","</p>","<br>","<br />","<b>","</b>");
		//$rtags = array("","\n","\n","\n");
		$tags = array("<p>","</p>","<br>","<br />");
        $rtags = array("","\n","\n","\n");
        $introtext1 = str_replace($tags, $rtags, $introtext);
		//$introtext1 = htmlentities($introtext,ENT_QUOTES);
		
		
//echo $user->email;
?>
<div class="clear"></div>
<textarea name="reject_body" id="mytxtarea" class="reject_body" style=" width:300px; height:150px" ><?php echo $introtext1;  ?></textarea>
<div class="clear"></div>
<input type="image" src="images/submit.png" alt="Submit Text" vspace="10" style="margin-top:20px;" border="0"  />
<?php /*?><img src="images/submit.png" alt="Submit Text" vspace="10" style="margin-top:20px;" border="0" onclick="javascript:fun();" /><?php */?>
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="editreject" />
<input type="hidden" name="rfp_id" value="<?php echo $_REQUEST['id']; ?>" />
<input type="hidden" name="industry_id" value="<?php echo $_REQUEST['industry_id']; ?>" />
<input type="hidden" name="search" value="<?php echo $_REQUEST['search']; ?>" />
<input type="hidden" name="status" value="<?php echo $_REQUEST['status']; ?>" />
<input type="hidden" name="rfpstatus" value="<?php echo $_REQUEST['rfpstatus']; ?>" />
<input type="hidden" name="rfpapproval" value="<?php echo $_REQUEST['rfpapproval']; ?>" />
<input type="hidden" name="fullname" value="<?php echo $fullname; ?>" />


<input type="hidden" name="controller" value="rfp" />
<?php echo JHTML::_( 'form.token' ); ?>

</div>
<!--<div id="txt_box_botomcurve"></div> -->
</div>
<div class="clear"></div></div>

<div class="form_row">
<div id="txt_box"></div>
<div class="clear"></div>
</div>
</form>
</div>
<?PHP exit; ?>