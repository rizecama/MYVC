<?php
//restricted access
defined('_JEXEC') or die('Restricted access');

// import html tooltips
JHTML::_('behavior.tooltip');

?>


<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th class="content">
			Configuration Emails: <small><?php echo $this->detail->id ? 'Edit' : 'Add';?></small>
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
					<td width="300">
					Customer Conformation Email:
					</td>
					<td >
					<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'customer_confirm',  $this->detail->customer_confirm , '30%', '200', '75', '20','false' ) ;
					?>
					</td>
				</tr>
				<tr>
					<td width="300">
						Customer Approval Email:
					</td>
					<td >
					<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'customer_appemail',  $this->detail->customer_appemail , '30%', '200', '75', '20','false' ) ;
					?>
					</td>
				</tr>
				
				<tr>
					<td width="300">
					Vendor Approval Email:
					</td>
					<td >
					<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'vendor_appemail',  $this->detail->vendor_appemail , '30%', '200', '75', '20','false' ) ;
					?>
					</td>
				</tr>
					<tr>
						<td width="300">
					Invite a Vendor to be an In-House Vendor:
						</td>
						<td colspan="2">
						<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'invite_vinhouse',  $this->detail->invite_vinhouse , '30%', '200', '75', '20','false' ) ;
					?>
						</td>
					</tr>
				<tr>
					<td width="300">
				Invite a Vendor to be Preferred:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'invite_vpreferred',  $this->detail->invite_vpreferred , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				A Professional Hired by the Property Association:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'pro_hired_propertyassociation',  $this->detail->pro_hired_propertyassociation , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
				<tr>
					<td width="300">
				Hire a Professional through CAM Assistant:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'hire_pro_camassistant',  $this->detail->hire_pro_camassistant , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				Have up to 3 Vendors that meet my Project criteria define the SOW for free:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'vendors_meet_myproject',  $this->detail->vendors_meet_myproject , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				Automated Award Email (Automatically sent out when a Vendors Proposal is marked as Accepted):
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'automated_awardemail',  $this->detail->automated_awardemail , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				Automated Rejection Email (Automatically sent out to non-awarded Vendors):
					</td>
					<td>
						<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'automated_rejectedemail',  $this->detail->automated_rejectedemail , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
				<tr>
					<td width="300">
				Invite New Manager:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'invite_manager',  $this->detail->invite_manager , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
						<td width="300">
					Invite a Vendor to be an In-House Vendor(With out Registration):
						</td>
						<td colspan="2">
						<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'invite_rvinhouse',  $this->detail->invite_rvinhouse , '30%', '200', '75', '20' ) ;
					?>
						</td>
					</tr>
				<tr>
					<td width="300">
				Invite a Vendor to be Preferred(With out Registration):
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'invite_rvpreferred',  $this->detail->invite_rvpreferred , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				 Email to Board member when create a RFP:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'email_boardmember',  $this->detail->email_boardmember , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				 RFP Invitation From CAMAssistant:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'rfp_invitation',  $this->detail->rfp_invitation , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
					<tr>
					<td width="300">
				Update RFP Invitation From CAMAssistant:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'udrfp_invitation',  $this->detail->udrfp_invitation , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>

<tr>
					<td width="300">
				 Vendor Activation link:
					</td>
					<td>
				<?php
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'vendor_activation',  $this->detail->vendor_activation , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>
<tr>
					<td width="300">
				Cancel RFP:
					</td>
					<td>
				<?php
						//print_r($this->detail->cancel_rfp);
						// parameters : areaname, content, width, height, cols, rows
						$editor=&JFactory::getEditor();
						echo $editor->display( 'cancel_rfp',  $this->detail->cancel_rfp , '30%', '200', '75', '20' ) ;
					?>
					</td>
					</tr>

				</table>
			</td>
			
		</tr>
		</table>

<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="mails" />
</form>


