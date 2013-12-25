<?php 
    session_start();
    if(isset($_SESSION['uid'])) {
        //header("Status: 404 Not Found");
        header("Location:/stream?");
        exit();
    }
    $fname="";
    $lname='';
    $gid = '';
    
        $metatitle='LyfeOn - Turn your life back ON !';
        $metadescription='LyfeOn helps you do things quickly and easily. Manage your notes, reminders and expenses across all your devices.';
        $metaabstract='LyfeOn - Login / Signup';
        $metasubject='LyfeOn - Login / Signup';
        $metapagename='LyfeOn - Login / Signup';
        $metasubtitle='LyfeOn - Manage your life';
        $metacopyright='LyfeOn';
        
        $robots_index='index';
        $robots_follow='follow';
        $load_js['global_js'] = 'global_scripts';
        $twitter_card_content='app';
        $image_url='http://commondatastorage.googleapis.com/lyfeon%2Flogos%2Flyfeon_300x300_center.png';
        $image_width='300';
        $image_height='300';
        
//        $load_css['css']='global';
        include 'paths.php';
        include_once 'head.php'; ?>
<!-- Google+ Signin -->
<script type="text/javascript">
  (function() {
   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
   po.src = 'https://apis.google.com/js/client:plusone.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
</script>
<body>
        <?php include_once 'header.php'; ?>
        <div class="center">
                </br>
                <div id="wrapper" style="max-width:1400px"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
                        <ul id="columns">
                                <li class="pin single_note_card" style="text-align:center;width:100%;">
                                				<h2 style="color:#dd4b39;"">Get your FREE account</h2>
                                                </br>
                                                <?php include 'google_plus_signin_button.php'; ?>
                                                </br></br>
                                                <div style="text-align:center;width:100%;">
                                                        <a href="https://play.google.com/store/search?q=pub:LyfeOn">
                                                          <div class="google_play_store_icon fl_le" style="width:24px;height:24px;margin-right:5%;" title="Android app on Google Play"></div>
                                                        </a>
                                                        <span style="cursor:pointer;" onclick="chrome.webstore.install()" id="install-button">
                                                          <div class="google_chrome_icon fl_le" style="width:24px;height:24px;margin-right:5%;" title="Install on Google Chrome"></div>
                                                        </span>
                                                        <script>
                                                                if (chrome.app.isInstalled) {
                                                                  $('#install-button img').css({"opacity":0.3});
                                                                }
                                                                
                                                        </script>
                                                </div>
                                                </br>
                                </li>
                                <li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fpaperclip_rep_427x640.jpg" />
									<h2>Take Notes</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fmanage_money_rep_427x640.jpg" />
									<h2>Track Expenses and Save Money</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fnote_leaf_rep_427x640.jpg" />
									<h2>Discover & Share</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Freminder_rep_427x640.jpg" />
									<h2>Set Reminders</h2>
								</li>
								<!-- 
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fproducts_reach_rep_427x640.jpg" />
									<h2>Get wider reach for your Business</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fmanage_business_rep_427x740.png" />
									<h2>Manage Employees and Products</h2>
								</li>
								-->

                        </ul>
                </div>
        </div>
        <?php include_once 'footer_reg.php'; ?>
</body>