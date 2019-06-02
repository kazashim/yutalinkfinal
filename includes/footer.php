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

   echo'<footer class="footer">
            <div class="wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="#" class="brand">';
							if (!empty($settings['logo_two'])) {
								echo'<img src="'.$settings['logo_two'].'" alt="Logo two">';
							} 
                        echo'</a>
                            <p>';
							if (!empty($settings['general_about'])) {
								echo $settings['general_about'];
							} 
                        echo'</p>
                        </div>';

						$l_pages = $db -> query("SELECT * FROM pages")->fetch();
						
						if (!empty($l_pages)) {
							echo'<div class="col-md-5">';
						} else {
							echo'<div class="col-md-4">';
						}

                        echo'<h2>'.$lang['footer_navigation'].'</h2>
                            <div class="row">';
							
							$pgs = $db->prepare("SELECT * FROM pages ORDER BY id DESC LIMIT 10");
							$pgs->execute();
															 
							if($pgs->rowCount()) {
							
                            echo'<div class="col-md-6 col-sm-6">
                                    <nav>
                                        <ul class="list-unstyled">
                                            <li>';
												foreach($pgs as $rs) {
													echo'<a style="padding:0px;" class="nav-link" href="page.php?id='.$rs['id'].'&title='.seo($rs['title']).'">'.$rs['page_name'].'</a>';
												}
                                        echo'</li>
                                        </ul>
                                    </nav>
                                </div>';
								
							}
								
                            echo'<div class="col-md-6 col-sm-6">
                                    <nav>
                                        <ul class="list-unstyled">
                                            <li>
                                                <a class="nav-link" href="index.php">'.$lang['home'].'</a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="blog.php">'.$lang['blog'].'</a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="contact.php">'.$lang['contact'].'</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>';
						
						if (!empty($l_pages)) {
							echo'<div class="col-md-3">';
						} else {
							echo'<div class="col-md-4">';
						}
						
                        echo'<h2>'.$lang['footer_contact'].'</h2>
                            <address>
                                <figure>';
							if (!empty($settings['address'])) {
								echo $settings['address'];
							} 
                        echo'</figure>

                                <strong>'.$lang['footer_phone'].': </strong>';
							if (!empty($settings['phone'])) {
								echo $settings['phone'];
							} 
                        echo'<br>
								
                                <strong>'.$lang['footer_email'].':</strong>';
							if (!empty($settings['email'])) {
								echo'<a href="mailto:'.$settings['email'].'"> '.$settings['email'].'</a>';
							} 
                        echo'<br>
								
                                <strong>'.$lang['footer_facebook'].': </strong>';
							if (!empty($settings['facebook'])) {
								echo'<a target="_blank" href="https://www.facebook.com/'.$settings['facebook'].'"> '.$settings['facebook'].'</a>';
							} 
                        echo'<br>
						
                                <strong>'.$lang['footer_twitter'].': </strong>';
							if (!empty($settings['twitter'])) {
								echo'<a target="_blank" href="https://www.twitter.com/'.$settings['twitter'].'"> '.$settings['twitter'].'</a>';
							} 
                        echo'<br>
								
                                <br>
                                <a href="contact.php" class="btn btn-primary text-caps btn-framed">'.$lang['contact'].'</a>
                            </address>

                        </div>
           
                    </div>

                </div>';
			if (!empty($settings['footer_img'])) {	
            echo'<div class="background">
                    <div class="background-image original-size">
                        <img src="'.$settings['footer_img'].'" alt="Footer img">
                    </div>

                </div>';
			}
        echo'</div>
			
        </footer>
		
    </div>

	<script src="assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key='.$settings['google_api_key'].'&libraries=places"></script>
	<script src="assets/js/selectize.min.js"></script>
	<script src="assets/js/masonry.pkgd.min.js"></script>
	<script src="assets/js/icheck.min.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/transactions.js"></script>
	<script src="assets/js/jQuery.MultiFile.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/readmore.min.js"></script>
	<script src="assets/js/custom.js"></script>';
	
	if (!empty($_SESSION['session'])) {
	echo'<script type="text/javascript">
				$(document).ready(function() {

					refreshMessageList();

					function refreshMessageList() {
						$.ajax({
							type: "POST",
							url: "includes/comment.php",
							data: {"type":"messagelist", "user_id":"'.$users['id'].'"},
							dataType: "json",
							success: function(data) {
									$(".message-list-count").html(data.count);
									setTimeout(function(){ refreshMessageList(); }, 2000);
								
							}
						});
					}
				});
		</script>';
		
	} 
	
	if (!empty($settings['google_analytics_code'])) {
		echo $settings['google_analytics_code'];
	}


  echo'</body>
</html>';