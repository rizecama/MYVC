<?php 
JHTML::_('behavior.modal');
?>
<script type="text/javascript">
function submit_data()
{
var frm = document.Frmbillingcentre;
frm.task.value = "save_billing_centre";
frm.submit();
}
function popup_pmr(){
el='<?php  echo Juri::base(); ?>index2.php?option=com_camassistant&controller=vendors&task=billing_pledge_form';
//SqueezeBox.fromElement(el);
var options = $merge(options || {}, Json.evaluate("{handler: 'iframe', size: {x: 650, y:450}}"))
SqueezeBox.fromElement(el,options);
}
</script>
<?php 
$user =& JFactory::getUser(); 
if($user->user_type != 11)
{ ?>
<div align="center" style="color:#0066FF; font-size:15px"> You are not authorized to view this page.</div>
<?php } else { ?>
<div id="vender_right2">

<!-- sof bedcrumb -->
<div id="bedcrumb" style="display:none">
<ul>
<li class="home"><a href="index.php?option=com_camassistant&controller=vendors&task=vendor_dashboard&Itemid=112">Home  </a></li>
<li> My Billing Center</li></ul>
</div>
<!-- eof bedcrumb -->

<!-- sof dotshead -->
<div id="i_bar">
<div id="i_bar_txt">
<span><strong>MY BILLING CENTER</strong>   </span>
</div>
<div id="i_icon001"><a href="index2.php?option=com_content&amp;view=article&amp;id=72&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" style="text-decoration: none;"><img src="templates/camassistant_left/images/info_icon2.png" style="margin-top:6px;"> </a></div>
</div>
<!-- eof dotshead -->

<!--<div id="i_bar_gr">
<div id="i_bar_txt1"><span>PAYMENT PREFERENCE FOR JOB REFERRAL FEES  (DUE UPON JOB AWARD*)</span></div>
<div id="i_icon"><a href="#"><img src="images/info_icon2.png" alt="info" /></a></div>
</div>-->
<div class="headding_panel001" style="margin-top:5px;">
<div class="headbg_top001"></div>
<div class="headbg_midd001" id="i_bar_txt1001">PAYMENT PREFERENCE FOR JOB REFERRAL FEES  (DUE UPON JOB AWARD*)</div>
<div class="headbg_bott001"></div>
</div>

<!-- sof table pan -->

<div class="table_pannel">
<form name="Frmbillingcentre" method="post" />
<div class="head_greybg1"><!--sof rfp box-->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="20%">Payment Preference:</td>
    <td width="4%" align="right"><label>
     <?php /*?> <input name="checkbox[]" type="checkbox" id="checkbox2" <?PHP if($this->billing_data[0]->payment_preference == 'PBC') {?> checked="checked" <?PHP } ?> value="PBC"  onclick="javascript: if(this.checked == true) {document.getElementById('checkbox3').checked=false; document.getElementById('checkbox4').checked=false};" /><?php */?>
	  <input type="radio" name="checkbox[]" id="checkbox2" <?PHP if($this->billing_data[0]->payment_preference == 'PBC' || $this->billing_data[0]->payment_preference =='') {?> checked="checked" <?PHP } ?> value="PBC"  />
    </label></td>
    <td width="19%"><span>Pay by Check</span></td>
   <?php /*?> <td width="3%"><label>
      <input type="checkbox" name="checkbox[]" value="PBA" id="checkbox3" <?PHP if($this->billing_data[0]->payment_preference == 'PBA') {?> checked="checked" <?PHP } ?> onclick="javascript: if(this.checked == true) {document.getElementById('checkbox2').checked=false; document.getElementById('checkbox4').checked=false};" />
    </label></td>
    <td width="21%"><span>Pay by ACH (set up)</span></td><?php */?>
    <td width="4%" align="right"><label>	
     <?php /*?> <input  type="checkbox" name="checkbox[]" <?PHP if($this->pledge_status == 0) { ?> disabled="disabled" <?PHP } ?> value="PMR" id="checkbox4" <?PHP if($this->billing_data[0]->payment_preference == 'PMR') {?> checked="checked" <?PHP } ?> onclick="javascript: if(this.checked == true) {document.getElementById('checkbox2').checked=false; document.getElementById('checkbox3').checked=false};" /><?php */?>
	  <input onclick="javascript:popup_pmr();" type="radio" name="checkbox[]" id="checkbox2" <?PHP if($this->billing_data[0]->payment_preference == 'PMR') {?> checked="checked" <?PHP } ?> value="PMR" />
    </label></td>
    <td width="35%"><span>Pledge My Receivables<strong>(<?PHP echo $this->billing_pledge_popup; ?>)</strong></span></td>
  </tr>
 
</table>
</div>
<div class="head_greybg2">
  <p><span>PAY BY CHECK:</span></p>
I agree to remit a check to CAMassistant.com as soon as I am awarded a job via CAMassistant.com to pay the balance of my job referral fee(s).  I understand that this payment has a grace period of 5 days from the date I am awarded a job.  If my account is not paid in full after the 5 day grace period, I agree to furnish the proper<strong class="blue_small2"> documentation </strong>to pledge my receivables to CAMassistant.com.  I also understand that pledging my receivables carries an <span>18% annualized finance charge </span> in addition to my referral fees, and that interest is calculated from the date that I am awarded a job through CAMassistant.com.<br />
</div>
<?php /*?><div class="head_greybg2">
<p><span>PAY BY ACH:</span></p>
I agree to remit payment via ACH to CAMassistant.com as soon as I am awarded a job via CAMassistant.com to pay the balance of my job referral fee(s).  I understand that this payment has a grace period of 5 days from the date I am awarded a job.  If my account is not paid in full after the 5 day grace period, I agree to furnish the proper <strong class="blue_small2"> documentation </strong> to pledge my receivables to CAMassistant.com.  I also understand that pledging my receivables carries an <span>18% annualized finance charge </span> in addition to my referral fees, and that interest is calculated from the date that I am awarded a job through CAMassistant.com.<strong class="blue_small2"><?PHP echo $this->ACH_ACCOUNT_popup; ?></strong>
</div><?php */?>
<div class="head_greybg2">
  <p><span>PLEDGE MY RECEIVABLES:</span></p>
I would like to pledge my receivables of awarded jobs specific to CAMassistant.com RFPs and reduce my cashflow risks by providing the proper <?PHP echo $this->documentation; ?> to CAMassistant.com.  I understand that pledging my receivables carries an <span>18% annualized finance charge </span>in addition to my referral fees, and that interest is calculated from the date that I am awarded a job through CAMassistant.com. <strong class="blue_small2"><?PHP echo $this->enable_this_option_popup; ?></strong>
</div>
<div class="proposal_form1">
*Vendor Referral Fees are stated on every Proposal submitted by a vendor, and are calculated based on our <?PHP echo $this->rate_schedule; ?><!--<strong class="blue_small2">
<a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 650}}" href="index2.php?option=com_jefaqpro&view=category&layout=categorylist&task=lists&catid=2&Itemid=41?hidden=popup">
Rate Schedule</a></strong>-->.  If a vendor is awarded a job that CAMassistant.com discloses to that vendor (via e-mail or job listing on their "My Dashboard" page) that vendor is responsible for the referral fees (whether or not they were awarded the job through CAMassistant.com).<br />
</div>
<div id="topborder_row" align="right">
        <a href="javascript: submit_data();" ><img src="templates/camassistant_left/images/savechenges.gif" alt="Save Changes" /></a></div> 
<!-- eof line item pan -->
</div>
<input type="hidden" name="controller" value="vendors" />
<input type="hidden" name="option" value="com_camassistant" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?PHP echo $this->billing_data[0]->id; ?>" />
</form>

</div>
<?Php } ?>