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

	if (!empty($_GET['users'])) {
		$p_users = $db -> query("SELECT * FROM users WHERE `username` = '{$_GET['users']}'")->fetch();	
		if (empty($p_users)) {
			header("Location: index.php"); 
		}
	} else {
	    header("Location: index.php"); 
	}
	
	$recordset = $db -> query("SELECT SUM(i_rate) as total FROM users_comment WHERE `your_id` = '" . $p_users['id'] . "'")->fetch();
	
	$query = $db->prepare("SELECT COUNT(*) FROM users_comment WHERE `your_id` = '" . $p_users['id'] . "'");
	$query->execute();
	$rewcount = $query->fetchColumn();
	
          echo '<div class="page-title">
                    <div class="container">
                        <h1>'.$lang[$te].'</h1>
                    </div>
                </div>

                <div class="background">
				</div>
            </div>
        </header>
		
        <section class="content">
            <section class="block">
                <div class="container">
                    <div class="row flex-column-reverse flex-md-row">
                        <div class="col-md-12">
                            <section class="my-0">
                                <div class="author big">
                                    <div class="author-image">';
											if (!empty($p_users['picture'])) {
									  echo '<div class="background-image">
												<img src="'.$p_users['picture'].'" alt="">
											</div>';
											} else {
												if ($p_users['gender'] == "1") {
									  echo '<div id="picture_sex" class="background-image">
												<img src="assets/img/picture/no_picture_mr.png" alt="">
											</div>';
												} else if ($p_users['gender'] == "2") { 
									  echo '<div id="picture_sex" class="background-image">
												<img src="assets/img/picture/no_picture_mrs.png" alt="">
											</div>';
												}
											}
                                     echo '</div>

                                    <div class="author-description">
                                        <div class="section-title">';
										if (!empty($p_users['fullname'])) {
											echo '<h2>'.$p_users['fullname'].'</h2>';
										}
										if (!empty($p_users['location'])) {
                                        echo'<h4 class="location">
                                                <a>'.$p_users['location'].'</a>
                                            </h4>';
										}
										
										if ($recordset['total'] > "0" && $rewcount > "0") {
										    $rewsi = $recordset['total'] / $rewcount;
										}
										
                                        echo'<figure>';
										
											if (!empty($rewsi)) {
                                            echo'<div class="float-left">
                                                    <div class="rating" data-rating="'.$rewsi.'"></div>
                                                </div>';
											}	
                                            echo'<div class="text-align-right social">';
												if (!empty($p_users['facebook'])) {
                                                echo'<a target="_blank" href="'.$p_users['facebook'].'">
                                                        <i class="fa fa-facebook-square"></i>
                                                    </a>';
												}
												if (!empty($p_users['twitter'])) {
                                                echo'<a target="_blank" href="'.$p_users['twitter'].'">
                                                        <i class="fa fa-twitter-square"></i>
                                                    </a>';
												}
												if (!empty($p_users['instagram'])) {
                                                echo'<a target="_blank" href="'.$p_users['instagram'].'">
                                                        <i class="fa fa-instagram"></i>
                                                    </a>';
												}
												if (!empty($p_users['youtube'])) {
                                                echo'<a target="_blank" href="'.$p_users['youtube'].'">
                                                        <i class="fa fa-youtube"></i>
                                                    </a>';
												}
                                            echo'</div>
												<br>
                                            </figure>
                                        </div>';
									if (!empty($p_users['phone']) || !empty($p_users['email'])) { 
                                    echo'<div class="additional-info">
                                            <ul>';
											if (!empty($p_users['phone'])) { 
											
												if ($p_users['hide_phone'] == "1") { 
                                            echo'<li>
                                                    <figure>'.$lang['profile_phone'].'</figure>
                                                    <aside>'.$lang['product_secret_phone_number'].'</aside>
                                                </li>';
												} else {
                                            echo'<li>
                                                    <figure>'.$lang['profile_phone'].'</figure>
                                                    <aside><a href="tel:'.$p_users['phone'].'">'.$p_users['phone'].'</a></aside>
                                                </li>';
												}
											}
											
											if (!empty($p_users['email'])) { 
											
												if ($p_users['hide_email'] == "1") { 
												
												echo'<li>
														<figure>'.$lang['profile_email'].'</figure>
														<aside>'.$lang['product_secret_email_address'].'</aside>
													</li>';
												
												} else {
												echo'<li>
														<figure>'.$lang['profile_email'].'</figure>
														<aside><a href="mailto:'.$p_users['email'].'">'.$p_users['email'].'</a></aside>
													</li>';
												}

											}
                                        echo'</ul>
                                        </div>';
									} else {
										echo'<br><br><br><br><br>';
									}
									if (!empty($p_users['about'])) {
                                    echo'<p>
                                            '.$p_users['about'].'
                                        </p>';
									}
                                echo'</div>';
								if (!empty($_SESSION['session'])) {
									if ($_SESSION['id'] != $p_users['id']) {
								echo'<div class="follow-button">
										<a href="messaging.php?message='.$p_users['username'].'" style="margin-right: 12px;" class="btn btn-light btn-framed">'.$lang['profile_send_message'].'</a>
									</div>';
									} else {
										echo'<p style="float: right;">'.$lang['profile_you_are_viewing_your_own_profile'].'</p>';
									}
								}
                            echo'</div>

                            </section>

                            <hr>

                            <section>
                                <h2>'.$lang['profile_my_ads'].'</h2>

							<form onsubmit="return false" id="filterdetail">	
								<div class="section-title clearfix">
									<div class="float-left float-xs-none">
										<label class="mr-3 align-text-bottom">'.$lang['profile_d_sort_by'].': </label>
										<select name="sorting" onchange="filterProfileDetail(1)" class="small width-200px" data-placeholder="'.$lang['profile_d_default_sorting'].'" >
											<option value="">'.$lang['profile_d_default_sorting'].'</option>
											<option value="1">'.$lang['profile_d_sold'].'</option>
											<option value="0">'.$lang['profile_d_things_sold'].'</option>
										</select>

									</div>
									<div class="float-right d-xs-none thumbnail-toggle">';
									
								if ($ip_users['grid_list_profile'] == "0") {
                                echo'<a href="#" onclick="filterProfileDetail(1)" grid_list="0" class="change-class profile_detail active" data-change-from-class="list" data-change-to-class="grid" data-parent-class="items">
                                        <i class="fa fa-th"></i>
                                    </a>
                                    <a href="#" onclick="filterProfileDetail(1)" grid_list="1" class="change-class profile_detail" data-change-from-class="grid" data-change-to-class="list" data-parent-class="items">
                                        <i class="fa fa-th-list"></i>
                                    </a>';
								} else {
                                echo'<a href="#" onclick="filterProfileDetail(1)" grid_list="0" class="change-class profile_detail" data-change-from-class="list" data-change-to-class="grid" data-parent-class="items">
                                        <i class="fa fa-th"></i>
                                    </a>
                                    <a href="#" onclick="filterProfileDetail(1)" grid_list="1" class="change-class profile_detail active" data-change-from-class="grid" data-change-to-class="list" data-parent-class="items">
                                        <i class="fa fa-th-list"></i>
                                    </a>';
								}

								echo'</div>
								</div>
							</form>';
								
								
								

	define("ROW_PER_PAGE",$settings['profile_detail_per_page']);
	
	$sql = 'SELECT * FROM items WHERE user_id = "'.$p_users['id'].'" AND permit = "1" AND sale_status IN("0","1")';
	
	$drby = " ORDER BY create_date ASC";

		$per_page_html = '';

		if(!empty($_GET["page"])) {
			$page = $_GET["page"];
			$start = ($page - "1") * ROW_PER_PAGE;
		} else {
			$page = "1";
			$start = "0";
		}
		
		$limit=" LIMIT " . $start . "," . ROW_PER_PAGE;
		
		$pagination_statement = $db->prepare($sql);
		
		$pagination_statement->execute();
		$row_count = $pagination_statement->rowCount();

		if(!empty($row_count)) {
			$per_page_html .= "";
			$page_count=ceil($row_count/ROW_PER_PAGE);
			$view = $settings['profile_detail_pag_view'];
			if($page_count > "1") {
				for($i = $page - $view; $i < $page + $view + "1"; $i++) {
					
					if($i > "0" and $i <= $page_count) {
						if($i == $page) {
							$per_page_html .= '<li class="page-item active"><input class="page-link" type="submit" onclick="filterProfileDetail('.$i.')" value="'.$i.'" /></li>';
						} else {
							$per_page_html .= '<li class="page-item"><input class="page-link" type="submit" onclick="filterProfileDetail('.$i.')" value="'.$i.'"/></li>';
						}
					}
				}
			}
			$per_page_html .= "";
		}

		$query = $sql.$drby.$limit;
		
		$pdo_statement = $db->prepare($query);
		
		$pdo_statement->execute();
		
		$result = $pdo_statement->rowCount();
    
		if(!empty($result)) {
								
						echo'<div id="productMyContainer">';	

						if ($ip_users['grid_list_profile'] == "0") {
							echo'<div class="items grid grid-xl-3-items grid-lg-3-items grid-md-2-items">';
						} else {
							echo'<div class="items list grid-xl-3-items grid-lg-3-items grid-md-2-items">'; 
						}
						
						
								while ($row = $pdo_statement->fetchObject()) {
									
									$gallery = $db -> query("SELECT * FROM gallery WHERE `item_id` = '" . $row->id . "'")->fetch();
									$category = $db -> query("SELECT * FROM category WHERE `id` = '" . $row->category . "'")->fetch();
									$usr = $db -> query("SELECT * FROM users WHERE `id` = '" . $row->user_id . "'")->fetch();
									
									$i_category_box_1 = $db -> query("SELECT * FROM i_category_box_1 WHERE `item_id` = '" . $row->id . "' ORDER BY rand()")->fetch();
									$category_box_1 = $db -> query("SELECT * FROM category_box_1 WHERE `id` = '{$i_category_box_1['ctg_bx_1_id']}'")->fetch();
									$category_box = $db -> query("SELECT * FROM category_box WHERE `id` = '{$category_box_1['category_box_id']}'")->fetch();
									
									$i_category_box_2 = $db -> query("SELECT * FROM i_category_box_2 WHERE `item_id` = '" . $row->id . "' ORDER BY rand()")->fetch();
									$category_box_2 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$i_category_box_2['ctg_bx_2_id']}'")->fetch();
									
									$i_category_box_3 = $db -> query("SELECT * FROM i_category_box_3 WHERE `item_id` = '" . $row->id . "' ORDER BY rand()")->fetch();
									$category_box_3 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$i_category_box_3['ctg_bx_3_id']}'")->fetch();
									
									$ttl = $row->title;
									$limit = 30;
									$text = strlen($ttl);
									$title = substr($ttl,0,$limit);
									
									$adr = $row->address;
									$limit = 30;
									$text = strlen($adr);
									$address = substr($adr,0,$limit);
									
									if ($row->sale_status == "0") {
								echo'<div class="item js-category-filterable">';
									} else if ($row->sale_status == "1") {
								echo'<div class="item item-sold js-category-filterable">								
										<div class="ribbon-diagonal">
											<div class="ribbon-diagonal__inner">
												<span style="background:#5da232;">'.$lang['book_s_sold'].'</span>
											</div>
										</div>';
									}
									
									echo'<div class="wrapper">
									
											<div class="image">
												<h3>';
													if (!empty($category['ctg_name'])) {
														echo '<a class="tag category">'.$category['ctg_name'].'</a>';
													}
													if (!empty($row->title)) {
														if ($row->sale_status == "0") {
															echo'<a href="product.php?title='.seo($row->title).'&id='.$row->id.'" class="title">'.$title.'</a>';
														} else {
															echo'<a class="title">'.$title.'</a>';
														}	
													}
													
													if (!empty($row->type)) {
														echo '&nbsp;<span class="tag">'.$row->type.'</span>';
													}
												echo '</h3>';
												if ($row->sale_status == "0") {
													echo'<a href="product.php?title='.seo($row->title).'&id='.$row->id.'" class="image-wrapper background-image">';
												} else {
													echo'<a class="image-wrapper background-image">';
												}
												if (!empty($gallery['image'])) {
													echo '<img src="'.$gallery['image'].'" alt="">';
												}
                                            echo'</a>
											</div>';
											if (!empty($row->address)) {
									  echo '<h4 class="location">
                                                <a>'.$address.'</a>
                                            </h4>';
											}
								       if (!empty($row->price)) {
												echo'<div class="price">'.$settings['currency'].' '.number_format($row->price,"0","",".").'</div>';
											}
								      
                                       echo '<div class="meta">
                                                <figure>
                                                    '.timeConvert(date('d.m.Y H:i:s', $row->create_date)).'
                                                </figure>';
												if (!empty($usr['fullname'])) {
											echo '<figure>
                                                    <a href="profile_detail.php?users='.$usr['username'].'">
                                                        <i class="fa fa-user"></i>'.$usr['fullname'].'
                                                    </a>
                                                </figure>';
												}
                                            echo '</div>';
											if (!empty($row->description)) {
									  echo '<div class="description">
                                                <p>'.$row->description.'</p>
                                            </div>';
											}
                                        echo'<div class="additional-info">
                                                <ul>
                                                    <li>
                                                        <figure><i class="fa fa-calendar-o">&nbsp;</i> '.$lang['book_create_date'].' </figure>
                                                        <aside>'.date('d.m.Y H:i:s', $row->create_date).'</aside>
                                                    </li>';
													if (!empty($i_category_box_1['id'])) {
											   echo '<li>
                                                        <figure>'.$category_box['ctg_bx_name'].'</figure>
                                                        <aside>'.$category_box_1['name'].'</aside>
                                                    </li>';
													}
													if (!empty($i_category_box_2['ctg_bx_2_subj'])) {
											   echo '<li>
                                                        <figure>'.$category_box_2['ctg_bx_name'].'</figure>
                                                        <aside>'.$i_category_box_2['ctg_bx_2_subj'].' '.$category_box_2['text_val'].'</aside>
                                                    </li>';
													}
													if (!empty($i_category_box_3['ctg_bx_3_subj'])) {
											   echo '<li>
                                                        <figure>'.$category_box_3['ctg_bx_name'].'</figure>
                                                        <aside>'.$i_category_box_3['ctg_bx_3_subj'].'</aside>
                                                    </li>';
													}
                                                    
                                             echo '</ul>
                                            </div>';
										if ($row->sale_status == "0") {
											echo'<a href="product.php?title='.seo($row->title).'&id='.$row->id.'" class="detail text-caps underline">'.$lang['book_detail'].'</a>';
										} else {
											echo'<a class="detail text-caps underline">'.$lang['book_detail'].'</a>';
										}
										echo'</div>
									</div>';
								}

							echo'</div>';
							
							
							$previous = $page - "1";
							$next = $page + "1";
							
							if($next <= $page_count) {
								$nx = $next;
							} else {
								$nx = $page;
							}

							if ($previous >= "1") {
								$pr = $previous;
							} else {
								$pr = $page;
							}
							
					if(!empty($row_count)) {		
					$page_count=ceil($row_count/ROW_PER_PAGE);
						
						if($page_count>1) {
						echo'<div class="page-pagination">
                                <nav aria-label="Pagination">
                                    <ul class="pagination">';
									
									echo'<li class="page-item">
                                            <a class="page-link" onclick="filterProfileDetail('.$pr.')" aria-label="Previous">
                                        <span aria-hidden="true">
                                            <i class="fa fa-chevron-left"></i>
                                        </span>
                                                <span class="sr-only">Previous</span>
                                            </a>
										</li>';
										
										echo $per_page_html;
										
										echo'<li class="page-item">
                                            <a class="page-link" onclick="filterProfileDetail('.$nx.')" aria-label="Next">
                                        <span aria-hidden="true">
                                            <i class="fa fa-chevron-right"></i>
                                        </span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
										
                                    </ul>
                                </nav>
                            </div>';
						}
					}
							
							echo'</div>';
							
							
							
							} else {
								echo'<p>'.$lang['home_view_there_were_no_results'].'</p>';
							}	

                        echo'</section>';

						
						if (!empty($_SESSION['session'])) {
							if ($users['id'] != $p_users['id']) {
							echo'<section>
                                <h2>'.$lang['profile_write_a_review'].'</h2>
                                <form class="form clearfix" onsubmit="return false" id="users_comment">
                                    <div class="row">
									
                                        <div id="i_review" class="col-md-8">
                                            <div class="form-group">
                                                <label for="review" class="col-form-label">'.$lang['profile_your_review'].'</label>
                                                <textarea name="review" id="review" class="form-control" rows="4" placeholder="'.$lang['profile_good_seller_i_am_satisfied'].'"></textarea>
												<span class="input-group-addon"><i id="c_review" class="fa fa-pencil"></i></span>
											</div>
                                        </div>
										<input type="hidden" name="r_id" value="'.$p_users['id'].'">
                                        <div id="i_rating" class="col-md-4">
                                            <div class="form-group">
                                                <label for="rating" class="col-form-label">'.$lang['profile_rating'].'</label>
                                                <select name="rating" id="rating" data-placeholder="'.$lang['profile_select_rating'].'">
                                                    <option value="">'.$lang['profile_select_rating'].'</option>
                                                    <option value="1" data-option-stars="1">'.$lang['profile_horrible'].'</option>
                                                    <option value="2" data-option-stars="2">'.$lang['profile_average'].'</option>
                                                    <option value="3" data-option-stars="3">'.$lang['profile_good'].'</option>
                                                    <option value="4" data-option-stars="4">'.$lang['profile_very_good'].'</option>
                                                    <option value="5" data-option-stars="5">'.$lang['profile_excellent'].'</option>
                                                </select>
                                            </div>

											<button type="submit" onclick="users_comment()" class="btn btn-primary width-100"><div id="resultc"></div> '.$lang['profile_publish_review'].'</button>
                                        </div>

                                    </div>
                                </form><br />
								<div id="result"></div>
                            </section>';
							} else {

							}
						}
						if (!empty($rewsi)) {
                        echo'<section>
                                <h2>'.$p_users['fullname'].' '.$lang['profile_all_comments_and_opinions_made_about_this_seller'].'</h2>
								
                                <div id="results" class="comments wrapper">
                                </div>

                            </section>';
						}
                    echo'</div>

                        <div class="col-md-3">

                            <aside class="sidebar">

                            </aside>

                        </div>

                    </div>
                </div>
                <!--end container-->
            </section>
            <!--end block-->
        </section>
        <!--end content-->';
	  
    include ('includes/footer.php');
	
echo'<script>
		var oneMoreTime = 1;
		function filterProfileDetail(valu) {
			var val = $("form#filterdetail").serialize();
			
			if( oneMoreTime == 1 ) {
				oneMoreTime = 0;

				$.ajax({
					type: "POST",
					url: "getProfileDetail.php?page=" + valu + "&p_user=" + '.$p_users['id'].',
					data: val,
					beforeSend: function () {
						$(".items").css("opacity", ".5");
						oneMoreTime = 1;
					},
					success: function (html) {
						$("#productMyContainer").html(html);
						$(".items").css("opacity", "");
						oneMoreTime = 1;
					}
				});
			}
		}
	</script>';
	 
echo'<script type="text/javascript">

	(function($) {
		
		$.fn.loaddata = function(options) {
			var settings = $.extend({ 
				loading_gif_url	: "assets/img/ajax-loader.gif", 
				end_record_text	: "'.$lang['profile_no_more_records_found'].'", 
				data_url 		: "fetch_pages.php?p_users='.$p_users['id'].'", 
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