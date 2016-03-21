<?php
/**
 * @version		1.2 feedback $
 * @package		feedback
 * @copyright	Copyright � 2010 Mertonium. All rights reserved.
 * @license		GNU/GPL
 * @author		Mertonium
 * @author mail	john@mertonium.com
 * @website		http://mertonium.com
 *
 */
?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	// Make sure MooTools is included
	JHTML::_('behavior.mootools');

	$curUser = JFactory::getUser();
	$sliderButton = '<div id="feedback-slider"><img id="feedback-slider" src="https://camassistant.com/live/modules/mod_feedback/images/feedback.gif"></div>';
?>
<?php 
/*
	I've opted to put the style declarations in this file (instead of a separate CSS file) to
	lower the number of calls to the server, thereby improving performance. 
*/
$start_state =  $params->get('start_state','open');
$mod_width = (int)$params->get('mod_width','250') - 10;
$start_pos = ($start_state == 'open') ? 0: 0-$mod_width;
// In order to send module-specific parameters to the component, we put them in an array and encode them
$validation_params = base64_encode(serialize(array('name_req'=>$params->get('name_req'),'email_req'=>$params->get('email_req'),'comment_req'=>$params->get('comment_req'))));

?>
<style type="text/css">
	#feedback-div {
		position: fixed;
		<?php echo $params->get('location','left'); ?>:<?php echo $start_pos; ?>px;
		top: <?php echo $params->get('mod_top','20'); ?>px;
		z-index: <?php echo $params->get('z_index','1001'); ?>;
	}

	#feedback-info {
		padding: 5px;		
		background-color: #efefef;	
		float:left;	
		width:<?php echo $mod_width; ?>px;
		overflow:hidden;
	}
	#feedback-slider {
		float:left;
		width:45px;
		height:134px;
               /* background: #fcc800 url('<?php echo JURI::base(); ?>modules/mod_feedback/images/feedback.gif') right top no-repeat;*/
				cursor:pointer;
		/* background: #f55110 url('<?php echo JURI::base(); ?>modules/mod_feedback/images/feedback.png') right top no-repeat;*/
	}
	#feedback-slider :hover{
	opacity:0.8;
	}
	#submitter_email { width: 220px; }
	#feedback-div dd { margin-left:10px; }
	#feedback-div textarea { 
		width: 220px; 
		height: 200px; 
		
	} 
	#feedback-div textarea, #feedback-div input { 
		font-family: 'Trebuchet MS', Arial, san-serif;
		font-size: 12px;
	}
	#feedback-div .feedback-button {
                background: url("<?php echo JURI::base(); ?>modules/mod_feedback/images/sendfeedback.gif") no-repeat scroll 0 0 transparent;
		/* background-color: #f55110; */
		border: 0;
		color:#000;
               	padding: 3px 80px;
		font-family: Arial, san-serif;
		font-size:40px;
		margin-left:40px;
		cursor:pointer;
	}
	#feedback-div .feedback-button:hover{ opacity:0.8;}
	
	#feedback-div .ajax-loading {
		background-image: url('<?php echo JURI::base(); ?>modules/mod_feedback/images/ajax-loader.gif') right top no-repeat;
	}
	
	#feedback_msg {
		background-color: #fcc800;
		/* background-color: #f55110; */
		color: #000;
              	padding: 3px 10px;
	}
	
	#feedback-div .disabled-button {
		background-color: #F28052;
		color: #737272;
	}
	
	.hideme { display: none; }
