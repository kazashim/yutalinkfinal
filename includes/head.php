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

	if(!file_exists("db/db.php")) {	
		header("Location: install");
	}
	
	require_once('db/func.php');
	require_once('db/db.php');
	ini_set("error_reporting", E_ALL);
	
	$base = dirname($_SERVER['PHP_SELF']);
		
	$val = explode("/",$base);
	
	$ip = GetIP();
	
	$ip_users = $db -> query("SELECT * FROM ip_users WHERE ip = '".$ip."'")->fetch();
	
		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("lang/".$settings["lang"].".php");
			} else {
				require("lang/en.php");
			}
		} else {
			require("lang/".$ip_users["lang"].".php");
		}
	
	$time = time();
	
	if (empty($ip_users)) {
		$query = $db->prepare("INSERT INTO ip_users SET ip = ?, date = ?, user_id = ?");
        $insert = $query->execute(array("".$ip."", "".$time."", "".@$users['id'].""));
	} else {
		if (!empty($_SESSION['session'])) {
			$query = $db->prepare("UPDATE ip_users SET up_date = :udat, user_id = :uid WHERE ip = :ips");
			$update = $query->execute(array("udat" => "".$time."","uid" => "".$users['id']."","ips" => "".$ip.""));
		} else {
			$query = $db->prepare("UPDATE ip_users SET up_date = :udat WHERE ip = :ips");
			$update = $query->execute(array("udat" => "".$time."","ips" => "".$ip.""));
		}
	}
	
	if ($settings['h_url'] == "on")	{
	
		if(!$_SERVER['HTTPS']) {
			$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header("Location: $url");
		}
		
	}

	if (empty($_GET['title'])) {
		
		if (!empty($_SERVER['SCRIPT_NAME'])) {
			
			$a = seo($_SERVER['SCRIPT_NAME']);
			$c = array("php","=","?","and","&","-",$val[1]);
			$b = array(""," "," "," "," ","","");
			$te = str_replace($c, $b, $a);
			
			if ($te == "index") {
				
				if ($settings['home_title'] != "" && $settings['url_ay'] != "" && $settings['home_subj'] != "") {
					$title = "".$settings['home_title']." ".$settings['url_ay']." ".$settings['home_subj']."";
				} else {
					$title = "".$lang[$te]."";
				}
				

			} else {
				
				$title = "".$settings['home_title']." ".$settings['url_ay']." ".$lang[$te]."";
				$header_title = "".$lang[$te]."";
				$keywords = $header_title;
				
			}
			 
		} else {
			
			$title = '';
			$header_title = "";
			$keywords = "";
		}
	
	} else {
		
		$a = seo($_GET['title']);
		$c = array("php","=","?","and","&","-",$val[1]);
		$b = array(""," "," "," "," "," ","");
		$te = str_replace($c, $b, $a);
		$title = "".$settings['home_title']." ".$settings['url_ay']." ".ucfirst($te)."";
		$header_title = "".$te."";
		
	}
	
		if (empty($_GET['id'])) {
			
			$a = seo($_SERVER['SCRIPT_NAME']);
			$c = array("php","=","?","and","&","-",$val[1]);
			$b = array(""," "," "," "," ","","");
			$te = str_replace($c, $b, $a);
			
			if ($te == "index") {
				
				$description = $settings['home_meta_desc'];
				$keywords = $settings['home_meta_keywords'];
				
			} else {
				
				$description = "";
				
			}

		} else {
			
			if(!filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
				header("Location: index.php");
			} else {

				$a = seo($_SERVER['SCRIPT_NAME']);
				$c = array("php","=","?","and","&","-",$val[1]);
				$b = array(""," "," "," "," ","","");
				$te = str_replace($c, $b, $a);
				
				if ($te == "product") {
				
					$i_t_m_ = $db->query("SELECT * FROM items WHERE id = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
					
					$adr = $i_t_m_['description'];
					$limit = 230;
					$text = strlen($adr);
					$description = substr($adr,0,$limit);
					
				} else if ($te == "page") { 
				
					$p_g_s_ = $db->query("SELECT * FROM pages WHERE id = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
					
					$adr = $p_g_s_['description'];
					$limit = 230;
					$text = strlen($adr);
					$description = substr($adr,0,$limit);
					
				} else if ($te == "blog_detail") { 
				
					$b_l_g = $db->query("SELECT * FROM blog WHERE id = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
					
					$adr = $b_l_g['description'];
					$limit = 230;
					$text = strlen($adr);
					$description = substr($adr,0,$limit);
					
				}
				
			}
		}

echo'<!doctype html>
		<html lang="'.$lang['lang'].'">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				<meta name="author" content="Themerig">

				<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,Varela+Round" rel="stylesheet">
				<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css">
				<link rel="stylesheet" href="assets/fonts/font-awesome.css" type="text/css">
				<link rel="stylesheet" href="assets/css/selectize.css" type="text/css">
				<link rel="stylesheet" href="assets/css/bootsrap-social.css">
				<link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css">
				<link rel="stylesheet" href="assets/css/style.css">
				<link rel="stylesheet" href="assets/css/user.css">
				<link rel="shortcut icon" href="'.$settings['favicon_ico'].'" type="image/x-icon"/>
				<title>' .ucfirst($title). '</title>
				<meta name="description" content="'.@$description.'">
				<meta name="keywords" content="'.@$keywords.'">';