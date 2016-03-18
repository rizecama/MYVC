<?php
//select empno,Salary FROM jos_employe where empno != (select empno from jos_employe order by salary desc limit 0,1) order by salary desc limit 0,1
/*echo "123<pre>";
print_r($_REQUEST);exit;*/
$c1		=0;
$c2		=$_REQUEST['c2'];
$added =  $_REQUEST['added'];
$other =  $_REQUEST['other'];
$path	=$_REQUEST['path'];
require_once($path."/configuration.php");
$obj= new JConfig;
$host = $obj->host;
$username = $obj->user;
$password = $obj->password;
$database = $obj->db;
$con = mysql_connect( $host, $username, $password) or die('Could not connect to server.' );
mysql_select_db($database, $con) or die('Could not select database.');
$c2 = doubleval(str_replace(",","",$c2));
if($c1 == 0 && $c2 !=0) //code to combined calculation
{
	if($c2 < 4400000)
	{
		$formula = (-0.00869*log($c2))+0.15;
		$percent = round($formula,5); 
	}
	else if($c2 >= 4400000 && $c2 < 6500000)
	{
		$formula	=  (-0.00000000000000000000004033*pow($c2,3))+((0.0000000000000010088)*pow($c2,2))-(0.0000000083137)*$c2 + 0.037557; 
		$percent = round($formula,5); 
	}
	else if($c2 >= 6500000)
	{
		$percent = 0.015;
	}
	$comm_amnt = $percent*$c2;
	$comm_amnt = round($comm_amnt,2);
	//$comm_amnt = round($comm_amnt);
}
//echo $comm_amnt;
//$comm_amnt = '1000000';
//$comm_amnt = number_format($comm_amnt,2,'.','');
$comm_amnt = doubleval(str_replace(",","",$comm_amnt));
//$comm_amnt = number_format($comm_amnt,2);
$c2 = doubleval(str_replace(",","",$c2));
$amnt = number_format($c2,2);
$added = doubleval(str_replace(",","",$added));
$added = number_format($added,2);
$other = doubleval(str_replace(",","",$other));
$other = number_format($other,2);
echo $comm_amnt.'AND'.$amnt.'AND'.$added.'AND'.$other;
mysql_close($con);
?>
