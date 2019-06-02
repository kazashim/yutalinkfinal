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

	if (!empty($_SESSION['session'])) {	
	
		if (!empty($_GET['id'])) {
			
			$itm = $db -> query("SELECT * FROM items WHERE id = '".$_GET['id']."' AND user_id = '".$users['id']."'")->fetch();	
			
			$items = $db -> query("SELECT * FROM items WHERE id = '".$_GET['id']."'")->fetch();	
			
			if (!empty($itm)) {
				
				$views_ = 'Sahibi görüyor!';
				
			} else {
				
				$itm_i = $db -> query("SELECT * FROM items WHERE id = '".$_GET['id']."'")->fetch();
				
				if (!empty($itm_i)) {
					
					$usr_s = $db -> query("SELECT * FROM users WHERE id = '".$users['id']."' AND st = 1")->fetch();
					
					if (!empty($usr_s)) {
						
						$views_ = 'Yönetici görüyor!';
						
					} else {
						
						header("Location: index.php");
						
					}
					
				} else {
					
					header("Location: index.php");
					
				}
				
			}
			
		} else {
			
			header("Location: index.php");
			
		}
	
	} else {
		
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
                   
                    <form class="form form-submit" id="i_data" enctype="multipart/form-data">
					
					
					    <section>
						
                            <h2 id="ttls">'.$lang['sub_basic_information'].'</h2>
                            <div class="row">
							
								<input name="item_id" value="'.$items['id'].'" type="hidden"/>
								<input name="submit_category" value="'.$items['category'].'" type="hidden"/>
							
                                <div class="col-md-8">
                                    <div class="form-group">
									
                                        <label id="ttl" for="title" class="col-form-label">'.$lang['sub_title'].'</label>
                                        <input name="title" type="text" class="form-control" id="title" value="'.$items['title'].'" placeholder="'.$lang['sub_write_a_title_in_this_field'].'">
										<span class="input-group-addon"><i id="title_c" class="fa fa-pencil"></i></span>
										
                                    </div>
                                </div>

								
								
                                <div class="col-md-4">
                                    <div class="form-group">
									
                                        <label id="prc" for="price" class="col-form-label">'.$lang['sub_price'].'</label>
                                        <input name="price" type="text" class="form-control" id="price" value="'.$items['price'].'" placeholder="'.$lang['sub_use_numbers_only'].'">
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
								
                           echo '<div class="col-md-4">
                                    <h2 id="smbt_ctgs">'.$lang['sub_category'].'</h2>
                                    <div class="form-group">
									
                                        <label id="ctgry" for="submit_category" class="col-form-label">'.$lang['sub_category'].'</label>
                                        <select class="change-tab" data-change-tab-target="category-tabs" name="submit_category" data-placeholder="'.$lang['sub_select_category'].'" disabled>
                                            <option value="">'.$lang['sub_select_category'].'</option>';
											foreach ($category as $row) {
												if ($row['id'] == $items['category']) {
													echo'<option value="'.$row['id'].'" selected>'.$row['ctg_name'].'</option>';
												}
											}
                                   echo '</select>
                                    </div>

                                </div>';
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
                                                        <select name="ctg_bx_1[]" data-placeholder="'.$lang['sub_select'].' '.$row_1['ctg_bx_name'].'">';
															$category_box_1 = $db->prepare("SELECT * FROM category_box_1 WHERE category_box_id = '".$row_1['id']."' ORDER BY name ASC");
															$category_box_1->execute();
															
															if ($category_box_1->rowCount()) {
																
																foreach ($category_box_1 as $row_b_1) {
																	
																	$i_ct_bx_1 = $db -> query("SELECT * FROM i_category_box_1 WHERE ctg_bx_1_id = '".$row_b_1['id']."' AND item_id = '".$items['id']."'")->fetch();

																	if ($row_b_1['id'] == $i_ct_bx_1['ctg_bx_1_id']) {
																		
																		echo'<option value="'.$row_b_1['id'].'" selected>'.$row_b_1['name'].'</option>';
																		
																	} else {
																		
																		echo'<option value="'.$row_b_1['id'].'">'.$row_b_1['name'].'</option>';
																		
																	}
																	
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
												
												$i_ct_bx_2 = $db -> query("SELECT * FROM i_category_box_2 WHERE ctg_bx_2_id = '".$row_2['id']."' AND item_id = '".$items['id']."'")->fetch();
												
                                          echo '<div class="col-md-'.$row_2['size'].'">
                                                    <div class="form-group">
														<input name="ctg_bx_2_id[]" type="hidden" class="form-control" value="'.$row_2['id'].'">
                                                        <label for="ctg_bx_2_subj" class="col-form-label">'.$row_2['ctg_bx_name'].'</label>
                                                        <input name="ctg_bx_2_subj[]" type="text" class="form-control" value="'.$i_ct_bx_2['ctg_bx_2_subj'].'">
                                                        <span class="input-group-addon">'.$row_2['text_val'].'</span>
														
                                                    </div>
                                                </div>';
												
											}
											
										}
												
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 3 and category_id = '".$row['id']."'");
										$category_box->execute();
										
										if ($category_box->rowCount()) {
											
											foreach ($category_box as $row_3) {	
											
											$i_ct_bx_3 = $db -> query("SELECT * FROM i_category_box_3 WHERE ctg_bx_3_id = '".$row_3['id']."' AND item_id = '".$items['id']."'")->fetch();
											
                                           echo '<div class="col-md-'.$row_3['size'].'">
                                                    <div class="form-group">
														<input name="ctg_bx_3_id[]" type="hidden" class="form-control" value="'.$row_3['id'].'">
                                                        <label for="ctg_bx_3_subj" class="col-form-label">'.$row_3['ctg_bx_name'].'</label>
                                                        <input name="ctg_bx_3_subj[]" value="'.$i_ct_bx_3['ctg_bx_3_subj'].'" type="text" class="form-control">
														
                                                    </div>
                                                </div>';
												
											}
											
										}

												
										$category_box = $db->prepare("SELECT * FROM category_box WHERE type = 4 and category_id = '".$row['id']."'");
										$category_box->execute();
										
										if ($category_box->rowCount()) {
											
											foreach ($category_box as $row_4) {	
											
											$i_ct_bx_4 = $db -> query("SELECT * FROM i_category_box_4 WHERE ctg_bx_4_id = '".$row_4['id']."' AND item_id = '".$items['id']."'")->fetch();
											
										  echo '<div class="col-md-'.$row_4['size'].'">
													<div class="form-group">
														<input name="ctg_bx_4_id[]" type="hidden" class="form-control" value="'.$row_4['id'].'">
														<label for="ctg_bx_4_subj" class="col-form-label">'.$row_4['ctg_bx_name'].'</label>
														<textarea name="ctg_bx_4_subj[]" class="form-control" rows="4">'.$i_ct_bx_4['ctg_bx_4_subj'].'</textarea>
														
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
														
													$i_ct_bx_5 = $db -> query("SELECT * FROM i_category_box_5 WHERE ctg_bx_5_id = '".$row_5['id']."' AND item_id = '".$items['id']."'")->fetch();
													
														if ($row_5['id'] == $i_ct_bx_5['ctg_bx_5_id']) {
															
														echo'<li>
																<label>
																	<input type="checkbox" name="ctg_bx_5_id[]" value="'.$row_5['id'].'" checked>
																	'.$row_5['ctg_bx_name'].'
																</label>
															</li>';
															
														} else {
															
														echo'<li>
																<label>
																	<input type="checkbox" name="ctg_bx_5_id[]" value="'.$row_5['id'].'">
																	'.$row_5['ctg_bx_name'].'
																</label>
															</li>';
															
														}
														
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
                                <textarea name="details" id="details" class="form-control" rows="8" placeholder="'.$lang['sub_you_should_write_something_about_the_product_in_this_area'].'">'.$items['description'].'</textarea>
								<span class="input-group-addon"><i id="details_c" class="fa fa-pencil"></i></span>
                            </div>
                        </section>
						
						
						
						

                        <section>
                            <h2 id="locations">'.$lang['sub_location'].'</h2>

                            <div class="form-group">
							
                                <label for="input-location" class="col-form-label">'.$lang['sub_exact_location'].'</label>
                                <input name="location" type="text" class="form-control" id="input-location" placeholder="'.$lang['sub_enter_location'].'" value="'.$items['address'].'">
                                <span class="geo-location input-group-addon" data-toggle="tooltip" data-placement="top" title="'.$lang['sub_find_my_position'].'"><i id="lctn" class="fa fa-map-marker"></i></span>
                          
						  </div>

                            <label>'.$lang['sub_map'].'</label>
                            <div class="map height-400px" id="map-submit"></div>
							
                            <input name="latitude" value="'.$items['latitude'].'"type="text" class="form-control" id="latitude" hidden>
							
                            <input name="longitude" value="'.$items['longitude'].'" type="text" class="form-control" id="longitude" hidden>
							
                        </section>
						
						
						
						

                        <section>
                            <h2 id="MultiFile2">'.$lang['sub_gallery'].'</h2>';
							
						$gallery = $db->prepare("SELECT * FROM gallery WHERE item_id = '".$items['id']."'");
						$gallery->execute();
										
						if ($gallery->rowCount()) {
							
                       echo'<div class="file-uploaded-images">';
							foreach ($gallery as $gal_lery) {
                            echo'<div class="image imege_rem">
                                    <figure class="remove-image"><i class="fa fa-close"></i></figure>
                                    <img src="'.$gal_lery['image'].'" alt="">
									<input name="g_image_id[]" type="hidden" value="'.$gal_lery['id'].'"/>
                                </div>';
							}
                        echo'</div>';
							
						}
                        echo'<div class="file-upload-previews"></div>
							
                            <div class="file-upload">
                                <input type="file" name="file[]" class="file-upload-input with-preview" multiple title="'.$lang['sub_click_to_add_files'].'" maxlength="10" />
                                <span><i id="MultiFile_c" class="fa fa-plus-circle"></i>'.$lang['sub_click_or_drag_images_here'].'</span>
                            </div>
							
                        </section>
						
						

                        <section class="clearfix">
						
                            <div id="add" class="form-group">
                                <button type="submit" onclick="item_edit()" class="btn btn-primary large icon float-right"><div id="resultc"></div>'.$lang['sub_edit_listing'].'<i class="fa fa-chevron-right"></i></button>
                            </div>
							
                        </section>
						
					</form>
					<div style="padding-bottom: 12px;" id="result"></div>
					
                </div>
				

            </section>

        </section>';
    include ('includes/footer.php');
	
echo'<script>
        var latitude = '.$items['latitude'].';
        var longitude = '.$items['longitude'].';
        var markerImage = "assets/img/map-marker.png";
        var mapTheme = "light";
        var mapElement = "map-submit";
        var markerDrag = true;
        simpleMap(latitude, longitude, markerImage, mapTheme, mapElement, markerDrag);
    </script>';	