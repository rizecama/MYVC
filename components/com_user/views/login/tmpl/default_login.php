<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang = &JFactory::getLanguage();
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
						' var comlogin = 1;';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');
endif; ?>
<script type="text/javascript" src="components/com_camassistant/skin/js/jquery-1.4.4.min.js"></script>
<script>
K = jQuery.noConflict();

K(document).ready(function() {	
	//select all the a tag with name equal to modal
	var uname,pwd;
	K('#lgnButton').click(function(e) { 
	 uname = document.comlogin.username.value;
	 pwd = document.comlogin.passwd.value;
 	 document.loginsinner.username.value=uname;
	 document.loginsinner.passwd.value=pwd;
	 document.loginsinner.submit();	 
	});
	
});

</script>
<style>
#maskinner {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxesinner .window {
  position:absolute;
  left:0;
  top:0;
  width:350px;
  height:150px;
  display:none;
  z-index:9999;
  padding:20px;
}


#boxesinner #submitinner {
  width:300px; 
  height:150px;
  padding:10px;
  background-color:#ffffff;
}
#doneinner {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
#closeinner {
border:0 none;
cursor:pointer;
height:30px;
margin:0;
padding:0;
}
</style>

<div class="left-pan login-pan" style="text-align:center;">
<form action="<?php echo JRoute::_( 'index.php', true, $this->params->get('usesecure')); ?>" method="post" name="comlogin" id="com-form-login">
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="contentpane<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
<tr>
	
</tr>

</table>

	<p id="com-form-login-username">
		<br />
		<input name="username" id="username" type="text" class="inputbox" alt="username" size="18" placeholder="E-Mail" value="" onclick="if(this.placeholder == 'E-Mail') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='E-Mail';" />
	</p>
	<p id="com-form-login-password">
		<br />
		<input type="password" id="passwd" name="passwd" class="inputbox" placeholder="Password" size="18" alt="password" value="" style="margin-left:3px;" onclick="if(this.placeholder == 'Password') this.placeholder='';" onblur="if(this.placeholder == '') this.placeholder ='Password';" onfocus="this.placeholder=''" />
	</p>
    <div id="forgot" style="padding-left:33px;" align="center">
	<table width="62%" cellpadding="0" cellspacing="0"><tr><td><input type="checkbox" name="terms" id="terms" style="padding:0px; margin:0px; width:auto; margin-right:5px; float:none; box-shadow:none;" tabindex="3" /></td>
	<td>Remember Me</td><td>
        &nbsp;&nbsp;&nbsp;<span style="margin-left:63px;">Forgot your password? <a href="index.php?option=com_user&view=reset&Itemid=137">Click here.</a></span></td></tr></table></div>
	<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
	<!--<p id="com-form-login-remember">
		<label for="remember"><?php //echo JText::_('Remember me') ?></label>
		<input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" alt="Remember Me" />
	</p>-->
	<?php endif; ?>
<!--	<input type="submit" name="Submit" id="lgnButton" class="button" value="<?php //echo JText::_('LOGIN') ?>" />-->
<p style="height:20px;"></p>
    <button type="submit" id="lgnButton" name="Submit" class="button" tabindex="4" style="margin-left:11px; float:none;"><img src="templates/camassistant/images/login.png" /></button>
        <div class="clear"></div>
        
	<?php /*?><li>
		<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
		<?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
	</li><?php */?>
	<?php /*?><li>
		<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind' ); ?>">
		<?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a>
	</li><?php */?>
	<?php
	$usersConfig = &JComponentHelper::getParams( 'com_users' );
	if ($usersConfig->get('allowUserRegistration')) : ?>
	<?php /*?><li>
		<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=register' ); ?>">
			<?php echo JText::_('REGISTER'); ?></a>
	</li><?php */?>
	<?php endif; ?>
</ul>
 <?php
	if($_GET['return']){
	$_SESSION['return'] = $_GET['return'];
	}
	?>
        <input type="hidden" name="return" value="<?php echo $_GET['return']; ?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />

	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<div id="boxesinner">		
<div id="submitinner" class="window">
<form name="loginsinner" id="loginsinner" method="post">
<div style="padding-top:40px; text-align:center"><font color="#21314D">Do you Agree to the&nbsp;</font><a style="text-decoration: none;" title="Click here" class="modal" rel="{handler: 'iframe', size: {x: 680, y: 530}}" href="index2.php?option=com_content&amp;view=article&amp;id=51&amp;Itemid=113" target="_blank"><font color="#7AB800">Terms & Conditions</font><font color="#7ab800">?</font></a></div>
<div style="padding-top:20px; text-align:center;">
<button id="doneinner" name="done" value="Ok"><img src="templates/camassistant/images/yes.gif" /></button>
<button id="closeinner" name="close" value="Cancel"><img src="templates/camassistant/images/No.gif" /></button></div>
<input type="hidden" name="username" value="" />
<input style="display:none;" type="password" name="passwd" value="" />
<input type="hidden" name="option" value="com_user" />
<input type="hidden" name="task" value="login" />

<input type="hidden" name="return" value="<?php echo $_GET['return']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
  <div id="maskinner"></div>
</div>