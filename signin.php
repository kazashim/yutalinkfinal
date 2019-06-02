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
		<section class="content" id="sign">
            <section class="block">
                <div class="container">
                    <div class="row justify-content-center">
					
                        <div class="col-md-4" style="display:none;" id="loginlink_reset">
                            <form class="form clearfix" onsubmit="return false" id="pass_ress">
							
                                <div class="form-group">
                                    <label for="email_r" class="col-form-label">'.$lang['signin_email'].'</label>
                                    <input name="email_r" type="email" id="email_fx" class="form-control" placeholder="'.$lang['signin_your_email'].'" >
									<span class="input-group-addon"><i id="email_r" class="fa fa-user"></i></span>
                                </div>
								
                                <div class="d-flex justify-content-between align-items-baseline">
									<label>
									</label>
                                    <button type="submit" onclick="password_reset()" class="btn btn-primary"><div id="resultc_reset"></div>'.$lang['signin_reset'].'</button>
                                </div>
                            </form>
							<div style="padding-bottom: 15px;" id="result_reset"></div>
							<br>
							<p>'.$lang['signin_for_entry'].' <a href="javascript:void(0)" id="resetlink" class="link">'.$lang['signin_click_here'].'</a></p>
						</div>	
					
					
                        <div class="col-md-4" id="loginlink_signin">
                            <form class="form clearfix" onsubmit="return false" id="signin">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">'.$lang['signin_email'].'</label>
                                    <input name="email" type="email" id="email_f" class="form-control" placeholder="'.$lang['signin_your_email'].'" >
									<span class="input-group-addon"><i id="email" class="fa fa-user"></i></span>
                                </div>
                                <!--end form-group-->
                                <div class="form-group">
                                    <label for="password" class="col-form-label">'.$lang['signin_password'].'</label>
                                    <input name="password" type="password" class="form-control" id="password_f" placeholder="'.$lang['signin_your_password'].'" >
									<span class="input-group-addon"><i id="password" class="fa fa-lock"></i></span>
                                </div>
                                <!--end form-group-->
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <label>
                                        <input type="checkbox" name="remember" value="1">
                                        '.$lang['signin_remember_me'].'
                                    </label>
                                    <button type="submit" onclick="signin()" class="btn btn-primary"><div id="resultc"></div>'.$lang['signin_signin'].'</button>
                                </div>
                            </form>
							<div id="result"></div>

							<br>				
							
                            <p>'.$lang['signin_troubles_with_signing'].' <a href="javascript:void(0)" id="loginlink" class="link">'.$lang['signin_click_here'].'</a></p>
							
                            <hr>
							
							<div style="display:none;" class="text-left">
									<a href="#" class="btn btn-social-icon btn-facebook">
								  <i class="fa fa-facebook"></i>
								    </a>
									<a href="#" class="btn btn-social-icon btn-google">
								  <i class="fa fa-google"></i>
								    </a>
								    <a href="#" class="btn btn-social-icon btn-twitter">
								  <i class="fa fa-twitter"></i>
								    </a>
								    <a href="#" class="btn btn-social-icon btn-linkedin">
								  <i class="fa fa-linkedin"></i>
								    </a>
								    <a href="#" class="btn btn-social-icon btn-vk">
								  <i class="fa fa-vk"></i>
								  </a>
							</div>
                        </div>
                    </div>
                </div>
            </section>
        </section>';
	  
    include ('includes/footer.php');