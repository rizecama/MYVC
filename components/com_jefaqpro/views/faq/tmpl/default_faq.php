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
$model  	 = & $this->getModel();

$tempid	 	 = $this->settings->themes ;
$template 	 = 'mymenu'.$tempid ;

?>
<!-- Content area started -->
<div id="contentarea" style="text-align : justify;">
<?php
if ( count($this->items) > 0 ) {
?>
	<div class="yui-skin-sam">
		 <div id="wrapper1">
			<ul id="<?php echo $template; ?>">
				<?php

					$w = 1;
					for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{

						$row 			= &$this->items[$i];
						$res			= $model->getResponsedet( $row->id,$row->catid );
						$count			= $model->getResponsecount( $row->id,$row->catid );

						if ( $count->response_yes == '' )
							$count->response_yes = 0;
						if ( $count->response_no == '' )
							$count->response_no = 0;

						if ( $this->settings->allow_reg == '1' ) {

								if ( $this->user->get('id') > 0 ) {

									if ( $this->user->get('id') == $res->userid && $row->id == $res->faqid && ( $count->response_yes > 0 || $count->response_no > 0) )	{

										$onclick_yes = "onclick=\"getResponse('$i', '1', '$row->id', '$row->catid','2');\"";;
										$onclick_no  = "onclick=\"getResponse('$i', '2', '$row->id', '$row->catid','2');\"";;
										$title		 = JText::_('JE_FAQ_ALREADY');

									} else {

										$title		 = JText::_('JE_FAQ_RESPONSE');
										$onclick_yes = "onclick=\"getResponse('$i', '1', '$row->id', '$row->catid','0');\"";
										$onclick_no  = "onclick=\"getResponse('$i', '2', '$row->id', '$row->catid','0');\"";

									}

								} else {

									$title = JText::_('JE_FAQ_LOGIN');
									$onclick_yes = "onclick=\"getResponse('$i', '1', '$row->id', '$row->catid','1');\"";
									$onclick_no  = "onclick=\"getResponse('$i', '2', '$row->id', '$row->catid','1');\"";

								}

						}  else {

							if ( $this->remote_ip == $res->remote_ip && $row->id == $res->faqid && ( $count->response_yes > 0 || $count->response_no > 0) )	{

								$onclick_yes = "onclick=\"getResponse('$i', '1', '$row->id', '$row->catid','2');\"";;
								$onclick_no  = "onclick=\"getResponse('$i', '2', '$row->id', '$row->catid','2');\"";;
								$title		 = JText::_('JE_FAQ_ALREADY');

							} else	{
								$title		 = JText::_('JE_FAQ_RESPONSE');
								$onclick_yes = "onclick=\"getResponse('$i', '1', '$row->id', '$row->catid','0');\"";
								$onclick_no  = "onclick=\"getResponse('$i', '2', '$row->id', '$row->catid','0');\"";
							}

						}
				?>
						<li>

							<p>	<?php echo $row->questions; ?> </p>
							<div>
								<div class="padded clearfix">
									<?php
									if ($this->settings->show_author == '1' || $this->settings->show_date == '1') {
									 ?>
										<div id="je-posted" style="padding : 5px; text-align : right; font-style : italic;">
											<?php
											if ($this->settings->show_date == '1') {
											?>
												<span id="je-posteddate">
													<?php
														$date 	 = new JDate( $row->posted_date );
														$posted  = $date->toFormat( $this->settings->date_format );
														echo $posted;
													?>
												</span>
											<?php
											}

											if ($this->settings->show_author == '1') {
											?>
												<span id="je-author"> <?php echo '&nbsp;&nbsp;'.$row->posted_by; ?> </span>
											<?php
											}
											?>
										</div>
									<?php
									}

									// Diplay answers here..
									echo $row->answers;

									if ($this->settings->show_response == '1') {
									?>
										<div style="padding : 5px 0px 5px 0px; ">
											<ul id="je-response-ul">
												<li id="je-response" > <span id="je-userlogin<?php echo $i; ?>"></span></li>
												<li id="je-response" > <span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_RESPONSE' )?> :: <?php echo JText::_( 'JE_LIKE' ); ?>"> <span id="je-responsetop<?php echo $i; ?>"><?php echo $count->response_yes; ?></span> <a id="je-atagtop<?php echo $i; ?>" href="javascript:void(0);"  <?php echo $onclick_yes; ?> title="<?php echo $title; ?>" > <span id="je-top"> &nbsp; </span> </a> </span> </li>
												<li id="je-response" > <span class="editlinktip hasTip" title="<?php echo JText::_( 'JE_RESPONSE' )?> :: <?php echo JText::_( 'JE_DISLIKE' ); ?>"> <span id="je-responsebot<?php echo $i; ?>"><?php echo $count->response_no ; ?></span> <a id="je-atagbot<?php echo $i; ?>"  href="javascript:void(0);"  <?php echo $onclick_no; ?> title="<?php echo $title; ?>" > <span id="je-bot"> &nbsp; </span> </a> </span> </li>
											</ul>
										</div>
									<?php
									}
									if ($this->settings->show_hits == '1') {
									?>
										<div id="je-hits<?php echo $w; ?>" style="text-align : right; padding : 2px; font-style : italic;" > <?php echo JText::_('JE_FAQ_HITS').'&nbsp;'.$row->hits; ?> </div>
									<?php
									}
									?>
									<input type="hidden" name="ques_id<?php echo $w; ?>" id="ques_id<?php echo $w; ?>" value="<?php echo $row->id; ?>">
								</div>
							</div>
						</li>

				<?php
						$w++;

					}
				?>
			</ul>
			<input type="hidden" name="path" id="path" value="<?php echo JURI::root(); ?>" />
			<input type="hidden" name="user_login" id="user_login" value="<?php echo JText::_('JE_FAQ_LOGIN'); ?>" />
			<input type="hidden" name="je_already_added" id="je_already_added" value="<?php echo JText::_('JE_FAQ_ALREADY'); ?>" />
		</div>

		<script type="text/javascript" src="<?php echo JURI::root().'components/com_jefaqpro/assets/js/accordionview.js'?>"></script>
		<script type="text/javascript">
			var menu1 = new YAHOO.widget.AccordionView('<?php echo $template; ?>', {collapsible: true, width: '100%', margin : '0', animationSpeed: '0.3', animate: true, effect: YAHOO.util.Easing.easeBothStrong});
		</script>
	</div>
<?php
} else {
	echo '<div id="je-nofaqs" style="text-align : center;">'.JText::_('JE_FAQS').'</div>';
}
?>
</div>
<!-- Content area ended -->