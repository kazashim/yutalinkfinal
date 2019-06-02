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

	$pgs = $db -> query("SELECT * FROM pages WHERE `id` = '{$_GET['id']}'")->fetch();
	
	if (seo($pgs['title']) != $_GET['title']) {
		header("Location: index.php");
	} 
	
    echo'<div class="page-title">
                    <div class="container">
                        <h1>'.$pgs['title'].'</h1>
                    </div>
                    <!--end container-->
                </div>
                <div class="background"></div>
				
            </div>
			
        </header>
		


					
        <section class="content">
            <section class="block">
                
                <div class="container">
				
                    <div class="row">';
					
					$pgsd = $db->prepare("SELECT * FROM pages ORDER BY id DESC");
					$pgsd->execute();
															 
					if($pgsd->rowCount()) {
					
                    echo'<div class="col-md-3">
                            <nav class="nav flex-column side-nav">';
							
							foreach($pgsd as $rs) {
								
                            echo'<a class="nav-link icon" href="page.php?id='.$rs['id'].'&title='.seo($rs['title']).'">
									'.$rs['page_name'].'
                                </a>';
								
							}
							
                        echo'</nav>
                        </div>';
						
					}
						
					echo'<div class="col-md-9">

							<section>
								<p>
									'.$pgs['description'].'
								</p>
							</section>
						
						</div>
						
					</div>
				

                   
                </div>    
			   
            </section>
        </section>';
	  
    include ('includes/footer.php');