</style>
<div id="feedback-div" class="<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php if($params->get('location') == 'right') echo $sliderButton; ?>
	<div id="feedback-info">
		<div id="feedback_msg"></div>
		<div id="feedback_preface"><?php echo $params->get('preface'); ?></div>
		<form id="feedback-form" action="<?php echo JRoute::_('index.php'); ?>" method="post">
			<dl>
				<dt><label for="submitter_name"><?php echo JText::_('Name'); ?></label></dt>
				<dd><input type="text" name="submitter_name" id="submitter_name" value="<?php echo ($curUser->guest) ? '' : $curUser->name; ?>" /></dd>
				<dt><label for="submitter_email"><?php echo JText::_('Email'); ?></label></dt>
				<dd><input type="text" name="submitter_email" id="submitter_email" value="<?php echo ($curUser->guest) ? '' : $curUser->email; ?>" /></dd>			
				<dt><label for="feedback"><?php echo JText::_('Feedback or comments'); ?></label></dt>
				<dd><textarea id="feedback" name="feedback"></textarea></dd>
			</dl>
			<div class="hideme"><label for="bottrap"><?php echo JText::_('Do not fill out this field its a trap'); ?></label><input id="bottrap" name="bottrap" value="" /></div>
			<input type="submit" id="submit-feedback" class="feedback-button" value="" />
			<input type="hidden" name="option" value="com_feedback" />
			<input type="hidden" name="task" value="submitfeedback" />
			<input type="hidden" name="submitter_id" id="submitter_id" value="<?php echo ($curUser->guest) ? '0' : $curUser->id; ?>" />
			<input type="hidden" name="browser" id="browser" value="<?php echo JText::_('Javascript disabled'); ?>" />
			<input type="hidden" name="browser_version" id="browser_version" value="<?php echo JText::_('Javascript disabled'); ?>" />
			<input type="hidden" name="operating_system" id="operating_system" value="<?php echo JText::_('Javascript disabled'); ?>" />
			<input type="hidden" name="screen_resolution" id="screen_resolution" value="<?php echo JText::_('Javascript disabled'); ?>" />
			<input type="hidden" name="url" id="url" value="<?php echo JRequest::getVar('REQUEST_URI','fail','SERVER'); ?>" />
			<input type="hidden" name="user_agent" id="user_agent" value="<?php echo JRequest::getVar('HTTP_USER_AGENT','fail','SERVER'); ?>" />
			<input type="hidden" name="script_name" id="script_name" value="<?php echo JRequest::getVar('SCRIPT_NAME','','SERVER') . JRequest::getVar('QUERY_STRING','','SERVER'); ?>" />
			<input type="hidden" name="referer" id="referer" value="<?php echo JRequest::getVar('HTTP_REFERER','','SERVER'); ?>" />
			<input type="hidden" name="user_ip" id="user_ip" value="<?php echo JRequest::getVar('REMOTE_ADDR','','SERVER'); ?>" />
			<input type="hidden" name="start_time" id="start_time" value="<?php echo date('U'); ?>" />
			<input type="hidden" name="vpms" id="vpms" value="<?php echo $validation_params; ?>" />
			<input type="hidden" name="flood_count" id="flood_count" value="0" />
		</form>
	</div>
	<?php if($params->get('location') == 'left') echo $sliderButton; ?>
</div>

