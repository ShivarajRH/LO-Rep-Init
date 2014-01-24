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

    $content_target_src='landing_default';
    
//    $load_css['css']='global';
    include 'paths.php';
    include_once 'head.php'; 
    ?>
<body>
    <!-- Google+ Signin -->
    <script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client:plusone.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
    </script>
        <?php include_once 'header.php'; ?>
        <div class="center">
                </br>
                <div id="wrapper" style="max-width:1400px"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
                        <ul id="columns">
                                <!--<li class="pin single_note_card" style="text-align:center;width:100%;">
                                                <h2 style="color:#dd4b39;"">Get your FREE account</h2>
                                                </br>
                                                <?php// include 'google_plus_signin_button.php'; ?>
                                                </br></br>
                                                <div>
                                                        <div></div>
                                                        <script>
                                                                if (chrome.app.isInstalled) {
                                                                  $('#install-button img').css({"opacity":0.3});
                                                                }
                                                                
                                                        </script>
                                                </div>
                                                </br>
                                </li>-->
                                
                                <li class="pin single_note_card">
                                        <h2 style="color:#dd4b39;"">Get your FREE account</h2>
                                        </br>
                                        <?php include 'google_plus_signin_button.php'; ?>
                                        </br></br>
                                        <div>
                                                <div>
                                                        <a href="https://play.google.com/store/apps/details?id=com.lyfeon.oneapp">
                                                          <span class="google_play_store_icon fl_le" style="width:24px;height:24px;margin-right:5%;" title="Android app on Google Play"></span>
                                                          <span style="color:#000000;">Download on Google Play</span>
                                                        </a>
                                                </div>
                                                <br><br>
                                                <div>
                                                        <span style="cursor:pointer;" onclick="chrome.webstore.install()" id="install-button">
                                                          <span class="google_chrome_icon fl_le" style="width:24px;height:24px;margin-right:5%;" title="Install on Google Chrome"></span>
                                                          <span>Download on Google Chrome</span>
                                                        </span>
                                                </div>
                                                <script>
                                                        if (chrome.app.isInstalled) {
                                                          $('#install-button img').css({"opacity":0.3});
                                                        }
                                                </script>
                                        </div>
                                        </br>
                                </li>
                                
                                
                                <li class="pin single_note_card">
                                        <img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fmanage_money_rep_427x640.jpg" />
                                        <h2>Manage & Save Money</h2>
                                </li>
                                <li class="pin single_note_card">
                                        <img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fnote_leaf_rep_427x640.jpg" />
                                        <h2>Discover & Share Notes</h2>
                                </li>
                                <li class="pin single_note_card">
                                        <img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fshopping_list_rep_427x640.jpg" />
                                        <h2>ToDo and Shopping List</h2>
                                </li>
                        </ul><!-- 
							<p style="font-size:200%;">For Businesses</p>
							<ul id="columns">
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fmanage_business_rep_427x740.png" />
									<h2>Setup your business in minutes</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fcustomers_reach_rep_427x640.jpg" />
									<h2>Manage Business</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fproducts_reach_rep_427x640.jpg" />
									<h2>Showcase your products</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fteam_rep_427x640.png" />
									<h2>Manage Employees</h2>
								</li>
								<li class="pin single_note_card">
									<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fanalytics_rep_427x640.png" />
									<h2>Get Analytics</h2>
								</li>
							</ul>-->
                </div>
        </div>
        <?php include_once 'footer_reg.php'; ?>
</body>