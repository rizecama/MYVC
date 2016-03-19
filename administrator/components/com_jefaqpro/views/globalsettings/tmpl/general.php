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

$doc		 = & JFactory::getDocument();
$js  		 = JURI::base().'components/com_jefaqpro/assets/js/validate.js';
$doc->addScript($js);

?>

<!-- General Settings -->
<fieldset class="adminform">
	<legend><?php echo JText::_( 'JE_GENERAL_CONFIG' ); ?></legend>
		<table class="admintable" width="100%">
			<tr>
				<td align="right" class="jekey" width="38%">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_SHOWFORM' ); ?>::<?php echo JText::_( 'JE_SHOWFORMDES' ); ?>">
						<label for="show_form">
							<?php echo JText::_( 'JE_SHOWFORM' ); ?>:
						</label>
					</span>
				</td>
				<td width="62%">
					<?php
						$show_form = ($this->items->id) ? $this->items->show_form : 0;
						echo JHTML::_('select.booleanlist',  'show_form', '', $show_form );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_SHOWREGUSER' ); ?>::<?php echo JText::_( 'JE_SHOWREGUSERDES' ); ?>">
						<label for="show_reguser">
							<?php echo JText::_( 'JE_SHOWREGUSER' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$show_reguser = ($this->items->id) ? $this->items->show_reguser : 0;
						echo JHTML::_('select.booleanlist',  'show_reguser', '', $show_reguser );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FOOTERTEXT' ); ?>::<?php echo JText::_( 'JE_FOOTERTEXTDES' ); ?>">
						<label for="footer_text">
							<?php echo JText::_( 'JE_FOOTERTEXT' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$footer_text = ($this->items->id) ? $this->items->footer_text : 0;
						echo JHTML::_('select.booleanlist',  'footer_text', '', $footer_text );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_AUTHOR' ); ?>::<?php echo JText::_( 'JE_FAQ_AUTHORDES' ); ?>">
						<label for="show_author">
							<?php echo JText::_( 'JE_FAQ_AUTHOR' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$show_author = ($this->items->id) ? $this->items->show_author : 0;
						echo JHTML::_('select.booleanlist',  'show_author', '', $show_author );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_DATE' ); ?>::<?php echo JText::_( 'JE_FAQ_DATEDES' ); ?>">
						<label for="show_date">
							<?php echo JText::_( 'JE_FAQ_DATE' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$show_date = ($this->items->id) ? $this->items->show_date : 0;
						echo JHTML::_('select.booleanlist',  'show_date', '', $show_date );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_SHOWHITS' ); ?>::<?php echo JText::_( 'JE_FAQ_SHOWHITSDES' ); ?>">
						<label for="show_hits">
							<?php echo JText::_( 'JE_FAQ_SHOWHITS' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$show_hits = ($this->items->id) ? $this->items->show_hits : 0;
						echo JHTML::_('select.booleanlist',  'show_hits', '', $show_hits );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_ALLOW_REG_RESPONSE' ); ?>::<?php echo JText::_( 'JE_FAQ_ALLOW_REG_RESPONSEDES' ); ?>">
						<label for="allow_reg">
							<?php echo JText::_( 'JE_FAQ_ALLOW_REG_RESPONSE' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$allow_reg = ($this->items->id) ? $this->items->allow_reg : 0;
						echo JHTML::_('select.booleanlist',  'allow_reg', '', $allow_reg );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_FAQ_RESPONSE' ); ?>::<?php echo JText::_( 'JE_FAQ_RESPONSEDES' ); ?>">
						<label for="show_response">
							<?php echo JText::_( 'JE_FAQ_RESPONSE' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<?php
						$show_response = ($this->items->id) ? $this->items->show_response : 0;
						echo JHTML::_('select.booleanlist',  'show_response', '', $show_response );
					?>
				</td>
			</tr>
			<tr>
				<td align="right" class="jekey">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_DATEFORMAT' ); ?>::<?php echo JText::_( 'JE_DATEFORMATDES' ); ?>">
						<label for="date_format">
							<?php echo JText::_( 'JE_DATEFORMAT' ); ?>:
						</label>
					</span>
				</td>
				<td>
					<input type="text" name="date_format" size="30" id="date_format" value="<?php echo $this->items->date_format; ?>" />
					<?php
						$date	 			= new JDate();
						$today				= $date->toFormat( $this->items->date_format );
						echo '&nbsp;'.$today;
					?>
				</td>
			</tr>
		</table>
</fieldset>
<!-- General Settings End-->