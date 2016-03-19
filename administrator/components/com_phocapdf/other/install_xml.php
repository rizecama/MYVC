<?php
/*********** XML PARAMETERS AND VALUES ************/
$xml_item = "component";// component | template
$xml_file = "phocapdf.xml";		
$xml_name = "PhocaPDF";
$xml_creation_date = "02/11/2010";
$xml_author = "Jan Pavelka (www.phoca.cz)";
$xml_author_email = "";
$xml_author_url = "www.phoca.cz";
$xml_copyright = "Jan Pavelka";
$xml_license = "GNU/GPL";
$xml_version = "1.0.9";
$xml_description = "Phoca PDF";
$xml_copy_file = 1;//Copy other files in to administration area (only for development), ./front, ./language, ./other

$xml_menu = array (0 => "Phoca PDF", 1 => "option=com_phocapdf", 2 => "components/com_phocapdf/assets/images/icon-16-ppdf-menu.png");
$xml_submenu[0] = array (0 => "Control Panel", 1 => "option=com_phocapdf", 2 => "components/com_phocapdf/assets/images/icon-16-ppdf-cp.png");
$xml_submenu[1] = array (0 => "Plugins", 1 => "option=com_phocapdf&view=phocaplugins", 2 => "components/com_phocapdf/assets/images/icon-16-ppdf-pdf.png");
$xml_submenu[2] = array (0 => "Fonts", 1 => "option=com_phocapdf&view=phocafonts", 2 => "components/com_phocapdf/assets/images/icon-16-ppdf-font.png");
$xml_submenu[3] = array (0 => "Info", 1 => "option=com_phocapdf&view=phocainfo", 2 => "components/com_phocapdf/assets/images/icon-16-ppdf-info.png");

$xml_install_file = 'install.phocapdf.php'; 
$xml_uninstall_file = 'uninstall.phocapdf.php';
/*********** XML PARAMETERS AND VALUES ************/
?>