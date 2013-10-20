<?php
$metatitle='LyfeOn - Help, Terms and About Us !';
$metadescription='LyfeOn Terms of Service, Privacy, Security, About, Contact and Help';
$metaabstract='LyfeOn - About, Terms and Help';
$metasubject='LyfeOn - About, Terms and Help';
$metapagename='LyfeOn - About, Terms and Help';
$metasubtitle='LyfeOn - Documentation';
$metacopyright='LyfeOn';
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
                                                <!-- Google+ Signin --> <!-- Insert Client ID-->
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
								  document.getElementById('install-button').style.display = 'none';
								}
							</script>
						</div>
						</br>
				</li>
				<li class="pin single_note_card">
					<img src="images/wall.jpg" />
					<h1>Take Notes</h1>
					<p>
						
					</p>
				</li>
				
				<li class="pin single_note_card">
					<img src="images/clock.jpg" />
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
					<img src="images/expenses.jpg" />
					<h1>Track Expenses</h1>
					<p>
						
					</p>
				</li>

			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>