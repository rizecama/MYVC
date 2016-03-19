<?php
/**
 * jeFAQ Pro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<!-- Email Settings -->
<fieldset class="adminform">
	<legend><?php echo JText::_( 'JE_EMAIL_CONFIG' ); ?></legend>
		<table class="admintable" width="100%">
			<tr>
				<td align="right" class="jekey" width="25%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_ENABLE_USEREMAIL' ); ?>::<?php echo JText::_( 'JE_ENABLE_USEREMAILDES' ); ?>">
						<label for="user_email">
							<?php echo JText::_( 'JE_ENABLE_USEREMAIL' ); ?>:
						</label>
					</span>
				</td>
				<td width="75%">
					<?php
						$user_email = ($this->items->id) ? $this->items->user_email : 0;
						echo JHTML::_('select.booleanlist',  'user_email', '', $user_email );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey" width="20%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_ENABLE_ADMINEMAIL' ); ?>::<?php echo JText::_( 'JE_ENABLE_ADMINEMAILDES' ); ?>">
						<label for="admin_email">
							<?php echo JText::_( 'JE_ENABLE_ADMINEMAIL' ); ?>:
						</label>
					</span>
				</td>
				<td width="80%">
					<?php
						$admin_email = ($this->items->id) ? $this->items->admin_email : 0;
						echo JHTML::_('select.booleanlist',  'admin_email', '', $admin_email );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey" width="20%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_ADMINEMAILID' ); ?>::<?php echo JText::_( 'JE_ADMINEMAILIDDES' ); ?>">
						<label for="emailid">
							<?php echo JText::_( 'JE_ADMINEMAILID' ); ?>:
						</label>
					</span>
				</td>
				<td width="80%">
					<input type="text" size="35" name="emailid" id="emailid" value="<?php echo $this->items->emailid ?>" />
				</td>
			</tr>
		</table>
</fieldset>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'JE_SORTFAQ' ); ?></legend>
		<table class="admintable" width="100%">
			<tr>
				<td align="right" class="jekey" width="25%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_ORDERBY' ); ?>::<?php echo JText::_( 'JE_ORDERBYDES' ); ?>">
						<label for="group">
							<?php echo JText::_( 'JE_ORDERBY' ); ?>:
						</label>
					</span>
				</td>
				<td width="75%">
					  <?php echo JHTML::_( 'select.genericlist', $this->group, 'group', '' ,'value','text', $this->items->group ); ?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_SORTBY' ); ?>::<?php echo JText::_( 'JE_SORTBYDES' ); ?>">
						<label for="sorting">
							<?php echo JText::_( 'JE_SORTBY' ); ?>:
						</label>
					</span>
				</td>
				<td>
					 <?php echo JHTML::_( 'select.genericlist', $this->sorting, 'sorting', '' ,'value','text', $this->items->sorting ); ?>
				</td>
			</tr>
		</table>
</fieldset>
<!-- Email Settings End-->