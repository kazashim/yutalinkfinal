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
	echo'<div class="col-md-3">
        <nav class="nav flex-column side-nav">
            <a class="nav-link icon" href="my_profile.php">
                <i class="fa fa-user"></i>'.$lang['my_profile'].'
            </a>
            <a class="nav-link icon" href="my_ads.php">
                <i class="fa fa-heart"></i>'.$lang['my_ads'].'
            </a>
            <a class="nav-link icon" href="bookmarks.php">
                <i class="fa fa-star"></i>'.$lang['bookmarks'].'
            </a>
            <a class="nav-link icon" href="change_password.php">
                <i class="fa fa-recycle"></i>'.$lang['change_password'].'
            </a>
            <a class="nav-link icon" href="sold_items.php">
                <i class="fa fa-check"></i>'.$lang['sold_items'].'
            </a>';
			if ($users['st'] == "1") { 
        echo'<a class="single-file-input btn btn-framed btn-primary" href="admin/index.php" style="padding-right:  13px;font-weight: 700;color:white;background-color:  #ff0000;">
                <i style="padding-right: 5px;" class="fa fa-sliders"></i>'.$lang['admin_control_panel'].'
            </a>';
			}
    echo'</nav>
    </div>';