<?php
if ($_GET['randomId'] != "yn3R8eCyKhefrHQgqUyMkPnVmnFteoTLNpSWq9nxeEocZiafhNPE1avoiHNxOQrH") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
