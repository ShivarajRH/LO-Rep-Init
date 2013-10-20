<?php 
	$metatitle='LyfeOn - Your Stuff !';
	$metadescription='LyfeOn - Access your notes, reminders and expenses and manage them across devices.';
	$metaabstract='LyfeOn - your notes, reminders and expenses';
	$metasubject='LyfeOn - your notes, reminders and expenses';
	$metapagename='LyfeOn - your notes, reminders and expenses';
	$metasubtitle='LyfeOn - Manage your stuff';
	$metacopyright=' $fname . &nbsp; . $lname ';
?>
<?php include_once 'head.php'; ?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				<?php include_once 'cards/creator_box_card.php'; ?>
				<?php include_once 'cards/reminder_list_card.php'; ?>
				<?php include_once 'cards/expenses_list_card.php'; ?>
				<?php 
					/* Fetch notes for this user and display cards in loop */
					for($usernote==1;$usernote<=$totalusernotes;$usernote++)
					{
						$content_id= /*note content id*/
						$note_id= /*note id*/
						include_once 'cards/note_single_stream_card.php';
					}
				?>
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>