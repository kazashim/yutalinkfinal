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
	
	if(file_exists("../db/db.php")) {
		
		require_once('../db/func.php');
		require_once('../db/db.php');
		ini_set("error_reporting", E_ALL);	
	
	}
				echo'<div class="col-md-3">
				
                    </div>
						
                        <div class="col-md-6 containers" id="dtbs">
	
							<h4 class="box"><i style="color: #28bf1f;box-shadow: 0 0.1rem 2rem rgb(4, 255, 0);border-radius:  50%;" class="fa fa-circle"></i> <a target="_blank" href="http://'.$site_url.'">'.ucwords($site_url).'</a> domain name licensing succeeded</h4>
							
							<form class="form email" onsubmit="return false" id="admin_imp">
									
								<div class="row">	
								
									<div class="form-group col-md-6">
										<label for="a_fullname" class="col-form-label">Fullname</label>
										<input name="a_fullname" type="text" class="form-control" placeholder="Fullname">
									</div>
								
									<div class="form-group col-md-6">
										<label for="a_username" class="col-form-label">Username</label>
										<input name="a_username" type="text" value="'.$envato_username.'" class="form-control" placeholder="Username">
									</div>

									<div style="display:none" id="p_code" class="purchase_code">'.$purchase_code.'</div>
									<input name="site_url" type="hidden" value="'.$site_url.'">
									<input name="a_buyer" type="hidden" value="'.$envato_username.'">

									<div class="form-group col-md-6">
										<label for="a_email" class="col-form-label">Admin Email Address</label>
										<input name="a_email" type="email" class="form-control" placeholder="Admin Email Address">
									</div>

									<div class="form-group col-md-6">
										<label for="a_password" class="col-form-label">Admin Password</label>
										<input name="a_password" type="password" class="form-control" placeholder="Admin Password">
									</div>
									
									<hr style="color: #f00;background-color: #ccc;height: 1px;border: 0;width: 94%;box-shadow: 0 0.2rem 1rem rgba(160, 153, 153, 0.31);">
									
									
									<div class="form-group col-md-2">
									
										<button type="submit" onclick="reg_adminis()" class="btn btn-primary"><div id="resultc_db"></div> Create an administrator</button>

									</div>

								</div>	
								
								<div style="display:none;padding-bottom: 13px;background-color: #eaeaea;" id="result_db"></div>
							</form>


                        </div>';