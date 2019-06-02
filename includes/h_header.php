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
	
echo'</head>
	<body>
		<div class="page home-page">
			<header class="hero has-dark-background">
				<div class="hero-wrapper">';
					include('includes/nav.php');
				echo'<div class="main-navigation">
						<div class="container">
							<nav class="navbar navbar-expand-lg navbar-light justify-content-between">
								<a class="navbar-brand" href="index.php">';
								if (!empty($settings['logo'])) {
									echo'<img src="'.$settings['logo'].'" alt="logo img">';
								} 
							echo'</a>
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>';
							   include ('includes/navbar.php'); 
						echo'</nav>
						</div>
					</div>
					
					
					
					
					<div class="page-title">
						<div class="container">
							<h1 class="center">
								'.$lang['home_view_buy_sell_find'].'
							</h1>
						</div>
					</div>
					
					
					
					<form class="hero-form form" onsubmit="return false" id="filter">
						<div class="container">
							
							<div class="main-search-form">
								<div class="form-row">';
								
								
								$ctgr_y = $db -> query("SELECT * FROM category")->fetch();
								
								if (!empty($ctgr_y)) {
									echo'<div class="col-md-3 col-sm-3">';
								} else {
									echo'<div class="col-md-6 col-sm-3">';
								}

									echo'<div class="form-group">
											<label for="what" class="col-form-label">'.$lang['home_view_what'].'</label>
											<input name="search" type="text" class="form-control" id="what" placeholder="'.$lang['home_view_what_placeholder'].'">
										</div>
										
									</div>
									
									
									
									<div class="col-md-3 col-sm-3">
										<div class="form-group">
											<label for="input-location" class="col-form-label">'.$lang['home_view_where'].'</label>';
										if (!empty($users['location'])) {
											echo'<input name="location" type="text" class="form-control" id="input-locations" placeholder="'.$users['location'].'">';
										} else {
											echo'<input name="location" type="text" class="form-control" id="input-locations" placeholder="'.$lang['home_view_where_placeholder'].'">';
										}
										echo'<span class="geo-location input-group-addon" data-toggle="tooltip" data-placement="top" title="'.$lang['home_view_find_my_position'].'"><i class="fa fa-map-marker"></i></span>
										
										</div>
										
										<div class="map height-400px" id="map-submit" style="display:none"></div>
										<input name="latitude" type="text" class="form-control" id="latitude" hidden>
										<input name="longitude" type="text" class="form-control" id="longitude" hidden>
									</div>';

							$category = $db->prepare("SELECT * FROM category");
							$category->execute();
							if ($category->rowCount()) {
								
                           echo '<div class="col-md-3 col-sm-3">
                                    <div class="form-group">
									
                                        <label id="ctgry" for="category" class="col-form-label">'.$lang['home_view_category'].'</label>
                                        <select class="change-tab" data-change-tab-target="category-tabs" name="category" data-placeholder="Sub Select Category">
                                            <option value="">'.$lang['home_view_select_category'].'</option>';
											foreach ($category as $row) {
										echo '<option value="'.$row['id'].'">'.$row['ctg_name'].'</option>';
											}
                                   echo '</select>
                                    </div>

                                </div>';
							}
								

							if (!empty($_SESSION['session'])) {
								echo'<div class="col-md-1 col-sm-1">
										<a style="margin:0 0 20px;" href="my_profile.php" class="btn button btn-primary width-100"><i class="fa fa-cog"></i></a>
									</div>
									<div class="col-md-2 col-sm-2">';
							} else {
								echo'<div class="col-md-3 col-sm-3">';
							}		

									echo'<button type="submit" onclick="filterProducts(1)" value="FILTER" class="btn btn-primary width-100"> '.$lang['home_view_search'].'</button>
									</div>
									
									
									
									
								</div>
								
							</div>
							
							
							
							
							<div class="alternative-search-form">
							
							
							
								<a href="#collapseAlternativeSearchForm" class="icon" data-toggle="collapse"  aria-expanded="false" aria-controls="collapseAlternativeSearchForm"><i class="fa fa-plus"></i>'.$lang['home_view_more_options'].'</a>
							   



							   <div class="collapse" id="collapseAlternativeSearchForm">
							   
							   
							   
									<div class="wrapper">
										<div class="form-row">
										
										
										
										
											<div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 d-xs-grid d-flex align-items-center justify-content-between">
												<label>
													<input type="checkbox" name="featured">
													'.$lang['home_view_featured_item'].'
												</label>
											</div>
											
											
											
											
											
											<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12">
												<div class="form-row">
												
												
												
												
													<div class="col-md-4 col-sm-4">
														<div class="form-group">
															<input name="min_price" type="text" class="form-control small" id="min-price" placeholder="'.$lang['home_view_minimal_price'].'">
															<span class="input-group-addon small">'.$settings['currency'].'</span>
														</div>
														
													</div>
													
													
													
													
													
													<div class="col-md-4 col-sm-4">
														<div class="form-group">
															<input name="max_price" type="text" class="form-control small" id="max-price" placeholder="'.$lang['home_view_maximal_price'].'">
															<span class="input-group-addon small">'.$settings['currency'].'</span>
														</div>
													</div>
													
													
													
													
													
													<div class="col-md-4 col-sm-4">
														<div class="form-group">
															<select name="distance" id="distance" class="small" data-placeholder="'.$lang['home_view_distance'].'" >
																<option value="">'.$lang['home_view_select_distance'].'</option>
																<option value="1">1 Km</option>
																<option value="5">5 Km</option>
																<option value="10">10 Km</option>
																<option value="50">50 Km</option>
																<option value="100">100 Km</option>
																<option value="250">250 Km</option>
																<option value="500">500 Km</option>
															</select>
														</div>
													</div>

													
												</div>
											</div>
											
											
											
											
											
											
										</div>
									</div>
									
									
									
									
									
								</div>
							</div>
						</div>
					</form>';
					
				if (!empty($settings['cover_img'])) {
				echo'<div class="background">
						<div class="background-image">
							<img src="'.$settings['cover_img'].'" alt="Cover img">
						</div>		
					</div>';
				}

					
			echo'</div>
				
			</header>    
			
			<section class="buys content">
				<section class="block">
					<div class="container">
						<div class="row flex-column-reverse flex-md-row">
							<div class="col-md-12">

								<form onsubmit="return false" id="filter">
								
									<div class="section-title clearfix">
									
										<div class="float-left float-xs-none">
											<label class="mr-3 align-text-bottom">'.$lang['home_view_sort_by'].' </label>
											<select name="sorting" id="sorting" onchange="filterProducts(1)" class="small width-200px" data-placeholder="'.$lang['home_view_default_sorting'].'" >
												<option value="">'.$lang['home_view_default_sorting'].'</option>
												<option value="1">'.$lang['home_view_newest_first'].'</option>
												<option value="2">'.$lang['home_view_oldest_first'].'</option>
												<option value="3">'.$lang['home_view_lowest_price_first'].'</option>
												<option value="4">'.$lang['home_view_highest_price_first'].'</option>
											</select>

										</div>
										
										<div class="float-right d-xs-none thumbnail-toggle">';
										
											if ($ip_users['grid_list_index'] == "0") {
											echo'<a href="#" onclick="filterProducts(1)" grid_list="0" class="change-class index_items active" data-change-from-class="list" data-change-to-class="grid" data-parent-class="items">
													<i class="fa fa-th"></i>
												</a>
												<a href="#" onclick="filterProducts(1)" grid_list="1" class="change-class index_items" data-change-from-class="grid" data-change-to-class="list" data-parent-class="items">
													<i class="fa fa-th-list"></i>
												</a>';
											} else {
											echo'<a href="#" onclick="filterProducts(1)" grid_list="0" class="change-class index_items" data-change-from-class="list" data-change-to-class="grid" data-parent-class="items">
													<i class="fa fa-th"></i>
												</a>
												<a href="#" onclick="filterProducts(1)" grid_list="1" class="change-class index_items active" data-change-from-class="grid" data-change-to-class="list" data-parent-class="items">
													<i class="fa fa-th-list"></i>
												</a>';
											}
											
									echo'</div>
										
									</div>
									
								</form>';