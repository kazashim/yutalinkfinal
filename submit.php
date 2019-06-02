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

          echo '<div class="page-title">
                    <div class="container">
                        <h1>'.$lang[$te].'</h1>
                    </div>
                    <!--end container-->
                </div>
				<div class="background"></div>
                <!--end background-->
            </div>
            <!--end hero-wrapper-->
        </header>
        <!--end hero-->
		<section class="content">
            <section class="block">
                <div class="container">';
				if (empty($_SESSION['session'])) {
					echo '<section id="reg1">
                        <div class="alert alert-warning" role="alert">
						
                            <h2 class="alert-heading">'.$lang['sub_you_don_t_have_an_account'].'</h2>
                            <p>'.$lang['sub_you_must_be_logged_in_to_submit_an_item_if_you_are_not_a_member_click_on'].'
							
                            <a id="register" href="javascript:void(0)" class="link"><strong> '.$lang['sub_register'].'</strong></a> '.$lang['sub_or_for_member_login_here'].' 
							
							<a id="signin" href="javascript:void(0)" class="link"><strong> '.$lang['sub_sign_in'].'</strong></a></p>
							
                        </div>
                    </section>';
					
				echo'<section style="display:none;" id="reg2">
					
                        <div style="background-color:#00ff0014;color:#616161;" class="alert alert-warning" role="alert">
                            <h2 class="alert-heading">'.$lang['sub_congratulations_user_registration_succeeded'].'</h2>
                             <div id="usernames"></div><p>'.$lang['sub_you_can_resume_where_you_left_off'].'</p> 
                        </div>
						
                    </section>';
					
				echo'<section style="display:none;" id="sig2">
					
                        <div style="background-color:#00ff0014;color:#616161;" class="alert alert-warning" role="alert">
                            <h2 class="alert-heading">'.$lang['sub_congratulations_user_signin_succeeded'].'</h2>
                             <h3><div id="fullnames"></div></h3><p>'.$lang['sub_you_can_resume_where_you_left_off'].'</p> 
                        </div>
						
                    </section>';
				} 
				
			  echo '<form class="form form-submit" onsubmit="return false" id="data_add">
			  
					    <section class="alert alert-warning" style="display:none;" id="reg">
						
                            <h2 id="by_us">'.$lang['sub_by_completing_this_form_you_will_also_become_a_member'].'</h2>
							<br>
							
                            <div class="row">
							
                                <div class="col-md-4">
								
                                    <div class="form-group">
									
                                        <label for="username" class="col-form-label ">'.$lang['register_username'].'</label>
                                        <input name="username" type="text" class="form-control" id="username" placeholder="'.$lang['register_your_username'].'">
										<span class="input-group-addon"><i id="username_c" class="fa fa-user"></i></span>
										
									</div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label "flnm" for="fullname" class="col-form-label ">'.$lang['register_fullname'].'</label>
                                        <input name="full_name" type="text" class="form-control" id="full_name" placeholder="'.$lang['register_your_fullname'].'">
                                        <span class="input-group-addon"><i id="full_name_c" class="fa fa-bookmark"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class="col-form-label ">'.$lang['register_email'].'</label>
                                        <input name="email" type="text" class="form-control" id="email" placeholder="'.$lang['register_your_email'].'">
                                        <span class="input-group-addon"><i id="email_c" class="fa fa-envelope"></i></span>
                                    </div>
                                </div>
								
                            </div>
							
                            <div class="row">
							
                                <div class="col-md-4">
								
                                    <div class="form-group">
                                        <label id="ps1" for="password" class="col-form-label ">'.$lang['register_password'].'</label>
                                        <input name="password" type="password" class="form-control" id="password" placeholder="'.$lang['register_your_password'].'">
										<span class="input-group-addon"><i id="password_c" class="fa fa-lock"></i></span>
									</div>
									
                                </div>
								
                                <div class="col-md-4">
								
                                    <div class="form-group">
                                        <label id="ps2" for="repeat_password" class="col-form-label ">'.$lang['register_repeat_password'].'</label>
                                        <input name="repeat_password" type="password" class="form-control" id="repeat_password" placeholder="'.$lang['register_your_repeat_password'].'">
										<span class="input-group-addon"><i id="repeat_password_c" class="fa fa-lock"></i></span>
                                    </div>
									
                                </div>
								
                                <div class="col-md-4">
								
                                    <div id="opn" style="display:none;" class="form-group">
                                        <label for="gender" class="col-form-label">'.$lang['register_ı_am'].'</label>
                                        <select name="gender" id="gender" data-placeholder="'.$lang['register_select_sex'].'"> 
                                            <option value="">'.$lang['register_select_sex'].':</option>
                                            <option value="1">'.$lang['register_mr'].'</option>
                                            <option value="2">'.$lang['register_mrs'].'</option>
                                        </select>
                                    </div>
									
                                </div>
								
                            </div>
							
							<br>
							

                                <div class="d-flex justify-content-between align-items-baseline">
                                    <label>
                                        <input type="checkbox" name="newsletter" value="1">
                                        '.$lang['register_receive_newsletter'].'
                                    </label>
                                    <button type="submit" onclick="i_submit_reg()" class="btn btn-primary"><div id="result_v"></div>'.$lang['register_register'].'</button>
                                </div>
							
							
                          '.$lang['register_terms_conditions'].'
						  <br>
						  <div id="result_sub"></div>
                        </section>

					</form>
					
					
					
					
					<form class="form form-submit" onsubmit="return false" id="data_signin">
			  
					    <section class="alert alert-warning" style="display:none;" id="sig">
						
                            <h2 id="by_us">'.$lang['sub_required_login'].'</h2>
							<br>
							
                            <div class="row">
							

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emails" class="col-form-label ">'.$lang['signin_email'].'</label>
                                        <input name="emails" type="text" class="form-control emails" placeholder="'.$lang['signin_your_email'].'">
                                        <span class="input-group-addon"><i id="email_cr" class="fa fa-envelope"></i></span>
                                    </div>
                                </div>
								
                                <div class="col-md-6">
								
                                    <div class="form-group">
                                        <label id="pssignin" for="passwords" class="col-form-label ">'.$lang['signin_password'].'</label>
                                        <input name="passwords" type="password" class="form-control passwords" placeholder="'.$lang['signin_your_password'].'">
										<span class="input-group-addon"><i id="password_cr" class="fa fa-lock"></i></span>
									</div>
									
                                </div>
								
                            </div>

							
							<br>
							

                                <div class="d-flex justify-content-between align-items-baseline">
                                    <label>
                                        <input type="checkbox" name="remember" value="1">
                                        '.$lang['signin_remember_me'].'
                                    </label>
                                    <button type="submit" onclick="i_submit_sig()" class="btn btn-primary"><div id="result_vsgn"></div>'.$lang['signin_signin'].'</button>
                                </div>

						  <br>
						  <div id="result_signinn"></div>
                        </section>

					</form>
					
					

                    <form class="form form-submit" id="data" enctype="multipart/form-data">
					
					
					    <section>
						
                            <h2 id="ttls">'.$lang['sub_basic_information'].'</h2>
                            <div class="row">
							
							
                                <div class="col-md-8">
                                    <div class="form-group">
									
                                        <label id="ttl" for="title" class="col-form-label ">'.$lang['sub_title'].'</label>
                                        <input name="title" type="text" class="form-control" id="title" placeholder="'.$lang['sub_write_a_title_in_this_field'].'">
										<span class="input-group-addon"><i id="title_c" class="fa fa-pencil"></i></span>
										
                                    </div>
                                </div>

								
								
                                <div class="col-md-4">
                                    <div class="form-group">
									
                                        <label id="prc" for="price" class="col-form-label ">'.$lang['sub_price'].'</label>
                                        <input name="price" type="text" class="form-control" id="price" placeholder="'.$lang['sub_use_numbers_only'].'">
                                        <span class="input-group-addon" id="price_c">'.$settings['currency'].'</span>
										
                                    </div>
                                </div>
							
								
                            </div>

                        </section>
						
						
						
                        <section>
                            <div class="row">';
							$category = $db->prepare("SELECT * FROM category");
							$category->execute();
							if ($category->rowCount()) {
								echo'<input name="submit_categorys" value="yes_category" type="hidden"/>';
                           echo '<div class="col-md-4">
                                    <h2 id="smbt_ctgs">'.$lang['sub_category'].'</h2>
                                    <div class="form-group">
									
                                        <label id="ctgry" for="submit_category" class="col-form-label">'.$lang['sub_category'].'</label>
                                        <select class="change-tab" data-change-tab-target="category-tabs" name="submit_category" data-placeholder="'.$lang['sub_select_category'].'">
                                            <option value="">'.$lang['sub_select_category'].'</option>';
											foreach ($category as $row) {
										echo '<option value="'.$row['id'].'">'.$row['ctg_name'].'</option>';
											}
                                   echo '</select>
                                    </div>

                                </div>';
							} else {
								echo'<input name="submit_categorys" value="no_category" type="hidden"/>';
							}
								
							echo '<div class="col-md-8">';
							
									$category = $db->prepare("SELECT * FROM category");
									$category->execute();
									if ($category->rowCount()) {
									
                                    echo'<h2>'.$lang['sub_features'].'</h2>
								     <div class="form-slides" id="category-tabs">
								   
										<div class="form-slide default">
                                            <h3>'.$lang['sub_please_select_a_category'].'</h3>
                                        </div>';

										foreach ($category as $row) {
                                   echo '<div class="form-slide" id="'.$row['id'].'">
                                            <h3>'.$row['ctg_name'].'</h3>
                                            <figure class="category-icon">
                                                <img src="'.$row['ctg_icon_img'].'" alt="">
                                            </figure>';

											
                                       echo '<div class="row">';
											
											
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 1 and category_id = '".$row['id']."'");
										$category_box->execute();
										if ($category_box->rowCount()) {
											foreach ($category_box as $row_1) {
                                          echo '<div class="col-md-'.$row_1['size'].'">
                                                    <div class="form-group">
													
                                                        <label for="ctg_bx_1" class="col-form-label">'.$row_1['ctg_bx_name'].'</label>
                                                        <select name="ctg_bx_1[]" data-placeholder="'.$lang['sub_select'].' '.$row_1['ctg_bx_name'].'">
                                                            <option value="">'.$lang['sub_select'].' '.$row_1['ctg_bx_name'].'</option>';
															$category_box_1 = $db->prepare("SELECT * FROM category_box_1 WHERE category_box_id = '".$row_1['id']."' ORDER BY id ASC");
															$category_box_1->execute();
															if ($category_box_1->rowCount()) {
																foreach ($category_box_1 as $row_b_1) {
																echo '<option value="'.$row_b_1['id'].'">'.$row_b_1['name'].'</option>';
																}	
															}
                                                   echo '</select>
														
                                                    </div>
                                                </div>';
											}
										}
												
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 2 and category_id = '".$row['id']."'");
										$category_box->execute();
										if ($category_box->rowCount()) {
											foreach ($category_box as $row_2) {
                                          echo '<div class="col-md-'.$row_2['size'].'">
                                                    <div class="form-group">
														<input name="ctg_bx_2_id[]" type="hidden" class="form-control" value="'.$row_2['id'].'">
                                                        <label for="ctg_bx_2_subj" class="col-form-label">'.$row_2['ctg_bx_name'].'</label>
                                                        <input name="ctg_bx_2_subj[]" type="text" class="form-control">
                                                        <span class="input-group-addon">'.$row_2['text_val'].'</span>
														
                                                    </div>
                                                </div>';
											}
										}
												
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 3 and category_id = '".$row['id']."'");
										$category_box->execute();
										if ($category_box->rowCount()) {
											foreach ($category_box as $row_3) {	
                                           echo '<div class="col-md-'.$row_3['size'].'">
                                                    <div class="form-group">
														<input name="ctg_bx_3_id[]" type="hidden" class="form-control" value="'.$row_3['id'].'">
                                                        <label for="ctg_bx_3_subj" class="col-form-label">'.$row_3['ctg_bx_name'].'</label>
                                                        <input name="ctg_bx_3_subj[]" type="text" class="form-control">
														
                                                    </div>
                                                </div>';
											}
										}

												
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 4 and category_id = '".$row['id']."'");
										$category_box->execute();
										if ($category_box->rowCount()) {
											foreach ($category_box as $row_4) {		
										  echo '<div class="col-md-'.$row_4['size'].'">
													<div class="form-group">
														<input name="ctg_bx_4_id[]" type="hidden" class="form-control" value="'.$row_4['id'].'">
														<label for="ctg_bx_4_subj" class="col-form-label">'.$row_4['ctg_bx_name'].'</label>
														<textarea name="ctg_bx_4_subj[]" class="form-control" rows="4"></textarea>
														
													</div>
												</div>';
											}
										}
												
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 5 and category_id = '".$row['id']."'");
										$category_box->execute();
										if ($category_box->rowCount()) {
											
										  echo '<div class="col-md-12">	
													<h4>'.$lang['sub_property_features'].'</h4>
													<ul class="list-unstyled columns-3">';
													foreach ($category_box as $row_5) {	
													  echo '<li>
																<label>
																	<input type="checkbox" name="ctg_bx_5_id[]" value="'.$row_5['id'].'">
																	'.$row_5['ctg_bx_name'].'
																</label>
															</li>';
													}
											  echo '</ul>
												</div>';
											}
													
										echo '</div>';

                                   echo '</div>';
										}
										
										echo '</div>';
									}


                            echo'</div>
                            </div>
                        </section>
						
	
                        <section>
                            <h2 id="detail">'.$lang['sub_details'].'</h2>
                            <div class="form-group">
                                <label for="details" class="col-form-label">'.$lang['sub_additional_details'].'</label>
                                <textarea name="details" id="details" class="form-control" rows="4" placeholder="'.$lang['sub_you_should_write_something_about_the_product_in_this_area'].'"></textarea>
								<span class="input-group-addon"><i id="details_c" class="fa fa-pencil"></i></span>
                            </div>
                        </section>
						
						
						
						

                        <section>
                            <h2 id="locations">'.$lang['sub_location'].'</h2>

                            <div class="form-group">
                                <label for="input-location" class="col-form-label">'.$lang['sub_exact_location'].'</label>
                                <input name="location" type="text" class="form-control" id="input-location" placeholder="'.$lang['sub_enter_location'].'">
                                <span class="geo-location input-group-addon" data-toggle="tooltip" data-placement="top" title="'.$lang['sub_find_my_position'].'"><i id="lctn" class="fa fa-map-marker"></i></span>
                            </div>

                            <label>'.$lang['sub_map'].'</label>
                            <div class="map height-400px" id="map-submit"></div>
                            <input name="latitude" type="text" class="form-control" id="latitude" hidden>
                            <input name="longitude" type="text" class="form-control" id="longitude" hidden>
                        </section>
						
						
						
						

                        <section>
                            <h2 id="MultiFile2">'.$lang['sub_gallery'].'</h2>
                            <div class="file-upload-previews"></div>
                            <div class="file-upload">
                                <input type="file" name="file[]" class="file-upload-input with-preview" multiple title="'.$lang['sub_click_to_add_files'].'" maxlength="10" />
                                <span><i id="MultiFile_c" class="fa fa-plus-circle"></i>'.$lang['sub_click_or_drag_images_here'].'</span>
                            </div>
                        </section>
						
						

                        <section class="clearfix">
						
                            <div id="add" class="form-group">
                                <button type="submit" onclick="i_submit()" class="btn btn-primary large icon float-right"><div id="resultc"></div>'.$lang['sub_add_listing'].'<i class="fa fa-chevron-right"></i></button>
                            </div>
							
                        </section>
						
					</form>
					<div id="result"></div>
						
						<section class="clearfix">
							<div class="form-group">
								<id id="view"></i>
							</div>
							
							<div class="form-group">
								<id id="edit"></i>
							</div>
						</section>
					
				</div>

            </section>

        </section>';
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