<?php ob_start();
    session_start();
    if(!isset($_SESSION['uid'])) {
        //header("Status: 404 Not Found"); // has effect of returning 404 status for browser no output shoud echo after
        //echo '<script>alert("Please login");</script>';
        header("Location:/?resp=Please_Sign_In");
        exit();
    }
    $fname=$_SESSION['fname'];
    $lname=$_SESSION['lname'];
    $gid = $_SESSION['gid'];
    
	$metatitle='LyfeOn - Your Stuff !';
	$metadescription='LyfeOn - Access your notes, reminders and expenses and manage them across devices.';
	$metaabstract='LyfeOn - your notes, reminders and expenses';
	$metasubject='LyfeOn - your notes, reminders and expenses';
	$metapagename='LyfeOn - your notes, reminders and expenses';
	$metasubtitle='LyfeOn - Manage your stuff';
       
	$metacopyright=$fname . " " . $lname;
        
        $robots_index='no-index';
	$robots_follow='no-follow';

        $load_js['global_js'] = 'global_scripts';
        $load_js['stream'] = 'stream';
	$content_target_src='stream';
?>
<?php include '/paths.php'; ?>
<?php include_once 'head.php'; ?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
			<ul id="columns">
				<?php include_once '/cards/card_creator_box.php'; ?>
				<?php include_once '/cards/card_reminder_box.php'; ?>
				<?php include_once '/cards/card_expenses_box.php'; ?>
				<?php 
                                    
					$max_notes_count = $total_records_count;
					if($max_notes_count==0)
                                        {
                                                $max_notes_count=1;
                                                $note_text='';
                                                $note_image='';
                                        }
                                        //http://lyfeon.com/api/search/?action_object=list_content&uid=6585877897&content_type=note
					for($note_item_count==1;$note_item_count<=$max_notes_count;$note_item_count++)
					{
						$content_id= /*note content id*/
						$note_id= /*note id*/
						$note_text;
						$note_image;
						$note_options_req='yes';
						include_once '/cards/card_note_box.php';
					}
				?>
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>