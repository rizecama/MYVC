<?php
/**
 * @version		1.0.0 camassistant $
 * @package		camassistant
 * @copyright	Copyright © 2010 - All rights reserved.
 * @license		GNU/GPL
 * @author		
 * @author mail	nobody@nobody.com
 *
 *
 * @MVC architecture generated by MVC generator tool at http://www.alphaplug.com
 */

// no direct access

?>
<!--<div id="container_inner"  style=" padding-top:40px;">

<div id="thanks"><span>Thanks!</span><br />
<strong>We will email you a verification link that you must click to verify your email address.</strong> Please be sure to check your SPAM folder for this email as well. Once we approve your account,
you will be able to <strong>Log in and finalize your registration</strong> so you can receive automated RFP notifications, and provide proposals to communities. <br />
<br />
Our review process can take up to 3 business days.<br />  If you need this expedited, please call 1-800-985-9BID (1-800-985-9243)
<br /><br />

Sincerely,<br /><br />

<p>The CAMassistant.com Team</p></div>


<div class="clear"></div>
</div> -->
<div id="vender_right2">

<!-- sof bedcrumb -->
<div id="bedcrumb">

</div>
  <!-- eof bedcrumb -->

<!-- sof dotshead -->
<?php 
$db =& JFactory::getDBO();
	$vendormessage = "SELECT introtext  FROM #__content where id=124";
					$db->Setquery($vendormessage);
					$message = $db->loadResult();
					echo $message;
		?>			
<p >&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p></p>
</div>
<!-- sof table pan -->
<div class="clear"></div>

<!-- eof table pan -->

</div>

<!-- eof table pan -->

</div>






