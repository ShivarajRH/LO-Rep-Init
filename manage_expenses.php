<!-- SESSION REQUIRED FOR THIS PAGE -->

<?php 
	$metatitle='LyfeOn - Your Expenses !';
	$metadescription='LyfeOn - Manage your expenses across devices.';
	$metaabstract='LyfeOn - your expenses';
	$metasubject='LyfeOn - your expenses';
	$metapagename='LyfeOn - your expenses';
	$metasubtitle='LyfeOn - Manage your expenses';
	$metacopyright=' $fname . &nbsp; . $lname ';
	$robots_index='no-index';
	$robots_follow='no-follow';
	
	$content_target_src='manage_expenses';
?>
<?php include_once 'head.php'; ?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				<?php include_once 'cards/card_expenses_box.php'; ?>
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>