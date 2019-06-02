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
	
	$user_id = $users['id'];
	
	if (!empty($_GET["message"])) {
		
		$query = $db->query("SELECT * FROM users WHERE username = '".$_GET["message"]."'", PDO::FETCH_ASSOC);
		
		if ($query->rowCount()) {
			
			$_GET_message = $_GET["message"];
			
		} else {
			
			header('location: messaging.php');
			
		}
		
	} else {
		
		$_GET_message = "";
		
	}
	
	$getUser = veriCek("users", "id, username, fullname, picture, gender", "username", $_GET_message);

	echo '<div class="page-title">
                    <div class="container">
                        <h1>'.$lang[$te].'</h1>
                    </div>
                </div>

                <div class="background"></div>
            </div>
        </header>

        <section class="content">
            <section class="block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-xl-4">

                            <div class="section-title clearfix">
                                <h3>'.$lang['mes_people'].'</h3>
                            </div>
                            <div id="messaging__chat-list" class="messaging__box">

                                <div class="messaging__content">
                                    <ul class="messaging__persons-list message-list">
										<center><p style="padding:50px;font-size:20px;"><i class="fa fa-users"></i> '.$lang['mes_no_user'].'</p></center>
                                    </ul>
                                </div>


                            </div>
                            <!--end section-title-->
                        </div>
                        <div class="col-md-7 col-lg-7 col-xl-8">
  
                            <div class="section-title clearfix">
                                <h3>'.$lang['mes_message_window'].'</h3>
                            </div>';
                            
							if (!empty($_GET['message'])) {
							
						  echo '<div id="messaging__chat-window" class="messaging__box">
                                <div class="messaging__header" id="messaging_scroll">
                                    <div class="float-left flex-row-reverse messaging__person">
                                        <h5 class="font-weight-bold"><a target="_blank" href="profile_detail.php?users='.$getUser["username"].'">'.$getUser["fullname"].'</a><div class="message_type" style="display: none"><div class="messaging__main-chat__bubble"><p style="text-decoration: underline;text-align: -webkit-match-parent;font-weight: bold;color: green;margin-bottom: -6px;">'.$lang['mes_writing'].'</p></div></div></h5>';

										if (!empty($getUser['picture'])) {
											echo'<figure class="mr-4 messaging__image-person" data-background-image="'.$getUser["picture"].'"></figure>';
										} else {
											if ($getUser['gender'] == "1") { 
												echo'<figure class="mr-4 messaging__image-person" data-background-image="assets/img/picture/no_picture_mr.png"></figure>';
											} else if ($getUser['gender'] == "2") { 
												echo'<figure class="mr-4 messaging__image-person" data-background-image="assets/img/picture/no_picture_mrs.png"></figure>';
											}
										}
                                echo'</div>
                                    <div class="float-right messaging__person">
                                        <h5 class="mr-4">'.$lang['mes_you'].'</h5>';
										if (!empty($users['picture'])) {
											echo'<figure id="messaging__user" class="messaging__image-person" data-background-image="'.$users['picture'].'"></figure>';
										} else {
											if ($users['gender'] == "1") { 
												echo'<figure class="mr-4 messaging__image-person" data-background-image="assets/img/picture/no_picture_mr.png"></figure>';
											} else if ($users['gender'] == "2") { 
												echo'<figure class="mr-4 messaging__image-person" data-background-image="assets/img/picture/no_picture_mrs.png"></figure>';
											}
										}
                                echo'</div>
                                </div>
								
								<div class="messaging__content" data-background-color="rgba(0,0,0,.05)">
                                    <div class="messaging__main-chat main-chat-form">

                                    </div>
									

                                </div>
								
								
                                <div class="messaging__footer">
                                    <form class="form reply-form">
                                        <div class="input-group">
											<input type="hidden" name="type" value="comment" />
											<input type="hidden" name="user_id" value="'.$user_id.'" />
											<input type="hidden" name="target_id" value="'.$_GET_message.'" />
											<input type="hidden" name="product_id" value="'.@$_GET["product_id"].'" />
                                            <input type="text" name="message" id="messaging_focus" class="form-control mr-4 this-message" placeholder="'.$lang['mes_write_something'].'">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary send-comment" type="submit"><div id="resultc"></div> '.$lang['mes_send'].' <i class="fa fa-send ml-3"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>';
								} else {
									echo '
                            <div id="messaging__chat-window" class="messaging__box">
                                <div class="messaging__header">
                                    <div class="float-left flex-row-reverse messaging__person">
                                        <h5 class="font-weight-bold">'.$lang['mes_dialog_user'].'</h5>
                                        <figure class="mr-4 messaging__image-person" data-background-image="assets/img/picture/no_picture_mrs.png"></figure>
                                    </div>
                                    <div class="float-right messaging__person">
                                        <h5 class="mr-4">'.$lang['mes_you'].'</h5>
                                        <figure id="messaging__user" class="messaging__image-person" data-background-image="assets/img/picture/no_picture_mr.png"></figure>
                                    </div>
                                </div>
                                <div class="messaging__content" data-background-color="rgba(0,0,0,.05)">
                                    <div class="messaging__main-chat">
										<div class="no-messages">
											  '.$lang['mes_go_to_the_ad_you_need'].'
											  <h1 style="padding-top:13px;" ><i class="fa fa-pencil-square-o"></i></h1>
											   '.$lang['mes_and_start_dialog'].'
									    </div>
                                    </div>
                                </div>
                                <div class="messaging__footer">
                                    <form class="form reply-form" onsubmit="return false">
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-4" onkeydown="Wo_SubmitForm(event);" onfocus="Wo_SubmitForm(event);" placeholder="'.$lang['mes_write_something'].'" disabled="" disabled>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary">'.$lang['mes_send'].' <i class="fa fa-send ml-3"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>';
								}

					echo' </div>

                    </div>

                </div>

            </section>

        </section>';
	  
    include ('includes/footer.php');
