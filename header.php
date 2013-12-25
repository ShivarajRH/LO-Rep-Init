	<?php include_once $global_analytics; ?>
	
	<div class="header">
		<div class="logo_block">
			<a href="">
				<!-- <span class="fl_le" style="margin-top: -.3%;margin-left: -0.3%;">&#9776;</span> -->
				<img class="fl_le logo_image" src="http://commondatastorage.googleapis.com/lyfeon%2Flogos%2Flyfeon_48x48_center_w_less_gamma.png" title="Stream" alt="LyfeOn Logo"></img>
				<span class="fl_le logo_text" title="Stream">LyfeOn</span>
			</a>
		</div>
		<div class="fl_le search_block">
	  		<form name="globalsearchform" action="<?=$site_url?>search/form" method="get">
		  		<input type="text" class="fl_le search_box" placeholder=" Search" autocomplete="off" autofocus > 
				<input type="submit" value="" class="search_icon search_submit" title="Search">
			</form>
		</div>
		<div class="fl_ri menu_drop">
                        <div class="apps_grid_icon fl_ri" id="btn_apps_grid_icon" title="Menu" style="background-size:100%;"></div>
			<!-- ONClick Drop Down http://stackoverflow.com/questions/17091596/how-can-i-close-a-dropdown-menu-with-a-click-anywhere-else-on-the-page-and-remov -->
			<ul class="menu_drop_list" style="display: none;">
				<?php if(isset($_SESSION['uid'])) { ?>
					<li><a href="http://lyfeon.com/u/"><span class="">Profile</span></a></li>
					<li><a href="http://lyfeon.com/manage_reminders/"><span class="">Reminders</span></a></li>
					<li><a href="http://lyfeon.com/manage_expenses/"><span class="">Expenses</span></a></li>
					<li class="divider"></li>
					<li><a href="http://lyfeon.com/business" target="_blank"><span class="">Manage Business</span></a></li>
					<li class="divider"></li>
					<li class="last"><a href=""><span class="">Sign out</span></a></li>
					<li class="divider"></li>
				<?php } ?>
				<li><a href="http://help.lyfeon.com" target="_blank"><span class="">Help</span></a></li>
				<li class="last">
					<a href="https://google.com/+LyfeOn" target="_blank"><span class="">Google+</span></a>
					<div class="g-follow" style="width:50px;height:20px;" data-href="https://plus.google.com/118335972259503633372" data-rel="publisher" data-annotation="none" data-height="24"></div>
						<script type="text/javascript">
							(function() {
							var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							po.src = 'https://apis.google.com/js/plusone.js';
							var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							})();
						</script>
				</li>
			</ul>
		</div>
		<!-- 
		<div class="fl_ri menu_drop notification_block">
			<span class="fl_ri highlight highlight_notification_count">3</span>
			<div class="reminder_bell_icon fl_ri" title="Notifications"></div>
		</div>
		-->
	</div>