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
					
					<div id="productContainer" class="col-md-8 containers">';

	define("ROW_PER_PAGE",$settings['blog_per_page']);
	
	$sql = 'SELECT * FROM blog WHERE (blog_permit IN("1"))';

	$sorting = " ORDER BY create_date DESC";

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
			$view = $settings['blog_pag_view'];
			if($page_count > "1") {
				for($i = $page - $view; $i < $page + $view + "1"; $i++) {
					
					if($i > "0" and $i <= $page_count) {
						if($i == $page) {
							$per_page_html .= '<li class="page-item active"><input class="page-link" type="submit" onclick="blogProducts('.$i.')" value="'.$i.'" /></li>';
						} else {
							$per_page_html .= '<li class="page-item"><input class="page-link" type="submit" onclick="blogProducts('.$i.')" value="'.$i.'"/></li>';
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
								
		while ($row = $pdo_statement->fetchObject()) {
						
									$ct= "SELECT * FROM blog_category WHERE id = '" . $row->category . "'"; 
									$stmt = $db->query($ct); 
									$blog_category = $stmt->fetch(PDO::FETCH_ASSOC);
									
									$us= "SELECT * FROM users WHERE id = '" . $row->author_id . "'"; 
									$stmt = $db->query($us); 
									$usr = $stmt->fetch(PDO::FETCH_ASSOC);
															
									$ttl = $row->title;
									$limit = 55;
									$text = strlen($ttl);
									$title = substr($ttl,0,$limit);
															
									$adr = $row->description;
									$limit = 250;
									$text = strlen($adr);
									$description = substr($adr,0,$limit);
						
						
                        echo'<article class="blog-post clearfix">';
								if (!empty($row->cover_image)) {
								echo'<a href="blog_detail.php?title='.seo($row->title).'&id='.$row->id.'">
										<img src="'.$row->cover_image.'" alt="">
									</a>';
								}
                                
                            echo'<div class="article-title">
                                    <h2><a href="blog_detail.php?title='.seo($row->title).'&id='.$row->id.'">'.$title.'</a></h2>';
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
                                        '.timeConvert(date('d.m.Y H:i:s', $row->create_date)).'
                                    </figure>';
									if ($row->views > "0") {
									echo'<i style="font-size: 13px;font-weight: 600;font-style: italic;" class="fa fa-eye"> '.$row->views.'</i>';
									}
                            echo'</div>
								
                                <div class="blog-post-content">
                                    <p>
                                        '.$description.'
                                    </p>
                                    <a href="blog_detail.php?title='.seo($row->title).'&id='.$row->id.'" class="btn btn-primary btn-framed detail">'.$lang['blog_read_more'].'</a>
                                </div>
                            </article>';
							
						}

                            
							
							
							

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
                                            <a class="page-link" onclick="blogProducts('.$pr.',1)" aria-label="Previous">
                                        <span aria-hidden="true">
                                            <i class="fa fa-chevron-left"></i>
                                        </span>
                                                <span class="sr-only">Previous</span>
                                            </a>
										</li>';
										
										echo $per_page_html;
										
										echo'<li class="page-item">
                                            <a class="page-link" onclick="blogProducts('.$nx.',1)" aria-label="Next">
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
							
							
                    echo'</div>

                        <div class="col-md-4">

                            <aside class="sidebar">
							
							
                                <section>

                                    <form class="sidebar-form form" onsubmit="return false" id="blog">
									
                                        <div class="form-group">
                                            <label for="what" class="col-form-label">'.$lang['blog_what'].'</label>
                                            <input name="search" type="text" class="form-control" id="what" placeholder="'.$lang['blog_enter_keyword_and_press_enter'].'">
											<span class="input-group-addon"  title="'.$lang['blog_enter_keyword_and_press_enter'].'"><i class="fa fa-search"></i></span>
                                        </div>';
										$blog_category = $db->prepare("SELECT * FROM blog_category");
										$blog_category->execute();
										 
										if($blog_category->rowCount()){
                                    echo'<div class="form-group">
                                            <label for="category" class="col-form-label">'.$lang['blog_category'].'</label>
                                            <select name="category" id="category" data-placeholder="'.$lang['blog_select_category'].'">
                                                <option value="">'.$lang['blog_select_category'].'</option>';
												foreach($blog_category as $row) {
                                                echo'<option value="'.$row['id'].'">'.$row['blog_ctg_name'].'</option>';
												}
                                        echo'</select>
                                        </div>';
										}
                                    echo'<button type="submit" onclick="blogProducts(1)" class="btn btn-primary width-100">'.$lang['blog_search'].'</button>


                                    </form>

                                </section>';
								
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
								
                        echo'</aside>
							
                        </div>
                    </div>
                </div>
            </section>
        </section>';
	  
	echo'<script>
	
		var oneMoreTime = 1;
		function blogProducts(valu) {
			var val = $("form#blog").serialize();
			
			if( oneMoreTime == 1 ) {
				oneMoreTime = 0;

				$.ajax({
					type: "POST",
					url: "blogProducts.php?page=" + valu,
					data: val,
					beforeSend: function () {
						$(".containers").css("opacity", ".5");
						oneMoreTime = 1;
					},
					success: function (html) {
						$("#productContainer").html(html);
						$(".containers").css("opacity", "");
						oneMoreTime = 1;
					}
				});
			}
		}
	</script>';
	  
    include ('includes/footer.php');