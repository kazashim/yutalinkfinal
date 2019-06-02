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
	
echo'<!doctype html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="author" content="Themerig">

			<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Varela+Round" rel="stylesheet">
			<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" type="text/css">
			<link rel="stylesheet" href="../assets/fonts/font-awesome.css" type="text/css">
			<link rel="stylesheet" href="../assets/css/selectize.css" type="text/css">
			<link rel="stylesheet" href="../assets/css/style.css">
			<link rel="stylesheet" href="../assets/css/user.css">

			<title>Craigs CMS - Welcome to the setup wizard!</title>

		</head>
		<body>
	<div class="page sub-page">';

    echo'<header class="hero">
		
            <div class="hero-wrapper">
			
                <div class="page-title">
				
                    <div class="container">
						<center>
							<h1>Craigs CMS - Welcome to the setup wizard!</h1>
						</center>	
                    </div>
					
                </div>
				
                <div class="background"></div>
				
            </div>
			
        </header>
	
		<section class="content">
		
            <section class="block">
			
                <div class="container">
				
                    <div class="row">
					
                        <div class="col-md-4" id="prch_d">
						
                            <h2>Short description</h2>
                            <p>
                               - Please enter your product <strong>purchase code</strong> in the space on the right hand side.
                            </p>
                            <br>
							
                        </div>
						
                        <div class="col-md-8" id="prch">
						
                            <h2>Purchase Code</h2>
							
                            <form class="form email" onsubmit="return false">
							
                                <div class="row">

                                
								
									<div class="form-group col-md-12">
									
										<input type="text" id="purchase_code"  value="62cb619a-2991-4677-8ad7-000000000000" class="form-control" placeholder="Write the Purchase Code."/>
										
									</div>
									
									<div class="form-group col-md-2">
									
										<button type="submit" id="btn_check_pc" class="btn btn-primary"> <div class="btn_c"></div> License Inquiry</button>

									</div>
									
								</div>	

								<div style="background-color: #eaeaea;" id="error"></div>
                            </form>

                        </div>

					<div id="productContainer" class="row">	
						
						
                        <div class="col-md-3">
						
                        </div>
						
                        <div style="display:none;right:1300px;" class="col-md-6 containers" id="dtbs">
						
                    

							<h3 class="buyer box"></h3>
							
							<form class="form email" onsubmit="return false" id="s_imp">
									
								<div class="row">	
								
									<div class="form-group col-md-12">
										<label for="s_url" class="col-form-label">Site Url e.g (example.com)</label>
										<input name="s_url" type="text" class="form-control" placeholder="example.com">
									</div>
								
									<div class="form-group col-md-6">
										<label for="d_localhost" class="col-form-label">MySQL Hostname</label>
										<input name="d_localhost" type="text" class="form-control" value="localhost">
									</div>
											
									<div class="form-group col-md-6">
										<label for="d_name" class="col-form-label">MySQL Database Name</label>
										<input name="d_name" type="text" class="form-control" placeholder="MySQL Database Name">
									</div>

									<div class="form-group col-md-6">
										<label for="d_username" class="col-form-label">MySQL Database User</label>
										<input name="d_username" type="text" class="form-control" placeholder="MySQL Database User">
									</div>

									<div style="display:none" id="p_code" class="purchase_code"></div>
									<div style="display:none" id="a_buyers" class="buyers"></div>
									<div style="display:none" id="a_item_id" class="item_id"></div>

									<div class="form-group col-md-6">
										<label for="d_password" class="col-form-label">MySQL Database Password</label>
										<input name="d_password" type="text" class="form-control" placeholder="MySQL Database Password">
									</div>
									
									<hr style="color: #f00;background-color: #ccc;height: 1px;border: 0;width: 94%;box-shadow: 0 0.2rem 1rem rgba(160, 153, 153, 0.31);">
									
									
									<div class="form-group col-md-2">
									
										<button type="submit" onclick="sql_imp()" class="btn btn-primary"><div id="resultc_db"></div> Start setup</button>

									</div>

								</div>	
								
								<div style="display:none;padding-bottom: 13px;background-color: #eaeaea;" id="result_db"></div>
							</form>


                        </div>
						
						
					</div>	
						
						
                    </div>
					
                </div>
				
            </section>
			
        </section>';
	
echo'</div>

	<script src="../assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../assets/js/popper.min.js"></script>
	<script type="text/javascript" src="../assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/selectize.min.js"></script>
	<script src="../assets/js/masonry.pkgd.min.js"></script>
	<script src="../assets/js/icheck.min.js"></script>
	<script src="../assets/js/jquery.validate.min.js"></script>
	<script src="../assets/js/check.js"></script>';
	
	@$users = $db -> query("SELECT * FROM users WHERE st = 1")->fetch();
	
	if (empty($users)) {
		
	echo'<script>
	
		var oneMoreTime = 1;
		
			
			var val = $("form#s_imp").serialize();
			
			myDivObj = document.getElementById("p_code");

			var n1 = document.getElementById("a_buyers").innerHTML;
			
			if( oneMoreTime == 1 ) {
				oneMoreTime = 0;

				$.ajax({
					type: "POST",
					url: "getIndex.php?p_code=" + myDivObj.innerHTML+"&a_buyer="+n1,
					data: val,
					beforeSend: function () {
							
						$(".containers").css("opacity", ".5");
						oneMoreTime = 1;
					},
					success: function (html) {
							
						$("#productContainer").html(html);
						$(".containers").css("opacity", "");
							
						$( "#prch" ).remove();	

						$( "#prch_d" ).remove();									

						oneMoreTime = 1;
					}
				});
			}

		</script>';
		
	} else {
		header("Location: ../signin.php");
	}
	
echo'</body>
</html>';	