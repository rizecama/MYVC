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
$editor = & JFactory::getEditor();

if ( $this->user->get('id') != '0' ) {
	$diabled = 'Readonly="true"';
} else {
	$diabled = '';
}

if ( $this->user->get('gid') != 0 ) {
	$gid =  $this->user->get('gid');
} else {
	$gid =  1;
}

?>

<div class="componentheading">
	<?php
		if($this->params->get('show_page_title', 1)) {
			//echo $this->params->get('page_title');
		} else {
			//echo JText::_( 'JE_ADD_FAQS' );
		}
	?>
</div>
<?php 

$form = '0';
$msg  = '';
if ( $this->settings->show_form == '1' ) {
	if ( $this->settings->show_reguser == '1' ){
		if ( $this->user->get('id') > 0 ) {
			$form = '1';
		} else {
			$form = '0';
			$msg = JText::_('JE_ENABLEUSERS');
		}
	} else {
		$form = '1';
	}
} else {
	$msg =  JText::_('JE_ENABLEFORM');
}


if ( $form == '1' ) {

		// Get session
		$session 			= & JFactory::getSession();
		$ses 				= $session->get('formvalues');

		if ( isset( $ses ) ) {
			$uname  				  = $ses['posted_by'];
			$uemail 				  = $ses['posted_email'];
			$this->catid			  = $ses['catid'];
			$questions				  = $ses['questions'];
		} else {
			$uname  				  = $this->user->get('name');
			$uemail 				  = $this->user->get('email');
			$questions				  = '';
		}
?>
<div id="je-form">
	<form action="index.php" method="post" name="jeForm" id="jeForm" class="form-validate">
		<!--<span style="font-size : 15pt;"><?php //echo JText::_( 'JE_ADD_FAQS' ); ?>   </span>-->

<div id="je-categorylisting81">
				    		 		 		 	<img hspace="6" height="25" align="left" width="25" src="http://www.camassistant.com/cms//images/stories/jefaqcategory/1303267785.png" alt="1303267785.png" title="Property Manager FAQs">
				 	     <span id="je-category81"><?php echo JText::_( 'JE_ADD_FAQS' ); ?> </span>				<div class="clr"></div>
		</div>

		<table cellpadding="3" width="100%">
			<tr>
				<td align="left" colspan="2" height="40">
					<label for="required">
						<?php echo JText::_( 'JE_REQUIRED' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td align="left" width="15%" height="40">
					<label for="posted_by">
						<?php echo JText::_( 'JE_NAME' ); ?> :<span id="je-faqrequired">*</span>
					</label>
				</td>
				<td width="85%">
					<input class="inputbox required" type="text" name="posted_by" id="posted_by" size="25" maxlength="256" <?php echo $diabled; ?> value="<?php echo $uname; ?>" />
				</td>
			</tr>
			<tr>
				<td align="left">
					<label for="posted_email">
						<?php echo JText::_( 'JE_EMAIL' ); ?> :<span id="je-faqrequired">*</span>
					</label>
				</td>
				<td>
					<input class="inputbox required validate-email" type="text" name="posted_email" id="posted_email" size="25" maxlength="256" <?php echo $diabled; ?> value="<?php echo $uemail; ?>" />
				</td>
			</tr>
			<tr>
				<td align="left" height="40">
					<label for="catid">
						<?php echo JText::_( 'JE_CATEGORY' ); ?> :<span id="je-faqrequired">*</span>
					</label>
				</td>
				<td>
					<?php echo JHTML::_('select.genericlist', $this->category, 'catid', 'class="inputbox required" style="width : 175px;"', 'value', 'text', $this->catid) ?>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" height="40">
					<label for="questions">
						<?php echo JText::_( 'JE_QUESTIONS' ); ?> :<span id="je-faqrequired">*</span>
					</label>
				</td>
				<td>
					<textarea class="inputbox required" type="text" name="questions" id="questions" rows="3" cols="30" value="" ><?php echo $questions; ?></textarea>
				</td>
			</tr>

			<?php if ($this->settings->show_captcha == '1') :	?>
			<tr>
				<td align="left" height="40">
					<label for="autarticaptcha_entry">
						<?php echo JText::_( 'JE_CAPTCHA' ); ?> :<span id="je-faqrequired">*</span>
					</label>
				</td>
				<td>
					<table>
						<tr>
							<td>
									<?php echo(AutarticaptchaHelper::generateHiddenTags());?>
									<?php echo(AutarticaptchaHelper::generateInputTags());?>
							</td>
							<td>
									<?php echo(AutarticaptchaHelper::generateImgTags("components/com_jefaqpro/captcha/"));?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php  endif;	?>
			<tr>
				<td>
				&nbsp;
				</td>
				<td align="left" height="40">
					<input class="button validate" type="submit" name="subfaq" value="<?php echo JText::_( 'JE_SUBMIT' ); ?>" />
				</td>
			</tr>
		</table>

		<div class="clr"></div>

		<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
		<input type="hidden" name="remote_ip" value="<?php echo $this->remote_ip; ?>" />
		<input type="hidden" name="posted_date" value="<?php echo $this->today; ?>" />
		<input type="hidden" name="option" value="com_jefaqpro" />
		<input type="hidden" name="view" value="<?php echo $this->view; ?>" />
		<input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>" />
		<input type="hidden" name="id" value="" />
		<input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
<?php 
} else {
	echo '<div style="padding : 10px; text-align : center"><strong>'. $msg .'</strong></div>';
}
?>
<br style="clear : both" />

<?php if ( $this->settings->footer_text == '1') : ?>
	<p class="copyright" style="text-align : right; font-size : 10px;">
		<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
	</p>
<?php endif; ?>