<script type="text/javascript">

	var feedbacktoggle;
	
	window.addEvent(((window.webkit) ? 'load':'domready'), function() {
		// Determine the browser-specific information
		$('browser').value = ($chk(BrowserDetect)) ? BrowserDetect.browser : 'Sorry, we hit a snag, check the User Agent';
		$('browser_version').value = ($chk(BrowserDetect)) ? BrowserDetect.version : 'Sorry, we hit a snag, check the User Agent';
		$('operating_system').value = ($chk(BrowserDetect)) ? BrowserDetect.OS : 'Sorry, we hit a snag, check the User Agent';
		$('screen_resolution').value = screen.width + ' x '+screen.height;
		
		feedbacktoggle = new Fx.Style('feedback-div','<?php echo $params->get('location','left'); ?>', { duration: 1000 });
		feedbacktoggle.set(0-$('feedback-info').getCoordinates().width);
		
		// Disappear the message box at the top of the form
		$('feedback_msg').setOpacity(0);
		
		// Setup the form submission functionality
		$('feedback-form').addEvent('submit', function(e) {			
			new Event(e).stop();
		 
			// This empties the log and shows the spinning indicator
			var log = $('feedback_msg');
			log.empty();
			
			// Run the simple form validation
			errMsg = '';
			
			<?php if($params->get('name_req') == 1) { ?>
			if($('submitter_name').value == '') errMsg += '<?php echo JText::_('Please enter your name'); ?><br />';
			<?php } ?>
			
			<?php if($params->get('email_req') == 1) { ?>
			var emailFilter = new  RegExp("^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$");
			if(!emailFilter.test($('submitter_email').value)) errMsg += '<?php echo JText::_('Please enter a valid email address'); ?><br />';
			<?php } ?>
			
			<?php if($params->get('comment_req') == 1) { ?>
			if($('feedback').value == '') errMsg += '<?php echo JText::_('Please enter some feedback'); ?><br />';
			<?php } ?>
			
			// Check the flood count
			var flooded = false;
			<?php $flood_limit = $params->get('flood_limit'); ?>
			var flood_limit = <?php echo $flood_limit; ?>;
			if($('flood_count').value >= flood_limit) {
				errMsg += "<?php echo JText::sprintf('You are trying to submit more than NUMBER feedback forms on this page and we consider that flooding Please refresh the page to submit more feedback',$flood_limit); ?><br />";
				flooded = true;
			}
			
			// If there are no error messages, submit the form
			if(errMsg == '') {
				$('flood_count').value++;
				disableForm();
				log.effect('opacity').set(0);
				var sbutton = $('feedback-form').addClass('ajax-loading');
				/**
				 * send takes care of encoding and returns the Ajax instance.
				 * onComplete removes the spinner from the log.
				 */
				this.send({
					update: log,
					onComplete: function() {
						sbutton.removeClass('ajax-loading');
						// 'update' doesn't seem to work with mootools 1.2.4 upgrade so we do it manually here
						log.setHTML(this.response.text);	
						log.effect('opacity', { duration: 1000}).start(1);
						log.addEvent('click', function(ev) {
							log.effect('opacity', { 
								duration: 1000, 
								onComplete: function(el) {
									log.empty();
								}							
							}).start(0);
						});
						$('feedback').value = '';
						enableForm();
					}
				});
			} else {
				// Display the validation errors
				log.setHTML(errMsg);
				log.effect('opacity', { duration: 1000}).start(1);
				if(flooded) disableForm();
			}
		});
	});
	
	function disableForm() {
		$('submit-feedback').setProperty('disabled','disabled');
		$('submit-feedback').addClass('disabled-button');
	}
	function enableForm() {
		$('submit-feedback').removeProperty('disabled');
		$('submit-feedback').removeClass('disabled-button');
	}
	
	
	$('feedback-slider').addEvent('click', function(ev) {	
		ev = new Event(ev);		
		// Figure out if we are sliding in or sliding out
		var now = $('feedback-div').getStyle('<?php echo $params->get('location','left'); ?>').toInt();
		var factor = (now < 0) ? 0 : 0-$('feedback-info').getCoordinates().width;
		feedbacktoggle.start(factor);
	});
	
	/************************/
	var BrowserDetect;
	try {
		BrowserDetect = {
			init: function () {
				this.browser = this.searchString(this.dataBrowser) || "<?php echo JText::_('An unknown browser'); ?>";
				this.version = this.searchVersion(navigator.userAgent)
					|| this.searchVersion(navigator.appVersion)
					|| "an unknown version";
				this.OS = this.searchString(this.dataOS) || "<?php echo JText::_('an unknown OS'); ?>";
			},
			searchString: function (data) {
				for (var i=0;i<data.length;i++)	{
					var dataString = data[i].string;
					var dataProp = data[i].prop;
					this.versionSearchString = data[i].versionSearch || data[i].identity;
					if (dataString) {
						if (dataString.indexOf(data[i].subString) != -1)
							return data[i].identity;
					}
					else if (dataProp)
						return data[i].identity;
				}
			},
			searchVersion: function (dataString) {
				var index = dataString.indexOf(this.versionSearchString);
				if (index == -1) return;
				return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
			},
			dataBrowser: [
				{
					string: navigator.userAgent,
					subString: "Chrome",
					identity: "Chrome"
				},
				{ 	string: navigator.userAgent,
					subString: "OmniWeb",
					versionSearch: "OmniWeb/",
					identity: "OmniWeb"
				},
				{
					string: navigator.vendor,
					subString: "Apple",
					identity: "Safari",
					versionSearch: "Version"
				},
				{
					prop: window.opera,
					identity: "Opera"
				},
				{
					string: navigator.vendor,
					subString: "iCab",
					identity: "iCab"
				},
				{
					string: navigator.vendor,
					subString: "KDE",
					identity: "Konqueror"
				},
				{
					string: navigator.userAgent,
					subString: "Firefox",
					identity: "Firefox"
				},
				{
					string: navigator.vendor,
					subString: "Camino",
					identity: "Camino"
				},
				{		// for newer Netscapes (6+)
					string: navigator.userAgent,
					subString: "Netscape",
					identity: "Netscape"
				},
				{
					string: navigator.userAgent,
					subString: "MSIE",
					identity: "Explorer",
					versionSearch: "MSIE"
				},
				{
					string: navigator.userAgent,
					subString: "Gecko",
					identity: "Mozilla",
					versionSearch: "rv"
				},
				{ 		// for older Netscapes (4-)
					string: navigator.userAgent,
					subString: "Mozilla",
					identity: "Netscape",
					versionSearch: "Mozilla"
				}
			],
			dataOS : [
				{
					string: navigator.platform,
					subString: "Win",
					identity: "Windows"
				},
				{
					string: navigator.platform,
					subString: "Mac",
					identity: "Mac"
				},
				{
					   string: navigator.userAgent,
					   subString: "iPhone",
					   identity: "iPhone/iPod"
				},
				{
					string: navigator.platform,
					subString: "Linux",
					identity: "Linux"
				}
			]

		};
		BrowserDetect.init();
	} catch (err) {
		BrowserDetect.browser = 'BrowserDetect did not load.';
		BrowserDetect.version = 'Error: '+err;
		BrowserDetect.OS = 'BrowserDetect did not load.';
	}
</script>
<noscript><?php echo JText::_('Please enable javascript so this form will work properly');?></noscript>