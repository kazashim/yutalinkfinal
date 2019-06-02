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

	$data = array();
	$type =  $_POST["type"];

	switch($type) {
	case "comment": {

		require_once('../db/db.php');
		require_once('../db/func.php');
		
		$user_id = $_POST["user_id"];
		$target_id = $_POST["target_id"];
		$message = trim(htmlspecialchars($_POST["message"]));
		$product_id = $_POST["product_id"];
		$date = time();
		$user = veriCek("users", "id", "username", $target_id);
		$target_id = $user["id"];
		$sutun = array("user_id", "target_id", "message", "product_id", "date");
		$cevap = array($user_id, $target_id, $message, $product_id, $date);
		
		if( !empty($message) ) {
			if (veriEkle($sutun, $cevap, "users_chats")) {
				$data["debug"] = "success";
				veriGuncelle(array("get_message"), array(""), "users", "id", $user_id);
			} else {
				$data["debug"] = "error";
			}
		}
	} 
	break;
	
	case "refresh": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$count = $_POST["count"];
		$user_id = $_POST["user_id"];
		$target_id = $_POST["target_id"];
		$user = veriCek("users", "id", "username", $target_id);
		$target_id = $user["id"];
		$mesajlar = tabloCek("users_chats", "*", "WHERE (user_id = '{$target_id}' AND target_id = '{$user_id}') OR (user_id = '{$user_id}' AND target_id = '{$target_id}') ORDER BY date DESC LIMIT {$count}");
										
		$msg = array();
		
		foreach ($mesajlar as $mesaj) {
			array_push($msg, $mesaj);
		}
		$msg = array_reverse($msg);
		
		foreach ($msg as $mesaj) {
			if ($mesaj["read_type"] == "0" && $mesaj["target_id"] == $user_id && $mesaj["user_id"] == $target_id) {
				$other = array();
				$other["read_type"] = "1";
				$query = $db->prepare("UPDATE users_chats SET read_type = :read_type WHERE user_id = '{$target_id}' AND target_id = '{$user_id}'");
				$update = $query->execute($other);
			}
			if ($mesaj["user_id"] == $user_id) {
				
				$user = "user";
				if ($mesaj["read_type"] == 0) {
					$view = "".$lang['mes_sent_to_him']."";
				} else if ($mesaj["read_type"] == 1) {
					$view = "".$lang['mes_he_saw']."";
				}
					
			} else {
				$user = "";
				$view = "";
			}
			if( $mesaj["user_id"] == $user_id ) {
			}
			$tarih = timConvert(date('d.m.Y H:i:s', $mesaj['date']));
			$data["content"] .= '
			<div class="messaging__main-chat__bubble '.$user.'">
				<p>
					'.$mesaj["message"].'
					<small style="font-style:italic;"> '.$tarih.'  '.$view.' </small>
				</p>
			</div>';
			
		}
		
	} 
	break;
	
	case "messagelist": {
		
		require_once('../db/db.php');				
		require_once('../db/func.php');
		
		$user_id = $_POST["user_id"];    
		
		$query = $db->query("SELECT * FROM users_chats WHERE user_id = '".$user_id."' or target_id = '".$user_id."'  GROUP BY date ORDER BY id DESC", PDO::FETCH_ASSOC);    
		
		$arr = array();    
		$say = 1;    
		$dur = 100000;    
		
		foreach ($query as $q) {
			
		if ($q['target_id'] == $user_id) {				
			$t_usr = $db -> query("SELECT * FROM users WHERE id = '".$q['user_id']."'")->fetch();			
		
		} else if ($q['user_id'] == $user_id) { 				
			$t_usr = $db -> query("SELECT * FROM users WHERE id = '".$q['target_id']."'")->fetch();			
		} 								
			$noRead = cmd("SELECT COUNT(*) FROM users_chats WHERE user_id = '{$t_usr['id']}' AND target_id = '{$q["target_id"]}' AND read_type = '0'")->fetchColumn();			
		if ($noRead == 0) {				
			$noRead = "";			
		} else {				
			$noRead = "({$noRead})";			
		}			
			$time = timConvert(date('d.m.Y H:i:s', $q['date']));			        
			if ($say == $dur) break;		    
		if ($q['target_id'] == $user_id) {				
			if (in_array($q['user_id'], $arr)) continue;			
		} else if ($q['user_id'] == $user_id) { 				
			if (in_array($q['target_id'], $arr)) continue;			
		} 
		
		$t_itm = $db -> query("SELECT * FROM items WHERE id = '".$q['product_id']."'")->fetch();
		$t_glr = $db -> query("SELECT * FROM gallery WHERE item_id = '".$t_itm['id']."'")->fetch();
		
		if ($t_usr['picture']) { 
			$picture = $t_usr['picture'];
		} else {
			if ($t_usr['gender'] == "1") { 
				$picture = "assets/img/picture/no_picture_mr.png";
			} else if ($t_usr['gender'] == "2") { 
				$picture = "assets/img/picture/no_picture_mrs.png";
			}
		}
		
		if (!empty($t_glr['image'])) { 
			$t_glr_image = $t_glr['image'];
		} else {
			$t_glr_image = "assets/img/gallery/no_item.png";
		}
		
		$data["content"] .= '<li>                                
			<a href="?message='.$t_usr['username'].'&product_id='.$q['product_id'].'" class="messaging__person">                                    
				<figure class="messaging__image-item" data-background-image="'.$t_glr_image.'" style="background-image: url('.$t_glr_image.')"></figure>                                    
				<figure class="content">                                        
					<h5>'.$t_itm['title'].' '.$noRead.'</h5>                                        
					<p>'.$q['message'].'</p>                                        
					<small>'.$time.'</small>                                    
				</figure>   
				<figure class="messaging__image-person" data-background-image="'.$picture.'" style="background-image: url('.$picture.')"></figure>				                                
			</a>                            
		</li>';	
		
		
		

		
		if ($q['target_id'] == $user_id) {				
			array_push($arr, $q['user_id']);			
		} else if ($q['user_id'] == $user_id) { 				
			array_push($arr, $q['target_id']);			
		} 		        
			$say++;    
		} 
		
		$items_c = $db->prepare("SELECT COUNT(*) FROM users_chats WHERE target_id = '{$user_id}' AND read_type = '0'");
		$items_c->execute();
		$cnt = $items_c->fetchColumn();
		
		if ($cnt == "0") {
			$data["coun"] .= '';
		} else {
			$data["count"] .= ''.$cnt.'';
		}

	}
	break;
	
	case "setmessage": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
		$user_id = $_POST["user_id"];
		$comment = $_POST["comment"];
		$target_id = $_POST["target_id"];
		$user = veriCek("users", "id", "username", $target_id);
		$target_id = $user["id"];
		
		if (!empty($comment)) {
			veriGuncelle(array("get_message"), array($target_id), "users", "id", $user_id);
		} else {
			veriGuncelle(array("get_message"), array(""), "users", "id", $user_id);
		}	
	} 
	break;
	
	case "favorite": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$u_id = $_POST["user_id"];
		$i_id = $_POST["item_id"];

		$t_add = $db -> query("SELECT * FROM bookmarks WHERE item_id = '".$i_id."' and user_id = '".$u_id."'")->fetch();	
		
		if (empty($t_add)) {
			
			$time = time();
			
			$reg = $db->prepare("INSERT INTO bookmarks set item_id = ? , user_id = ? , create_date = ?");
			$reg->execute(array($i_id,$u_id,$time));
						
			if($reg->rowCount()){
				$data["add"] .= '<p>'.$lang['fav_succesful_added'].'<p>'; 
			} else {
				$data["error"] .= '<p>'.$lang['fav_again_later'].'<p>'; 
			}

			
		} else {
			
            $query = $db->prepare("DELETE FROM bookmarks WHERE item_id = :i_id and user_id = :u_id");
            $delete = $query->execute(array('i_id' => $i_id,'u_id' => $u_id));
			
			if ($delete) {
				$data["remove"] .= '<p>'.$lang['fav_removed'].'<p>';
			} else {
				$data["error"] .= '<p>'.$lang['fav_again_later'].'<p>'; 
			} 
			
		}
	} 
	break;
	
    case'sold';	
	usleep(100000);
		
	if (!empty($_POST)) {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$u_id = $_POST["user_id"];
		$i_id = $_POST["item_id"];

		$t_add = $db -> query("SELECT * FROM items WHERE id = '".$i_id."' and user_id = '".$u_id."'")->fetch();	
		
		if ($t_add['sale_status'] == "0") {
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_status = :ss, sale_hidden_status_date = :shsd WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("ss" => "1","shsd" => $time,"ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["sold_g"] .= ''.$lang['sold_my_back'].'';
			} else {
				$data["error"] .= ''.$lang['sold_my_error'].'';
			}
			
		} else if ($t_add['sale_status'] == "1") {
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_status = :ss, sale_hidden_status_date = :shsd WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("ss" => "0","shsd" => $time,"ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["sold_s"] .= ''.$lang['sold_my_sold'].'';
			} else {
				$data["error"] .= ''.$lang['sold_my_error'].'';
			}
			
			
		} else {
			$data["empty"] .= ''.$lang['sold_my_sold'].'';
		}
	} 
	break;
	
    case'hide';	
	usleep(100000);
		
	if (!empty($_POST)) {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$u_id = $_POST["user_id"];
		$i_id = $_POST["item_id"];

		$t_add = $db -> query("SELECT * FROM items WHERE id = '".$i_id."' and user_id = '".$u_id."'")->fetch();	
		
		if ($t_add['sale_status'] == "0") {
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_status = :ss, sale_hidden_status_date = :shsd WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("ss" => "2","shsd" => $time,"ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["hide_g"] .= ''.$lang['hide_my_back'].'';
			} else {
				$data["error"] .= ''.$lang['hide_my_error'].'';
			}
			
		} else if ($t_add['sale_status'] == "2") {
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_status = :ss, sale_hidden_status_date = :shsd WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("ss" => "0","shsd" => $time,"ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["hide_s"] .= ''.$lang['hide_my_hide'].'';
			} else {
				$data["error"] .= ''.$lang['hide_my_error'].'';
			}
			
		} else {
			$data["empty"] .= ''.$lang['hide_my_hide'].'';
		} 
	} 
	break;
	
    case'remove';	
	usleep(100000);
		
	if (!empty($_POST)) {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$u_id = $_POST["user_id"];
		$i_id = $_POST["item_id"];

		
		$t_add = $db -> query("SELECT * FROM items WHERE id = '".$i_id."' and user_id = '".$u_id."'")->fetch();
		
		if ($t_add['remove'] == "0") {
			
			
			$query = $db->prepare("UPDATE items SET remove = :rm WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("rm" => "1","ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["remove_t"] .= ''.$lang['remove_my_yes'].'';
			} else {
				$data["error"] .= ''.$lang['remove_my_error'].'';
			}
			
			

		} else if ($t_add['remove'] == "1") {
			
			$query = $db->prepare("DELETE FROM items WHERE id = :i_id and user_id = :u_id");
			$delete = $query->execute(array('i_id' => $i_id,'u_id' => $u_id));
					
			if ($delete) {
				$data["remove_g"] .= ''.$lang['remove_my_deleted'].'';
			} else {
				$data["error"] .= ''.$lang['remove_my_error'].'';
			} 
			
		}
		
	} 
	break;
	
	case "onsold": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$u_id = $_POST["user_id"];
		$i_id = $_POST["item_id"];

		$t_add = $db -> query("SELECT * FROM items WHERE id = '".$i_id."' and user_id = '".$u_id."'")->fetch();	
		
		if ($t_add['sale_status'] == "1") {
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_hidden_reply_date = :shrd, sale_status = :sstts WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("shrd" => $time,"sstts" => "0","ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["on_sold_t"] .= 'On sold';
			} else {
				$data["sold_error"] .= 'Error';
			}

			
		} else if ($t_add['sale_status'] == "0") { 
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_hidden_reply_date = :shrd, sale_status = :sstts WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("shrd" => $time,"sstts" => "1","ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["off_sold_t"] .= 'Sold';
			} else {
				$data["sold_error"] .= 'Error';
			}
			
		}
	} 
	break;
	
	case "eye": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$u_id = $_POST["user_id"];
		$i_id = $_POST["item_id"];

		$t_add = $db -> query("SELECT * FROM items WHERE id = '".$i_id."' and user_id = '".$u_id."'")->fetch();	
		
		if ($t_add['sale_status'] == "2") {
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_hidden_reply_date = :shrd, sale_status = :sstts WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("shrd" => $time,"sstts" => "0","ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["on_hide_t"] .= 'On hide';
			} else {
				$data["hide_error"] .= 'Error';
			}

			
		} else if ($t_add['sale_status'] == "0") { 
			
			$time = time();
			
			$query = $db->prepare("UPDATE items SET sale_hidden_reply_date = :shrd, sale_status = :sstts WHERE id = :ids and user_id = :uds");
			$update = $query->execute(array("shrd" => $time,"sstts" => "2","ids" => $i_id,"uds" => $u_id));
			
			if ($update){
				$data["off_hide_t"] .= 'Hide';
			} else {
				$data["hide_error"] .= 'Error';
			}
			
		}
	} 
	break;
	
	case "p_my_ads": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$g_list = $_POST["grid_list"];

		$query = $db->prepare("UPDATE ip_users SET grid_list_my_ads = :shrd WHERE ip = :ips");
		$update = $query->execute(array("shrd" => $g_list,"ips" => $ip));

	} 
	break;
	
	case "p_bookmark": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$g_list = $_POST["grid_list"];

		$query = $db->prepare("UPDATE ip_users SET grid_list_bookmark = :shrd WHERE ip = :ips");
		$update = $query->execute(array("shrd" => $g_list,"ips" => $ip));


	} 
	break;
	
	case "p_sold_items": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$g_list = $_POST["grid_list"];

		$query = $db->prepare("UPDATE ip_users SET grid_list_sold_items = :shrd WHERE ip = :ips");
		$update = $query->execute(array("shrd" => $g_list,"ips" => $ip));
			

	} 
	break;
	
	case "p_index_items": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$g_list = $_POST["grid_list"];

		$query = $db->prepare("UPDATE ip_users SET grid_list_index = :shrd WHERE ip = :ips");
		$update = $query->execute(array("shrd" => $g_list,"ips" => $ip));
			

	} 
	break;
	
	case "p_profile_detail": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
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
		
		$g_list = $_POST["grid_list"];

		$query = $db->prepare("UPDATE ip_users SET grid_list_profile = :shrd WHERE ip = :ips");
		$update = $query->execute(array("shrd" => $g_list,"ips" => $ip));
			

	} 
	break;
	
	case "getmessage": {
		
		require_once('../db/db.php');
		require_once('../db/func.php');
		
		$user_id = $_POST["user_id"];
		$target_id = $_POST["target_id"];
		$user = veriCek("users", "id", "username", $target_id);
		$target_id = $user["id"];
		$control = veriCek("users", "get_message", "id", $target_id);
		
		if ($control["get_message"] == $user_id) { 
			$data["content"] = "1";
		} else {
			$data["content"] = "0";
		}
	} 
	break;
	
	default: { 
		$data["debug"] = "error"; 
	} 
	break;
}

echo json_encode($data);