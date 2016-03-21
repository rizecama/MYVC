<?php
$to      = 'documents@myvendorcenter.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@gallioneit.com' . "\r\n" .
    'Reply-To: webmaster@gallioneit.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>