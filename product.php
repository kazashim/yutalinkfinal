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

    include ('includes/head.php');
    include ('includes/header.php');

	if (!empty($_GET['id']) && !empty($_GET['title'])) {
		@$items = $db -> query("SELECT * FROM items WHERE `id` = '{$_GET['id']}'")->fetch();
		$view = $db -> prepare("update items set views = views +1 where id = ? ");
		$view-> execute (array($items['id']));  
	} else {
	    header("Location: index.php"); 
	}
	
	$adsns = $db -> query("SELECT * FROM adsense")->fetch();
	
	if (!empty($_SESSION['session'])) {
		 
		if ($users['st'] != "1") {
			if ($items['user_id'] != $users['id']) { 
				if ($items['permit'] != "1") {  
					header("Location: index.php");
				}	
				
				if ($items['sale_status'] != "0") {  
					header("Location: index.php");
				}	
			}
		} 
			
	} else {
		
		if ($items['permit'] != "1") {  
			header("Location: index.php");
		}	
		
		if ($items['sale_status'] != "0") {  
			header("Location: index.php");
		}	
		
	}
	
	if (empty($items['id'] == $_GET['id'])) {
		header("Location: index.php");
	} 
	
	if (empty(seo($items['title']) == $_GET['title'])) {
		header("Location: index.php");
	}
	
	$query = $db->prepare("SELECT COUNT(*) FROM items WHERE user_id = '".$items['user_id']."' AND permit = 1 AND sale_status NOT IN('1','2')");
    $query->execute();
    $users_count = $query->fetchColumn();
	
	$usr = $db -> query("SELECT * FROM users WHERE `id` = '{$items['user_id']}'")->fetch();
	
		echo'<div class="page-title">
                    <div class="container clearfix">
                        <div class="float-left float-xs-none">
                            <h1>';
							if (!empty($items['title'])) { 
								echo $items['title'];
							}  
							if (!empty($items['type'])) {
								echo '<span class="tag">'.$items['type'].'</span>';
							}
                       echo '</h1>
                            <h4 class="location">';
							if (!empty($items['address'])) {
								echo '<a> '.$items['address'].'</a>';
							}
                                
                       echo '</h4>
                        </div>
                        <div class="float-right float-xs-none price">';
							if (!empty($items['price'])) {
								echo '<div class="number">'.$settings['currency'].' '.number_format($items['price'],"0","",".").'</div>';
							}
							if (!empty($items['id'])) {
								echo '<div class="id opacity-50">
									<strong>ID: </strong>#'.$items['id'].'
								</div>';
							}
                   echo '</div>
                    </div>
                </div>
                <div class="background"></div>
            </div>
			
        </header>';
		
	echo'<section class="content">
            <section class="block">
                <div class="container">
                    <div class="row">

					
                        <div class="col-md-8">

						
                            <section>
                            <h2>'.$lang['product_gallery'].'</h2>';
								
                        $gallery = $db->prepare("SELECT * FROM gallery WHERE item_id = '".$items['id']."'");
                        $gallery->execute();
                        if ($gallery->rowCount()) {
								echo'<div class="gallery-carousel owl-carousel">';
							foreach ($gallery as $row) {
								echo '<img src="'.$row['image'].'" alt="" data-hash="'.$row['id'].'">';
							}
                            echo'</div>';
						}
								
                        $gallery = $db->prepare("SELECT * FROM gallery WHERE item_id = '".$items['id']."'");
                        $gallery->execute();
                        if ($gallery->rowCount()) {
					        echo'<div class="gallery-carousel-thumbs owl-carousel">';
							foreach ($gallery as $row) {
							echo'<a href="#'.$row['id'].'" class="owl-thumb background-image">
									<img src="'.$row['image'].'" alt="">
                                </a>';
							}
                            echo'</div>';
						}
									
                        echo'</section>
							
							

                            <section>
                                <h2>'.$lang['product_description'].'</h2>';
								if (!empty($items['description'])) {
                                    echo'<p>'.$items['description'].'</p>';
								}
                        echo'</section>';

						$i_b_1 = $db->query("SELECT * FROM i_category_box_1 WHERE item_id = '".$items['id']."'")->fetch(PDO::FETCH_ASSOC);
						$i_b_2 = $db->query("SELECT * FROM i_category_box_2 WHERE item_id = '".$items['id']."'")->fetch(PDO::FETCH_ASSOC);
						$i_b_3 = $db->query("SELECT * FROM i_category_box_3 WHERE item_id = '".$items['id']."'")->fetch(PDO::FETCH_ASSOC);
							
						if ($i_b_1 or $i_b_2 or $i_b_3) {	
							
							echo'<section>
									<h2>'.$lang['product_details'].'</h2>
									<dl class="columns-2">';
									
									$i_category_box_1 = $db->prepare("SELECT * FROM i_category_box_1 WHERE item_id = '".$items['id']."'");
									$i_category_box_1->execute();
									if ($i_category_box_1->rowCount()) {
										foreach ($i_category_box_1 as $row) {
											$category_box_1 = $db -> query("SELECT * FROM category_box_1 WHERE `id` = '{$row['ctg_bx_1_id']}'")->fetch();
											$category_box = $db -> query("SELECT * FROM category_box WHERE `id` = '{$category_box_1['category_box_id']}'")->fetch();
											echo'<dt>'.$category_box['ctg_bx_name'].'</dt>
											<dd>'.$category_box_1['name'].'</dd>';
										}
									}
									
									$i_category_box_2 = $db->prepare("SELECT * FROM i_category_box_2 WHERE item_id = '".$items['id']."'");
									$i_category_box_2->execute();
									if($i_category_box_2->rowCount()) {
										foreach ($i_category_box_2 as $row) {
											$category_box_2 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$row['ctg_bx_2_id']}'")->fetch();
											echo'<dt>'.$category_box_2['ctg_bx_name'].'</dt>
											<dd>'.$row['ctg_bx_2_subj'].'  '.$category_box_2['text_val'].'</dd>';
										}
									}
									
									$i_category_box_3 = $db->prepare("SELECT * FROM i_category_box_3 WHERE item_id = '".$items['id']."'");
									$i_category_box_3->execute();
									if($i_category_box_3->rowCount()) {
										foreach ($i_category_box_3 as $row) {
											$category_box_3 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$row['ctg_bx_3_id']}'")->fetch();
											echo'<dt>'.$category_box_3['ctg_bx_name'].'</dt>
											<dd>'.$row['ctg_bx_3_subj'].'</dd>';
										}
									}
									
								echo'</dl>
							</section>';
							
						}

                        echo'<section>
                                <h2>'.$lang['product_location'].'</h2>
                                <div class="map height-300px" id="map-small"></div>
                            </section>';
							
							
							$i_category_box_5 = $db->prepare("SELECT * FROM i_category_box_5 WHERE item_id = '".$items['id']."'");
							$i_category_box_5->execute();
							
							if ($i_category_box_5->rowCount()) {
								
						echo'<section>
						
                                <h2>'.$lang['product_features'].'</h2>
                                <ul class="features-checkboxes columns-4">';
									foreach ($i_category_box_5 as $row) {
										$category_box_5 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$row['ctg_bx_5_id']}'")->fetch();
										echo'<li>'.$category_box_5['ctg_bx_name'].'</li>';
									}
                            echo'</ul>
							
                            </section>';
							
							}

                      echo'<hr>';

							$item = $db->prepare("SELECT * FROM items WHERE user_id = '".$items['user_id']."' AND permit = 1 AND sale_status NOT IN('1','2') AND id NOT IN('".$items['id']."') ORDER BY rand() LIMIT 3");
							$item->execute();
							if ($item->rowCount()) {
					  
							$query = $db->prepare("SELECT COUNT(*) FROM items WHERE user_id = '".$items['user_id']."' AND permit = 1 AND sale_status NOT IN('1','2') AND id NOT IN('".$items['id']."')");
							$query->execute();
							$item_count = $query->fetchColumn();	
                        echo'<section>
                                <h2>'.$lang['product_other_ads_this_person_has_shared'].'</h2>
								
                                <div class="items list compact">';
								
								foreach ($item as $row) {
									
									
										$product_gallery = $db -> query("SELECT * FROM gallery WHERE `item_id` = '{$row['id']}'")->fetch();
										$product_category = $db -> query("SELECT * FROM category WHERE `id` = '{$row['category']}'")->fetch();
										$product_user = $db -> query("SELECT * FROM users WHERE `id` = '{$row['user_id']}'")->fetch();
										
										$ttl = $row['title'];
										$limit = 28;
										$text = strlen($ttl);
										$title = substr($ttl,0,$limit);
										
										$adr = $row['address'];
										$limit = 51;
										$text = strlen($adr);
										$address = substr($adr,0,$limit);
									
									
                                echo'<div class="item">';
									if ($row['featured'] == "1") {
										echo'<div class="ribbon-featured">'.$lang['product_featured'].'</div>';
									}
								
                                        echo'<div class="wrapper">
                                            <div class="image">
											
                                                <h3>';
												if (!empty($product_category['ctg_name'])) {
													echo'<a class="tag category">'.$product_category['ctg_name'].'</a>';
												}
                                                echo'<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="title">'.$title.'</a>';
												if (!empty($row['type'])) {
													echo'&nbsp;&nbsp;<span class="tag"> '.$row['type'].'</span>';
												}
                                                    
                                            echo'</h3>
												
                                                <a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="image-wrapper background-image">';
												if (!empty($product_gallery['image'])) {
													echo'<img src="'.$product_gallery['image'].'" alt="">';
												}
                                                    
											echo'</a>
                                            </div>

                                            <h4 class="location">';
											if ($row['address']) {
												echo'<a>'.$address.'</a>';
											}
                                                
                                        echo'</h4>';
											
											if (!empty($row['price'])) {
												echo'<div class="price">'.$settings['currency'].' '.number_format($row['price'],"0","",".").'</div>';
											}

                                        echo'<div class="meta">
										
                                                <figure>
                                                    <i class="fa fa-calendar-o"></i>'.timeConvert(date('d.m.Y H:i:s', $row['create_date'])).'
                                                </figure>
												
                                                <figure>
                                                    <a href="profile_detail.php?users='.$product_user['username'].'">
                                                        <i class="fa fa-user"></i>'.$product_user['fullname'].'
                                                    </a>
                                                </figure>
												
                                            </div>';
											
											if (!empty($row['description'])) {
										echo'<div class="description">
                                                <p>'.$row['description'].'</p>
                                            </div>';
											}
											
												echo'<div class="additional-info">
														<ul>
														
															<li>
																<figure><i class="fa fa-calendar-o">&nbsp;</i> '.$lang['product_create_date'].'</figure>
																<aside>'.date('d.m.Y H:i:s', $row['create_date']).'</aside>
															</li>
															
														</ul>
													</div>';

                                        echo'<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="detail text-caps underline">'.$lang['product_detail'].'</a>
                                        </div>
                                    </div>';
								}

									
								if ($item_count >= "3")	{
                                echo'<div class="center">
                                        <a href="profile_detail.php?users='.$product_user['username'].'" class="btn btn-primary text-caps btn-framed">'.$lang['product_show_all'].'</a>
                                    </div>';
								}
							echo'</div>
								

                            </section>';
							}

                    echo'</div>


                        <div class="col-md-4">
						
                            <aside class="sidebar">

                                <section>
                                    <h2>'.$lang['product_author'].'</h2>
                                    <div class="box">
                                        <div class="author">';
										
										if (!empty($_SESSION['session'])) {
										
											$i_add = $db->query("SELECT * FROM items WHERE user_id = '{$users['id']}' and id = '{$items['id']}'")->fetch(PDO::FETCH_ASSOC);
												
											if (empty($i_add)) {
													
												$t_add = $db -> query("SELECT * FROM bookmarks WHERE item_id = '".$items['id']."' and user_id = '".$users['id']."'")->fetch();	
													
												if ($t_add['item_id'] != $items['id']) {
													
													echo'<a href="javascript:void(0)" class="buton" item_id="'.$items['id'].'" user_id="'.$users['id'].'"><i style="transition: .3s background-color ease;float:  right;font-size:  40px;" class="glyphicon fa fa-bookmark-o"></i></a>';
												
												} else {
													
													echo'<a href="javascript:void(0)" class="buton" item_id="'.$items['id'].'" user_id="'.$users['id'].'"><i style="transition: .3s background-color ease;float:  right;font-size:  40px;" class="glyphicon fa fa-bookmark"></i></a>';
													
												}
											}
										}
										
										echo'<div class="author-image">';
											if (!empty($usr['picture'])) {
									  echo '<div class="background-image">
												<img class="no_pic" src="'.$usr['picture'].'" alt="">
											</div>';
											} else {
												if ($usr['gender'] == "1") {
									  echo '<div id="picture_sex" class="background-image">
												<img id="picture" src="assets/img/picture/no_picture_mr.png" alt="">
											</div>';
												} else if ($usr['gender'] == "2") { 
									  echo '<div id="picture_sex" class="background-image">
												<img id="picture" src="assets/img/picture/no_picture_mrs.png" alt="">
											</div>';
												}
											}
                                     echo '</div>

									 <div class="author-description">
                                                <h3>'.$usr['fullname'].'</h3>
                                                <a href="profile_detail.php?users='.$usr['username'].'" class="text-uppercase">'.$lang['product_show_my_listings'].'
                                                    <span class="appendix">('.$users_count.')</span>
                                                </a>
                                            </div>

                                        </div>
                                        <hr>
                                        <dl>';
											if (!empty($usr['phone'])) { 
												if ($usr['hide_phone'] == "1") { 
											   echo'<dt>'.$lang['product_phone'].'</dt>
													<dd>'.$lang['product_secret_phone_number'].'</dd>';
												} else {
											   echo'<dt>'.$lang['product_phone'].'</dt>
													<dd>'.$usr['phone'].'</dd>';
												}
											}
											
											if (!empty($usr['email'])) {
												if ($usr['hide_email'] == "1") { 
												echo'<dt>'.$lang['product_email'].'</dt>
													<dd>'.$lang['product_secret_email_address'].'</dd>';
												} else {
												echo'<dt>'.$lang['product_email'].'</dt>
													<dd>'.$usr['email'].'</dd>';
												}
												
											}

                                 echo'</dl>
								 
										<form class="form" onsubmit="return false" id="sentmessage">
										
                                            <div class="form-group">
                                                <label for="message" class="col-form-label">'.$lang['product_message'].'</label>
                                                <textarea name="message" id="message" class="form-control" rows="6" placeholder="'.$lang['product_send_a_message_to'].' '.$usr['fullname'].'">'.$lang['product_hi'].' '.$usr['fullname'].'! '.$lang['product_i_am_interested_in_your_offer_ID'].' '.$items['title'].'. '.$lang['product_please_give_me_more_details'].'</textarea>
                                            </div>
											<input type="hidden" name="target_id" value="'.$usr['id'].'">
											<input type="hidden" name="product_id" value="'.$items['id'].'">

                                            <button type="submit" onclick="sent_message()" class="btn btn-primary"><div id="resultc"></div>'.$lang['product_send'].'</button>

                                        </form>
										<br>
										<div id="result"></div>
										<div id="fav"></div>
										
										
										</div>

                                </section>

                            </aside>
						
                            <aside class="sidebar">';
							
							
							
							$featured_items = $db->prepare('SELECT * FROM items WHERE sale_status NOT IN("1","2") AND permit NOT IN("0") AND featured = "1" ORDER BY RAND() LIMIT 2');
							$featured_items->execute();
							 
							if($featured_items->rowCount()) {

                            echo'<section>
								
                                    <h2>'.$lang['product_featured_ads'].'</h2>
									
                                    <div class="items compact">';
									
									foreach($featured_items as $row){
									
									$ct= "SELECT * FROM category WHERE id = '" . $row['category'] . "'"; 
									$stmt = $db->query($ct); 
									$category_p = $stmt->fetch(PDO::FETCH_ASSOC);
											
									$us= "SELECT * FROM users WHERE id = '" . $row['user_id'] . "'"; 
									$stmt = $db->query($us); 
									$usr_p = $stmt->fetch(PDO::FETCH_ASSOC);
									
									$gl= "SELECT * FROM gallery WHERE item_id = '" . $row['id'] . "'"; 
									$stmt  = $db->query($gl); 
									$gallery_p = $stmt->fetch(PDO::FETCH_ASSOC);
									
                                    echo'<div class="item">';
										if($row['featured'] == "1") {
										echo'<div class="ribbon-featured">'.$lang['product_featured'].'</div>';
										} 

                                        echo'<div class="wrapper">
											
                                                <div class="image">
												
                                                    <h3>';
													if (!empty($category_p['ctg_name'])) {
                                                    echo'<a class="tag category">'.$category_p['ctg_name'].'</a>';
													}
													if (!empty($row['title'])) {
                                                    echo'<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="title">'.$row['title'].'</a>';
													}
													if (!empty($row['type'])) {		
                                                    echo'<span class="tag">'.$row['type'].'</span>';
													}
                                                echo'</h3>';
												if (!empty($gallery_p['image'])) {	
                                                echo'<a href="product.php?title='.seo($row['title']).'&id='.$row['id'].'" class="image-wrapper background-image">
                                                        <img src="'.$gallery_p['image'].'" alt="">
                                                    </a>';
												}
												
                                            echo'</div>';
											
											if (!empty($row['address'])) {
                                            echo'<h4 class="location">
                                                    <a>'.$row['address'].'</a>
                                                </h4>';
											}
											
												if(!empty($row['price'])) {
												echo'<div class="price">'.$settings['currency'].' '.number_format($row['price'],"0","",".").'</div>';
												}
												
                                            echo'<div class="meta">';
											
												if(!empty($row['create_date'])) {
                                                echo'<figure>
                                                        <i class="fa fa-calendar-o"></i>'.timeConvert(date('d.m.Y H:i:s', $row['create_date'])).'
                                                    </figure>';
												}
												
												if(!empty($usr_p['fullname'])) {	
                                                echo'<figure>
                                                        <a target="_blank" href="profile_detail.php?users='.$usr_p['username'].'">
                                                            <i class="fa fa-user"></i>'.$usr_p['fullname'].'
                                                        </a>
                                                    </figure>';
												}
												
                                            echo'</div>
												
                                            </div>
                                        </div>';
										
									}

                                        
                                echo'</div>

                                </section>';
								
								
								
							}
								
								

                        echo'</aside>';
						
						if ($adsns['item_ads_statu'] == "1") {
						
							echo'<section>
								
                                    <h2>'.$lang['admin_adsense_google_adsense'].'</h2>
									
										<div class="items compact"><div class="item">
									
											<div class="ribbon-featured">
												<div class="ribbon-start"></div>
												<div class="ribbon-content">'.$lang['admin_adsense_sponsored'].'</div>
												<div class="ribbon-end">
													<figure class="ribbon-shadow"></figure>
												</div>
											</div>
											
											<div class="wrapper">
											
                                                <div class="image">';
												echo $adsns['item_ads'];
                                            echo'</div>
												
                                            </div>
											
                                        </div>


                                </section>';
						}
								
                    echo'</div>
						
						
						
                       
                    </div>
                </div>
            </section>
        </section>';
	  
    include ('includes/footer.php');
	
echo'<script>
        var latitude = '.$items['latitude'].';
        var longitude = '.$items['longitude'].';
        var markerImage = "assets/img/map-marker.png";
        var mapTheme = "light";
        var mapElement = "map-small";
        simpleMap(latitude, longitude, markerImage, mapTheme, mapElement);
    </script>';