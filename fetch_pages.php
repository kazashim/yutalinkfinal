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
	
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

	if (!is_numeric($page_number)) {
		header('HTTP/1.1 500 Invalid page number!');
		exit;
	}
	
	sleep(1);
	
	$position = (($page_number - 1) * $settings['item_per_page']);
	
	$select = $db->prepare("SELECT * FROM users_comment WHERE your_id = '".$_GET["p_users"]."' ORDER BY date DESC LIMIT ".$position.", ".$settings['item_per_page']."");

	$select->execute();

		while ($row = $select->fetch()) { 
		
		$i_usr = $db -> query("SELECT * FROM users WHERE `id` = '{$row['i_id']}'")->fetch();
		
		$dt = $row['date'] + 1800;
		
		if ($dt >= time()) {
			echo'<div class="comment" style="background:#16fb4708;padding:20px;">';
		} else {
			echo'<div class="comment">';
		}
	    
			echo'<div class="author">
					<a href="profile_detail.php?users='.$i_usr['username'].'" class="author-image">';
											if (!empty($i_usr['picture'])) {
									  echo '<div class="background-image" style="background-image: url(&quot;'.$i_usr['picture'].'&quot;);">
												<img src="'.$i_usr['picture'].'" alt="">
											</div>';
											} else {
												if ($i_usr['gender'] == "1") {
									  echo '<div class="background-image" style="background-image: url(&quot;assets/img/picture/no_picture_mr.png&quot;);">
												<img src="assets/img/picture/no_picture_mr.png" alt="">
											</div>';
												} else if ($i_usr['gender'] == "2") { 
									  echo '<div class="background-image" style="background-image: url(&quot;assets/img/picture/no_picture_mrs.png&quot;);">
												<img src="assets/img/picture/no_picture_mrs.png" alt="">
											</div>';
												}
											}
                echo'</a>
				
					<div class="author-description">
					<h5><a href="profile_detail.php?users='.$i_usr['username'].'">'.$i_usr['fullname'].'</a></h5>
						<div class="meta">';
						if ($row['i_rate'] == "1") {	
						echo'<span class="rating" data-rating="1">
								<i class="active fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>';
						} else if ($row['i_rate'] == "2") {
						echo'<span class="rating" data-rating="2">
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>';
						} else if ($row['i_rate'] == "3") { 
						echo'<span class="rating" data-rating="3">
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>';
						} else if ($row['i_rate'] == "4") { 
						echo'<span class="rating" data-rating="4">
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="fa fa-star"></i>
							</span>';
						} else if ($row['i_rate'] == "5") { 
						echo'<span class="rating" data-rating="5">
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
								<i class="active fa fa-star"></i>
							</span>';
						}
						echo'<span>'.timeConvert(date('d.m.Y H:i:s', $row['date'])).'</span>
							
						</div>

						<p>
							'.$row['i_desc'].'
						</p>
					</div>

				</div>

			</div>'; 
		}