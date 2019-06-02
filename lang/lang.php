<?php  
	// +------------------------------------------------------------------------+
	// | @author Ercan Agkaya (Themerig)
	// | @author_url 1: https://www.themerig.com
	// | @author_url 2: https://codecanyon.net/user/themerig
	// | @author_email: support@themerig.com   
	// +------------------------------------------------------------------------+
	// | Craigs Cms - Directory Listing Theme
	// | Copyright (c) 2018 Directory & Listings CMS. All rights reserved.
	// +------------------------------------------------------------------------+
	
	require_once('../db/func.php');
	require_once('../db/db.php');
	ini_set("error_reporting", E_ALL);
	
	$ip = GetIP();
	
	$ip_users = $db -> query("SELECT * FROM ip_users WHERE ip = '".$ip."'")->fetch();
	
	sleep(1);  
	
    if(!empty($_GET)) {
		
		$ln= "SELECT * FROM language WHERE id = '" . $_GET['lang'] . "'"; 
		$stmt = $db->query($ln); 
		$lng = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(file_exists("".$lng['lang_'].".php")) {	
		
			$q = $db->prepare("UPDATE ip_users SET lang = :ln WHERE ip = :i");
			$update = $q->execute(array("ln" => $lng['lang_'],"i" => $ip_users['ip']));
			
		}

	}