echo'<script>
        $("#messaging__chat-window .messaging__content").scrollTop( $(".messaging__content")[0].scrollHeight );
    </script>

	<script type="text/javascript" src="assets/js/comment.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {
		
		var loaded = 0;
		var divPos = $(".main-chat-form").height();
		var count = 20;

		$(".messaging__content").scrollTop($(".main-chat-form").height());
		controlType();
		refreshChat();
		refreshMessageList();
		
		$(".this-message").on("input",function(e) {
			var comment = $(".this-message").val();
			
			$.ajax({
				type: "POST",
				url: "includes/comment.php",
				data: {"type":"setmessage", "comment":comment, "user_id":"'.$user_id.'", "target_id":"'.$_GET_message.'"},
				dataType: "json"
			});
		});
		
		function controlType() {
			
			$.ajax({
				type: "POST",
				url: "includes/comment.php",
				data: {"type":"getmessage", "user_id":"'.$user_id.'", "target_id":"'.$_GET_message.'"},
				dataType: "json",
				success: function(data) {
					if( data.content == "1" ) {
						$(".message_type").css("display", "block");
					} else {
						$(".message_type").css("display", "none");
					}
					
					setTimeout(function(){ controlType(); }, 1000);
				}
			});
		}
		
		function refreshChat() {
			
			$.ajax({
				type: "POST",
				url: "includes/comment.php",
				data: {"type":"refresh", "user_id":"'.$user_id.'", "target_id":"'.$_GET_message.'", "count":count},
				dataType: "json",
				success: function(data) {
					$(".main-chat-form").html(data.content);
					
					if( loaded == 0 ) {
						if( divPos != $(".main-chat-form").height()) {
							$(".messaging__content").scrollTop($(".main-chat-form").height() - divPos);
							divPos = $(".main-chat-form").height();
						}
						loaded = 1;
						
					}
					
					setTimeout(function(){ refreshChat(); }, 1000);
					
				}
			});
		}
		
		function refreshMessageList() {
			
			$.ajax({
				type: "POST",
				url: "includes/comment.php",
				data: {"type":"messagelist", "user_id":"'.$user_id.'"},
				dataType: "json",
				success: function(data) {
					$(".message-list").html(data.content);
					$(".message-list-count").html(data.count);
					setTimeout(function(){ refreshMessageList(); }, 2000);
				}
			});
		}
		
		$(".messaging__content").scroll(function() {
			if( $(this).scrollTop() < 1 ) {
				count += 20;
				loaded = 0;
			}
		});
		
	});
	</script>';