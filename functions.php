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
    
	require_once('db/func.php');
	require_once('db/db.php');
	ini_set("error_reporting", E_ALL);
	
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
	
    $cr = @$_GET['cr'];
    Switch($cr) {

    case'signin';	
	sleep(2);
	
    if (!empty($_POST)) {

		if (trim($_POST['email'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['signin_your_email_can_not_be_empty'];
		} else if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
			$array["error"] = $lang['signin_this_email_address_is_invalid'];
		} else if (trim($_POST['password'])=='' OR empty($_POST)) {
			$array["error"] = $lang['signin_your_password_can_not_be_empty'];
		} else {
			$password = md5($_POST['password']);
			$remember  = @$_POST['remember'];
			$login = $db->prepare("Select * from users WHERE email = ? and password = ? ");
			$login->execute(array($_POST['email'],$password));
			if($login->rowCount()){ 
				$row = $login->fetch(PDO::FETCH_ASSOC);
				$_SESSION['session']	= TRUE;
				$_SESSION['email']      = $_POST['email'];
				$_SESSION['password']   = $password;
				$_SESSION['id']		    = $row['id'];
				$_SESSION['token']		= $row['token'];
				$_SESSION['st']         = $row['st'];

				if($remember == "remember"){
					setcookie("email",$_SESSION['email'],time()+(60*60*24));
					setcookie("password",$_SESSION['password'],time()+(60*60*24));
				}
				$array["success"] = $lang['signin_you_have_successfully_logged_in'];
			} else {
				$array["con_error"] = $lang['signin_username_or_password_is_incorrect'];
			}
		}
    }
    break;

    case'register';	
	sleep(2);
    if (!empty($_POST)) {
	
		if (trim($_POST['username'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['register_your_username_can_not_be_empty'];
		} else if (trim($_POST['full_name'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['register_your_fullname_can_not_be_empty']; 
		} else if (trim($_POST['email'])=='' OR empty($_POST)) {
			$array["error"] = $lang['register_your_email_can_not_be_empty']; 
		} else if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
			$array["error"] = $lang['register_this_email_address_is_invalid']; 
		} elseif (trim($_POST['password'])=='' OR empty($_POST)) {
			$array["error"] = $lang['register_your_password_can_not_be_empty']; 
		} elseif (strlen($_POST['password']) < 5) {
			$array["error"] = $lang['register_the_password_must_be_at_least_5_characters']; 
		} elseif (trim($_POST['repeat_password'])=='' OR empty($_POST)) {
			$array["error"] = $lang['register_your_repeat_password_can_not_be_empty']; 
		} elseif (strlen($_POST['repeat_password']) < 5) {
			$array["error"] = $lang['register_the_repeat_password_must_be_at_least_5_characters']; 
		} elseif (trim($_POST['password'])!=($_POST['repeat_password'])) {
			$array["error"] = $lang['register_the_passwords_entered_are_different']; 
		} elseif (trim($_POST['gender'])=='' OR empty($_POST)) {
			$array["opn"] = $lang['register_please_write_your_gender']; 
		} else {	
					
				$control = $db->prepare("Select * from users WHERE username = ?");
				$control->execute(array($_POST['username']));
					
				if ($control->rowCount()) { 
				
					$array["con_error_username"] = $lang['register_the_username_has_already_been_used']; 
					
				} else {
					
						$control = $db->prepare("Select * from users WHERE email = ? ");
						$control->execute(array($_POST['email']));
						
					if($control->rowCount()){ 
					
						$array["con_error_email"] = $lang['register_the_email_has_already_been_used']; 
						
					} else {
						
							$password 	    = md5($_POST['password']);
							$token          = uniqid($_POST['username'],true);
							$register_date  = time();
							$username 	    = seo($_POST['username']);
						
							if (!empty($_POST['newsletter']) == "1") {
								
								$newsletter = "1";
								
							} else {
								
								$newsletter = "0";
								
							}
							
							$reg = $db->prepare("INSERT INTO users set fullname = ? , password = ? , email = ? , register_date = ? , gender = ? , token = ?, username = ?, newsletter = ?");
							$reg->execute(array($_POST['full_name'],$password,$_POST['email'],$register_date,$_POST['gender'],$token,$username,$newsletter));
							
							$sn_id = $db->lastInsertId();
							
							if($reg->rowCount()){
								
								$array["success"] = $lang['register_successful_registration_redirecting']; 
								
								$query = $db->prepare("INSERT INTO notification SET a_id = ?, st = ?, create_date = ?");
								$insert = $query->execute(array($sn_id, "4", $register_date));
								
							} else {
								
								$array["error"] = $lang['register_try_again']; 
								
							}
					}
			}		
		}
    }
    break;

	case'Logout';
	if (isset($_SESSION['session'])) {
		session_start();
		session_destroy();
		header("Location:index.php");
				setcookie("username",$_SESSION['username'],time()-3600);
				setcookie("password",$_SESSION['password'],time()-3600);
	} else {
		header("Location:index.php");
	}
	break;
	
	
    case'i_submit';	
	sleep(2);
	
    if (!empty($_POST)) {
		
		if (trim($_POST['title'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_item_header_field_can_not_be_empty']; 
		} else if (trim($_POST['price'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_item_price_field_cannot_be_left_blank']; 
		} else if ($_POST['submit_categorys'] == 'no_category') { 
			$array["error"] = $lang['sub_no_category_insert']; 
		} else if (trim($_POST['submit_category'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_you_need_to_select_a_category']; 
		} else if (trim($_POST['details'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_item_detail_description_field_cannot_be_empty']; 
		} else if (trim($_POST['location'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_address_field_can_not_be_empty']; 
		} else if ($_FILES['file']['tmp_name'][0] == "") { 
			$array["error"] = $lang['sub_gallery_field_can_not_be_left_blank']; 
		} else if (empty($_SESSION['session'])) { 
			$array["no_session"] = $lang['sub_you_must_login_or_register_to_send_items']; 
		} else  { 
		
				$price = seo($_POST['price']);
				
				$date = time();
				$item = $db->prepare("INSERT INTO items set title = ? , price = ? , category = ? , address = ? , latitude = ? , longitude = ? , description = ? , permit = ? , user_id = ? , create_date = ?");
				$item->execute(array($_POST['title'],$price,$_POST['submit_category'],$_POST['location'],$_POST['latitude'],$_POST['longitude'],$_POST['details'],$settings['permit'],$_SESSION['id'],$date));
				
				$last_id = $db->lastInsertId();
				
				if ($item->rowCount()) { 
				
					$query = $db->prepare("INSERT INTO notification SET item_id = ?, a_id = ?, st = ?, create_date = ?");
					$insert = $query->execute(array($last_id, $_SESSION['id'], "5", $date));
				
				    if ($settings['permit'] == "1") {
						$array["success"] = $lang['sub_you_product_successfully_published']; 
					} else {
						$array["success"] = $lang['sub_your_product_will_be_published_after_the_administrator_approval']; 
					}
					
					$array["title"] = seo($_POST['title']);
					$array["id"] 	= $last_id;
					
					if (isset($_FILES['file'])) {

								$j = 0;    
								$target_path = "assets/img/gallery/";  
						for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
						 
								$validextensions = array("jpeg", "jpg", "png","gif");  
								$ext = explode('.', basename($_FILES['file']['name'][$i]));  
								$file_extension = end($ext); 
								$userpic = rand(1000,1000000).".".$file_extension;
								$j = $j + 1;   
						
							if (move_uploaded_file($_FILES['file']['tmp_name'][$i], "assets/img/gallery/".$userpic)) {
						
								$gallpic = 	"$target_path$userpic";	
								$saverg = $db->prepare("INSERT INTO gallery set image = ?,item_id = ?");
								$saverg->execute(array($gallpic,$last_id));

							}
						}
					 
					}
			
						$_POST['ctg_bx_1'] = ( !isset($_POST['ctg_bx_1']) ) ? "" : $_POST['ctg_bx_1'];
						$ctg_bx_1 = array($_POST['ctg_bx_1']);
						$ctg_bx_1[0] = ( !isset($ctg_bx_1[0]) ) ? 0 : $ctg_bx_1[0];
					
							for ($i = 0; $i < count($ctg_bx_1[0]); $i++) {
							
								if (@trim($ctg_bx_1[0][$i]) != '') {
									$ctgbx1 = $db->prepare("INSERT INTO i_category_box_1 SET ctg_bx_1_id = ?, item_id = ?");
									$ctgbx1->execute(array($ctg_bx_1[0][$i],$last_id));
								}
							}
					
						$_POST['ctg_bx_2_id'] = ( !isset($_POST['ctg_bx_2_id']) ) ? "" : $_POST['ctg_bx_2_id'];
						$_POST['ctg_bx_2_subj'] = ( !isset($_POST['ctg_bx_2_subj']) ) ? "" : $_POST['ctg_bx_2_subj'];
						$ctg_bx_2 = array($_POST['ctg_bx_2_id'],$_POST['ctg_bx_2_subj']);
						$ctg_bx_2[0] = ( !isset($ctg_bx_2[0]) ) ? 0 : $ctg_bx_2[0];
					
							for ($i = 0; $i < count($ctg_bx_2[0]); $i++) {
								if (@trim($ctg_bx_2[1][$i]) != '') {
									$ctgbx2 = $db->prepare("INSERT INTO i_category_box_2 SET ctg_bx_2_id = ?, ctg_bx_2_subj = ?, item_id = ?");
									$ctgbx2->execute(array($ctg_bx_2[0][$i],$ctg_bx_2[1][$i],$last_id));
								}
							}
						
						$_POST['ctg_bx_3_id'] = ( !isset($_POST['ctg_bx_3_id']) ) ? "" : $_POST['ctg_bx_3_id'];
						$_POST['ctg_bx_3_subj'] = ( !isset($_POST['ctg_bx_3_subj']) ) ? "" : $_POST['ctg_bx_3_subj'];
						$ctg_bx_3 = array($_POST['ctg_bx_3_id'],$_POST['ctg_bx_3_subj']);
						$ctg_bx_3[0] = ( !isset($ctg_bx_3[0]) ) ? 0 : $ctg_bx_3[0];	
						
						
							for ($i = 0; $i < count($ctg_bx_3[0]); $i++) {
								if (@trim($ctg_bx_3[1][$i]) != '') {
									$ctgbx3 = $db->prepare("INSERT INTO i_category_box_3 SET ctg_bx_3_id = ?, ctg_bx_3_subj = ?, item_id = ?");
									$ctgbx3->execute(array($ctg_bx_3[0][$i],$ctg_bx_3[1][$i],$last_id));
								}
							}
						
						
						$_POST['ctg_bx_4_id'] = ( !isset($_POST['ctg_bx_4_id']) ) ? "" : $_POST['ctg_bx_4_id'];	
						$_POST['ctg_bx_4_subj'] = ( !isset($_POST['ctg_bx_4_subj']) ) ? "" : $_POST['ctg_bx_4_subj'];	
						$ctg_bx_4 = array($_POST['ctg_bx_4_id'],$_POST['ctg_bx_4_subj']);
						$ctg_bx_4[0] = ( !isset($ctg_bx_4[0]) ) ? 0 : $ctg_bx_4[0];	
						
					
							for ($i = 0; $i < count($ctg_bx_4[0]); $i++) {
								if (@trim($ctg_bx_4[1][$i]) != '') {
									$ctgbx4 = $db->prepare("INSERT INTO i_category_box_4 SET ctg_bx_4_id = ?, ctg_bx_4_subj = ?, item_id = ?");
									$ctgbx4->execute(array($ctg_bx_4[0][$i],$ctg_bx_4[1][$i],$last_id));
								}
							}
						
						$_POST['ctg_bx_5_id'] = ( !isset($_POST['ctg_bx_5_id']) ) ? "" : $_POST['ctg_bx_5_id'];	
						$ctg_bx_5 = array($_POST['ctg_bx_5_id']);
						$ctg_bx_5[0] = ( !isset($ctg_bx_5[0]) ) ? 0 : $ctg_bx_5[0];			
					
							for ($i = 0; $i < count($ctg_bx_5[0]); $i++) {
							
								if (@trim($ctg_bx_5[0][$i]) != '') {
									$ctgbx5 = $db->prepare("INSERT INTO i_category_box_5 SET ctg_bx_5_id = ?, item_id = ?");
									$ctgbx5->execute(array($ctg_bx_5[0][$i],$last_id));
								}
							}
					
				} else {
					
					$array["error"] = $lang['sub_try_again']; 
					
				}
		}
	}
	break;
	
   

    case'i_submit_reg';	
	sleep(2);
	
    if (!empty($_POST)) {
	
		if (trim($_POST['username'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['register_your_username_can_not_be_empty'];
		} else if (trim($_POST['full_name'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['register_your_fullname_can_not_be_empty']; 
		} else if (trim($_POST['email'])=='' OR empty($_POST)) {
			$array["error"] = $lang['register_your_email_can_not_be_empty']; 
		} else if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
			$array["error"] = $lang['register_this_email_address_is_invalid']; 
		} elseif (trim($_POST['password'])=='' OR empty($_POST)) {
			$array["error"] = $lang['register_your_password_can_not_be_empty']; 
		} elseif (strlen($_POST['password']) < 5) {
			$array["error"] = $lang['register_the_password_must_be_at_least_5_characters']; 
		} elseif (trim($_POST['repeat_password'])=='' OR empty($_POST)) {
			$array["error"] = $lang['register_your_repeat_password_can_not_be_empty']; 
		} elseif (strlen($_POST['repeat_password']) < 5) {
			$array["error"] = $lang['register_the_repeat_password_must_be_at_least_5_characters']; 
		} elseif (trim($_POST['password'])!=($_POST['repeat_password'])) {
			$array["error"] = $lang['register_the_passwords_entered_are_different']; 
		} elseif (trim($_POST['gender'])=='' OR empty($_POST)) {
			$array["opn"] = $lang['register_please_write_your_gender']; 
		} else {	
	        $control = $db->prepare("Select * from users WHERE username = ?");
	        $control->execute(array($_POST['username']));
			
			if ($control->rowCount()) { 
				$array["con_error_username"] = $lang['register_the_username_has_already_been_used']; 
			} else {
				
				$control = $db->prepare("Select * from users WHERE email = ? ");
				$control->execute(array($_POST['email']));
				
				if ($control->rowCount()) { 
					$array["con_error_email"] = $lang['register_the_email_has_already_been_used']; 
				} else {
					
					$password 	    = md5($_POST['password']);
					$token          = uniqid($_POST['username'],true);
					$register_date  = time();
					$username 	    = seo($_POST['username']);
					
					if (!empty($_POST['newsletter']) == "1") {
						$newsletter = "1";
					} else {
						$newsletter = "0";
					}
					
					$reg = $db->prepare("INSERT INTO users set fullname = ? , password = ? , email = ? , register_date = ? , gender = ? , token = ?, username = ?, newsletter = ?");
					$reg->execute(array($_POST['full_name'],$password,$_POST['email'],$register_date,$_POST['gender'],$token,$username,$newsletter));
					
					$sn_ids = $db->lastInsertId();
					
					if ($reg->rowCount()) {

						$query = $db->prepare("INSERT INTO notification SET a_id = ?, st = ?, create_date = ?");
						$insert = $query->execute(array($sn_ids, "4", $register_date));
					
						if (!empty($_POST)) {

						$password = md5($_POST['password']);
						$remember  = @$_POST['remember'];
						$login = $db->prepare("Select * from users WHERE email = ? and password = ? ");
						$login->execute(array($_POST['email'],$password));
						
							if ($login->rowCount()) { 
								$row = $login->fetch(PDO::FETCH_ASSOC);
								$_SESSION['session']	= TRUE;
								$_SESSION['email']      = $_POST['email'];
								$_SESSION['password']   = $password;
								$_SESSION['id']		    = $row['id'];
								$_SESSION['token']		= $row['token'];
								$_SESSION['st']         = $row['st'];

								if ($remember == "remember") {
									setcookie("email",$_SESSION['email'],time()+(60*60*24));
									setcookie("password",$_SESSION['password'],time()+(60*60*24));
								}
								$array["success"] = $lang['sub_success_login']; 
								$array["fnames"] = $row['fullname'];
							} else {
								$array["error"] = $lang['register_try_again']; 
							}
						}	   
					} else {
						$array["error"] = $lang['register_try_again']; 
					}
				}
			}		
		}
    }
    break;


    case'i_submit_sgin';	
	sleep(2);
	
    if (!empty($_POST)) {

		if (trim($_POST['emails'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['signin_your_email_can_not_be_empty'];
		} else if ( ! filter_var($_POST['emails'], FILTER_VALIDATE_EMAIL)) { 
			$array["error"] = $lang['signin_this_email_address_is_invalid'];
		} else if (trim($_POST['passwords'])=='' OR empty($_POST)) {
			$array["error"] = $lang['signin_your_password_can_not_be_empty'];
		} else {
			$password = md5($_POST['passwords']);
			$remember  = @$_POST['remember'];
			$login = $db->prepare("Select * from users WHERE email = ? and password = ? ");
			$login->execute(array($_POST['emails'],$password));
			if($login->rowCount()){ 
				$row = $login->fetch(PDO::FETCH_ASSOC);
				$_SESSION['session']	= TRUE;
				$_SESSION['email']      = $_POST['emails'];
				$_SESSION['password']   = $password;
				$_SESSION['id']		    = $row['id'];
				$_SESSION['token']		= $row['token'];
				$_SESSION['st']         = $row['st'];

				if($remember == "remember"){
					setcookie("email",$_SESSION['email'],time()+(60*60*24));
					setcookie("password",$_SESSION['password'],time()+(60*60*24));
				}
				
				$array["success"] = $lang['signin_you_have_successfully_logged_in'];
				
				$array["fname"] = $row['fullname'];
				
			} else {
				$array["con_error"] = $lang['signin_username_or_password_is_incorrect'];
			}
		}
    }
    break;
	
	case'my_profile';	
	sleep(2);
	
    if (!empty($_POST)) {
		if (trim($_POST['gender'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['dash_gender_field_can_not_be_empty']; 
		} else if (trim($_POST['fullname'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['dash_your_fullname_can_not_be_empty']; 
		} else {
			
		if (!empty($_POST['emp_phone'])) {
			$hide_ph = "1";
		} else {
			$hide_ph = "0";
		}	
		
		if (!empty($_POST['emp_email'])) {
			$hide_em = "1";
		} else {
			$hide_em = "0";
		}	
		
	        $update = "UPDATE users SET fullname = :flnm , gender = :gndr , location = :lctn , latitude = :lttd , longitude = :lngtd , about = :abt , email = :ml , phone = :phn , facebook = :fcbk , twitter = :twtr , instagram = :nstgrm , youtube = :ytb , hide_phone = :hd_phn , hide_email = :hd_eml WHERE id = :id";
            $usr = $db->prepare($update);                                  
            $usr->bindParam(':flnm', $_POST['fullname'], PDO::PARAM_STR);
			$usr->bindParam(':gndr', $_POST['gender'], PDO::PARAM_STR);
			$usr->bindParam(':lctn', $_POST['location'], PDO::PARAM_STR);
			$usr->bindParam(':lttd', $_POST['latitude'], PDO::PARAM_STR);
			$usr->bindParam(':lngtd', $_POST['longitude'], PDO::PARAM_STR);
			$usr->bindParam(':abt', $_POST['about'], PDO::PARAM_STR);
			$usr->bindParam(':ml', $_POST['email'], PDO::PARAM_STR);
			$usr->bindParam(':phn', $_POST['phone'], PDO::PARAM_STR);
			$usr->bindParam(':fcbk', $_POST['facebook'], PDO::PARAM_STR);
			$usr->bindParam(':twtr', $_POST['twitter'], PDO::PARAM_STR);
			$usr->bindParam(':nstgrm', $_POST['instagram'], PDO::PARAM_STR);
			$usr->bindParam(':ytb', $_POST['youtube'], PDO::PARAM_STR);
			$usr->bindParam(':hd_phn', $hide_ph, PDO::PARAM_STR);
			$usr->bindParam(':hd_eml', $hide_em, PDO::PARAM_STR);
	        $usr->bindParam(':id', $users['id'], PDO::PARAM_INT);
				if($usr->execute()) {
					if (!empty($_FILES['file']['tmp_name'][0])) { 
								$j = 0;    
								$target_path = "assets/img/picture/";  
						for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
						 
								$validextensions = array("jpeg", "jpg", "png","gif");  
								$ext = explode('.', basename($_FILES['file']['name'][$i]));  
								$file_extension = end($ext); 
								$userpic = rand(1000,1000000).".".$file_extension;
								$j = $j + 1;   
						
							if (move_uploaded_file($_FILES['file']['tmp_name'][$i], "assets/img/picture/".$userpic)) {
						
								$pictures = "$target_path$userpic";	
								$update = "UPDATE users SET picture = :pctr WHERE id = :id";
								$pct = $db->prepare($update);                                  
								$pct->bindParam(':pctr', $pictures, PDO::PARAM_STR);
								$pct->bindParam(':id', $users['id'], PDO::PARAM_INT);
									if($pct->execute()) {
										$array["success"] = $lang['dash_you_have_successfully_updated_your_profile_picture_and_other_settings']; 
									}

							}
						}
					} else {
						$array["success"] = $lang['dash_you_successfully_updated_your_profile']; 
					}
				}

		}
	}
	break;

	case'sent_message';	
	sleep(2);
	
    if (!empty($_POST)) {
		$message = trim(htmlspecialchars($_POST["message"]));
		$date = time();
		
		if (empty($_SESSION['session'])) {  
			$array["noses"] = $lang['product_you_most_login_send_message'];
		} else if (empty($message)) {
			$array["error"] = $lang['product_message_field_cannot_be_left_blank'];
		} else if ($users['id'] == $_POST["target_id"]) {
			$array["noses"] = $lang['product_you_can_not_send_messages_to_yourself'];
		} else {
			
			$sale_status_control = $db -> query("SELECT * FROM items WHERE id = '".$_POST["product_id"]."'")->fetch();
				
			if ($sale_status_control['sale_status'] != "0") { 
				$array["noses"] = $lang['product_this_product_is_no_longer_available'];
			} else {
					
				$ins = $db->prepare("INSERT INTO users_chats set message = ? , user_id = ? , target_id = ? , product_id = ? , date = ?");
				$ins->execute(array($message,$users['id'],$_POST["target_id"],$_POST["product_id"],$date));
				
				if($ins->rowCount()){
					
					$array["success"] = $lang['product_your_message_was_successfully_sent'];
					
					$query = $db->prepare("INSERT INTO notification SET g_id = ?, a_id = ?, st = ?, create_date = ?");
					$insert = $query->execute(array($users["id"], $_POST["target_id"], "2", $date));

					$smtp = $db -> query("SELECT * FROM smtp")->fetch();

					$target = $db -> query("SELECT * FROM users WHERE id = '".$_POST["target_id"]."'")->fetch();
					
					$you_target = $db -> query("SELECT * FROM users WHERE id = '".$users["id"]."'")->fetch();
					
					if ($you_target['picture'] != "") {
						$pic = "".$smtp['site_name']."/".$you_target['picture'].""; 
					} else {
						if ($you_target['gender'] == "1") { 
							$pic = "".$smtp['site_name']."/assets/img/picture/no_picture_mr.png"; 
						} else {
							$pic = "".$smtp['site_name']."/assets/img/picture/no_picture_mrs.png"; 
						}
					}

					
					$id = $_POST['product_id']; 
					
					$glr = $db->query("SELECT * FROM gallery WHERE item_id = '{$id}'")->fetch(PDO::FETCH_ASSOC);

					include 'Mail/class.phpmailer.php';
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Host = $smtp['host'];
					$mail->Port = $smtp['port'];
					$mail->SMTPSecure = $smtp['smtp_secure'];
					$mail->Username = $smtp['username'];
					$mail->Password = $smtp['password'];
					$mail->SetFrom($mail->Username, $smtp['username']);
					$mail->AddAddress($target['email']);
					$mail->CharSet = 'UTF-8';
					$mail->Subject = $lang['e_mail_new_message'];
					$content = '<center>
									<table border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff" width="750">
										<tbody>
											<tr>
												<td style="border-bottom:solid 5px #ec1c24;" background="'.@$settings['mail_header_img'].'">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tbody>
														
															<tr>
															
																<td width="30%" align="left" style="padding:20px">
																
																		<a href="'.@$smtp['site_name'].'" target="_blank">
																			<img src="'.@$settings['logo_two'].'" alt="'.@$settings['general_about'].'" border="0" class="CToWUd">
																		</a>
																		
																</td>
																
																<td width="70%" align="right" style="padding:20px">
																
																	<a href="http://twitter.com/'.@$settings['twitter'].'" style="background-color: #ec1c24;padding:14px;border: solid 1px #ed1c24de;display:inline-block;" target="_blank">
																		<img src="assets/img/twitter.png" alt="twitter" border="0" class="CToWUd">
																	</a>
																
																	<a href="http://www.facebook.com/'.@$settings['facebook'].'" style="background-color: #ec1c24;padding:14px;border: solid 1px #ed1c24de;display:inline-block;margin:0 6px 0 6px" target="_blank">
																		<img src="assets/img/facebook.png" alt="facebook" border="0" class="CToWUd">
																	</a>

																</td>
																
															</tr>
															
														</tbody>
													</table>
												</td>
											</tr>
											
											<tr>
	 
												<td style="padding:20px">
													<center>
														<a href="'.@$smtp['site_name'].'/profile_detail.php?users='.$you_target['username'].'">
															<p style="font-size:18px;color:black;"><strong>'.$you_target['fullname'].'</strong></p>
															<img style="width: 31px;height: 30px;line-height: 0.375rem;border-radius: 50%;" src="'.$pic.'" class="h-100" alt=""> 
														</a>	
														<p style="font-size:18px;">'.$message.'</p>
													</center>	
													<center>
													<a href="'.@$smtp['site_name'].'/product.php?title='.seo($sale_status_control['title']).'&id='.$sale_status_control['id'].'">
														<img style="width: 35%;height: 35%;line-height: 0.375rem;border-radius: 2%;" src="'.$glr['image'].'">
													</a>
													</center>
													<br>

													
												</td>
												
											</tr>
											
											<tr>
												<td style="background-color:#ec1c24">
											
													<table border="0" cellpadding="0" cellspacing="0" style="color:#ffffff" width="100%">
													
														<tbody>
															
															<tr>
																<td colspan="3" align="center" style="padding:30px">
																	<a href="'.@$smtp['site_name'].'" target="_blank">
																	<img src="'.@$settings['logo'].'" alt="'.@$settings['general_about'].'" border="0" class="CToWUd"></a>
																</td>
															</tr>
															
															<tr>
															
																<td width="33%" align="center" style="padding:0 0 20px 0">
																	<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_phone'].'</strong><br>
																	'.@$settings['phone'].'
																</td>

																<td width="33%" align="center" style="padding:0 0 30px 0">
																	<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_address'].'</strong><br>
																	<a style="color:white;">'.@$settings['address'].'</a>
																</td>
																
																<td width="33%" align="center" style="padding:0 0 30px 0">
																	<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_email'].'</strong><br>
																	<a style="color:white;" href="mailto:'.@$settings['email'].'" target="_blank">'.@$settings['email'].'</a>
																</td>
																

																
															</tr>
															
														</tbody>
													
													</table>
													
												</td>
												
											</tr>
											
										</tbody>
									</table>
								</center>';
								
				$mail->MsgHTML($content);
				
				if($mail->Send()) {
					
				}
					
					
				} else {
					$array["array"] = $lang['product_try_again_later'];
				}
			}
		}
		
	}
	break;
	
	case'change_password';	
	sleep(2);
	
    if (!empty($_POST)) {

		if (trim($_POST['current_password'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['change_your_current_password_can_not_be_empty'];
		} else {
			$password = md5($_POST['current_password']);
			$control = $db->prepare("Select * from users WHERE password = ? and id = ?");
			$control->execute(array($password,$users['id']));
			if ($control->rowCount()) { 
			
				if (trim($_POST['new_current_password'])=='' OR empty($_POST)) { 
					$array["p_error"] = $lang['change_your_new_current_password_can_not_be_empty'];
				} else if (strlen($_POST['new_current_password']) < 5) { 
					$array["p_error"] = $lang['change_your_new_current_password_can_not_be_less_than_5_characters'];
				} else if (trim($_POST['repeat_new_current_password'])=='' OR empty($_POST)) {
					$array["p_error"] = $lang['change_your_repeat_new_current_password_can_not_be_empty'];
				} else if (strlen($_POST['repeat_new_current_password']) < 5) { 
					$array["p_error"] = $lang['change_your_repeat_password_can_not_be_less_than_5_characters'];
				} else if (trim($_POST['new_current_password'])!=($_POST['repeat_new_current_password'])) {
					$array["p_error"] = $lang['change_new_password_and_repeat_password_are_not_the_same'];
				} else {
					$new_password = md5($_POST['new_current_password']);
					$update = "UPDATE users SET password = :pswrd WHERE id = :id";
					$psw = $db->prepare($update);                                  
					$psw->bindParam(':pswrd', $new_password, PDO::PARAM_STR);
					$psw->bindParam(':id', $users['id'], PDO::PARAM_INT);
					if($psw->execute()) {
						$array["success"] = $lang['change_your_password_has_been_successfully_updated'];
					}
				}
			
			} else {				
				$array["c_error"] = $lang['change_current_password_is_incorrect'];
			}
		}
    }
    break;
	
	case'contact_send_message';	
	sleep(2);
	
    if (!empty($_POST)) {

		$date = time();
		
		if (trim($_POST['c_fullname'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['contact_full_name_can_not_be_empty'];
		} else if (trim($_POST['c_email'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['contact_email_can_not_be_empty'];
		} else if (!filter_var($_POST['c_email'], FILTER_VALIDATE_EMAIL)) { 
			$array["error"] = $lang['contact_email_address_is_incorrect'];
		} else if (trim($_POST['c_subject'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['contact_subject_can_not_be_empty'];
		} else if (trim($_POST["c_message"])=='' OR empty($_POST)) { 
			$array["error"] = $lang['contact_message_can_not_be_empty'];
		} else {
			
			$cont_mes = $db->prepare("INSERT INTO contact SET c_fullname = ? , c_email = ? , c_subject = ? , c_message = ? , c_date = ?");
			$cont_mes->execute(array($_POST["c_fullname"],$_POST["c_email"],$_POST["c_subject"],$_POST["c_message"],$date));
				
				if($cont_mes->rowCount()){
					$array["success"] = $lang['contact_message_sent_successfully'];
				} else {
					$array["error"] = $lang['contact_try_again'];
				}
		}
	}
	break;
	
	case'users_comment';	
	sleep(2);
	
    if (!empty($_POST)) {
		
		$date = time();
		
		if (trim($_POST['review'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['profile_comment_field_cannot_be_blank'];
		} else if (trim($_POST['rating'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['profile_evaluation_field_can_not_be_empty'];
		} else {
			$u_comment = $db->prepare("INSERT INTO users_comment SET your_id = ? , i_rate = ? , date = ? , i_id = ? , i_desc = ?");
			$u_comment->execute(array($_POST["r_id"],$_POST["rating"],$date,$users["id"],$_POST['review']));
				
			if($u_comment->rowCount()){
				
				
					$array["success"] = $lang['profile_the_review_is_successful'];

					$query = $db->prepare("INSERT INTO notification SET g_id = ?, a_id = ?, st = ?, create_date = ?");
					$insert = $query->execute(array($users["id"], $_POST["r_id"], "1", $date));
					
					$smtp = $db -> query("SELECT * FROM smtp")->fetch();

					$target = $db -> query("SELECT * FROM users WHERE id = '".$_POST["r_id"]."'")->fetch();
					
					$you_target = $db -> query("SELECT * FROM users WHERE id = '".$users["id"]."'")->fetch();
					
					if ($you_target['picture'] != "") {
						$pic = "".$smtp['site_name']."/".$you_target['picture'].""; 
					} else {
						if ($you_target['gender'] == "1") { 
							$pic = "".$smtp['site_name']."/assets/img/picture/no_picture_mr.png"; 
						} else {
							$pic = "".$smtp['site_name']."/assets/img/picture/no_picture_mrs.png"; 
						}
					}
					
					if ($_POST["rating"] == "5") {
						$rat = $lang['profile_excellent'];
					} else if ($_POST["rating"] == "4") {
						$rat = $lang['profile_very_good'];
					} else if ($_POST["rating"] == "3") {
						$rat = $lang['profile_good'];	
					} else if ($_POST["rating"] == "2") {
						$rat = $lang['profile_average'];	
					} else if ($_POST["rating"] == "1") {
						$rat = $lang['profile_horrible'];
					}

					include 'Mail/class.phpmailer.php';
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Host = $smtp['host'];
					$mail->Port = $smtp['port'];
					$mail->SMTPSecure = $smtp['smtp_secure'];
					$mail->Username = $smtp['username'];
					$mail->Password = $smtp['password'];
					$mail->SetFrom($mail->Username, $smtp['username']);
					$mail->AddAddress($target['email']);
					$mail->CharSet = 'UTF-8';
					$mail->Subject = $lang['e_mail_new_reviews'];
					$content = '<center>
									<table border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff" width="750">
										<tbody>
											<tr>
												<td style="border-bottom:solid 5px #ec1c24;" background="'.@$settings['mail_header_img'].'">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tbody>
														
															<tr>
															
																<td width="30%" align="left" style="padding:20px">
																
																		<a href="'.@$smtp['site_name'].'" target="_blank">
																			<img src="'.@$settings['logo_two'].'" alt="'.@$settings['general_about'].'" border="0" class="CToWUd">
																		</a>
																		
																</td>
																
																<td width="70%" align="right" style="padding:20px">
																
																	<a href="http://twitter.com/'.@$settings['twitter'].'" style="background-color: #ec1c24;padding:14px;border: solid 1px #ed1c24de;display:inline-block;" target="_blank">
																		<img src="assets/img/twitter.png" alt="twitter" border="0" class="CToWUd">
																	</a>
																
																	<a href="http://www.facebook.com/'.@$settings['facebook'].'" style="background-color: #ec1c24;padding:14px;border: solid 1px #ed1c24de;display:inline-block;margin:0 6px 0 6px" target="_blank">
																		<img src="assets/img/facebook.png" alt="facebook" border="0" class="CToWUd">
																	</a>

																</td>
																
															</tr>
															
														</tbody>
													</table>
												</td>
											</tr>
											
											<tr>
	 
												<td style="padding:20px">
													<center>
														<a href="'.@$smtp['site_name'].'/profile_detail.php?users='.$you_target['username'].'">
															<p style="font-size:18px;color:black;"><strong>'.$you_target['fullname'].'</strong></p>
															<img style="width: 31px;height: 30px;line-height: 0.375rem;border-radius: 50%;" src="'.$pic.'" class="h-100" alt=""> 
														</a>	
														<p style="font-size:18px;"><strong> '.$rat.' </strong><br><br>'.$_POST['review'].'</p>
													</center>	
													<br>
													
												</td>
												
											</tr>
											
											<tr>
												<td style="background-color:#ec1c24">
											
													<table border="0" cellpadding="0" cellspacing="0" style="color:#ffffff" width="100%">
													
														<tbody>
															
															<tr>
																<td colspan="3" align="center" style="padding:30px">
																	<a href="'.@$smtp['site_name'].'" target="_blank">
																	<img src="'.@$settings['logo'].'" alt="'.@$settings['general_about'].'" border="0" class="CToWUd"></a>
																</td>
															</tr>
															
															<tr>
															
																<td width="33%" align="center" style="padding:0 0 20px 0">
																	<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_phone'].'</strong><br>
																	'.@$settings['phone'].'
																</td>

																<td width="33%" align="center" style="padding:0 0 30px 0">
																	<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_address'].'</strong><br>
																	<a style="color:white;">'.@$settings['address'].'</a>
																</td>
																
																<td width="33%" align="center" style="padding:0 0 30px 0">
																	<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_email'].'</strong><br>
																	<a style="color:white;" href="mailto:'.@$settings['email'].'" target="_blank">'.@$settings['email'].'</a>
																</td>
																

																
															</tr>
															
														</tbody>
													
													</table>
													
												</td>
												
											</tr>
											
										</tbody>
									</table>
								</center>';
								
				$mail->MsgHTML($content);
				
				if($mail->Send()) {
					
				}
				
				
			} else {
				$array["success"] = $lang['profile_try_again_later'];
			}
		}
	}
	break;
	
	case'blog_message';	
	sleep(2);
	
    if (!empty($_POST)) {
		
		$comment = trim(htmlspecialchars($_POST["comment"]));
		
		$date = time(); 
		
		if (empty($_SESSION['session'])) {  
			$array["boses"] = "<p>".$lang['blog_you_must_login']."</p>";
		} else if (empty($comment)) {
			$array["error"] = "<p>".$lang['blog_comment_field_can_not_be_empty']."</p>";
		} else {
			
			if ($users['st'] != "1") {
			
				if ($users['id'] != $_POST['blog_user_id']) {
				
					if ($settings['blog_permit'] == "0") {
						
						$ins = $db->prepare("INSERT INTO blog_comment set blog_id = ? , b_desc = ? , user_id = ? , b_permit = ? , create_date = ?");
						$ins->execute(array($_POST["blog_id"],$comment,$users['id'],"0",$date));
							
						if($ins->rowCount()){
							$array["success"] = "<p>".$lang['blog_your_comment_will_be_published_after_review']."</p>";
						} else {
							$array["error"] = "<p>".$lang['blog_error_later_try_again']."</p>";
						}
						
					} else {
						
						$ins = $db->prepare("INSERT INTO blog_comment set blog_id = ? , b_desc = ? , user_id = ? , b_permit = ? , create_date = ?");
						$ins->execute(array($_POST["blog_id"],$comment,$users['id'],"1",$date));
							
						if($ins->rowCount()){
							$array["success"] = "<p>".$lang['blog_your_comment_has_been_success']."</p>";
						} else {
							$array["error"] = "<p>".$lang['blog_error_later_try_again']."</p>";
						}
						
					}
					
				} else {
					
					$ins = $db->prepare("INSERT INTO blog_comment set blog_id = ? , b_desc = ? , user_id = ? , b_permit = ? , create_date = ?");
					$ins->execute(array($_POST["blog_id"],$comment,$users['id'],"1",$date));
							
					if($ins->rowCount()){
						$array["success"] = "<p>".$lang['blog_your_comment_has_been_success_published']."</p>";
					} else {
						$array["error"] = "<p>".$lang['blog_error_later_try_again']."</p>";
					}
					
				}
			} else {
				
					$ins = $db->prepare("INSERT INTO blog_comment set blog_id = ? , b_desc = ? , user_id = ? , b_permit = ? , create_date = ?");
					$ins->execute(array($_POST["blog_id"],$comment,$users['id'],"1",$date));
							
					if($ins->rowCount()){
						$array["success"] = "<p>".$lang['blog_succesful_published_as_an_admin']."</p>";
					} else {
						$array["error"] = "<p>".$lang['blog_error_later_try_again']."</p>";
					}
				
			}
		}
		
	}
	break;
	
    case'i_edit';	
	sleep(2);
	
	if (!empty($_POST)) {
	
		$id = $_POST['item_id']; 
	
		if (trim($_POST['title'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_item_header_field_can_not_be_empty']; 
		} else if (trim($_POST['price'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_item_price_field_cannot_be_left_blank']; 
		} else if (trim($_POST['details'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_item_detail_description_field_cannot_be_empty']; 
		} else if (trim($_POST['location'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['sub_address_field_can_not_be_empty']; 
		} else if (@$_FILES['file']['tmp_name'][0] == '' AND @$_POST['g_image_id'][0] == '') { 
			$array["error"] = $lang['sub_edit_picture_for_the_gallery']; 
		} else {

			$query = $db->query("SELECT * FROM items WHERE id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
			
			if ($query['category'] == $_POST['submit_category']) {
				
				$update = "UPDATE items SET title = :ttl, price = :prc, category = :ctgry, description = :dtl, address = :adr, latitude = :ltd, longitude = :lng WHERE id = :i";
				$it_b = $db->prepare($update);                                  
				$it_b->bindParam(':ttl', $_POST['title'], PDO::PARAM_STR);
				$it_b->bindParam(':prc', $_POST['price'], PDO::PARAM_STR);
				$it_b->bindParam(':ctgry', $_POST['submit_category'], PDO::PARAM_STR);
				$it_b->bindParam(':dtl', $_POST['details'], PDO::PARAM_STR);
				$it_b->bindParam(':adr', $_POST['location'], PDO::PARAM_STR);
				$it_b->bindParam(':ltd', $_POST['latitude'], PDO::PARAM_STR);
				$it_b->bindParam(':lng', $_POST['longitude'], PDO::PARAM_STR);
				$it_b->bindParam(':i', $id , PDO::PARAM_STR);
				
				if($it_b->execute()) { 
				
					$array["success"] = $lang['sub_edit_successfully_updated']; 	
				
				// 1
					
				$_POST['ctg_bx_1'] = ( !isset($_POST['ctg_bx_1']) ) ? "" : $_POST['ctg_bx_1'];	
				$ctg_bx_1 = array($_POST['ctg_bx_1']);
				$ctg_bx_1[0] = ( !isset($ctg_bx_1[0]) ) ? 0 : $ctg_bx_1[0];			
					
				for ($i = 0; $i < count($ctg_bx_1[0]); $i++) {
							
					if (@trim($ctg_bx_1[0][$i]) != '') {
						
						$query = $db->query("SELECT * FROM i_category_box_1 WHERE ctg_bx_1_id = '".$ctg_bx_1[0][$i]."' AND item_id = '".$id."'")->fetch(PDO::FETCH_ASSOC);
						
						if (empty($query)) {
						
							$ctgbx1 = $db->prepare("INSERT INTO i_category_box_1 SET ctg_bx_1_id = ?, item_id = ?");
							$ctgbx1->execute(array($ctg_bx_1[0][$i],$id));
							
						}
					}
				}

				$people = (isset($_POST['ctg_bx_1'])) ? array($_POST['ctg_bx_1']) : array();

				$adding = $db->query(" select * from `i_category_box_1` where `item_id` = '".$id."' ")->fetchAll(); 

				foreach ($adding as $a => $b) {
				
					if (!in_array( $b['ctg_bx_1_id'] , $people[0])) {
							
						$delete = "DELETE FROM i_category_box_1  WHERE ctg_bx_1_id = :cid AND item_id =:id";
						$stmt = $db->prepare($delete);                                  
						$stmt->bindParam(':cid', $b['ctg_bx_1_id'], PDO::PARAM_STR);  
						$stmt->bindParam(':id', $id, PDO::PARAM_STR); 						
						if($stmt->execute()) {
							
						}
								
					}	
				
				}
				
				// 2

				$ctg_bx_2_id = array(@$_POST['ctg_bx_2_id'],@$_POST['ctg_bx_2_subj']);	
					
				for ($i = 0; $i < count($ctg_bx_2_id[0]); $i++) {
							
					if (@trim($ctg_bx_2_id[1][$i]) != '') {
						
						$query = $db->query("SELECT * FROM i_category_box_2 WHERE ctg_bx_2_subj = '".$ctg_bx_2_id[1][$i]."' AND item_id = '".$id."'")->fetch(PDO::FETCH_ASSOC);
						
						if (empty($query)) {
						
							$ctgbx1 = $db->prepare("INSERT INTO i_category_box_2 SET ctg_bx_2_id = ?, ctg_bx_2_subj = ?, item_id = ?");
							$ctgbx1->execute(array($ctg_bx_2_id[0][$i],$ctg_bx_2_id[1][$i],$id));

						}
					}
				}

				$people = (isset($_POST['ctg_bx_2_subj'])) ? array($_POST['ctg_bx_2_subj']) : array();

				$adding = $db->query("SELECT * FROM `i_category_box_2` WHERE `item_id` = '".$id."' ")->fetchAll(); 

				foreach ($adding as $a => $b) {
				
					if (!in_array( $b['ctg_bx_2_subj'] , $people[0])) {
							
						$delete = "DELETE FROM i_category_box_2  WHERE ctg_bx_2_subj = :cid AND item_id =:id";
						$stmt = $db->prepare($delete);                                  
						$stmt->bindParam(':cid', $b['ctg_bx_2_subj'], PDO::PARAM_STR);  
						$stmt->bindParam(':id', $id, PDO::PARAM_STR); 						
						if($stmt->execute()) {
							
						}
								
					}	
				
				}

				// 3
						
				$ctg_bx_3_id = array(@$_POST['ctg_bx_3_id'],@$_POST['ctg_bx_3_subj']);	
					
				for ($i = 0; $i < count($ctg_bx_3_id[0]); $i++) {
							
					if (@trim($ctg_bx_3_id[1][$i]) != '') {
						
						$query = $db->query("SELECT * FROM i_category_box_3 WHERE ctg_bx_3_subj = '".$ctg_bx_3_id[1][$i]."' AND item_id = '".$id."'")->fetch(PDO::FETCH_ASSOC);
						
						if (empty($query)) {
						
							$ctgbx1 = $db->prepare("INSERT INTO i_category_box_3 SET ctg_bx_3_id = ?, ctg_bx_3_subj = ?, item_id = ?");
							$ctgbx1->execute(array($ctg_bx_3_id[0][$i],$ctg_bx_3_id[1][$i],$id));

						}
					}
				}

				$people = (isset($_POST['ctg_bx_3_subj'])) ? array($_POST['ctg_bx_3_subj']) : array();

				$adding = $db->query("SELECT * FROM `i_category_box_3` WHERE `item_id` = '".$id."' ")->fetchAll(); 

				foreach ($adding as $a => $b) {
				
					if (!in_array( $b['ctg_bx_3_subj'] , $people[0])) {
							
						$delete = "DELETE FROM i_category_box_3  WHERE ctg_bx_3_subj = :cid AND item_id =:id";
						$stmt = $db->prepare($delete);                                  
						$stmt->bindParam(':cid', $b['ctg_bx_3_subj'], PDO::PARAM_STR);  
						$stmt->bindParam(':id', $id, PDO::PARAM_STR); 						
						if($stmt->execute()) {
							
						}
								
					}	
				
				}
						
				// 4		
						
				$ctg_bx_4_id = array(@$_POST['ctg_bx_4_id'],@$_POST['ctg_bx_4_subj']);	
					
				for ($i = 0; $i < count($ctg_bx_4_id[0]); $i++) {
							
					if (@trim($ctg_bx_4_id[1][$i]) != '') {
						
						$query = $db->query("SELECT * FROM i_category_box_4 WHERE ctg_bx_4_subj = '".$ctg_bx_4_id[1][$i]."' AND item_id = '".$id."'")->fetch(PDO::FETCH_ASSOC);
						
						if (empty($query)) {
						
							$ctgbx1 = $db->prepare("INSERT INTO i_category_box_4 SET ctg_bx_4_id = ?, ctg_bx_4_subj = ?, item_id = ?");
							$ctgbx1->execute(array($ctg_bx_4_id[0][$i],$ctg_bx_4_id[1][$i],$id));
							
						}
					}
				}

				$people = (isset($_POST['ctg_bx_4_subj'])) ? array($_POST['ctg_bx_4_subj']) : array();

				$adding = $db->query("SELECT * FROM `i_category_box_4` WHERE `item_id` = '".$id."' ")->fetchAll(); 

				foreach ($adding as $a => $b) {
				
					if (!in_array( $b['ctg_bx_4_subj'] , $people[0])) {
							
						$delete = "DELETE FROM i_category_box_4  WHERE ctg_bx_4_subj = :cid AND item_id =:id";
						$stmt = $db->prepare($delete);                                  
						$stmt->bindParam(':cid', $b['ctg_bx_4_subj'], PDO::PARAM_STR);  
						$stmt->bindParam(':id', $id, PDO::PARAM_STR); 						
						if($stmt->execute()) {
							
						}
								
					}	
				
				}	

				// 5
				
				$_POST['ctg_bx_5_id'] = ( !isset($_POST['ctg_bx_5_id']) ) ? "" : $_POST['ctg_bx_5_id'];	
				$ctg_bx_5 = array($_POST['ctg_bx_5_id']);
				$ctg_bx_5[0] = ( !isset($ctg_bx_5[0]) ) ? 0 : $ctg_bx_5[0];			
					
				for ($i = 0; $i < count($ctg_bx_5[0]); $i++) {
							
					if (@trim($ctg_bx_5[0][$i]) != '') {
						
						$ctgbx5 = $db->prepare("INSERT INTO i_category_box_5 SET ctg_bx_5_id = ?, item_id = ?");
						$ctgbx5->execute(array($ctg_bx_5[0][$i],$id));
						
					}
				}

				$ctg_bx_5_id = (isset($_POST['ctg_bx_5_id'])) ? array($_POST['ctg_bx_5_id']) : array();
			
				$adding = $db->query(" select * from `i_category_box_5` where `item_id` = '".$id."' ")->fetchAll(); 
				
				foreach ($adding as $a => $b) {
					
					if(!in_array( $b['ctg_bx_5_id'] , $ctg_bx_5_id)) {
						
						$delete = "DELETE FROM i_category_box_5  WHERE ctg_bx_5_id = :aid AND item_id =:id";
						$stmt = $db->prepare($delete);                                  
						$stmt->bindParam(':aid', $b['ctg_bx_5_id'], PDO::PARAM_STR);  
						$stmt->bindParam(':id', $id, PDO::PARAM_STR);
 						
						if($stmt->execute()) {
							
						}
						
					}
				}

				for ($i = 0; $i < @count($ctg_bx_5_id[0]); $i++) {
				 
					if(trim(@$ctg_bx_5_id[0][$i]) !='') {
						
						$items_i = $db -> query("SELECT * FROM i_category_box_5 WHERE `ctg_bx_5_id` = '{$ctg_bx_5_id[0][$i]}' AND `item_id` = '".$id."'")->fetch();	
						
						if (empty($items_i)) {
							
							$statement = $db->prepare("INSERT INTO i_category_box_5(ctg_bx_5_id, item_id) VALUES(?, ?)");
							$statement->execute(array($ctg_bx_5_id[0][$i], $id));
							
						}				
					}
					
				}

					// Delete İmage
						
					if (isset($_POST)) {

						
						$people = (isset($_POST['g_image_id'])) ? array($_POST['g_image_id']) : array();

						if ($_FILES['file']['tmp_name'][0] != "" AND @$_POST['g_image_id'] != "") { 
						
							$peop = $people[0];
							
						} else if(@$_POST['g_image_id'] != "") {
							
							$peop = $people[0];
							
							$array['success'] = $lang['sub_edit_successfully_updated'];
							
						} else {
							
							$peop = $people;
							
						}
						
						$adding = $db->query("SELECT * FROM `gallery` WHERE `item_id` = '".$id."' ")->fetchAll(); 

						foreach ($adding as $a => $b) {
						
							if (!in_array( $b['id'] ,$peop )) {
									
								$delete = "DELETE FROM gallery  WHERE id =:i";
								$stmt = $db->prepare($delete);                        
								$stmt->bindParam(':i', $b['id'], PDO::PARAM_STR); 						
								if($stmt->execute()) {
									
								}
										
							}	
						
						}
						
						// İnsert İmage
						
						if (!empty($_FILES['file']['tmp_name'][0])) { 
							
							$j = 0;    
							$target_path = "assets/img/gallery/";  

							for ($i = 0; $i < count($_FILES['file']['name']); $i++) {	
											 
									$validextensions = array("jpeg", "jpg", "png","gif");  
									$ext = explode('.', basename($_FILES['file']['name'][$i]));  
									$file_extension = end($ext); 
									$userpic = rand(1000,1000000).".".$file_extension;
									$j = $j + 1;   
											
								if (move_uploaded_file($_FILES['file']['tmp_name'][$i], "assets/img/gallery/".$userpic)) {
											
									$pictures = "$target_path$userpic";	
										
									$ins = $db->prepare("INSERT INTO gallery SET image = :img, item_id = :i_id");
									$ins->execute(array("img" => $pictures,"i_id" => $id));

								}
							}
						}
					}					

				}
			}
		}
	}
	break;
	
	case'pass_rst';	
	sleep(2);
	
    if (!empty($_POST)) {

		if (trim($_POST['email_r'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['signin_email_address_field_c_n_b_empty'];
		} else {

			$e_mail = $db->query("SELECT * FROM users WHERE email='".$_POST['email_r']."'");

			$e_mail = $e_mail->fetch(PDO::FETCH_ASSOC);

			if($e_mail) {

				$smtp = $db -> query("SELECT * FROM smtp")->fetch();

				$token =  $e_mail['token'];

				include 'Mail/class.phpmailer.php';
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Host = $smtp['host'];
				$mail->Port = $smtp['port'];
				$mail->SMTPSecure = $smtp['smtp_secure'];
				$mail->Username = $smtp['username'];
				$mail->Password = $smtp['password'];
				$mail->SetFrom($mail->Username, $smtp['username']);
				$mail->AddAddress($_POST['email_r']);
				$mail->CharSet = 'UTF-8';
				$mail->Subject = $lang['e_mail_password_reset'];
				$content = '<center>
								<table border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff" width="750">
									<tbody>
										<tr>
											<td style="border-bottom:solid 5px #ec1c24;" background="'.@$settings['mail_header_img'].'">
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
													<tbody>
													
														<tr>
														
															<td width="30%" align="left" style="padding:20px">
															
																	<a href="'.@$smtp['site_name'].'" target="_blank">
																		<img src="'.@$settings['logo_two'].'" alt="'.@$settings['general_about'].'" border="0" class="CToWUd">
																	</a>
																	
															</td>
															
															<td width="70%" align="right" style="padding:20px">
															
																<a href="http://twitter.com/'.@$settings['twitter'].'" style="background-color: #ec1c24;padding:14px;border: solid 1px #ed1c24de;display:inline-block;" target="_blank">
																	<img src="assets/img/twitter.png" alt="twitter" border="0" class="CToWUd">
																</a>
															
																<a href="http://www.facebook.com/'.@$settings['facebook'].'" style="background-color: #ec1c24;padding:14px;border: solid 1px #ed1c24de;display:inline-block;margin:0 6px 0 6px" target="_blank">
																	<img src="assets/img/facebook.png" alt="facebook" border="0" class="CToWUd">
																</a>

															</td>
															
														</tr>
														
													</tbody>
												</table>
											</td>
										</tr>
										
										<tr>
										
											<td style="padding:20px">
											
												<p>'.$lang['e_mail_hello'].' '.@$e_mail['fullname'].' ('.@$e_mail['username'].'),</p>
												<p>'.$lang['e_mail_if_you_did_not_create_this_request'].' <strong>'.$lang['e_mail_do_not_mind'].'</strong></p>
												<p>'.$lang['e_mail_order_to_update_with_your_new_password'].'<p>

												<p>'.$lang['e_mail_to_reset_your_password'].'
													<a style="color:red;" href="'.@$smtp['site_name'].'/e_change_password.php?do=Forget&token='.@$token.'" target="_blank">'.$lang['e_mail_click'].'</a>
												</p>
												<br>

												
											</td>
											
										</tr>
										
										<tr>
											<td style="background-color:#ec1c24">
										
												<table border="0" cellpadding="0" cellspacing="0" style="color:#ffffff" width="100%">
												
													<tbody>
														
														<tr>
															<td colspan="3" align="center" style="padding:30px">
																<a href="'.@$smtp['site_name'].'" target="_blank">
																<img src="'.@$settings['logo'].'" alt="'.@$settings['general_about'].'" border="0" class="CToWUd"></a>
															</td>
														</tr>
														
														<tr>
														
															<td width="33%" align="center" style="padding:0 0 20px 0">
																<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_phone'].'</strong><br>
																'.@$settings['phone'].'
															</td>

															<td width="33%" align="center" style="padding:0 0 30px 0">
																<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_address'].'</strong><br>
																<a style="color:white;">'.@$settings['address'].'</a>
															</td>
																	
															<td width="33%" align="center" style="padding:0 0 30px 0">
																<strong style="padding-bottom:5px;display:inline-block">'.$lang['e_mail_email'].'</strong><br>
																<a style="color:white;" href="mailto:'.@$settings['email'].'" target="_blank">'.@$settings['email'].'</a>
															</td>
															
														</tr>
														
													</tbody>
												
												</table>
												
											</td>
											
										</tr>
										
									</tbody>
								</table>
							</center>';
				
				$mail->MsgHTML($content);
				
				if($mail->Send()) {

					$array["success"] = $lang['signin_password_reset_request_succesfull'];
					
					$date = time();
					
					$query = $db->prepare("INSERT INTO notification SET a_id = ?, st = ?, create_date = ?");
					$insert = $query->execute(array($e_mail['id'], "3", $date));
					

				} else {

					$array["error"] = $lang['signin_unknown_prob_occur'];

				}
			
			} else { 

				$array["error"] = $lang['signin_email_addr_nt_found'];
				
			}

		}
	}
	break;
	
	case'e_f_change_password';	
	sleep(2);
	
    if (!empty($_POST)) {
			
		if (trim($_POST['new_current_password'])=='' OR empty($_POST)) { 
			$array["error"] = $lang['change_your_new_current_password_can_not_be_empty'];
		} else if (strlen($_POST['new_current_password']) < 5) { 
			$array["error"] = $lang['change_your_new_current_password_can_not_be_less_than_5_characters'];
		} else if (trim($_POST['repeat_new_current_password'])=='' OR empty($_POST)) {
			$array["error"] = $lang['change_your_repeat_new_current_password_can_not_be_empty'];
		} else if (strlen($_POST['repeat_new_current_password']) < 5) { 
			$array["error"] = $lang['change_your_repeat_password_can_not_be_less_than_5_characters'];
		} else if (trim($_POST['new_current_password']) != trim($_POST['repeat_new_current_password'])) {
			$array["error"] = $lang['change_new_password_and_repeat_password_are_not_the_same'];
		} else {
			
			$new_password = md5($_POST['new_current_password']);
			$update = "UPDATE users SET password = :pswrd WHERE token = :tkn";
			$psw = $db->prepare($update);                                  
			$psw->bindParam(':pswrd', $new_password, PDO::PARAM_STR);
			$psw->bindParam(':tkn', $_POST['e_token'], PDO::PARAM_INT);
			if($psw->execute()) {
				
				$array["success"] = $lang['change_your_password_has_been_successfully_updated'];
				
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