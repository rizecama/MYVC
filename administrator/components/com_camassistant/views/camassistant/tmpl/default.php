<?php
/**
 * @version 1.0 $Id: default.php 958 2009-02-02 17:23:05Z julienv $
 * @package Joomla
 * @subpackage EventList
 * @copyright (C) 2005 - 2009 Christoph Lukes
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * EventList is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with EventList; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined('_JEXEC') or die('Restricted access');
// import html tooltips
JHTML::_('behavior.tooltip');
JToolBarHelper::title(   JText::_( 'MyVendorCenter' ), 'generic.png' );
$user = JFactory::getUser(); if($user->usertype=='Manager' && $user->gid=='23') { ?>
<table><TR>
			  <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=vendorsordercentre&amp;task=vendorsordercentre"><img src="./components/com_camassistant/assets/images/icons/manage_customers.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title="Vendor Compliance Doocuments"  href="index.php?option=com_camassistant&amp;controller=vendorcompliances&amp;task=vendorcompliances_list" ><strong><u>Vendor Compliance Documents</u></strong></a><br>
						Vendor Compliance Documents<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td></TR></table>
<?php } else { ?>
	<table width="100%" cellspacing="0"  cellpadding="0" class="" style="background:url(./components/com_camassistant/assets/images/header-controlpanelindex.jpg); background-repeat: no-repeat;"  align="left">
  <!--<tr>
    <td height="62"></td>
  </tr>-->
  <tr valign="top">
    <td width="100%" align="left"><table  class="adminform">
        <tr class="adminlist">
          <td width="50%">
            <table cellpadding="0" cellspacing="0" width="98%" align="center" style="height:350px">
              <TR>
			    <td width="162">
					<table width="90%" class="adminlist" >
					  <tr >
					  	<td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=category"><img src="./components/com_camassistant/assets/images/icons/manage_categories.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_camassistant&amp;controller=category" title="Create,Edit and Delete Industries" ><strong><u>Manage Industries</u></strong></a><br>
						  Create,Edit and Delete Industries
						</td>
					  </tr>
					</table>
				</td>
                <td width="162">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=customer"><img src="./components/com_camassistant/assets/images/icons/manage_customers.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_camassistant&amp;controller=customer" title="Create,Edit and Delete Customers"><strong><u>Manage Managers</u></strong></a><br>
						 Create,Edit and Delete Customers
						</td>
					  </tr>
					</table>
				</td>
				 <td width="162">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=configuration"><img src="./components/com_camassistant/assets/images/icons/configuration.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_camassistant&controller=configuration" title="Edit The configuration"><strong><u>Configuration</u></strong></a><br>
						  Edit The configuration
						</td>
					  </tr>
					</table>
				</td>
				 
              </TR>
              <TR>
			  <td width="162">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=vendors&amp;task=displayext"><img src="./components/com_camassistant/assets/images/icons/manage_v.endors.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_camassistant&amp;controller=vendors&amp;task=displayext" title="Create,Edit and Delete Vendors"><strong><u>Manage Vendors</u></strong></a><br>
						   Create,Edit and Delete Vendors
						</td>
					  </tr>
					</table>
				</td>
				
			  <td width="162">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_content&filter_sectionid=8"><img src="./components/com_camassistant/assets/images/icons/manag_emails.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_content&filter_sectionid=8" title="Creat & Edit Mails"><strong><u>Manage Emails</u></strong></a><br>
						  Creat & Edit Mails
						</td>
					  </tr>
					</table>
				</td>
			    <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=assignproperty"><img src="./components/com_camassistant/assets/images/icons/manage_properties.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_camassistant&amp;controller=propertyowner" title="Create,Edit and Delete Properties"><strong><u>Manage Property owners</u></strong></a><br>
						 Create,Edit and Delete Properties
						</td>
					  </tr>
					</table>
				</td>
				
               <TR >
			   </td>
			    <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=assignproperty"><img src="./components/com_camassistant/assets/images/icons/manage_properties.png" border="0"></a></td>
					    <td width="70%">
						  <a href="index.php?option=com_camassistant&amp;controller=assignproperty" title="Create,Edit and Delete Properties"><strong><u>Manage Properties</u></strong></a><br>
						 Create,Edit and Delete Properties
						</td>
					  </tr>
					</table>
				</td>
			  <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=invitevendors"><img src="./components/com_camassistant/assets/images/icons/invite_vendors.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title=" Invited Vendors"  href="index.php?option=com_camassistant&controller=invitevendors" rel="{handler: 'iframe', size: {x: 629, y: 450}}" ><strong><u>Old Invited Vendors</u></strong></a><br>
						Old Invited Vendors<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
				<td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=newinvitevendors"><img src="./components/com_camassistant/assets/images/icons/invite_vendors.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title=" Invited Vendors"  href="index.php?option=com_camassistant&controller=newinvitevendors" rel="{handler: 'iframe', size: {x: 629, y: 450}}" ><strong><u>New Invited Vendors</u></strong></a><br>
						 New Invited Vendors<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
			   
			   
			
              </TR>
			   </TR>
	

              <TR >
			  <?php /*?><td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=vendorsordercentre&amp;task=vendorsordercentre"><img src="./components/com_camassistant/assets/images/icons/manage_customers.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title="Invite"  href="index.php?option=com_camassistant&amp;controller=vendorsordercentre&amp;task=vendorsordercentre" ><strong><u>Vendor Order Centre</u></strong></a><br>
						 Total Vendor Orders<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td><?php */?>
			   <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=documents"><img src="./components/com_camassistant/assets/images/icons/document_center.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title="Document Center"  href="index.php?option=com_camassistant&controller=documents" rel="{handler: 'iframe', size: {x: 629, y: 450}}" ><strong><u>Document Center </u></strong></a><br>
						 Uploading File Types<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
			     <td width="180">
					<table width="100%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=announcement"><img src="./components/com_camassistant/assets/images/icons/manage_customers.png" border="0"></a></td>
					    <td width="80%">
						  <a class="modal" id="links1"  title="announcements of customers,cam admin and vendors"  href="index.php?option=com_camassistant&controller=announcement" ><strong><u>Manage Announcements</u></strong></a><br>
						 announcements of customers,cam admin and vendors<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
			  <td width="180">
					<table width="100%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=announcement"><img src="./components/com_camassistant/assets/images/icons/promocode.png" border="0"></a></td>
					    <td width="80%">
						  <a class="modal" id="links1"  title="Create,Edit and Delete Promo Codes"  href="index.php?option=com_camassistant&controller=promocode" ><strong><u>Manage Promo Codes</u></strong></a><br>
						 Create,Edit and Delete Promo Codes<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
					
              </TR>
			  
			  <TR >
			   <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=rfp&rfpstatus=rfp&rfpapproval=1"><img src="./components/com_camassistant/assets/images/icons/manage_customers.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title="Manage RFP's,ITB's and Proposals"  href="index.php?option=com_camassistant&amp;controller=rfp&rfpstatus=rfp&rfpapproval=1" ><strong><u>Manage Rfp's</u></strong></a><br>
						 Manage RFP's,ITB's and Proposals<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
			  <td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=vendorsordercentre&amp;task=vendorsordercentre"><img src="./components/com_camassistant/assets/images/icons/manage_customers.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title="Vendor Compliance Doocuments"  href="index.php?option=com_camassistant&amp;controller=vendorcompliances&amp;task=vendorcompliances_list" ><strong><u>Vendor Compliance Doocuments</u></strong></a><br>
						Vendor Compliance Doocuments<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
				 
                
               <!-- ////By sateesh-->
			  <td width="180">
					<table width="100%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=announcement"><img src="./components/com_camassistant/assets/images/icons/asds.png" border="0"></a></td>
					    <td width="80%">
						  <a class="modal" id="links1"  title="Add question to vendor registration"  href="index.php?option=com_camassistant&controller=questions" ><strong><u>security Questions</u></strong></a><br>
						 Add question to vendor registration<br>&nbsp;
						</td>
						
					  </tr>
					</table>
				</td>
                
			    <!--//Completed-->
              </TR>
              <tr>
              
                </tr>
			 <tr>
			 <td width="180">
					<table width="100%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&controller=announcement"><img src="./components/com_camassistant/assets/images/icons/asds.png" border="0"></a></td>
					    <td width="80%">
						  <a class="modal" id="links1"  title="Login As"  href="index.php?option=com_camassistant&controller=login" ><strong><u>Login As</u></strong></a><br>
						 Login As<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
			 <td width="180">
					<table width="100%" class="adminlist">
					  <tbody><tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&amp;controller=invitecode"><img border="0" src="./components/com_camassistant/assets/images/icons/promocode.png"></a></td>
					    <td width="80%">
						  <a href="index.php?option=com_camassistant&amp;controller=invitecode" title="Create,Edit and Delete Promo Codes" id="links1" class="modal"><strong><u>Manage Invite Codes</u></strong></a><br>
						 Create,Edit and Delete Invite Codes<br>&nbsp;
						</td>
					  </tr>
					</tbody></table>
				</td>
				<td width="166">
					<table width="90%" class="adminlist">
					  <tr>
					    <td width="30%" style="padding-top:10px;padding-bottom:10px;padding-left:10px;"><a href="index.php?option=com_camassistant&view=filetype"><img src="./components/com_camassistant/assets/images/icons/Document-Center-conf.png" border="0"></a></td>
					    <td width="70%">
						  <a class="modal" id="links1"  title="Document Center"  href="index.php?option=com_camassistant&view=filetype" rel="{handler: 'iframe', size: {x: 629, y: 450}}" ><strong><u>Document Center </u></strong></a><br>
						 Uploading File Types<br>&nbsp;
						</td>
					  </tr>
					</table>
				</td>
			 </tr>
            </table>
          </td>
		  <td width="40%">
		  <table  class="adminform1">
  <tr>
    <td><div id="logo">
				<img alt="CAMassistant.com - we do your bidding" src="./components/com_camassistant/assets/images/icons/MyVClogo.gif">
		</div>
		<div id="vender_left" style="width:470px;">
		<p style="margin-top: -61px;z-index:9999;float:right;"><img alt="lady_img" src="./components/com_camassistant/assets/images/icons/ba_vendor_proposal_center.png"></p>
	</div>
		</td>
  </tr>
</table>
</td>

        </tr>
      </table></td>
	  <td width="10%"></td>
	<td width="50%" align="left"><!--<table width="500" height="200"  cellpadding="0" cellspacing="0" class="adminform"><tr><td style="vertical-align: top;"><TABLE cellpadding="0" cellspacing="0" width="98%" align="center" >
			  <TR valign="top" >
			    <td width="166">
					<strong style="color:#0B55C4">Component Status</strong>
									</td>
              </TR>  
			  <TR valign="top" >
			    <td valign="top" width="166"></td>
              </TR>  
            </table>--></td></tr></table><?Php } ?>

	