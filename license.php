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

	if(file_exists("db/db.php")) {
		require_once('db/db.php');
		ini_set("error_reporting", E_ALL);	
	}
	
	if(!file_exists("db/db.php")) {	
		header("Location: install");
	}	
	
	
echo'<!doctype html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="author" content="Themerig">

			<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Varela+Round" rel="stylesheet">
			<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css">
			<link rel="stylesheet" href="assets/fonts/font-awesome.css" type="text/css">
			<link rel="stylesheet" href="assets/css/selectize.css" type="text/css">
			<link rel="stylesheet" href="assets/css/style.css">
			<link rel="stylesheet" href="assets/css/user.css">

			<title>Craigs CMS - Purchase license check page!</title>

		</head>
		<body>
	<div class="page sub-page">';

    echo'<header class="hero">
		
            <div class="hero-wrapper">
			
                <div class="page-title">
				
                    <div class="container">
						<center>
							<h1>Craigs CMS - Purchase license check page!</h1>
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

                        <div class="col-md-12 center" id="prch_d">
						
                            <h2>Check your purchase license ('.$_SERVER['REMOTE_ADDR'].')</h2>
							
                            <p>
								- The <strong><a style="color:red;" href="install">installation</a></strong> may not be completely finished.
                            </p>
							
                            <p>
								- You may be using an <strong>invalid license.</strong>
                            </p>
							
							<p>
								- If you have removed your license from the management panel,<strong> you will need to install it again.</strong>
							</p>
							
                            <br>
							
                        </div>
						

                    </div>
					
                </div>
				
            </section>
			
        </section>';
	
echo'</div>

	<script src="assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/selectize.min.js"></script>
	<script src="assets/js/masonry.pkgd.min.js"></script>
	<script src="assets/js/icheck.min.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>';
	
	
echo'</body>
</html>';	