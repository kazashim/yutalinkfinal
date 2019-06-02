<?php  
	// +------------------------------------------------------------------------+
	// | @author Ercan Agkaya (Themerig)
	// | @author_url 1: https://www.themerig.com
	// | @author_url 2: https://codecanyon.net/user/themerig
	// | @author_email: support@themerig.com   
	// +------------------------------------------------------------------------+
	// | Listing Hub - Directory & Listings CMS Theme
	// | Copyright (c) 2017 Directory & Listings CMS. All rights reserved.
	// +------------------------------------------------------------------------+

    session_start();
	
	function GetIP() { 
		if (getenv("HTTP_CLIENT_IP")) { 
			$ip = getenv("HTTP_CLIENT_IP"); 
		} else { 
			if (getenv("HTTP_X_FORWARDED_FOR")) { 
				$ip = getenv("HTTP_X_FORWARDED_FOR"); 
				if( strstr($ip, ",")) { 
					$tmp = explode(",", $ip); 
					$ip = trim($tmp[0]); 
				} 
			} else { 
				$ip = getenv("REMOTE_ADDR"); 
			} 
		} 
	 return $ip; 
	}
	
	function setTimezone($default) {
    $timezone = "";
    
    // On many systems (Mac, for instance) "/etc/localtime" is a symlink
    // to the file with the timezone info
		if (is_link("/etc/localtime")) {
			
			// If it is, that file's name is actually the "Olsen" format timezone
			$filename = readlink("/etc/localtime");
			
			$pos = strpos($filename, "zoneinfo");
			if ($pos) {
				// When it is, it's in the "/usr/share/zoneinfo/" folder
				$timezone = substr($filename, $pos + strlen("zoneinfo/"));
			} else {
				// If not, bail
				$timezone = $default;
			}
		} else {
        // On other systems, like Ubuntu, there's file with the Olsen time
        // right inside it.
			$timezone = file_get_contents("/etc/timezone");
			if (!strlen($timezone)) {
				$timezone = $default;
			}
		}
    date_default_timezone_set($timezone);
	}
	
	date_default_timezone_set('UTC');

	function seo($s) {
		 $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','&','®','+','craigs');
		 $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','and','','','');
		 $s = str_replace($tr,$eng,$s);
		 $s = strtolower($s);
		 $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
		 $s = preg_replace('/\s+/', '-', $s);
		 $s = preg_replace('|-+|', '-', $s);
		 $s = preg_replace('/#/', '', $s);
		 $s = str_replace('.', '', $s);
		 $s = trim($s, '-');
		 return $s;
	}
	
	// General 
	
	function timeConvert($time) {
	
		include 'db.php';
	
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
		
		$time =  strtotime($time);
		$time_difference = time() - $time;
		$second = $time_difference;
		$minute = round($time_difference/60);
		$hour = round($time_difference/3600);
		$day = round($time_difference/86400);
		$week = round($time_difference/604800);
		$moon = round($time_difference/2419200);
		$year = round($time_difference/29030400);
		if ($second < 60) {
			if ($second == 0) {
				return $lang['time_a_little_ago'];
			} else {
				return $second .' '.$lang['time_seconds_ago'].'';
			}
		} else if ($minute < 60) {
			return $minute .' '.$lang['time_minutes_ago'].'';
		} else if ($hour < 24) {
			return $hour.' '.$lang['time_hours_ago'].'';
		} else if ($day < 7) {
			return $day .' '.$lang['time_day_ago'].'';
		} else if ($week < 4) {
			return $week .' '.$lang['time_week_ago'].'';
		} else if ($moon < 12) {
			return $moon .' '.$lang['time_month_ago'].'';
		} else {
			return $year.' '.$lang['time_year_ago'].'';
		}
	}
	
	// General Admin
	
	function timeAdminConvert($time) {
	
		include 'db.php';
	
		$ip = GetIP();
		
		$ip_users = $db -> query("SELECT * FROM ip_users WHERE ip = '".$ip."'")->fetch();
		
		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("../lang/".$settings["lang"].".php");
			} else {
				require("../lang/en.php");
			}
		} else {
			require("../lang/".$ip_users["lang"].".php");
		}
		
		$time =  strtotime($time);
		$time_difference = time() - $time;
		$second = $time_difference;
		$minute = round($time_difference/60);
		$hour = round($time_difference/3600);
		$day = round($time_difference/86400);
		$week = round($time_difference/604800);
		$moon = round($time_difference/2419200);
		$year = round($time_difference/29030400);
		if ($second < 60) {
			if ($second == 0) {
				return $lang['time_a_little_ago'];
			} else {
				return $second .' '.$lang['time_seconds_ago'].'';
			}
		} else if ($minute < 60) {
			return $minute .' '.$lang['time_minutes_ago'].'';
		} else if ($hour < 24) {
			return $hour.' '.$lang['time_hours_ago'].'';
		} else if ($day < 7) {
			return $day .' '.$lang['time_day_ago'].'';
		} else if ($week < 4) {
			return $week .' '.$lang['time_week_ago'].'';
		} else if ($moon < 12) {
			return $moon .' '.$lang['time_month_ago'].'';
		} else {
			return $year.' '.$lang['time_year_ago'].'';
		}
	}
	
	// General Admin Data
	
	function timeAdminDataConvert($time) {
	
		include 'db.php';
	
		$ip = GetIP();
		
		$ip_users = $db -> query("SELECT * FROM ip_users WHERE ip = '".$ip."'")->fetch();
		
		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("../../lang/".$settings["lang"].".php");
			} else {
				require("../../lang/en.php");
			}
		} else {
			require("../../lang/".$ip_users["lang"].".php");
		}
		
		$time =  strtotime($time);
		$time_difference = time() - $time;
		$second = $time_difference;
		$minute = round($time_difference/60);
		$hour = round($time_difference/3600);
		$day = round($time_difference/86400);
		$week = round($time_difference/604800);
		$moon = round($time_difference/2419200);
		$year = round($time_difference/29030400);
		if ($second < 60) {
			if ($second == 0) {
				return $lang['time_a_little_ago'];
			} else {
				return $second .' '.$lang['time_seconds_ago'].'';
			}
		} else if ($minute < 60) {
			return $minute .' '.$lang['time_minutes_ago'].'';
		} else if ($hour < 24) {
			return $hour.' '.$lang['time_hours_ago'].'';
		} else if ($day < 7) {
			return $day .' '.$lang['time_day_ago'].'';
		} else if ($week < 4) {
			return $week .' '.$lang['time_week_ago'].'';
		} else if ($moon < 12) {
			return $moon .' '.$lang['time_month_ago'].'';
		} else {
			return $year.' '.$lang['time_year_ago'].'';
		}
	}
	
	// Messages
	
	function timConvert($time) {

		include 'db.php';
	
		$ip = GetIP();
		
		$ip_users = $db -> query("SELECT * FROM ip_users WHERE ip = '".$ip."'")->fetch();
		
		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("../lang/".$settings["lang"].".php");
			} else {
				require("../lang/en.php");
			}
		} else {
			require("../lang/".$ip_users["lang"].".php");
		}
		
		$time =  strtotime($time);
		$time_difference = time() - $time;
		$second = $time_difference;
		$minute = round($time_difference/60);
		$hour = round($time_difference/3600);
		$day = round($time_difference/86400);
		$week = round($time_difference/604800);
		$moon = round($time_difference/2419200);
		$year = round($time_difference/29030400);
		if ($second < 60) {
			if ($second == 0) {
				return $lang['time_a_little_ago'];
			} else {
				return $second .' '.$lang['time_seconds_ago'].'';
			}
		} else if ($minute < 60) {
			return $minute .' '.$lang['time_minutes_ago'].'';
		} else if ($hour < 24) {
			return $hour.' '.$lang['time_hours_ago'].'';
		} else if ($day < 7) {
			return $day .' '.$lang['time_day_ago'].'';
		} else if ($week < 4) {
			return $week .' '.$lang['time_week_ago'].'';
		} else if ($moon < 12) {
			return $moon .' '.$lang['time_month_ago'].'';
		} else {
			return $year.' '.$lang['time_year_ago'].'';
		}
	}
	
	function git($adres) {
		echo "<script>document.location.href='".$adres."';</script>";
		die();
	}
	
	function cmd($sorgu) {
		global $db;
		
		$veri = $db->query($sorgu);
		return $veri;
	}
	
	function tabloCek($tablo, $alanlar, $manuel) {
		global $db;
		
		$veri = $db->query("SELECT {$alanlar} FROM {$tablo} {$manuel}", PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriCek($tablo, $alanlar, $sutun, $id) {
		global $db;
		
		$veri = $db->query("SELECT {$alanlar} FROM {$tablo} WHERE {$sutun} = '{$id}'")->fetch(PDO::FETCH_ASSOC);
		return $veri;
	}
	
	function veriSil($tablo, $sutun, $id) {
		global $db;
		
		$query = $db->prepare("DELETE FROM {$tablo} WHERE {$sutun} = :edc");
		$delete = $query->execute(array(
		   'edc' => $id
		));
	}
	
	function veriEkle($sutunlar, $veriler, $tablo) {
		global $db;
		
		$other = array();
		$sorgu = "";
		$count = count($veriler);
		$a = 0;
		for($i = 0; $i < $count; $i++)
		{
			$a++;
			if($a == $count)
				$sorgu .= $sutunlar[$i]." = ?";
			else
				$sorgu .= $sutunlar[$i]." = ?,";
		}
		
		$query = $db->prepare("INSERT INTO {$tablo} SET {$sorgu}");
		$insert = $query->execute($veriler);
		
		if ( $insert )
			return true;
		else
			return false;
	}
	
	if(file_exists("db/db.php")) {	

		include 'db.php';
		
		$curl =	curl_init('https://themerig.com/license-craigs/users.php?p_code='.$purchase_code.'&e_username='.$envato_username.'');
		
        curl_setopt ($curl, CURLOPT_TIMEOUT, "50");
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt ($curl, CURLOPT_HEADER, 0);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($curl, CURLOPT_ENCODING, "UTF-8");
        curl_setopt ($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $curlResult = curl_exec($curl);
        curl_close($curl);
			
		$xml = simplexml_load_string($curlResult);

		$www_license_url = "www.".$xml->license[0]->url."";
			
		$license_url = "".$xml->license[0]->url."";	

		if ($license_url != $_SERVER['SERVER_NAME']) {
			if ($www_license_url != $_SERVER['SERVER_NAME']) {
				header("Location: license.php");
				$_SESSION['license_statu'] = "0";
			} else {
				$_SESSION['license_statu'] = "1";
			}
			
		} else {
			$_SESSION['license_statu'] = "1";
		}
		
		$query = $db->query("SELECT * FROM users WHERE st = 1")->fetch(PDO::FETCH_ASSOC);
		if(empty($query)) {
			header("Location: license.php");
		}
		
	}
	
	function veriGuncelle($sutunlar, $veriler, $tablo, $hedef, $no) {
		global $db;
		
		$other = array();
		$sorgu = "";
		$a = 0;
		$count = count($veriler);
		for($i = 0; $i < $count; $i++) {
			$a++;
			if($a == $count)
				$sorgu .= $sutunlar[$i]." = :a_".$sutunlar[$i];
			else
				$sorgu .= $sutunlar[$i]." = :a_".$sutunlar[$i].",";
		}
		
		$b = 0;
		foreach( $sutunlar as $sutun ) {
			$other["a_".$sutun] = $veriler[$b];
			$b++;
		}
		
		$other["no"] = $no;
		
		$query = $db->prepare("UPDATE {$tablo} SET {$sorgu} WHERE {$hedef} = :no");
		$update = $query->execute($other);
		
		if ( $update )
			return true;
		else
			return false;
	}
	
	function delete_db($database) {
		global $db;
		$statement = $db->exec("DROP DATABASE IF EXISTS " . $database);
	}	
	
	function views_api() {
	   $envato_api='vg3xnq90k9agwtcoemd72i7ipwuqr1fx';
	   return $envato_api;
	}
	
	function views_user() {
	   $envato_username='themerig'; 
	   return $envato_username;
	}