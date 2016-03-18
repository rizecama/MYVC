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
    <td width="8%" align="center" valign="middle">RFP#</td>
    <td width="33%" align="center" valign="middle">PROJECT NAME</td>
    <td width="15%" align="center" valign="middle">CITY</td>
    <td width="25%" align="center" valign="middle">REQUESTED DUE DATE</td>
   <!-- <td width="16%" align="center" valign="middle">TIME LEFT</td>-->
    <td width="19%" align="center" valign="middle">OPTIONS</td>
  </tr>
  <?php //echo "<pre>"; print_r($invitations); echo "</pre>"; ?>
  
  <?PHP for($d=0; $d<count($invitations); $d++) {
  			if($invitations[$d]['not_interested'] == '2') {
  		$subject = $Jobs[$d]['time_left'];
		$pattern = '|-|';
		preg_match($pattern, substr($subject,0), $matches, PREG_OFFSET_CAPTURE);
		$cnt = count($matches);
   if($invitations[$d]['not_interested'] == '1') {?>
  <tr class="table_blue_rowdots" style="color:#808080;" color="#808080">
  <?php } else { ?>
   <tr class="table_blue_rowdots">
  <?php } ?>
   <td width="8%" align="center" valign="middle"><?PHP echo sprintf('%06d', $invitations[$d]['rfp_id']);//echo $Jobs[$d]['rfp_id'];  ?></td>
    <td width="33%" align="center" valign="middle"><?PHP  echo $invitations[$d]['projectName']; //echo $Drafts[$d]->Prperty_id;  ?></td>
    <td width="15%" align="center" valign="middle"><?PHP echo $invitations[$d]['City'];  ?></td>
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
   <!-- <td align="center" valign="top"><?PHP //echo $Jobs[$d]['time_left'];  ?></td>-->
    <td width="19%" align="center" valign="middle">
	<a href="index.php?option=com_camassistant&controller=proposals&task=vendor_proposal_form&view=proposals&Prp_id=<?PHP echo $invitations[$d]['prp_id'];  ?>&rfp_id=<?PHP echo $invitations[$d]['rfp_id'];  ?>&not_interested=<?PHP echo $invitations[$d]['not_interested'];  ?>&type=invitation&id=<?PHP echo $invitations[$d]['id']; ?>&type=invitation&jobtype=<?php echo $invitations[$d]['jobtype']?>&Itemid=<?PHP echo $Itemid; ?>">View Job Details</a>
	</td>
  </tr>
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