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

	if (empty($_SESSION['session'])) {
		header("Location: index.php");
	}	
	
          echo '<div class="page-title">
                    <div class="container">
                        <h1>'.$lang[$te].'</h1>
                    </div>
                </div>
                <div class="background"></div>
            </div>
        </header>
		
        <section class="content">
            <section class="block">
                <div class="container">
                    <div class="row">';
					include ('includes/my_nav.php');

                  echo '<div class="col-md-9">
                            <form class="form" id="profile">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h2>'.$lang['dash_personal_information'].'</h2>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label id="sex" for="gender" class="col-form-label required">'.$lang['dash_i_am'].'</label>
                                                        <select name="gender" id="gender" data-placeholder="Gender">
                                                            <option value="">'.$lang['dash_select_sex'].'</option>';
														if ($users['gender'] == "1") {
															echo '<option id="mr" value="1" selected>'.$lang['dash_mr'].'</option>';
														} else if ($users['gender'] == "2") {
															echo '<option id="mrs" value="2" selected>'.$lang['dash_mrs'].'</option>';
														} else {
															echo '<option value="">'.$lang['dash_select_sex'].'</option>';
														}
                                                      echo '<option id="mr" value="1">'.$lang['dash_mr'].'</option>
                                                            <option id="mrs" value="2">'.$lang['dash_mrs'].'</option>
                                                        </select>
                                                    </div>
													
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label id="name" for="fullname" class="col-form-label required">'.$lang['dash_fullname'].'</label>
                                                        <input name="fullname" id="fullname_f" type="text" class="form-control" placeholder="'.$lang['dash_your_fullname'].'" value="'.$users['fullname'].'">
														<span class="input-group-addon"><i id="fullname_c" class="fa fa-user"></i></span>
                                                    </div>
													
                                                </div>
												
                                            </div>
											
											<section>
											<div class="form-group">
												<label for="input-location" class="col-form-label">'.$lang['dash_your_location'].'</label>
												<input name="location" type="text" class="form-control" id="input-locations" placeholder="'.$lang['dash_enter_location'].'" value="'.$users['location'].'">
												<span class="geo-location input-group-addon" data-toggle="tooltip" data-placement="top" title="'.$lang['dash_find_my_position'].'"><i class="fa fa-map-marker"></i></span>
											</div>
												<label>'.$lang['dash_map'].'</label>
											<div class="map height-200px" id="map-submit"></div>
												<input name="latitude" value="'.$users['latitude'].'" type="text" class="form-control" id="latitude" hidden>
												<input name="longitude" value="'.$users['longitude'].'" type="text" class="form-control" id="longitude" hidden>
											</section>
                                            <!--end form-group-->
                                            <div class="form-group">
                                                <label for="about" class="col-form-label">'.$lang['dash_more_about_you'].'</label>
                                                <textarea name="about" id="about" class="form-control" rows="4" placeholder="'.$lang['dash_write_something_about'].'">'.$users['about'].'</textarea>
                                            </div>
											
                                        </section>

                                        <section>
                                            <h2>'.$lang['dash_contact'].'</h2>
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">'.$lang['dash_phone'].'</label>
                                                <input name="phone" type="text" class="form-control" id="phone" placeholder="'.$lang['dash_your_phone'].'" value="'.$users['phone'].'">
												<span class="input-group-addon">x xxx xxx xx xx</span>
                                            </div>';
											if ($users['hide_phone'] == "1") {
									    echo'<label>
												<input checked type="checkbox" name="emp_phone" value="1"> '.$lang['dash_you_can_hide_your_phone_number_everywhere'].'
											</label>';
											} else if ($users['hide_phone'] == "0") { 
									    echo'<label>
												<input type="checkbox" name="emp_phone" value="1"> '.$lang['dash_you_can_hide_your_phone_number_everywhere'].'
											</label>';
											}
                                        echo'<div class="form-group">
                                                <label for="email" class="col-form-label">'.$lang['dash_email'].'</label>
                                                <input name="email" type="email" class="form-control" id="email" placeholder="'.$lang['dash_your_email'].'" value="'.$users['email'].'">
												<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            </div>';
											if ($users['hide_email'] == "1") {
									    echo'<label>
												<input checked type="checkbox" name="emp_email" value="1"> '.$lang['dash_you_can_hide_your_email_address_everywhere'].'
											</label>';
											} else if ($users['hide_email'] == "0") { 
									    echo'<label>
												<input type="checkbox" name="emp_email" value="1"> '.$lang['dash_you_can_hide_your_email_address_everywhere'].'
											</label>';
											}
                                    echo'</section>

                                        <section>
                                            <h2>'.$lang['dash_social'].'</h2>
											
                                            <div class="form-group">
                                                <label for="facebook" class="col-form-label">Facebook</label>
                                                <input name="facebook" type="text" class="form-control" id="facebook" placeholder="http://" value="'.$users['facebook'].'">
												<span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                            </div>
											
                                            <div class="form-group">
                                                <label for="twitter" class="col-form-label">Twitter</label>
                                                <input name="twitter" type="text" class="form-control" id="twitter" placeholder="http://" value="'.$users['twitter'].'">
												<span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                            </div>
											
                                            <div class="form-group">
                                                <label for="instagram" class="col-form-label">İnstagram</label>
                                                <input name="instagram" type="text" class="form-control" id="instagram" placeholder="http://" value="'.$users['instagram'].'">
												<span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                            </div>
											
                                            <div class="form-group">
                                                <label for="youtube" class="col-form-label">Youtube</label>
                                                <input name="youtube" type="text" class="form-control" id="youtube" placeholder="http://" value="'.$users['youtube'].'">
												<span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                                            </div>

                                        </section>

                                        <section class="clearfix">
                                            <button type="submit" onclick="my_profile()" class="btn btn-primary float-right"><div id="resultc"></div> '.$lang['dash_save_changes'].'</button>
											
                                        </section>
										<div id="result"></div>
                                    </div>
									
                                    <div class="col-md-4">
                                        <div class="profile-image">';
											if (!empty($users['picture'])) {
									  echo '<div class="image background-image">
												<img class="no_pic" src="'.$users['picture'].'" alt="">
											</div>';
											} else {
												if ($users['gender'] == "1") {
									  echo '<div id="picture_sex" class="image background-image">
												<img id="picture" src="assets/img/picture/no_picture_mr.png" alt="">
											</div>';
												} else if ($users['gender'] == "2") { 
									  echo '<div id="picture_sex" class="image background-image">
												<img id="picture" src="assets/img/picture/no_picture_mrs.png" alt="">
											</div>';
												}
											}
                                     echo '<div class="single-file-input">
                                                <input type="file" id="file" name="file[]">
                                                <div class="btn btn-framed btn-primary small">'.$lang['dash_upload_a_picture'].'</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
						
                        </div>
                    </div>
                </div>
            </section>
        </section>';
	  
    include ('includes/footer.php');
	
  echo'
    <script>';
	if (!empty($users['latitude']) && !empty($users['longitude'])) {
   echo'var latitude = '.$users['latitude'].';
		var longitude = '.$users['longitude'].';';
	} else {
   echo'var latitude = 51.511971;
		var longitude = -0.137597;';
	}
   echo'var markerImage = "assets/img/map-marker.png";
		var mapTheme = "light";
		var mapElement = "map-submit";
		var markerDrag = true;
		simpleMap(latitude, longitude, markerImage, mapTheme, mapElement, markerDrag);
    </script>';