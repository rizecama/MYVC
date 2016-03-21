  <?php

$link = mysql_connect('localhost', 'allen_cam', 'Ht6J2zksNM4t');
if (!$link)
{
	die('Could not connect: ' . mysql_error());
}
		$today = date('m-d-Y');
		$time = date("h:i A");
		$time = str_replace(' ','',$time); 
$now = $today." ".$time;
echo $now."<br><br>";    
$db_selected = mysql_select_db('allen_camassistant', $link);
$result = mysql_query("SELECT  *  FROM jos_cam_rfpinfo");
while($row = mysql_fetch_array($result))
  {
 echo $closetime =  $row['proposalDueDate'] . " " . $row['proposalDueTime'];
if($closetime == $now){
$result = mysql_query("UPDATE jos_cam_rfpinfo SET rfp_type  = 'closed' WHERE id= ".$row['id']." ");

}
  }


?>
