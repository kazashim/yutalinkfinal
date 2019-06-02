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

                <div class="background">
				</div>
            </div>
        </header>
		
        <section class="content">
            <section class="block">
                <div class="container">
                    <div class="row">';
					include ('includes/my_nav.php');
                    echo'<div class="col-md-9">
                            <form class="form" onsubmit="return false" id="password">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="form-group current_password">
                                            <label for="current_password" class="col-form-label required">'.$lang['change_current_password'].'</label>
                                            <input name="current_password" type="password" class="form-control" id="current_password" placeholder="'.$lang['change_your_current_password'].'" >
											<span class="input-group-addon"><i id="current_password_c" class="fa fa-recycle"></i></span>
                                        </div>
                                        <!--end form-group-->
                                        <div class="form-group new_current_password">
                                            <label for="new_current_password" class="col-form-label required">'.$lang['change_new_password'].'</label>
                                            <input name="new_current_password" type="password" class="form-control" id="new_current_password" placeholder="'.$lang['change_your_new_password'].'" >
											<span class="input-group-addon"><i id="new_current_password_c" class="fa fa-lock"></i></span>
                                        </div>
                                        <!--end form-group-->
                                        <div class="form-group repeat_new_current_password">
                                            <label for="repeat_new_current_password" class="col-form-label required">'.$lang['change_repeat_password'].'</label>
                                            <input name="repeat_new_current_password" type="password" class="form-control" id="repeat_new_current_password" placeholder="'.$lang['change_your_repeat_password'].'">
											<span class="input-group-addon"><i id="repeat_new_current_password_c" class="fa fa-lock"></i></span>
                                        </div>
										
                                        <section class="clearfix">
											<button type="submit" onclick="change_password()" class="btn btn-primary float-right"><div id="resultc"></div> '.$lang['change_change_password'].'</button>
										</section>
										<div id="result"></div>
                                    </div>
    
									
                                </div>
								
                            </form>
							
                        </div>
   
						
                    </div>

                </div>

            </section>

        </section>';
	  
    include ('includes/footer.php');