<script type="text/javascript">
G = jQuery.noConflict();
G(document).ready( function(){
	G('.codeinfo_drafts').click(function(){
		rfpid = G(this).attr('data');
		var res = rfpid.split("_"); 
		rfpid = res[0];
		proposalid = res[1];
		propertyid = G(this).attr('rel');
		if(!G(this).hasClass("active")){
			getrfpdata_drafts(rfpid,propertyid,proposalid,res[2]);
			G('.codeinfo_drafts').removeClass('active');
			G(this).addClass('active');
		}
		else{
			G('#codedetails_'+proposalid).slideUp('slow').html('');
			G('.table_blue_rowdots_submitted').removeClass('active');
			G(this).removeClass('active');
			G('.codeinfo_open').removeClass('active');
		}
	});
	
	
	
});

function getrfpdata_drafts(rfpid,propertyid,proposalid,type){
	G.post("index2.php?option=com_camassistant&controller=vendors&task=getinvitationdetails", {rfp: ""+rfpid+"", propertyid: ""+propertyid+"", proposalid: ""+proposalid+"", type: ""+type+""}, function(data){
	if(data) {
		G('#codedetails_'+proposalid).removeClass('loader');
		G('.prop_details').slideUp();
		G('.table_blue_rowdots_submitted').removeClass('active');
		G('#table_blue_rowdots'+rfpid).addClass('active');
		G('#codedetails_'+proposalid).html(data).slideDown('slow');
		G('#codedetails_'+proposalid).show();
	}
	else{
		G('#codedetails_'+proposalid).removeClass('loader');
		G('#codedetails_'+proposalid).html("No data for this RFP");
	}
	});
}

</script>
<?php
$invitations 		= $this->Invitations;
$Itemid = JRequest::getVar('Itemid','');
?>
<?PHP
	$deccount_pre = 0;
	for($ide=0; $ide<count($invitations); $ide++) {
		if($invitations[$ide]['not_interested'] != '2') {
			$deccount_pre ++ ;
		}
	}
?>
<p style="height:21px;"></p>
<div id="i_bar">
<div id="i_bar_txt">
<span><strong>DECLINED PROJECTS</strong></span>
</div>
<div id="i_icon001"><a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=109&amp;Itemid=113"><img style="margin-top:6px;" src="templates/camassistant_left/images/info_icon2.png"> </a></div>
</div>
<div class="table_pannel">
<div class="table_panneldiv">
<table width="100%" cellpadding="0" cellspacing="4" class="vendortable">
<?PHP if(count($invitations)>0 && count($invitations) > $deccount_pre ) { ?>
    <tr class="vendorfirsttr">
	<td></td>
    <td width="30%" align="center" valign="middle">PROPERTY</td>
    <td width="33%" align="center" valign="middle">PROJECT NAME</td>
    <td width="15%" align="center" valign="middle">COUNTY</td>
    <td width="25%" align="center" valign="middle">REQUESTED DUE DATE</td>
  </tr>
  <?php //echo "<pre>"; print_r($invitations); echo "</pre>"; ?>
  
  <?PHP for($d=0; $d<count($invitations); $d++) {
  			if($invitations[$d]['not_interested'] == '2') {
  		$subject = $Jobs[$d]['time_left'];
		$pattern = '|-|';
		preg_match($pattern, substr($subject,0), $matches, PREG_OFFSET_CAPTURE);
		$cnt = count($matches);
   if($invitations[$d]['not_interested'] == '1') {?>
  <tr class="table_blue_rowdots_submitted" style="color:#808080;" color="#808080">
  <?php } else { ?>
   <tr class="table_blue_rowdots_submitted">
  <?php } ?>
  	<td width="15" valign="middle" align="center">
   <a id="getcodeinfo_<?php echo $invitations[$d]['rfp_id']; ?>" class="codeinfo_drafts" data="<?php echo $invitations[$d]['rfp_id']; ?>_<?php echo $invitations[$d]['id']; ?>_declined" rel="<?php echo $invitations[$d]['property_id']; ?>" href="javascript:void(0);"></a>
   </td>
   	<td width="30%" align="center" valign="middle"><?PHP  echo str_replace('_',' ',$invitations[$d]['Propertyname']); ?></td>
    <td width="33%" align="center" valign="middle"><?PHP  echo $invitations[$d]['projectName']; //echo $Drafts[$d]->Prperty_id;  ?></td>
    <td width="15%" align="center" valign="middle"><?PHP echo $invitations[$d]['County'];  ?></td>
	 <?php $main = $invitations[$d]['proposalDueDate'];
  if($main != '0000-00-00'){
    $main = explode('-',$main);
	$date = $main[0].'-'.$main[1].'-'.$main[2];
	}
	else{
	$date = '00-00-0000';
	}

   ?>
  <td width="25%" align="center" valign="middle"><?PHP echo $date;  ?></td>
  </tr>
  <tr><td colspan="6"><div id="codedetails_<?php echo $invitations[$d]['id']; ?>" class="prop_details" ></div></td></tr>
  <?PHP 
  		 } 
		 	}
		  } 
  if(count($invitations)<=0 ||  count($invitations) == $deccount_pre )
 { ?>
 <tr>
    <td colspan="5"  align="center" valign="top"><p style="margin-top:10px; margin-bottom:10px;">You have not any declined projects</p></td>
  </tr>
  <?PHP } ?>
 </table>
<div class="clear"></div>
</div>
</div>