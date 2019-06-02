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
	
    if (!empty($_SESSION['session'])) {
          echo '<div class="secondary-navigation">
                    <div class="container">';
					
					if ($settings['statu_language'] == "1") {
					
                    echo'<ul class="left">';
								$lang_l = $db->prepare("SELECT * FROM language");
								$lang_l->execute();
										 
								if($lang_l->rowCount()){
                        echo'<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<i class="fa fa-language"></i> '.$lang['lang_language'].'
								</a>
								<form onsubmit="return false" id="flang">
								<ul style="background-color:#363636;min-width:auto;" class="dropdown-menu" role="menu">';
								foreach($lang_l as $row) {
							       echo'<li><a class="lang" href="javascript:void(0);" onclick="langProduct('.$row['id'].')" rel="nofollow">'.$row['name'].'</a></li>';
								   }
							echo'</ul>
								</form>
                            </li>';
								}
                    echo'</ul>';
						
					}	
						
                    echo'<ul class="right">
                            <li>
                                <a href="messaging.php">
                                    <i class="fa fa-envelope"></i><h5 style="float:right;" class="message-list-count"></h5>
                                </a>
                            </li>
                            <li>
                                <a href="my_profile.php">
                                    <i class="fa fa-user"></i>'.$users['fullname'].'
                                </a>
                            </li>
                            <li>
                                <a href="functions.php?cr=Logout">
                                    <i class="fa fa-exit"></i>'.$lang['logout'].'
                                </a>
                            </li>
                        </ul>
						
						
						
                    </div>
                </div>';
	} else {
          echo '<div class="secondary-navigation">
                    <div class="container">';
					
					if ($settings['statu_language'] == "1") {
						
                    echo'<ul class="left">';
								$lang_l = $db->prepare("SELECT * FROM language");
								$lang_l->execute();
										 
								if($lang_l->rowCount()){
                        echo'<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<i class="fa fa-language"></i> '.$lang['lang_language'].'
								</a>
								<form onsubmit="return false" id="flang">
								<ul style="background-color:#363636;" class="dropdown-menu" role="menu">';
								foreach($lang_l as $row) {
							       echo'<li><a class="lang" href="javascript:void(0);" onclick="langProduct('.$row['id'].')" rel="nofollow">'.$row['name'].'</a></li>';
								   }
							echo'</ul>
								</form>
                            </li>';
								}
                    echo'</ul>';
					
					}

                    echo'<ul class="right" id="no_signin">
                            <li>
                                <a href="signin.php">
                                    <i class="fa fa-sign-in"></i>'.$lang['signin'].'
                                </a>
                            </li>
                            <li>
                                <a href="register.php">
                                    <i class="fa fa-pencil-square-o"></i>'.$lang['register'].'
                                </a>
                            </li>
                        </ul>
						
                        <ul class="right" style="display:none;" id="yes_signin">
                            <li>
                                <a href="messaging.php">
                                    <i class="fa fa-envelope"></i><h5 style="float:right;" class="message-list-count"></h5>
                                </a>
                            </li>
                            <li>
                                <div class="signin_name"></div>
                            </li>
                            <li>
                                <a href="functions.php?cr=Logout">
                                    <i class="fa fa-exit"></i>'.$lang['logout'].'
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>';
	}