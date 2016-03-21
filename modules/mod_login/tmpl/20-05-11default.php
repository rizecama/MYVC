<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
function submitform()
{
    if(document.login.onsubmit && 
    !document.login.onsubmit())
    {
        return;
    }
 document.login.submit();
}

</script> 
<script type="text/javascript">
function validate()
{

if (document.login.terms.checked == false)
  {
  var result = confirm('Do you Agree to the Terms & Conditions?');
if(result == true)
	{
	return true;
	}
	else {
	return false;
	}


	 }
} 
</script>
<?php if($type == 'logout') : ?>
<form action="index.php" method="post" name="login" id="form-login" >
      <div id="welocme">
<?php if ($params->get('greeting')) : ?>
	
	<?php if ($params->get('name')) : {
		echo JText::sprintf( 'HINAME', $user->get('name') );
	} else : {
echo  'Hi '.$user->get('name').' '.$user->get('lastname').'!'; //		
//echo JText::sprintf( 'HINAME', $user->get('name').'&nbsp;'.$user->get('lastname') );
	} endif; ?>
	
	
<?php endif; ?>
	<img align="absbottom" src="templates/camassistant_inner/images/blue-small.gif" alt="arrow_image">
		<!--<input type="submit" name="Submit"  value="<?php echo JText::_( 'Sign Out'); ?>" />
-->		<a href="#" onclick="javascript:submitform()"  style="border:0;">Sign Out</a>
	
</div>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<?php else : ?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
						' var modlogin = 1;';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');
endif; ?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" onsubmit="return validate();" >
	<?php echo $params->get('pretext'); ?>
	
	<div id="signin_button"> 
        <div class="clear"></div>
      </div><div id="signin"><div id="signin_user">
          <label></label>
		  <input id="modlgn_username" type="text" style="width:161px;" name="username" alt="username"  tabindex="1" />
         
        </div>
		<div id="signin_password">
          <label></label>
		  	<input id="modlgn_passwd" type="password" name="passwd" style="width:111px"  alt="password" tabindex="2"/>
        </div>
		<span>
		 <!--	<input type="submit" name="submit" id="logibtn" src="templates/camassistant/images/go.gif"/>-->
		 <button type="submit" id="logibtn" name="submit" tabindex="4"><img src="templates/camassistant/images/go.gif" /></button>
		 
			<!--<a href="javascript: submitform()"><img src="templates/camassistant/images/go.gif" alt="go" border="0" /></a>-->
</span>
        <div class="clear"></div>
        <div class="clear"></div>
        <div id="forgot"><input type="checkbox" name="terms" id="terms" style="padding:0px; margin:0px; width:auto; margin-right:5px;" tabindex="3" />Agree to <a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=51&amp;Itemid=113">Terms & Conditions</a>
        &nbsp;&nbsp;&nbsp;Forgot your password? <a href="index.php?option=com_user&view=reset&Itemid=137">Click here.</a></div>

	<?php /*?><fieldset class="input">
	<p id="form-login-username">
		<label for="modlgn_username"><?php echo JText::_('Username') ?></label><br />
		<input id="modlgn_username" type="text" name="username" class="inputbox" alt="username" size="18" />
	
		<label for="modlgn_passwd"><?php echo JText::_('Password') ?></label><br />
		<input id="modlgn_passwd" type="password" name="passwd" class="inputbox" size="18" alt="password" />
	</p>
	<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
	<p id="form-login-remember">
		<label for="modlgn_remember"><?php echo JText::_('Remember me') ?></label>
		<input id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" />
	</p>
	<?php endif; ?>
	<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
	</fieldset>
	<ul>
		<li>
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
			<?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind' ); ?>">
			<?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		<?php
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li>
			<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=register' ); ?>">
				<?php echo JText::_('REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul><?php */?>
	<?php echo $params->get('posttext'); ?>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />

	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	</div>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php endif; ?>