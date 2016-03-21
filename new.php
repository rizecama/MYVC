 <?php 
  
 echo $_SERVER['REMOTE_ADDR'];
 echo 'hai';
 echo $_SERVER['HTTP_HOST'];
 echo '<br>';
 echo  $ip = getenv(‘REMOTE_ADDR’);
 
 ?>
 
 <?php
echo ' Client IP: ';
if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
    echo '' . $_SERVER["HTTP_CLIENT_IP"] . ' ';
}
?> 
 <?php
  echo sprintf('Local IP address: %s', gethostbyname($_SERVER_NAME));
?>
 