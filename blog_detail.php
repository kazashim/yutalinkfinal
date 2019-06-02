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
		
		@$blog_detail = $db -> query("SELECT * FROM blog WHERE `id` = '{$_GET['id']}'")->fetch();
		$view = $db -> prepare("update blog set views = views +1 WHERE id = ? ");
		$view-> execute (array($blog_detail['id'])); 

		$ct= "SELECT * FROM blog_category WHERE id = '" . $blog_detail['category'] . "'"; 
		$stmt = $db->query($ct); 
		$blog_category = $stmt->fetch(PDO::FETCH_ASSOC);
										
		$us= "SELECT * FROM users WHERE id = '" . $blog_detail['author_id'] . "'"; 
		$stmt = $db->query($us); 
		$usr = $stmt->fetch(PDO::FETCH_ASSOC);
		
	} else {
	    header("Location: blog.php"); 
	}
	
	$adsns = $db -> query("SELECT * FROM adsense")->fetch();
	
	if (!empty($_SESSION['session'])) {
		 
		if ($users['st'] != "1") {
			if ($blog_detail['author_id'] != $users['id']) { 
				if ($blog_detail['blog_permit'] != "1") {  
					header("Location: blog.php");
				}	
			}
		} 
		
		$query = $db->prepare("SELECT COUNT(*) FROM blog_comment WHERE `user_id` = '" . $users['id'] . "' AND (b_permit IN('1')) AND blog_id = '".$blog_detail['id']."'");
		$query->execute();
		$blog_user_count = $query->fetchColumn();
			
	} else {
		
		if ($blog_detail['blog_permit'] != "1") {  
			header("Location: blog.php");
		}		
	}
	
	if (empty($blog_detail['id'] == $_GET['id'])) {
		header("Location: blog.php");
	} 
	
	if (empty(seo($blog_detail['title']) == $_GET['title'])) {
		header("Location: blog.php");
	}
	
	$recordset = $db -> query("SELECT SUM(i_rate) as total FROM users_comment WHERE `your_id` = '" . $usr['id'] . "'")->fetch();
	
	$query = $db->prepare("SELECT COUNT(*) FROM users_comment WHERE `your_id` = '" . $usr['id'] . "'");
	$query->execute();
	$rewcount = $query->fetchColumn();
	
	$query = $db->prepare("SELECT COUNT(*) FROM blog_comment WHERE `blog_id` = '" . $blog_detail['id'] . "' AND (b_permit IN('1'))");
	$query->execute();
	$blog_comment_count = $query->fetchColumn();
	

	
    echo'<div class="page-title">
	
            <div class="container">
                <h1>Blog</h1>
            </div>
					
        </div>
			<div class="background"></div>
        </div>
        </header>


        <section class="content">
            <section class="block">
                <div class="container">
                    <div class="row">
					
					<div class="col-md-8">
					
					
                            <article class="blog-post clearfix">';
							if (!empty($blog_detail['cover_image'])) {
                            echo'<a>
                                    <img src="'.$blog_detail['cover_image'].'" alt="">
                                </a>';
							} 
	
                            echo'<div class="article-title">
                                    <h2>'.$blog_detail['title'].'</h2>';
                                    if (!empty($blog_category['blog_ctg_name'])) {
									echo'<div class="tags framed">
											<a class="tag">'.$blog_category['blog_ctg_name'].'</a>
										</div>';
									}
										
                            echo'</div>
                                <div class="meta">';
								if (!empty($usr['fullname'])) {
                                echo'<figure>
                                        <a href="profile_detail.php?users='.$usr['username'].'" class="icon">
                                            <i class="fa fa-user"></i>
                                            '.$usr['fullname'].'
                                        </a>
                                    </figure>'; 
								}
                                echo'<figure>
                                        <i class="fa fa-calendar-o"></i>
                                        '.timeConvert(date('d.m.Y H:i:s', $blog_detail['create_date'])).'
                                    </figure>';
									if ($blog_detail['views'] > "0") {
									echo'<i style="font-size: 13px;font-weight: 600;font-style: italic;" class="fa fa-eye"> '.$blog_detail['views'].'</i>';
									}
                            echo'</div>
                                <div class="blog-post-content">
                                    <p>
                                    '.$blog_detail['description'].'
                                    </p>
                                    <hr>
									
									
                                    <div class="author">
										
										<div class="author-image">';
												if (!empty($usr['picture'])) {
										  echo '<div class="background-image">
													<img src="'.$usr['picture'].'" alt="">
												</div>';
												} else {
													if ($usr['gender'] == "1") {
										  echo '<div id="picture_sex" class="background-image">
													<img src="assets/img/picture/no_picture_mr.png" alt="">
												</div>';
													} else if ($usr['gender'] == "2") { 
										  echo '<div id="picture_sex" class="background-image">
													<img src="assets/img/picture/no_picture_mrs.png" alt="">
												</div>';
													}
												}
									echo '</div>
										
                                        <div class="author-description">
                                            <div class="section-title">';
											if (!empty($usr['fullname'])) {
											
                                                echo'<a href="profile_detail.php?users='.$usr['username'].'"><h2>'.$usr['fullname'].'</h2></a>';
											}	
											if (!empty($usr['location'])) {
                                            echo'<h4 class="location">
                                                    <a>'.$usr['location'].'</a>
                                                </h4>';
											}	
											
											if(!empty($rewcount)) {
												$rewsi = $recordset['total'] / $rewcount;
												echo '<br>';
											} else {
												echo '<br>';
											}
												
											
                                            echo'<figure>';
											
											if (!empty($rewsi)) {
                                                echo'<div class="float-left">
                                                        <div class="rating" data-rating="'.$rewsi.'"></div>
                                                    </div>';
											}	
											
                                                echo'<div class="text-align-right social">';
												
												if (!empty($usr['facebook'])) {
                                                    echo'<a target="_blank" href="'.$usr['facebook'].'">
                                                            <i class="fa fa-facebook-square"></i>
                                                        </a>';
												}
												
												if (!empty($usr['twitter'])) {		
                                                    echo'<a target="_blank" href="'.$usr['twitter'].'">
                                                            <i class="fa fa-twitter-square"></i>
                                                        </a>';
												}	
												
												if (!empty($usr['instagram'])) {		
                                                    echo'<a target="_blank" href="'.$usr['instagram'].'">
                                                            <i class="fa fa-instagram"></i>
                                                        </a>';
												}	
												
												if (!empty($usr['youtube'])) {		
                                                    echo'<a target="_blank" href="'.$usr['youtube'].'">
                                                            <i class="fa fa-youtube"></i>
                                                        </a>';
												}	
												
                                                echo'</div>';
											
													
                                            echo'</figure>';
												
                                        echo'</div>';
										
									if (!empty($usr['about'])) {		
                                        echo'<br>
											<p>
                                                '.$usr['about'].'
                                            </p>';
									}
									
                                    echo'</div>
										
                                    </div>
									
									
									
                                </div>
								
                            </article>';
							
						$query = $db->prepare("SELECT COUNT(*) FROM blog");
						$query->execute();
						$blogcount = $query->fetchColumn();
	
						if ($blogcount > "1") {
	
                        echo'<section>
                                <div class="blog-posts-navigation clearfix">';
								
								$blog_asc = $db -> query("SELECT * FROM blog WHERE create_date > '".$blog_detail['create_date']."'")->fetch();
								
								if ($blog_asc) {
								
                                echo'<a href="blog_detail.php?title='.seo($blog_asc['title']).'&id='.$blog_asc['id'].'" class="prev">
                                        <i class="fa fa-chevron-left"></i>
                                        <figure>'.$lang['blog_previous_post'].'</figure>
                                        <h3>'.$blog_asc['title'].'</h3>
                                    </a>';
									
								}
								
								$blog_desc = $db -> query("SELECT * FROM blog WHERE create_date < '".$blog_detail['create_date']."'")->fetch();
								
								if ($blog_desc) {
									
                                echo'<a href="blog_detail.php?title='.seo($blog_desc['title']).'&id='.$blog_desc['id'].'" class="next">
                                        <i class="fa fa-chevron-right"></i>
                                        <figure>'.$lang['blog_next_post'].'</figure>
                                        <h3>'.$blog_desc['title'].'</h3>
                                    </a>';
									
								}
									
                            echo'</div>
								
                            </section>';
						}
						
						
						
						
						
                        echo'<section>
                                <h2>'.$lang['blog_add_comment'].'</h2>
								<hr>
                                <form class="form" onsubmit="return false" id="blogcomment">
                                    <div class="row">
										
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="comment" class="col-form-label">';
											if (!empty($users)) {
												
											echo'<div class="author-images">';
														if (!empty($users['picture'])) {
												    echo'<div class="background-image">
															<img src="'.$users['picture'].'" alt="">
														</div>';
														} else {
															if ($users['gender'] == "1") {
												    echo'<div id="picture_sex" class="background-image">
															<img src="assets/img/picture/no_picture_mr.png" alt="">
														</div>';
															} else if ($users['gender'] == "2") { 
												    echo'<div id="picture_sex" class="background-image">
															<img src="assets/img/picture/no_picture_mrs.png" alt="">
														</div>';
														
															}
														}
											echo'</div>
											
												<a target="_blank" href="profile_detail.php?users='.$users['username'].'" style="margin: 5px;">'.$users['fullname'].' ';
											}
												echo'</a>
												
													'.$lang['blog_your_commnent'].' ';		
													if (!empty($_SESSION['session'])) {
														if ($blog_user_count > "0") { 
													echo''.$blog_user_count.'';
														} 
													}
											echo'</label>
                                                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="'.$lang['blog_your_commnent'].'"></textarea>
                                            </div>
                                        </div>
										
										<input type="hidden" name="blog_id" value="'.$blog_detail['id'].'">
										<input type="hidden" name="blog_user_id" value="'.$blog_detail['author_id'].'">
										
                                    </div>
									
                                    <button type="submit" onclick="blog_message()" class="btn btn-primary float-right"><div id="resulbc"></div>'.$lang['blog_add_comment'].'</button>
                                </form>

                            </section>
							<br>
							<div id="result"></div>';
						
						
						
						
						
						
						

						
						if ($blog_comment_count > "0") {
						
                        echo'<hr><section>
                                <h2>'.$lang['blog_comments'].' ';												
									if ($blog_comment_count > "0") { 
									echo'('.$blog_comment_count.')';
									} 
							echo'</h2>
								
                                <div id="results" class="comments wrapper">
								
                                </div>
								
                            </section>';
							
						}
						

								
								
								
								
                    echo'</div>
						

                        <div class="col-md-4">
						
                            <aside class="sidebar">';

							$blog_popu = $db->prepare("SELECT * FROM blog WHERE blog_permit IN('1') ORDER BY views DESC");
							$blog_popu->execute();
							 
							if($blog_popu->rowCount()){
							 
								
								
                            echo'<section>
								
                                    <h2>'.$lang['blog_popular_posts'].'</h2>';
									
									
								foreach ($blog_popu as $row) {
									
								$popu_blog = $db -> query("SELECT * FROM users WHERE id = '".$row['author_id']."'")->fetch();
								
                                echo'<div class="sidebar-post">
								
                                        <a href="blog_detail.php?title='.seo($row['title']).'&id='.$row['id'].'" class="background-image">
                                            <img src="'.$row['cover_image'].'">
                                        </a>
										
                                        <div class="description">
										
                                            <h4>
                                                <a href="blog_detail.php?title='.seo($row['title']).'&id='.$row['id'].'"> '.$row['title'].'</a>
                                            </h4>';
											if ($row['views'] > "0") {
											echo'<i style="font-size: 13px;font-weight: 600;font-style: italic;" class="fa fa-eye"> '.$row['views'].'</i>';
											}
										echo'<div class="meta">
                                                <a target="_blank" href="profile_detail.php?users='.$popu_blog['username'].'">'.$popu_blog['fullname'].'</a>
                                                <figure>'.timeConvert(date('d.m.Y H:i:s', $row['create_date'])).'</figure>
                                            </div>
											
                                        </div>
										
                                    </div>';
								}


                            echo'</section>';
							
							}


                        echo'</aside>';
							
						if ($adsns['blog_ads_statu'] == "1") {
						
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
												echo $adsns['blog_ads'];
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
	
echo'<script type="text/javascript">

	(function($) {
		
		$.fn.loaddata = function(options) {
			var settings = $.extend({ 
				loading_gif_url	: "assets/img/ajax-loader.gif", 
				end_record_text	: "'.$lang['profile_no_more_records_found'].'", 
				data_url 		: "blog_comment_pages.php?blog_id='.$blog_detail['id'].'", 
				start_page 		: 1 
			}, options);
			
			var el = this;	
			loading  = false; 
			end_record = false;
			contents(el, settings); 
			
			$ (window).scroll(function() { 
				if($(window).scrollTop() + $(window).height() >= $(document).height()){
					contents(el, settings); 
				}
			});		
			
		}; 

		function contents(el, settings){
			var load_img = $("<img/>").attr("src",settings.loading_gif_url).addClass("loading-image");
			var record_end_txt = $("<div/>").text(settings.end_record_text).addClass("end-record-info"); 
			
			if (loading == false && end_record == false) {
				loading = true; 
				el.append(load_img); 
				$.post (settings.data_url, {"page": settings.start_page}, function(data) { 
					if (data.trim().length == 0) { 
						el.append(record_end_txt); 
						load_img.remove(); 
						end_record = true; 
						return; 
					}
					loading = false;  
					load_img.remove(); 
					el.append(data);  
					settings.start_page ++; 
				})
			}
		}

	})(jQuery);

	$("#results").loaddata();

	</script>';