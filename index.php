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
    include ('includes/h_header.php');
	
	echo'<div id="productContainer">';
	
	define("ROW_PER_PAGE",$settings['home_per_page']);
	
	$sql = 'SELECT * FROM items WHERE sale_status NOT IN("1","2") AND permit NOT IN("0")';

		
		if(!empty($_POST['sorting'])) {

			if($_POST['sorting'] == "1") {
				$sorting = " ORDER BY id DESC";
			} else if($_POST['sorting'] == "2") {
				$sorting = " ORDER BY id ASC";
			} else if($_POST['sorting'] == "3") {
				$sorting = " ORDER BY price ASC";
			} else if($_POST['sorting'] == "4") {
				$sorting = " ORDER BY price DESC";
			}
			
		} else {
			$sorting = " ORDER BY create_date DESC";
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
			$view = $settings['home_pag_view'];
			if($page_count > "1") {
				for($i = $page - $view; $i < $page + $view + "1"; $i++) {
					
					if($i > "0" and $i <= $page_count) {
						if($i == $page) {
							$per_page_html .= '<li class="page-item active"><input class="page-link" type="submit" onclick="filterProducts('.$i.')" value="'.$i.'" /></li>';
						} else {
							$per_page_html .= '<li class="page-item"><input class="page-link" type="submit" onclick="filterProducts('.$i.')" value="'.$i.'"/></li>';
						}
					}
				}
			}
			$per_page_html .= "";
		}

		$query = $sql.$sorting.$limit;
		
		$pdo_statement = $db->prepare($query);

		$pdo_statement->execute();
		
		$result = $pdo_statement->rowCount();
    
		if(!empty($result)) {
	
						if ($ip_users['grid_list_index'] == "0") {
							echo'<div class="items grid grid-xl-4-items grid-lg-3-items grid-md-2-items">';
						} else {
							echo'<div class="items list grid-xl-4-items grid-lg-3-items grid-md-2-items">'; 
						}

								while ($row = $pdo_statement->fetchObject()) {
									
									$gl= "SELECT * FROM gallery WHERE item_id = '" . $row->id . "'"; 
									$stmt  = $db->query($gl); 
									$gallery = $stmt->fetch(PDO::FETCH_ASSOC);
									
									$ct= "SELECT * FROM category WHERE id = '" . $row->category . "'"; 
									$stmt = $db->query($ct); 
									$category = $stmt->fetch(PDO::FETCH_ASSOC);
									
									$us= "SELECT * FROM users WHERE id = '" . $row->user_id . "'"; 
									$stmt = $db->query($us); 
									$usr = $stmt->fetch(PDO::FETCH_ASSOC);
															
									$ttl = $row->title;
									$limit = 30;
									$text = strlen($ttl);
									$title = substr($ttl,0,$limit);
															
									$adr = $row->address;
									$limit = 30;
									$text = strlen($adr);
									$address = substr($adr,0,$limit);
							
							
                            echo'<div class="item">';
										if(!empty($row->featured == "1")) {
										echo'<div class="ribbon-featured">
												<div class="ribbon-start">
												</div>
											<div class="ribbon-content">'.$lang['home_view_featured'].'</div>
												<div class="ribbon-end">
													<figure class="ribbon-shadow">
													</figure>
												</div>
											</div>';
										}
									echo'<div class="wrapper">
                                        <div class="image">
										
														<h3>';
															if(!empty($category['ctg_name'])) {
																echo '<a class="tag category">'.$category['ctg_name'].'</a>';
															}
															if(!empty($row->title)) {
																echo '<a href="product.php?title='.seo($row->title).'&id='.$row->id.'" class="title">'.$title.'</a>';
															}
															
															if(!empty($row->type)) {
																echo '&nbsp;<span class="tag">'.$row->type.'</span>';
															}
														echo '</h3>';
											
														if(!empty($gallery['image'])) {
															echo'<a href="product.php?title='.seo($row->title).'&id='.$row->id.'" class="image-wrapper background-image" style="background-image: url('.$gallery['image'].');">
																<img src="'.$gallery['image'].'" alt="'.$gallery['image'].'">
																</a>';
															}
											echo'</div>';

													if(!empty($row->address)) {
											  echo '<h4 class="location">
														<a>'.$address.'</a>
													</h4>';
													}	
													if(!empty($row->price)) {
											echo '<div class="price">'.$settings['currency'].' '.number_format($row->price,"0","",".").'</div>';
													}
											   echo '<div class="meta">
														<figure>
															'.timeConvert(date('d.m.Y H:i:s', $row->create_date)).'
														</figure>';
													if(!empty($usr['fullname'])) {
													echo '<figure>
															<a href="profile_detail.php?users='.$usr['username'].'">
																<i class="fa fa-user"></i>'.$usr['fullname'].'
															</a>
														</figure>';
														}
													echo '</div>';
													if(!empty($row->description)) {
											  echo '<div class="description">
														<p>'.$row->description.'</p>
													</div>';
													}

											echo'<a href="product.php?title='.seo($row->title).'&id='.$row->id.'" class="detail text-caps underline">'.$lang['product_detail'].'</a>';
												
											if (!empty($_SESSION['session'])) {
												
												$i_add = $db->query("SELECT * FROM items WHERE user_id = '{$users['id']}' and id = '{$row->id}'")->fetch(PDO::FETCH_ASSOC);
													
												if (empty($i_add)) {
												
													$t_add = $db -> query("SELECT * FROM bookmarks WHERE item_id = '".$row->id."' and user_id = '".$users['id']."'")->fetch();	
														
													if ($t_add['item_id'] != $row->id) {
														
														echo'<a href="javascript:void(0)" style="transition: .3s background-color ease;position: absolute;bottom: 1.8rem;left: 15rem;" class="buton text-caps underline" item_id="'.$row->id.'" user_id="'.$users['id'].'"><i style="transition: .3s background-color ease;font-size: 22px;position:  absolute;bottom: -0.5rem;left:  7rem;" class="glyphicon fa fa-bookmark-o"></i></a>';
													
													} else {
														
														echo'<a href="javascript:void(0)" style="transition: .3s background-color ease;position: absolute;bottom: 1.8rem;left: 15rem;" class="buton text-caps underline" item_id="'.$row->id.'" user_id="'.$users['id'].'"><i style="transition: .3s background-color ease;font-size: 22px;position:  absolute;bottom: -0.5rem;left:  7rem;" class="glyphicon fa fa-bookmark"></i></a>';
														
													}
													
												}
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
                                            <a class="page-link" onclick="filterProducts('.$pr.')" aria-label="Previous">
                                        <span aria-hidden="true">
                                            <i class="fa fa-chevron-left"></i>
                                        </span>
                                                <span class="sr-only">Previous</span>
                                            </a>
										</li>';
										
										echo $per_page_html;
										
										echo'<li class="page-item">
                                            <a class="page-link" onclick="filterProducts('.$nx.')" aria-label="Next">
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
		} else {
			echo'<p>'.$lang['home_view_there_were_no_results'].'</p>';
		}			
								
								
								
						echo'</div>';               
	

					echo'</div>
                    </div>
                </div>

            </section>

        </section>';
		
		
	echo'<script>
	
		var oneMoreTime = 1;
		function filterProducts(valu) {
			var val = $("form#filter").serialize();
			
			if( oneMoreTime == 1 ) {
				oneMoreTime = 0;

				$.ajax({
					type: "POST",
					url: "getProducts.php?page=" + valu,
					data: val,
					beforeSend: function () {
						
						$(".container").css("opacity", ".5");
						oneMoreTime = 1;
					},
					success: function (html) {
						$("#productContainer").html(html);
						$(".container").css("opacity", "");
						oneMoreTime = 1;
					}
				});
			}
		}
	</script>';
	  
	include ('includes/footer.php');
	
echo'<script>
		var latitude = 51.511971;
		var longitude = -0.137597;
		var markerImage = "assets/img/map-marker.png";
		var mapTheme = "light";
		var mapElement = "map-submit";
		var markerDrag = true;
		simpleMap(latitude, longitude, markerImage, mapTheme, mapElement, markerDrag);
    </script>';