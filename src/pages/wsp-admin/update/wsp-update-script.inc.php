<?php
// Warning, this script is use to update the framework WebSite-PHP
// This script will delete some files to clean the wsp files and folders

if (isset($is_call_from_wsp_admin_update) && $is_call_from_wsp_admin_update == true) {
	$base_dir = dirname(__FILE__)."/../../../";
	
	// Update: delete non used lanaguages
	if (!isset($array_lang_used) && !is_array($array_lang_used)) {
		$array_lang_used = array('en', 'fr');
	}
	$array_lang_dir = scandir($base_dir."/lang");
	for ($i=0; $i < sizeof($array_lang_dir); $i++) {
		if (is_dir($base_dir."/lang/".$array_lang_dir[$i]) && $array_lang_dir[$i] != "" && 
			$array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && strlen($array_lang_dir[$i]) == 2) {
				if (!in_array($array_lang_dir[$i], $array_lang_used)) {
					rrmdir($base_dir."/lang/".$array_lang_dir[$i]."/");
				}
		}
	}
	
	// Update: version 1.0.84
	rrmdir($base_dir."/wsp/class/display/advanced_object/google/googlesearch/");
	unlink($base_dir."/wsp/class/display/advanced_object/ContactForm.class.php");
	if (!file_exists($base_dir."/wsp/config/modules.cnf")) {
		$modules_conf = new File($base_dir."/wsp/config/modules.cnf");
		$modules_conf->write("Authentication\n");
		$modules_conf->close();
	}
	
	// Update: version 1.0.86
	unlink($base_dir."/wsp/js/jquery-1.4.4.min.js");
	unlink($base_dir."/wsp/js/jquery-ui-1.8.6.custom.min.js");
	
	
	// Move wsp-admin folder to the define folder on the file wsp/config/config_admin.inc.php
	include_once($base_dir."/wsp/config/config_admin.inc.php");
	if (WSP_ADMIN_URL != "wsp-admin") {
		copy($base_dir."/pages/".WSP_ADMIN_URL."/.passwd", $base_dir."/pages/wsp-admin/.passwd");
		rrmdir($base_dir."/pages/".WSP_ADMIN_URL);
		rename($base_dir."/pages/wsp-admin", $base_dir."/pages/".WSP_ADMIN_URL);
	}
	
	// Update: .htaccess
	if (file_exists($base_dir."/update.htaccess")) {
		$htaccess_data = "";
		if (file_exists($base_dir."/.htaccess")) {
			$ht_file = new File($base_dir."/.htaccess");
			while (($line = $ht_file->read_line()) != false) {
				if (find($line, "# End zone for your URL rewriting") > 0) {
					break;
				}
				$htaccess_data .= $line;
			}
			$ht_file->close();
		} else {
			$htaccess_data = "# Rule file .htaccess
RewriteEngine on
Options +FollowSymLinks

<IfModule mod_rewrite.c>
	# Redirecting www
	# Configure if you want redirect url http://example.com to http://www.example.com
	RewriteCond %{HTTP_HOST} ^mydomain\.com$ [NC]
	RewriteRule ^(.*)$ http://www.mydomain.com/$1 [R=301,L] 
	
	
	# Zone to define your URL rewriting
	# Exemple 1: 
	# RewriteRule ^myfolder/(.+)\.html$ index.php?p=$1&l=$1&folder_level=1&%{QUERY_STRING} [L] 
	# RewriteRule ^([a-z]{2})/myfolder/(.+)\.html$ index.php?p=$2&l=$1&folder_level=1&%{QUERY_STRING} [L] 
	# Exemple 2: 
	# RewriteRule ^myfolder/myfolder2/(.+)\.html$ index.php?p=$1&l=$1&folder_level=2&%{QUERY_STRING} [L] 
	# RewriteRule ^([a-z]{2})/myfolder/myfolder2/(.+)\.html$ index.php?p=$2&l=$1&folder_level=2&%{QUERY_STRING} [L] 
	\n";
		}
		$htaccess_data = $htaccess_data.file_get_contents($base_dir."/update.htaccess");
		
		$ht_file = new File($base_dir."/.htaccess", false, true);
		$ht_file->write($htaccess_data);
		$ht_file->close();
		
		unlink($base_dir."/update.htaccess");
	}
}
?>