<?php
include_once("zipclass.php");
$zipTest = new zipfile();
$zipTest->add_dir("images/");
$zipTest->add_file("images/apply_f2.png", "images/apply_f2.png");
$zipTest->add_file("images/archive_f2.png", "images/archive_f2.png");

// Return Zip File to Browser
Header("Content-type: application/octet-stream");
Header ("Content-disposition: attachment; filename=zipTest.zip");
echo $zipTest->file();



?>