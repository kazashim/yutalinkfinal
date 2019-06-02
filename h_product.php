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

	require_once('db/db.php');
	require_once('db/func.php');
	
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
		
										$gallery = $db -> query("SELECT * FROM gallery WHERE `item_id` = '{$row['id']}'")->fetch();
										$category = $db -> query("SELECT * FROM category WHERE `id` = '{$row['category']}'")->fetch();
										$usr = $db -> query("SELECT * FROM users WHERE `id` = '{$row['user_id']}'")->fetch();
																
										$ttl = $row['title'];
										$limit = 30;
										$text = strlen($ttl);
										$title = substr($ttl,0,$limit);
																
										$adr = $row['address'];
										$limit = 25;
										$text = strlen($adr);
										$address = substr($adr,0,$limit);
										
										echo'<div class="item">';
											if (!empty($row['featured'] == "1")) {
												echo'<div class="ribbon-featured">
													<div class="ribbon-start">
													</div>
													<div class="ribbon-content">Featured</div>
													<div class="ribbon-end">
														<figure class="ribbon-shadow">
														</figure>
													</div>
												</div>';
											}
											echo'<div class="wrapper">
													<div class="image">
															<h3>';
																if (!empty($category['ctg_name'])) {
																	echo '<a href="#" class="tag category">'.$category['ctg_name'].'</a>';
																}
																if (!empty($row['title'])) {
																	echo '<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="title">'.$title.'</a>';
																}
																
																if (!empty($row['type'])) {
																	echo '&nbsp;<span class="tag">'.$row['type'].'</span>';
																}
															echo '</h3>';
																if (!empty($gallery['image'])) {
																echo'<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="image-wrapper background-image" style="background-image: url('.$gallery['image'].');">
																	<img src="'.$gallery['image'].'" alt="">
																	</a>';
																}
												echo'</div>';

														if (!empty($row['address'])) {
												  echo '<h4 class="location">
															<a>'.$address.'</a>
														</h4>';
														}	
														if (!empty($row['price'])) {
												echo '<div class="price">'.$settings['currency'].' '.$row['price'].'</div>';
														}
												   echo '<div class="meta">
															<figure>
																'.timeConvert(date('d.m.Y H:i:s', $row['create_date'])).'
															</figure>';
															if (!empty($usr['fullname'])) {
														echo '<figure>
																<a href="profile_detail.php?users='.$usr['username'].'">
																	<i class="fa fa-user"></i>'.$usr['fullname'].'
																</a>
															</figure>';
															}
														echo '</div>';
														if (!empty($row['description'])) {
												  echo '<div class="description">
															<p>'.$row['description'].'</p>
														</div>';
														}

												echo'<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="detail text-caps underline">'.$lang['product_detail'].'</a>
												</div>
										</div>';
		}