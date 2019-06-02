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
	
	error_reporting(0);
	@ini_set("memory_limit", "-1");
	@set_time_limit(0);
	
	if(file_exists("../db/db.php")) {
		
		require_once('../db/func.php');
		require_once('../db/db.php');
		ini_set("error_reporting", E_ALL);	
	
	}
	
    $cr = @$_GET['cr'];
    Switch($cr) {

		case'insert_sql';	
		sleep(2);
		
		if (!empty($_POST)) {
			
			if (trim($_POST['s_url'])=='' OR empty($_POST)) {
				
				$array["err"] = "Site address can not be empty!";
			
			} else if (trim($_POST['d_localhost'])=='' OR empty($_POST)) {
				
				$array["err"] = "MySQL hostname can not be empty!";
				
			} else if (trim($_POST['d_name'])=='' OR empty($_POST)) {
				
				$array["err"] = "MySQL database name can not be empty!";
				
			} else if (trim($_POST['d_username'])=='' OR empty($_POST)) {

				$array["err"] = "MySQL username can not be empty!";
				
			} else {
			
					// Name of the file
				$filename = '../craigs.sql';
					// MySQL host
				$host = $_POST['d_localhost'];
					// MySQL username
				$username = $_POST['d_username'];
					// MySQL password
				$password = $_POST['d_password'];
					// Database name
				$database = $_POST['d_name'];
			
				$cnn = @mysql_connect($host, $username, $password);
				$dtb = @mysql_select_db($database);
					 
				if(!$cnn) {
						
						$array["err"] = "MySQL username yada password is incorrect!"; 
						
				} else if(!$dtb) { 
					
						$array["err"] = "The database name is incorrect!";
						
				} else {
			
					$curl_start=curl_init(); 
					curl_setopt($curl_start,CURLOPT_URL,"https://themerig.com/license-craigs/reg.php"); 
					curl_setopt($curl_start, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl_start,CURLOPT_POST,1);
					curl_setopt($curl_start,CURLOPT_POSTFIELDS,'site_url='.$_POST['s_url'].'&purchase_code='.$_GET['p_code'].'&ip_address='.$_SERVER['REMOTE_ADDR'].'&envato_username='.$_GET['a_buyer'].'&item_id='.$_GET['item_id'].''); 
					curl_setopt($curl_start,CURLOPT_RETURNTRANSFER,1); 
					$return_data=curl_exec($curl_start); 
					curl_close($curl_start);  
					
					if ($return_data == "no_save") {	
					
						$array["err"] = "Previously used purchase code!";
						
					} else if ($return_data == "history_save") {
						
						$connection = @mysqli_connect($host,$username,$password) or die(mysql_error());

						mysqli_select_db($connection, $database) or die(mysql_error());
			
						$templine = '';
						$lines = file($filename); // Read entire file

						foreach ($lines as $line) {
							
							// Skip it if it's a comment
							if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 2) == '/*' )
								continue;

							// Add this line to the current segment
							$templine .= $line;
							
							// If it has a semicolon at the end, it's the end of the query
							if (substr(trim($line), -1, 1) == ';')  {
								
								mysqli_query($connection, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connection) . '<br /><br />');
								
								$templine = '';

							}
						}
						
						$array["ok"] = "The license is currently active for this site!";

						
	$db_create = fopen('../db/db.php', 'w');
	fwrite($db_create, '<?php  

	// +------------------------------------------------------------------------+
	// | @author Ercan Agkaya (Themerig)
	// | @author_url 1: https://www.themerig.com
	// | @author_url 2: https://codecanyon.net/user/themerig
	// | @author_email: support@themerig.com   
	// +------------------------------------------------------------------------+
	// | Craigs Cms - Directory Listing Theme
	// | Copyright (c) 2018 Directory & Listings CMS. All rights reserved.
	// +------------------------------------------------------------------------+

	/*
		Pdo Connection
	*/
		
		ob_start();

	// Database Connection

	// MySQL Hostname
	$serverName   	= "'.$_POST['d_localhost'].'";
	// MySQL Database User
	$username 	    = "'.$_POST['d_username'].'";
	// MySQL Database Password
	$password 		= "'.$_POST['d_password'].'";
	// MySQL Database Name
	$databaseName 	= "'.$_POST['d_name'].'";

	try {
		$db = new PDO("mysql:host={$serverName};dbname={$databaseName}", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	} catch (PDOException $e) {
		return "connection error ". $e->getMessage();
	}	

	$settings = $db -> query("SELECT * FROM settings")->fetch();
					
	if (!empty($_SESSION["session"])) {
		$users = $db -> query("SELECT * FROM users WHERE id = ".$_SESSION["id"]."")->fetch();
	}					
	
	// Site URL
	$site_url = "'.$_POST['s_url'].'"; // e.g (example.com)

	// Purchase code
	$purchase_code = "'.$_GET['p_code'].'"; // Your purchase code, don\'t give it to anyone. 
	
	// Envato Username
	$envato_username = "'.$_GET['a_buyer'].'"; // Envato username
		
	');
					
	fclose($db_create);	
						
					} else if ($return_data == "success") { 
					
						$connection = @mysqli_connect($host,$username,$password) or die(mysql_error());

						mysqli_select_db($connection, $database) or die(mysql_error());
			
						$templine = '';
						$lines = file($filename); // Read entire file

						foreach ($lines as $line) {
							
							// Skip it if it's a comment
							if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 2) == '/*' )
								continue;

							// Add this line to the current segment
							$templine .= $line;
							
							// If it has a semicolon at the end, it's the end of the query
							if (substr(trim($line), -1, 1) == ';')  {
								
								mysqli_query($connection, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connection) . '<br /><br />');
								
								$templine = '';

							}
						}
						
						$array["ok"] = "Your setup has been successful";

						
	$db_create = fopen('../db/db.php', 'w');
	fwrite($db_create, '<?php  

	// +------------------------------------------------------------------------+
	// | @author Ercan Agkaya (Themerig)
	// | @author_url 1: https://www.themerig.com
	// | @author_url 2: https://codecanyon.net/user/themerig
	// | @author_email: support@themerig.com   
	// +------------------------------------------------------------------------+
	// | Craigs Cms - Directory Listing Theme
	// | Copyright (c) 2018 Directory & Listings CMS. All rights reserved.
	// +------------------------------------------------------------------------+

	/*
		Pdo Connection
	*/
		
		ob_start();

	// Database Connection

	// MySQL Hostname
	$serverName   	= "'.$_POST['d_localhost'].'";
	// MySQL Database User
	$username 	    = "'.$_POST['d_username'].'";
	// MySQL Database Password
	$password 		= "'.$_POST['d_password'].'";
	// MySQL Database Name
	$databaseName 	= "'.$_POST['d_name'].'";

	try {
		$db = new PDO("mysql:host={$serverName};dbname={$databaseName}", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	} catch (PDOException $e) {
		return "connection error ". $e->getMessage();
	}	

	$settings = $db -> query("SELECT * FROM settings")->fetch();
					
	if (!empty($_SESSION["session"])) {
		$users = $db -> query("SELECT * FROM users WHERE id = ".$_SESSION["id"]."")->fetch();
	}					
	
	// Site URL
	$site_url = "'.$_POST['s_url'].'"; // e.g (example.com)

	// Purchase code
	$purchase_code = "'.$_GET['p_code'].'"; // Your purchase code, don\'t give it to anyone. 
	
	// Envato Username
	$envato_username = "'.$_GET['a_buyer'].'"; // Envato username
		
	');
					
	fclose($db_create);	
					
					}
				
				}
				@mysql_close($cnn); 

			}
			
		}
		break;
		
		case'reg_ad';	
		sleep(2);
		
		if (!empty($_POST)) {
			
			if (trim($_POST['a_fullname'])=='' OR empty($_POST)) {
				
				$array["err"] = "Fullname can not be empty!";
			
			} else if (trim($_POST['a_username'])=='' OR empty($_POST)) {
				
				$array["err"] = "Username can not be empty!";
				
			} else if (trim($_POST['a_email'])=='' OR empty($_POST)) {
				
				$array["err"] = "Email address can not be empty!";
				
			} else if (trim($_POST['a_password'])=='' OR empty($_POST)) {

				$array["err"] = "Password can not be empty!";
				
			} else {
				
				$password 	 = md5($_POST['a_password']);
				$create_date = time();
				$token       = uniqid($_POST['a_username'],true);
				$username 	 = seo($_POST['a_username']);
				
				$query = $db->prepare("INSERT INTO users SET fullname = :f_name, username = :u_name, email = :e_ma, password = :pass, register_date = :r_date, st = :s, gender = :gndr, token = :tkn");
				$insert = $query->execute(array("f_name" => $_POST['a_fullname'],"u_name" => $username,"e_ma" => $_POST['a_email'],"pass" => $password,"r_date" => $create_date,"s" => "1","gndr" => "1","tkn" => $token));
				$last_id = $db->lastInsertId();
				
				if($insert) {
					
					$query = $db->prepare("UPDATE settings SET purchase_code = :p_code, purchase_site_url = :p_s_url, envato_username = :e_username");
					$update = $query->execute(array("p_code" => $_GET['p_code'],"p_s_url" => $_POST['site_url'],"e_username" => $_POST['a_buyer']));					
				   
					$query = $db->prepare("INSERT INTO notification SET a_id = ?, st = ?, create_date = ?");
					$insert = $query->execute(array($last_id, "4", $create_date));

					$array["ok"] = "Admin sign up successful";					
				   
				}
				
			}
			
		}
		break;
	
		default: { 
			$array["debug"] = "error"; 
		} 
		break;	
	
	}

echo json_encode($array);