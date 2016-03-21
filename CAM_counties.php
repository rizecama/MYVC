<?php $host = 'localhost';$username = 'allen';$password = 'cam007';$database = 'allen_camassistant'; 
$db       =  mysql_connect( $host, $username, $password) or die('Could not connect to server.' );
mysql_select_db($database,$db);
ini_set('max_execution_time',3600);
echo ini_get('max_execution_time');
//error_reporting(0);
if (!$myFile = @fopen('counties.csv', "r")) {
				die("Can't open CSV file.");
			} 
			
			else {
			
			while ($data = fgetcsv($myFile, 2048, ',')) {
				$res_county = '';
				//$state = ucwords(strtolower($data[3])); 
				/*if($state == 'Fl')
				{*/
				$state = ucwords(strtolower($data[3]));
				$city = ucwords(strtolower($data[4]));  
				$county = ucwords(strtolower($data[5])); 
				echo $qry_county = "SELECT count(*) as cnt FROM jos_cam_counties WHERE State = '".$state."' AND City = '".$city."' AND County = '".$county."'"; echo '<br/>';
				$res_county = mysql_query($qry_county); 
				if($res_county) 
				$res_county = mysql_fetch_assoc($res_county);
				echo $cnt = $res_county['cnt'];
				if($cnt == 0)
				{
				  
					echo $final_insert = "INSERT into jos_cam_counties(id,ZipCode,GPS1,GPS2,State,City,County) values('','$data[0]','$data[1]','$data[2]','$state','$city','$county')"; echo '<br/>';
					$result=mysql_query($final_insert);
					if($result > 0)
						{
						$cnt = $cnt+1;
						//echo 'Counties Added to your database<br/>';
						}
				}
				/*}	*/
				
			}
}
//echo $duplicates;
exit;
?>
