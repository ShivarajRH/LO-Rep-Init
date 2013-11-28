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
?>

<?php include_once 'head.php'; ?>
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
                                                </br>
						<?php include 'google_plus_signin_button.php'; ?>
						</br></br>
						<div style="text-align:center;width:100%;">
							<a href="https://play.google.com/store/search?q=pub:LyfeOn">
							  <img  class="fl_le" style="width:24px;height:24px;margin-right:5%;"  alt="Android app on Google Play"
								   src="assets/images/Google_Play_Store_48.png" />
							</a>
							<span style="cursor:pointer;" onclick="chrome.webstore.install()" id="install-button">
							  <img  class="fl_le" style="width:24px;height:24px;"  alt="Chrome app on Chrome Webstore"
								   src="assets/images/chrome-24.png" />
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
					<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fnote_rep_427x640.jpg" />
					<h1>Take Notes</h1>
					<p>

					</p>
				</li>
				
				<li class="pin single_note_card">
					<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Freminder_rep_427x640.jpg" />
					<h1>Set Reminders</h1>
					<p>
						
					</p>
				</li>
				<li class="pin single_note_card">
					<h2>Awesome things coming soon ..</h2>
					<p>
						
					</p>
				</li>
				<li class="pin single_note_card">
					<img src="http://commondatastorage.googleapis.com/lyfeon%2Fimages%2Freps%2Fexpenses_rep_427x640.jpg" />
					<h1>Track Expenses</h1>
					<p>
						
					</p>
				</li>

			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>