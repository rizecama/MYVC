<?php
$fileToZip="License.txt";
$fileToZip1="CreateZipFileMac.inc.php";
$fileToZip2="CreateZipFile.inc.php";

$directtozip='/home/allen/public_html/cms/templates';
//$rfpid = $_GET['rfp_id'];
//$rfpfile="RFP".$_GET[rfp_id];
//echo '<pre>'; print_r($_GET); exit;
// This will zip all the file(s) in this present working directory

$outputDir= ''; //Replace "/" with the name of the desired output directory.
$zipName= "RFP".$_GET[rfpid];

include_once("CreateZipFile.inc.php");
$createZipFile=new CreateZipFile;

/*
// Code to Zip a single file
$createZipFile->addDirectory($outputDir);
$fileContents=file_get_contents($fileToZip);
$createZipFile->addFile($fileContents, $outputDir.$fileToZip);
*/
//echo $directtozip;
//exit;

//Code toZip a directory and all its files/subdirectories
$createZipFile->zipDirectory($directtozip,$outputDir);

$rand=md5(microtime().rand(0,999999));
$zipName=$zipName.'.zip';
$fd=fopen($zipName, "wb");
$out=fwrite($fd,$createZipFile->getZippedfile());
fclose($fd);
$createZipFile->forceDownload($zipName);
//@unlink($zipName);
?>