	<?php include_once 'analyticstracking.php'; ?>
	
	<div class="header">
		<div class="logo">
			<a href="">
				<img class="fl_le" src="http://commondatastorage.googleapis.com/lyfeon%2Flogos%2Flyfeon_48x48_center_w_less_gamma.png" style="padding-left:1%;padding-right: 1%;width: 24px;margin-top:-0.3%;height:24px;"/>
				<span class="fl_le" style="padding-left:0.6%;margin-top: -0.2%;">LyfeOn</span>
			</a>
		</div>
		<div class="fl_ri menu_drop">
			<ul>
				<li class="menu_drop_list fl_ri"><a href=""><div class="info_icon" alt="About" title="About"></div></a>
					<ul>
						<li><a href="http://help.lyfeon.com" target="_blank"><span class="">Help</span></a></li>
						<li><a href="/co/services/terms" target="_blank"><span class="">Terms</span></a></li>
						<li><a href="/co/services/contact" target="_blank"><span class="">Contact</span></a></li>
						<li class="last">
							<a href="https://plus.google.com/118335972259503633372/posts" target="_blank">
								<span class="">Google+</span>
							</a>
							<div class="g-follow" style="width:50px;height:20px;" data-href="https://plus.google.com/118335972259503633372" data-rel="publisher" data-annotation="none" data-height="24"></div>
							<!--<script type="text/javascript">
								(function() {
								var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
								po.src = 'https://apis.google.com/js/plusone.js';
								var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
								})();
							</script>-->
						</li>
						<li><a href="/co/services/company" target="_blank"><span class="">Co.</span></a></li>
					</ul>
				</li>
                                <?php
                                if(isset($_SESSION['uid'])) {
                                ?>
                                <li class="menu_drop_list last fl_ri"><a href=""><div class="settings_icon" alt="Settings" title="Settings"></div></a>
                                    <ul>
                                        <li><a href=""><span class="">Account</span></a></li>
                                        <li class="last"><a href="javascript:void(0)" onclick="signOut();"><span class="">Logout</span></a></li>
                                    </ul>
				</li>
                                <?php
                                }
                                ?>
				<li class="menu_drop_list last fl_ri">
					<?php //include_once '/google_plus_signin_button.php'; ?>
				</li>
			</ul>
		</div>
	</div>