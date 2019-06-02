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
		
		define("ROW_PER_PAGE",$settings['blog_per_page']);
		
		if (empty($ip_users['lang'] )) {
			if (!empty($settings['lang'])) {
				require("lang/".$settings["lang"].".php");
			} else {
				require("lang/en.php");
			}
		} else {
			require("lang/".$ip_users["lang"].".php");
		}
		
		if (!empty($_GET['gl'])) {
			$grls = strip_tags($_GET['gl']);
		} else {
			$grls = "1";
		}
		
		if ($grls) { 
			$_SESSION['grdls'] = $grls;
		}
		
		
		
		if (!empty($_POST['search'])) {
			$search = "AND (title LIKE :ttl OR description LIKE :dsc)";
		} else {
			$search = "";
		}

		if (!empty($_POST['category'])) {
			$category = "AND (category = :ctg)";
		} else {
			$category = "";
		}
	

		$sql = "SELECT * FROM blog WHERE (blog_permit IN('1')) ".$search." ".$category."";
		
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
		
		// PAGİNATİON STATEMENT

		if (!empty($_POST['search'])) {
			$pagination_statement->bindValue(":ttl",'%'.$_POST['search'].'%', PDO::PARAM_STR);
			$pagination_statement->bindValue(":dsc",'%'.$_POST['search'].'%', PDO::PARAM_STR);
		}

		if (!empty($_POST['category'])) {
			$pagination_statement->bindValue(":ctg",$_POST['category'], PDO::PARAM_STR);
		}

		// PAGİNATİON STATEMENT
		
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
							$per_page_html .= '<li class="page-item active"><input class="page-link" type="submit" onclick="blogProducts('.$i.',1)" value="'.$i.'" /></li>';
						} else {
							$per_page_html .= '<li class="page-item"><input class="page-link" type="submit" onclick="blogProducts('.$i.',1)" value="'.$i.'"/></li>';
						}
					}
				}
			}
			$per_page_html .= "";
		}

		$query = $sql.$sorting.$limit;
		
		$pdo_statement = $db->prepare($query);

		
		// PDO_STATEMENT START

		if (!empty($_POST['search'])) {
			$pdo_statement->bindValue(":ttl",'%'.$_POST['search'].'%', PDO::PARAM_STR);
			$pdo_statement->bindValue(":dsc",'%'.$_POST['search'].'%', PDO::PARAM_STR);
		}

		if (!empty($_POST['category'])) {
			$pdo_statement->bindValue(":ctg",$_POST['category'], PDO::PARAM_STR);
		}

			
		// PDO_STATEMENT CLOSE

		
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
	}
	
	echo'<script>
	
		var oneMoreTime = 1;
		function blogProducts(valu,grls) {
			var val = $("form#blog").serialize();
			
			if( oneMoreTime == 1 ) {
				oneMoreTime = 0;

				$.ajax({
					type: "POST",
					url: "blogProducts.php?page=" + valu + "&gl=" + grls,
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