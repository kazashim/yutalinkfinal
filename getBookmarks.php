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
	
	sleep(1);  
		
	if(!empty($_POST)) {
			
	require_once('db/func.php');
	require_once('db/db.php');
	ini_set("error_reporting", E_ALL);
	
	$ip = GetIP();
	
	$ip_users = $db -> query("SELECT * FROM ip_users WHERE ip = '".$ip."'")->fetch();
	
		define("ROW_PER_PAGE",$settings['book_per_page']);
			
		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("lang/".$settings["lang"].".php");
			} else {
				require("lang/en.php");
			}
		} else {
			require("lang/".$ip_users["lang"].".php");
		}
	
		$sql = 'SELECT * FROM bookmarks b1, items i1 WHERE b1.user_id = "'.$users['id'].'" AND i1.sale_status IN("0","1") AND b1.item_id = i1.id AND i1.permit = 1';
		
		if($_POST['sorting'] == "1") {
			$drby = " ORDER BY b1.create_date ASC";
		} else if($_POST['sorting'] == "0") {
			$drby = " ORDER BY b1.create_date DESC";
		} else {
			$drby = " ORDER BY b1.create_date DESC";
		}

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
			$view = $settings['book_pag_view'];
			if($page_count > "1") {
				for($i = $page - $view; $i < $page + $view + "1"; $i++) {
					
					if($i > "0" and $i <= $page_count) {
						if($i == $page) {
							$per_page_html .= '<li class="page-item active"><input class="page-link" type="submit" onclick="filterBookmarks('.$i.')" value="'.$i.'" /></li>';
						} else {
							$per_page_html .= '<li class="page-item"><input class="page-link" type="submit" onclick="filterBookmarks('.$i.')" value="'.$i.'"/></li>';
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
								
								
						if ($ip_users['grid_list_bookmark'] == "0") {
							echo'<div class="items grid compact grid-xl-3-items grid-lg-2-items grid-md-2-items">';
						} else {
							echo'<div class="items list compact grid-xl-3-items grid-lg-2-items grid-md-2-items">'; 
						}


				while ($row = $pdo_statement->fetchObject()) {
									

									
					$gallery = $db -> query("SELECT * FROM gallery WHERE `item_id` = '{$row->item_id}'")->fetch();
					$itm = $db -> query("SELECT * FROM items WHERE `id` = '{$row->item_id}'")->fetch();
					$category = $db -> query("SELECT * FROM category WHERE `id` = '{$itm['category']}'")->fetch();
					$usr = $db -> query("SELECT * FROM users WHERE `id` = '{$itm['user_id']}'")->fetch();
									
					$i_category_box_1 = $db -> query("SELECT * FROM i_category_box_1 WHERE `item_id` = '{$row->item_id}' ORDER BY rand()")->fetch();
					$category_box_1 = $db -> query("SELECT * FROM category_box_1 WHERE `id` = '{$i_category_box_1['ctg_bx_1_id']}'")->fetch();
					$category_box = $db -> query("SELECT * FROM category_box WHERE `id` = '{$category_box_1['category_box_id']}'")->fetch();
									
					$i_category_box_2 = $db -> query("SELECT * FROM i_category_box_2 WHERE `item_id` = '{$row->item_id}' ORDER BY rand()")->fetch();
					$category_box_2 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$i_category_box_2['ctg_bx_2_id']}'")->fetch();
									
					$i_category_box_3 = $db -> query("SELECT * FROM i_category_box_3 WHERE `item_id` = '{$row->item_id}' ORDER BY rand()")->fetch();
					$category_box_3 = $db -> query("SELECT * FROM category_box WHERE `id` = '{$i_category_box_3['ctg_bx_3_id']}'")->fetch();
									
					$ttl = $itm['title'];
					$limit = 30;
					$text = strlen($ttl);
					$title = substr($ttl,0,$limit);
									
					$adr = $itm['address'];
					$limit = 30;
					$text = strlen($adr);
					$address = substr($adr,0,$limit);
									
									
									
								echo'<div class="item js-category-filterable" data-category="'.$itm['sale_status'].'">
										<div class="ribbon-vertical">
											<i class="fa fa-star"></i>
										</div>
										<div class="wrapper">
											<div class="image">
												<h3>';
													if (!empty($category['ctg_name'])) {
														echo '<a href="#" class="tag category">'.$category['ctg_name'].'</a>';
													}
													if (!empty($itm['title'])) {
														
														if ($itm['sale_status'] == "0") {
															echo '<a href="product.php?title='.seo($itm['title']).'&id='.$itm['id'].'" class="title">'.$title.'</a>';
														} else {
															echo '<a class="title">'.$title.'</a>';
														}
													}
													if (!empty($itm['type'])) {
														echo '&nbsp;<span class="tag">'.$itm['type'].'</span>';
													}
												echo '</h3>';
												
												if ($itm['sale_status'] == "0") {
													echo'<a href="product.php?title='.seo($itm['title']).'&id='.$itm['id'].'" class="image-wrapper background-image" style="background-image: url('.$gallery['image'].');">';
												} else {
													echo'<a class="image-wrapper background-image" style="background-image: url('.$gallery['image'].');">';
												}
												
												if (!empty($gallery['image'])) {
													echo '<img src="'.$gallery['image'].'" alt="">';
												}
											echo'</a>
											
											</div>';
											if (!empty($itm['address'])) {
									  echo '<h4 class="location">
                                                <a>'.$address.'</a>
                                            </h4>';
											}
								       if (!empty($itm['price'])) {
												echo'<div class="price">'.$settings['currency'].' '.number_format($itm['price'],"0","",".").'</div>';
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
											if (!empty($itm['description'])) {
									  echo '<div class="description">
                                                <p>'.$itm['description'].'</p>
                                            </div>';
											}
                                        echo'<div class="additional-info">
                                                <ul>
                                                    <li>
                                                        <figure><i class="fa fa-calendar-o">&nbsp;</i> '.$lang['book_create_date'].' </figure>
                                                        <aside>'.date('d.m.Y H:i:s', $itm['create_date']).'</aside>
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
											if ($itm['sale_status'] == "0") {
												echo'<a href="product.php?title='.seo($itm['title']).'&id='.$itm['id'].'" class="detail text-caps underline">'.$lang['book_detail'].'</a>';
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
														<a class="page-link" onclick="filterBookmarks('.$pr.')" aria-label="Previous">
													<span aria-hidden="true">
														<i class="fa fa-chevron-left"></i>
													</span>
															<span class="sr-only">Previous</span>
														</a>
													</li>';
													
													echo $per_page_html;
													
													echo'<li class="page-item">
														<a class="page-link" onclick="filterBookmarks('.$nx.')" aria-label="Next">
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
	
	}
	
	echo'<script>
			var oneMoreTime = 1;
			function filterBookmarks(valu) {
				var val = $("form#filterbook").serialize();
				
				if( oneMoreTime == 1 ) {
					oneMoreTime = 0;

					$.ajax({
						type: "POST",
						url: "getBookmarks.php?page=" + valu,
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