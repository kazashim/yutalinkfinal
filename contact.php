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
                        <h1>'.$lang['contact'].'</h1>
                    </div>
                    <!--end container-->
                </div>
                <div class="background"></div>
				
            </div>
			
        </header>
		

        <section class="content">
            <section class="block">
                <div class="map height-500px" id="map-contact"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>'.$lang['contact_get_in_touch'].'</h2>
                            <p>';
							if (!empty($settings['general_about'])) {
								echo $settings['general_about'];
							} 
                        echo'</p>
                            <br>
                            <figure class="with-icon">
                                <i class="fa fa-map-marker"></i>
                                <span>';
							if (!empty($settings['address'])) {
								echo $settings['address'];
							} 
                        echo'</span>
                            </figure>
                            <br>
                            <figure class="with-icon">
                                <i class="fa fa-phone"></i>
                                <span>';
							if (!empty($settings['phone'])) {
								echo $settings['phone'];
							} 
                        echo'</span>
                            </figure>
                            <figure class="with-icon">
                                <i class="fa fa-envelope"></i>';
							if (!empty($settings['email'])) {
								echo '<a href="mailto:'.$settings['email'].'"> '.$settings['email'].'</a>';
							} 
                        echo'</figure>
                            <figure class="with-icon">
                                <i class="fa fa-facebook"></i>';
							if (!empty($settings['facebook'])) {
								echo'<a target="_blank" href="https://www.facebook.com/'.$settings['facebook'].'"> '.$settings['facebook'].'</a>';
							} 
                        echo'</figure>
                            <figure class="with-icon">
                                <i class="fa fa-twitter"></i>';
							if (!empty($settings['twitter'])) {
								echo'<a target="_blank" href="https://www.twitter.com/'.$settings['twitter'].'"> '.$settings['twitter'].'</a>';
							} 
                        echo'</figure>
                        </div> 
						
                        <div class="col-md-8">
                            <h2>'.$lang['contact_form'].'</h2>
							
                            <form class="form" onsubmit="return false" id="send_mes">
							
                                <div class="row">
								
                                    <div class="col-md-6" id="name-email">
									
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">'.$lang['contact_your_name'].'</label>';
											if (!empty($users['fullname'])) {
												echo'<input name="c_fullname" type="text" class="form-control" id="i_fullname" value="'.$users['fullname'].'" placeholder="'.$lang['contact_write_your_name'].'">';
											} else {
												echo'<input name="c_fullname" type="text" class="form-control" id="i_fullname" placeholder="'.$lang['contact_write_your_name'].'">';
											}
										echo'<span class="input-group-addon"><i id="fullname_c" class="fa fa-user"></i></span>
                                        </div>
										
                                    </div>
									
                                    <div class="col-md-6">
									
                                        <div class="form-group">
                                            <label for="email" class="col-form-label">'.$lang['contact_your_email'].'</label>';
                                            if (!empty($users['email'])) {
												echo'<input name="c_email" type="text" class="form-control" id="i_email" value="'.$users['email'].'" placeholder="'.$lang['contact_write_your_email'].'">';
											} else {
												echo'<input name="c_email" type="text" class="form-control" id="i_email" placeholder="'.$lang['contact_write_your_email'].'">';
											}
										echo'<span class="input-group-addon"><i id="email_c" class="fa fa-envelope"></i></span>
                                        </div>
										
                                    </div>
									
                                </div>

								
                                <div class="form-group" id="top-subject">
                                    <label for="subject" class="col-form-label">'.$lang['contact_subject'].'</label>
                                    <input name="c_subject" type="text" class="form-control form-control-c" id="i_subject" placeholder="'.$lang['contact_write_subject'].'">
									<span class="input-group-addon"><i id="subject_c" class="fa fa-exclamation"></i></span>
                                </div>

								
                                <div class="form-group" id="top-message">
                                    <label for="message" class="col-form-label">'.$lang['contact_your_message'].'</label>
                                    <textarea name="c_message" id="i_message" class="form-control form-control-c" rows="4" placeholder="'.$lang['contact_write_your_message'].'"></textarea>
									<span class="input-group-addon"><i id="message_c" class="fa fa-pencil"></i></span>
                                </div>

                                <button type="submit" onclick="contact_send_mes()" class="btn btn-primary float-right"><div id="resultc"></div> '.$lang['contact_send_message'].'</button>

                            </form>
							<br><br><br>
							<div id="result"></div>
							
                        </div>
                       
                    </div>
                    
                </div>
                
            </section>
            <!--end block-->
        </section>
        <!--end content-->';
	  
    include ('includes/footer.php');
	if ((!empty($settings['con_lat'])) && (!empty($settings['con_lon']))) {
echo'<script>
        var latitude = '.$settings['con_lat'].';
        var longitude = '.$settings['con_lon'].';
        var markerImage = "assets/img/map-marker.png";
        var mapTheme = "light";
        var mapElement = "map-contact";
        simpleMap(latitude, longitude, markerImage, mapTheme, mapElement);
    </script>';
	} else {
echo'<script>
        var latitude = 51.511971;
        var longitude = -0.137597;
        var markerImage = "assets/img/map-marker.png";
        var mapTheme = "light";
        var mapElement = "map-contact";
        simpleMap(latitude, longitude, markerImage, mapTheme, mapElement);
    </script>';
	}
