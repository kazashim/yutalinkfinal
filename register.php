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
		<section class="content">
            <section class="block">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                            <form class="form clearfix" onsubmit="return false" id="register">
                                <div class="form-group">
                                    <label id="usnmm" for="username" class="col-form-label">'.$lang['register_username'].'</label>
                                    <input name="username" type="text" class="form-control" id="username_f" placeholder="'.$lang['register_your_username'].'">
									<span class="input-group-addon"><i id="username" class="fa fa-user"></i></span>
                                </div>
                                <div class="form-group">
                                    <label id="flnmm" for="name" class="col-form-label">'.$lang['register_fullname'].'</label>
                                    <input name="full_name" type="text" class="form-control" id="full_name_f" placeholder="'.$lang['register_your_fullname'].'">
									<span class="input-group-addon"><i id="full_name" class="fa fa-bookmark"></i></span>
                                </div>
                                <!--end form-group-->
                                <div class="form-group">
                                    <label id="emml" for="email" class="col-form-label">'.$lang['register_email'].'</label>
                                    <input name="email" type="text" class="form-control" id="email_f" placeholder="'.$lang['register_your_email'].'">
									<span class="input-group-addon"><i id="email" class="fa fa-envelope"></i></span>
                                </div>
                                <!--end form-group-->
                                <div class="form-group">
                                    <label id="password1" for="password" class="col-form-label">'.$lang['register_password'].'</label>
                                    <input name="password" type="password" class="form-control" id="password_f" placeholder="'.$lang['register_your_password'].'">
									<span class="input-group-addon"><i id="password" class="fa fa-lock"></i></span>
                                </div>
                                <!--end form-group-->
                                <div class="form-group">
                                    <label id="repeat_password1" for="repeat_password" class="col-form-label">'.$lang['register_repeat_password'].'</label>
                                    <input name="repeat_password" type="password" class="form-control" id="repeat_password_f" placeholder="'.$lang['register_your_repeat_password'].'">
									<span class="input-group-addon"><i id="repeat_password" class="fa fa-lock"></i></span>
                                </div>
                                <div id="opn" style="display:none;" class="form-group">
                                        <label for="gender" class="col-form-label">'.$lang['register_ı_am'].'</label>
                                        <select name="gender" id="gender" data-placeholder="'.$lang['register_select_sex'].'"> 
                                            <option value="">'.$lang['register_select_sex'].':</option>
                                            <option value="1">'.$lang['register_mr'].'</option>
                                            <option value="2">'.$lang['register_mrs'].'</option>
                                        </select>
                                </div>
                                <!--end form-group-->
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <label>
                                        <input type="checkbox" name="newsletter" value="1">
                                        '.$lang['register_receive_newsletter'].'
                                    </label>
                                    <button type="submit" onclick="register()" class="btn btn-primary"><div id="resultc"></div> '.$lang['register_register'].'</button>
                                </div>
                            </form>
							<div id="result"></div>
							<br>
                            '.$lang['register_terms_conditions'].'
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
                        <!--end col-md-6-->
                    </div>
                    <!--end row-->
                </div>
                <!--end container-->
            </section>
            <!--end block-->
        </section>
        <!--end content-->';
	  
    include ('includes/footer.php');