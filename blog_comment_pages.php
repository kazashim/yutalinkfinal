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
	
	$position = (($page_number - 1) * $settings['blog_per_page_count']);
	
	$select = $db->prepare("SELECT * FROM blog_comment WHERE blog_id = '".$_GET["blog_id"]."' AND (b_permit IN('1')) ORDER BY create_date DESC LIMIT ".$position.", ".$settings['blog_per_page_count']."");

	$select->execute();

		while ($row = $select->fetch()) { 
		
			$i_usr = $db -> query("SELECT * FROM users WHERE `id` = '{$row['user_id']}'")->fetch();
			
			$dt = $row['create_date'] + 1800;
			
			if ($dt >= time()) {
				echo'<div class="comments" style="background:#16fb4708;padding:20px;">';
			} else {
				echo'<div class="comments">';
			}
	    
			
			
                                echo'<div class="comment">
                                        <div class="author">
										
											<a class="author-image">';
													if (!empty($i_usr['picture'])) {
												echo'<div class="background-image" style="background-image: url(&quot;'.$i_usr['picture'].'&quot;);">
														<img src="'.$i_usr['picture'].'" alt="">
													</div>';
													} else {
														if ($i_usr['gender'] == "1") {
												echo'<div id="picture_sex" class="background-image" style="background-image: url(&quot;assets/img/picture/no_picture_mr.png&quot;);">
														<img src="assets/img/picture/no_picture_mr.png" alt="">
													</div>';
														} else if ($i_usr['gender'] == "2") { 
												echo'<div id="picture_sex" class="background-image" style="background-image: url(&quot;assets/img/picture/no_picture_mrs.png&quot;);">
														<img src="assets/img/picture/no_picture_mrs.png" alt="">
													</div>';
														}
													}
										echo '</a>
									
											
                                            <div class="author-description">';
											
											if (!empty($i_usr['fullname'])) {
                                            echo'<a target="_blank" href="profile_detail.php?users='.$i_usr['username'].'"><h3>'.$i_usr['fullname'].'</h3></a>';
											}
											
											if (!empty($row['create_date'])) {
                                            echo'<div class="meta">
                                                    <span>'.timeConvert(date('d.m.Y H:i:s', $row['create_date'])).'</span>
                                                </div>';
											}
											
											if (!empty($row['b_desc'])) {
                                            echo'<p>
                                                    '.$row['b_desc'].'
                                                </p>';
											}
												
                                        echo'</div>
											
                                        </div>
										
                                    </div>';
			
			

			echo'</div>'; 
		}