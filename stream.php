<?php 
    error_reporting(1);
    ob_start();
    session_start();
    
    if(!isset($_SESSION['uid'])) {
        //header("Status: 404 Not Found");
        header("Location:/?resp=Please_Sign_In");
        exit();
    }

    $fname=isset($_SESSION['fname'])?$_SESSION['fname'] : "";
    $lname=isset($_SESSION['lname'])?$_SESSION['lname'] : "";
    $gid = isset($_SESSION['gid'])?$_SESSION['gid'] : ""; 
    $uid = isset($_SESSION['uid'])?$_SESSION['uid'] : "104219296596850018797";
    $content_target_src='stream';

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
    $load_js['file'] = 'stream';
    
    include 'paths.php';
    include_once 'head.php';
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
                    <input type="hidden" value="<?=$uid;?>" name="uid" id="uid"/>
                    <input type="hidden" value="<?=$content_target_src;?>" name="content_target_src" id="content_target_src"/>
                    <input type="hidden" id="max_notes_count" name="max_notes_count" value=""/>
			<ul id="columns">
				<?php
                                        include_once 'cards/card_creator_box.php';
                                        include_once 'cards/card_reminder_box.php'; 
                                        include_once 'cards/card_expenses_box.php'; 
                                        include_once 'cards/card_discovery_box.php';
				?>
                                <span class="all_note_list_box"></span>
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>