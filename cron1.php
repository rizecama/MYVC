  <?php

$link = mysql_connect('localhost', 'root', '');
if (!$link)
{
	die('Could not connect: ' . mysql_error());
}
		  
$db_selected = mysql_select_db('allen_camassistant', $link);
echo $today = date('Y-m-d h:m:s');
$result = mysql_query("SELECT  id,approve_date FROM jos_cam_rfpinfo where approve_date = '".$time."'");
$row = mysql_fetch_array($result)

?>
