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
	
		define("ROW_PER_PAGE",$settings['home_per_page']);

		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("lang/".$settings["lang"].".php");
			} else {
				require("lang/en.php");
			}
		} else {
			require("lang/".$ip_users["lang"].".php");
		}
		
		
			if (!empty($_POST['latitude']) && !empty($_POST['longitude']) && !empty($_POST['location'])) {
				$lat = $_POST['latitude'];	
				$lng = $_POST['longitude'];	
			} else if (!empty($users['latitude']) && !empty($users['longitude']) && !empty($users['location'])) {
				$lat = $users['latitude'];	
				$lng = $users['longitude'];	
			} else {
				$lat = "";	
				$lng = "";	
			}
			
			$dsc = $_POST['distance'];
		
			if (!empty($dsc) && !empty($lat) && !empty($lng)) {
			$dis = ",
			( 3959 *
				acos(
                    COS(RADIANS(:lat)) *
                    COS(RADIANS(:lng)) * 
                    COS(RADIANS(latitude)) * 
                    COS(RADIANS(longitude)) 
                    +
                    COS(RADIANS(:lat)) * 
                    SIN(RADIANS(:lng)) * 
                    COS(RADIANS(latitude)) * 
                    SIN(RADIANS(longitude)) 
                    + 
                    SIN(RADIANS(:lat)) * 
                    SIN(RADIANS(latitude))
                )
            ) AS distance";
			$dist = "HAVING (distance <= :dis) AND";
			} else {
				$dis = "";
				$dist = "WHERE";
			}

			if (!empty($_POST['search'])) {
				$search = "AND (title LIKE :ttl OR description LIKE :dsc OR address LIKE :add)";
			} else {
				$search = "";
			}

			if (!empty($_POST['location'])) {
				$location = "AND (address LIKE :adr)";
			} else {
				$location = "";
			}

			if (!empty($_POST['category'])) {
				$category = "AND (category = :ctg)";
			} else {
				$category = "";
			}

			if (!empty(@$_POST['featured'])) {
				$featured = "AND (featured = :ftrd)";
			} else {
				$featured = "";
			}

			 if (!empty($_POST['max_price']) && ($_POST['min_price'])) {
				$price = "AND (price <= ".$_POST['max_price']." AND price >= ".$_POST['min_price'].")";
			} else if (!empty($_POST['max_price'])) {
				$price = "AND (price <= ".$_POST['max_price']." + 5 AND price >= ".$_POST['max_price']." - 5)";
			} else if (!empty($_POST['min_price'])) {
				$price = "AND (price <= ".$_POST['min_price']." + 5 AND price >= ".$_POST['min_price']." - 5)";
			} else {
				$price = "";
			}
			
			
			$sql = "SELECT  * ".$dis." FROM items ".$dist." (sale_status NOT IN('1','2')) AND (permit NOT IN('0')) ".$search." ".$location." ".$category." ".$featured." ".$price."";
		
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

		
		// pagination_statement START
		
			if (!empty($dsc) && ($lat) && ($lng)) {
				$pagination_statement->bindValue(":lat",$lat, PDO::PARAM_STR);
				$pagination_statement->bindValue(":lng",$lng, PDO::PARAM_STR);
				$pagination_statement->bindValue(":lat",$lat, PDO::PARAM_STR);
				$pagination_statement->bindValue(":lng",$lng, PDO::PARAM_STR);
				$pagination_statement->bindValue(":lat",$lat, PDO::PARAM_STR);
				$pagination_statement->bindValue(":dis",$_POST['distance'], PDO::PARAM_INT);
			}
			

			if (!empty($_POST['search'])) {
				$pagination_statement->bindValue(":ttl",'%'.$_POST['search'].'%', PDO::PARAM_STR);
				$pagination_statement->bindValue(":dsc",'%'.$_POST['search'].'%', PDO::PARAM_STR);
				$pagination_statement->bindValue(":add",'%'.$_POST['search'].'%', PDO::PARAM_STR);
			}

			if (!empty($_POST['location'])) {
				$pagination_statement->bindValue(":adr",'%'.$_POST['location'].'%', PDO::PARAM_STR);
			}

			if (!empty($_POST['category'])) {
				$pagination_statement->bindValue(":ctg",$_POST['category'], PDO::PARAM_STR);
			}
			
			if (!empty(@$_POST['featured'])) {
				$pagination_statement->bindValue(":ftrd","1", PDO::PARAM_STR);
			}
			
		// pagination_statement CLOSE

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

		// PDO_STATEMENT START
			
			if (!empty($dsc) && ($lat) && ($lng)) {
				$pdo_statement->bindValue(":lat",$lat, PDO::PARAM_STR);
				$pdo_statement->bindValue(":lng",$lng, PDO::PARAM_STR);
				$pdo_statement->bindValue(":lat",$lat, PDO::PARAM_STR);
				$pdo_statement->bindValue(":lng",$lng, PDO::PARAM_STR);
				$pdo_statement->bindValue(":lat",$lat, PDO::PARAM_STR);
				$pdo_statement->bindValue(":dis",$_POST['distance'], PDO::PARAM_INT);
			}
			

			if (!empty($_POST['search'])) {
				$pdo_statement->bindValue(":ttl",'%'.$_POST['search'].'%', PDO::PARAM_STR);
				$pdo_statement->bindValue(":dsc",'%'.$_POST['search'].'%', PDO::PARAM_STR);
				$pdo_statement->bindValue(":add",'%'.$_POST['search'].'%', PDO::PARAM_STR);
			}

			if (!empty($_POST['location'])) {
				$pdo_statement->bindValue(":adr",'%'.$_POST['location'].'%', PDO::PARAM_STR);
			}

			if (!empty($_POST['category'])) {
				$pdo_statement->bindValue(":ctg",$_POST['category'], PDO::PARAM_STR);
			}
			
			if (!empty(@$_POST['featured'])) {
				$pdo_statement->bindValue(":ftrd","1", PDO::PARAM_STR);
			}
			
		// PDO_STATEMENT CLOSE

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
																<img src="'.$gallery['image'].'" alt="">
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
	}
	
	echo'<script src="assets/js/transactions.js"></script>
	<script>
	
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