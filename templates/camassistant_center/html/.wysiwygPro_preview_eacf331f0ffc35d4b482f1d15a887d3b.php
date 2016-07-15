<?php
if ($_GET['randomId'] != "6YxWhzERrKJP_L6GZ4ztRZKyf6YEZyqN4NVx3PmGLB1F3vpZiDCXVxb7CCgT7AmH") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
