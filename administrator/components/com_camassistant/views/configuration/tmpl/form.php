<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.tooltip');
//echo "<pre>"; print_r($this->detail);
?>


<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th class="content">
			Configuration: <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Configuration Details
					</th>
				</tr>
				<tr>
					<th colspan="2">
					RFP Params
					</th>
				</tr>
			
				<tr>
					<td width="300">
					Closed RFP Limit Per Page:
					</td>
					<td >
					<input name="closedrfp_limit" id="closedrfp_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo  $this->detail->closedrfp_limit; ?>" />
					</td>
				</tr>
					<tr>
						<td width="300">
					Unsubmitted RFP Limit Per Page:
						</td>
						<td colspan="2">
							<input name="unsubrfp_limit" type="text" style="width:20px;" maxlength="2"  value="<?php echo $this->detail->unsubrfp_limit; ?>" />
						</td>
					</tr>
				<tr>
					<td width="300">
				Submitted RFP Limit Per Page:
					</td>
					<td>
					<input name="subrfp_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->subrfp_limit; ?>" />
					</td>
				</tr>
				<tr>
					<td width="300">
				Award RFP Limit Per Page:
					</td>
					<td>
					<input name="awardrfp_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->awardrfp_limit; ?>" />
					</td>
				</tr>
				<tr>
					<td width="300">
				Unaward RFP Limit Per Page:
					</td>
					<td>
					<input name="unawardrfp_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->unawardrfp_limit; ?>" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
					Vendor Proposal Params
					</th>
				</tr>
			
				<tr>
					<td width="300">
					Draft Proposals Limit Per Page:
					</td>
					<td >
					<input name="draftproposals_limit" id="draftproposals_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo  $this->detail->draftproposals_limit; ?>" />
					</td>
				</tr>
					<tr>
						<td width="300">
					Submitted Proposals Limit Per Page:
						</td>
						<td colspan="2">
							<input name="submittedproposals_limit" type="text" style="width:20px;" maxlength="2"  value="<?php echo $this->detail->submittedproposals_limit ; ?>" />
						</td>
					</tr>
				<tr>
					<td width="300">
				    Review Proposals Limit Per Page:
					</td>
					<td>
					<input name="reviewproposals_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->reviewproposals_limit; ?>" />
					</td>
				</tr>
				<tr>
					<td width="300">
				    Awarded Proposals Limit Per Page:
					</td>
					<td>
					<input name="awardedproposals_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->awardedproposals_limit; ?>" />
					</td>
				</tr>
				<tr>
					<td width="300">
				    Unawarded Proposals Limit Per Page:
					</td>
					<td>
					<input name="unawarderproposals_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->unawarderproposals_limit; ?>" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
					View RFPS By Property / Managers
					</th>
				</tr>
				<tr>
					<td width="300">
				    RFPS Limit Per Page:
					</td>
					<td>
					<input name="rfps_by_property_limit" type="text" style="width:20px;" maxlength="2" value="<?php echo $this->detail->rfps_by_property_limit; ?>" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
					Vendor Logo Dimensions
					</th>
				</tr>
				<tr>
					<td width="300">
				   Logo Height:
					</td>
					<td>
					<input name="vendor_logo_height" type="text" style="width:20px;" value="<?php echo $this->detail->vendor_logo_height; ?>" />
					</td>
				</tr>	
				<tr>
					<td width="300">
				   Logo Width:
					</td>
					<td>
					<input name="vendor_logo_width" type="text" style="width:20px;"  value="<?php echo $this->detail->vendor_logo_width; ?>" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
					Vendor GLI Policy Limits
					</th>
				</tr>
				<tr>
					<td width="300">
				   Verified Policy Limits:
					</td>
					<td>
					<input name="vendor_policy_limits" type="text" style="width:120px;" value="<?php echo $this->detail->vendor_policy_limits; ?>" />
					</td>
				</tr>	
				<tr>
					<td width="300">
				   Aggregate:
					</td>
					<td>
					<input name="vendor_aggregate" type="text" style="width:120px;"  value="<?php echo $this->detail->vendor_aggregate; ?>" />
					</td>
				</tr>		
				<tr>
					<th colspan="2">
					Vendor Payment Settings:
					</th>
				</tr>
				<tr>
					<td width="300">
				    <input name="payment_type" id="payment_type" type="radio"  value="Paypal" checked="checked" onclick="javascript: document.getElementById('show_paypal').style.display = 'block';  document.getElementById('show_authorize').style.display = 'none'; " <?php if($this->detail->payment_type == 'Paypal') { ?> checked="checked" <?PHP } ?>  />&nbsp;Paypal
					</td>
					<td>
					<input name="payment_type" id="payment_type" type="radio"  value="Authorize" onclick="javascript:  document.getElementById('show_authorize').style.display = 'block'; document.getElementById('show_paypal').style.display = 'none'; " <?php if($this->detail->payment_type == 'Authorize') { ?> checked="checked" <?PHP } ?> />&nbsp;Authorize
					</td>
				</tr>
				<tr id="show_paypal" <?php if($this->detail->payment_type == 'Authorize') { ?> style="display:none" <?PHP } ?> ><td colspan="2"><table>
				<tr><td>Payer's Name</td><td><input type="text" name="pay_name" id="pay_name" value="<?php echo $this->detail->pay_name; ?>" /></td></tr>
				<tr><td>Papal Currency</td><td><input type="radio" name="pay_currency" id="pay_currency" value="USD" checked="checked" <?php if($this->detail->pay_currency == 'USD') { ?> checked="checked" <?PHP } ?> />&nbsp;USD&nbsp;&nbsp;<input type="radio" name="pay_currency" id="pay_currency" value="Euro" <?php if($this->detail->pay_currency == 'Euro') { ?> checked="checked" <?PHP } ?> />&nbsp;Euro</td></tr>
				<tr><td>Business Email</td><td><input type="text" name="pay_busness_email" style="width:150px"  id="pay_busness_email" value="<?php echo $this->detail->pay_busness_email; ?>" /></td></tr>
				</table></td>
				</tr>
				<tr id="show_authorize" <?php if($this->detail->payment_type == 'Paypal') { ?>  style="display:none"<?PHP } ?>><td colspan="2"><table>
				<tr><td>Transaction Key</td><td><input type="text" name="auth_tx_key" id="auth_tx_key" value="<?php echo $this->detail->auth_tx_key; ?>" /></td></tr>
				<tr><td>Authorize Login ID</td><td><input type="text" style="width:150px" name="auth_login_id" id="auth_login_id" value="<?php echo $this->detail->auth_login_id; ?>" /></td></tr>
				</table></td>
				</tr>
                <tr>
					<th colspan="2">
					Vendor Available jobs:
					</th>
				</tr>
                <tr><td>Available RFP`s per page</td><td><input type="text" name="av_page" id="av_page" value="<?php echo $this->detail->av_page; ?>" /></td></tr>
				<?php //echo "<pre>"; print_r($this->detail->calender_on_off); ?>
				 <tr><td>Turn On Sat,Sun,Mon On Proposal Due Date</td><td><input type="radio" name="calender_on_off" value="yes" <?php if($this->detail->calender_on_off=='yes') { ?> checked="checked" <?php } ?> />Yes<input type="radio" name="calender_on_off" value="no" <?php if($this->detail->calender_on_off=='no') { ?> checked="checked" <?php } ?> />No</td></tr>
				  <tr>
					<th colspan="2">
					About Survey:
					</th>
				</tr>
				 <tr><td>Days after to survey</td><td><input type="text" name="survey_days" value="<?php echo $this->detail->survey_days; ?>" /></td></tr>
				</table>
			</td>
		</tr>
		</table>

<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="configuration" />
</form>


