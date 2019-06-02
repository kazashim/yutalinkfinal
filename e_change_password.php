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

    $fo = 'Forget';
    if ($_GET['do'] != $fo) { 
		header("Location: /"); 
    }	
	
	if (!empty($_SESSION['session'])) {
		header("Location: index.php");
	}
	
          echo '<div class="page-title">
                    <div class="container">
                        <h1 id="e_f_title">'.$lang[$te].'</h1>
						<h1 style="display:none;" id="e_signin_title">'.$lang['signin'].'</h1>
                    </div>
                </div>

                <div class="background"></div>
				
            </div>
        </header>';
		
	$do = @$_GET['do'];
	Switch ($do) {
		
		case'Forget';
		$token = $db -> query("SELECT * FROM users WHERE token='{$_GET['token']}'")->fetch();
		
		if (!empty($token)) {
			
	echo'<section class="content">
		
            <section class="block">
			
                <div class="container">
				
                    <div class="row" id="sign">';
					
                    echo'<div class="col-md-12" id="loginlink_reset">
					
                            <form class="form" onsubmit="return false" id="e_f_password">
							
                                <div class="row justify-content-center">
								
                                    <div class="col-md-5">

										<input name="e_token" value="'.$token['token'].'" type="hidden"/>
									
                                        <div class="form-group new_current_password">
                                            <label for="new_current_password" class="col-form-label required">'.$lang['change_new_password'].'</label>
                                            <input name="new_current_password" type="password" class="form-control" id="new_current_password" placeholder="'.$lang['change_your_new_password'].'" >
											<span class="input-group-addon"><i id="new_current_password_c" class="fa fa-lock"></i></span>
                                        </div>
										
                                        <div class="form-group repeat_new_current_password">
                                            <label for="repeat_new_current_password" class="col-form-label required">'.$lang['change_repeat_password'].'</label>
                                            <input name="repeat_new_current_password" type="password" class="form-control" id="repeat_new_current_password" placeholder="'.$lang['change_your_repeat_password'].'">
											<span class="input-group-addon"><i id="repeat_new_current_password_c" class="fa fa-lock"></i></span>
                                        </div>
										
                                        <section class="clearfix">
											<button type="submit" onclick="e_change_password()" class="btn btn-primary float-right"><div id="resultc_e_change"></div> '.$lang['change_change_password'].'</button>
										</section>
										
										<div id="result_e_change"></div>
                                    </div>
    
									
                                </div>
								
                            </form>
							
                        </div>';
						

                    echo'<div class="col-md-12" style="display:none;" id="loginlink_signin">

                            <form class="form" onsubmit="return false" id="signin">
							
								<div class="row justify-content-center">
								 
									<div class="col-md-5">
									
										<div class="form-group">
											<label for="email" class="col-form-label">'.$lang['signin_email'].'</label>
											<input name="email" type="email" id="email_f" class="form-control" placeholder="'.$lang['signin_your_email'].'" >
											<span class="input-group-addon"><i id="email" class="fa fa-user"></i></span>
										</div>
										
										<div class="form-group">
											<label for="password" class="col-form-label">'.$lang['signin_password'].'</label>
											<input name="password" type="password" class="form-control" id="password_f" placeholder="'.$lang['signin_your_password'].'" >
											<span class="input-group-addon"><i id="password" class="fa fa-lock"></i></span>
										</div>
										
										<div class="d-flex justify-content-between align-items-baseline">
											<label>
												<input type="checkbox" name="remember" value="1">
												'.$lang['signin_remember_me'].'
											</label>
											<button type="submit" onclick="signin()" class="btn btn-primary"><div id="resultc"></div>'.$lang['signin_signin'].'</button>
										</div>
										<div id="result"></div>
									</div>
									
								</div>	
								
                            </form>
							
							
							
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
							
                        </div>';
						
                echo'</div>

                </div>

            </section>

        </section>';
		
		} else { 
		
			header("Location: /"); 
			
		}  
	  
	}
	  
    include ('includes/footer.php');