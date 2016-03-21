<?php 
$rfpfile='RFP'.$_GET[rfp_id];

system('zip -r '.$rfpfile.' '.$_GET['directtozip'].'');

    header("Content-Type: archive/zip");
    header("Content-Disposition: attachment; filename=RFP".$_GET[rfp_id]."".".zip");

 ?>