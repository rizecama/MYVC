<?
$zip = new ZipArchive();
$filename = "temp.zip";

if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
exit("cannot open <$filename>\n");
}else{
	echo ' i am in';
}
?>
