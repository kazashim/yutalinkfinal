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
			<div class="page sub-page">
				<header class="hero">
					<div class="hero-wrapper">';
						include('includes/nav.php');
					echo'<div class="main-navigation">
							<div class="container">
								<nav class="navbar navbar-expand-lg navbar-light justify-content-between">
									<a class="navbar-brand" href="index.php">';
							if (!empty($settings['logo_two'])) {
								echo'<img src="'.$settings['logo_two'].'" alt="">';
							} 
                        echo'</a>
									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
										<span class="navbar-toggler-icon"></span>
									</button>';
									include("includes/navbar.php");
							echo'</nav>
							
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">'.$lang['home'].'</a></li>
									<li class="breadcrumb-item active">'.$header_title.'</li>
								</ol>
							</div>
						</div>';