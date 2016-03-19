<?php 
    //restricted access
    defined('_JEXEC') or die('Restricted access');
	$db=&JFactory::getDBO();
	$userid = JRequest::getVar('userid', '');
	$proposal_id = JRequest::getVar('id', '');
	$user  =  JFactory::getUser( $userid );
	$sql = "SELECT introtext FROM #__content   where id=204"; 
	$db->Setquery($sql);
	$introtext=$db->loadResult();
	$fullname=$user->name.'&nbsp;'.$user->lastname;
	$introtext = str_replace('{Vendor Name}',$fullname,$introtext);
	$tags = array("<p>","</p>","<br>","<br />");
	$rtags = array("","\n","\n","\n");
	$introtext1 = str_replace($tags, $rtags, $introtext);
?>
    <link href="<?php  echo Juri::root(); ?>templates/camassistant/css/popup.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_camassistant/editor/ed.js"></script>

    <form style="padding:0px; margin:0px;" action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="mailform" >
    <br/>
	<div class="head_greenbg2" style="font-weight:bold; padding-top:8px; color:#FFFFFF;">RFP Reject Mail</div><br/><br/>
        <div class="form_row">
		    <div class="form_text">Recipient:</div><label></label>
			<input type="email" style="width: 300px;" name="recipient" value="<?PHP echo $user->email ?>">
			<div class="clear"></div>
		</div>
        <div class="form_row">
	        <div class="form_text">Subject:</div><label></label>
		    <input type="text" style="width: 300px;" name="subject" value="Reject Proposal">
		    <div class="clear"></div>
	    </div>
    <div class="form_row_button">
         <div class="form_text">&nbsp;</div>
			<div id="txt_box">
				<div class="clear"></div>
				<textarea name="reject_body" id="mytxtarea" class="ed" style=" width:300px; height:150px"  ><?php echo $introtext1;  ?></textarea>
				<div class="clear"></div>
				<input type="image" src="images/submit.png" alt="Submit Text" vspace="10" style="margin-top:20px;" border="0"  />
				<input type="hidden" name="option" value="com_camassistant" />
				<input type="hidden" name="task" value="reject_proposal_mail" />
				<input type="hidden" name="email" value="<?PHP echo $user->email ?>" />
				<input type="hidden" name="fullname" value="<?PHP echo $fullname ?>" />
				<input type="hidden" name="proposal_id" value="<?PHP echo $proposal_id ?>" />
				<input type="hidden" name="controller" value="rfp" />
				 <?php echo JHTML::_( 'form.token' ); ?>
			</div>
    </div>
    <div class="clear"></div>
	</div>
    </form>
</div>
<?PHP exit; ?>