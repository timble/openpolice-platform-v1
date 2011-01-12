<?php
/*********** XML PARAMETERS AND VALUES ************/
$xml_item = "component";// component | template
$xml_file = "phocagallery.xml";		
$xml_name = "PhocaGallery";
$xml_creation_date = "22/09/2010";
$xml_author = "Jan Pavelka (www.phoca.cz)";
$xml_author_email = "";
$xml_author_url = "www.phoca.cz";
$xml_copyright = "Jan Pavelka";
$xml_license = "GNU/GPL";
$xml_version = "2.7.5";
$xml_description = "Phoca Gallery";
$xml_copy_file = 1;//Copy other files in to administration area (only for development), ./front, ./language, ./other

$xml_menu = array (0 => "Phoca Gallery", 1 => "option=com_phocagallery", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu.png");
$xml_submenu[0] = array (0 => "Control Panel", 1 => "option=com_phocagallery", 2 => "components/com_phocagallery/assets/images/icon-16-pg-control-panel.png");
$xml_submenu[1] = array (0 => "Images", 1 => "option=com_phocagallery&view=phocagallerys", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-gal.png");
$xml_submenu[2] = array (0 => "Categories", 1 => "option=com_phocagallery&view=phocagallerycs", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-cat.png");
$xml_submenu[3] = array (0 => "Themes", 1 => "option=com_phocagallery&view=phocagalleryt", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-theme.png");
$xml_submenu[4] = array (0 => "Category Rating", 1 => "option=com_phocagallery&view=phocagalleryra", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-vote.png");
$xml_submenu[5] = array (0 => "Image Rating", 1 => "option=com_phocagallery&view=phocagalleryraimg", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-vote-img.png");
$xml_submenu[6] = array (0 => "Category Comments", 1 => "option=com_phocagallery&view=phocagallerycos", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-comment.png");
$xml_submenu[7] = array (0 => "Image Comments", 1 => "option=com_phocagallery&view=phocagallerycoimgs", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-comment-img.png");
$xml_submenu[8] = array (0 => "Users", 1 => "option=com_phocagallery&view=phocagalleryusers", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-users.png");
$xml_submenu[9] = array (0 => "Info", 1 => "option=com_phocagallery&view=phocagalleryin", 2 => "components/com_phocagallery/assets/images/icon-16-pg-menu-info.png");

$xml_install_file = 'install.phocagallery.php'; 
$xml_uninstall_file = 'uninstall.phocagallery.php';
/*********** XML PARAMETERS AND VALUES ************/
?>