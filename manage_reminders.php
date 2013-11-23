<!-- SESSION REQUIRED FOR THIS PAGE -->

<?php 
	$metatitle='LyfeOn - Your Reminders !';
	$metadescription='LyfeOn - Manage your reminders across devices.';
	$metaabstract='LyfeOn - your reminders';
	$metasubject='LyfeOn - your reminders';
	$metapagename='LyfeOn - your reminders';
	$metasubtitle='LyfeOn - Manage your reminders';
	$metacopyright=' $fname . &nbsp; . $lname ';
	$robots_index='no-index';
	$robots_follow='no-follow';
	
	$content_target_src='manage_reminders';
?>
<?php include_once 'head.php'; ?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				<?php include_once '/cards/card_reminder_box.php'; ?>
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>