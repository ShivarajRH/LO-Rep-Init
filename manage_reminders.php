<?php ob_start();
    session_start();
    if(!isset($_SESSION['uid'])) {
        //header("Status: 404 Not Found"); // has effect of returning 404 status for browser no output shoud echo after
        //echo '<script>alert("Please login");</script>';
        header("Location:/?resp=Please_Sign_In");
        exit();
    }
    $fname=isset($_SESSION['fname'])?$_SESSION['fname']:"";
    $lname=isset($_SESSION['lname'])?$_SESSION['lname']:"";
    $gid = isset($_SESSION['gid'])?$_SESSION['gid']:"";
    $uid = isset($_SESSION['uid'])?$_SESSION['uid']:"104219296596850018797";
    $content_target_src='manage_reminders';
    
	$metatitle='LyfeOn - Your Reminders !';
	$metadescription='LyfeOn - Manage your reminders across devices.';
	$metaabstract='LyfeOn - your reminders';
	$metasubject='LyfeOn - your reminders';
	$metapagename='LyfeOn - your reminders';
	$metasubtitle='LyfeOn - Manage your reminders';
	
        $metacopyright=$fname . " " . $lname;
        
        $robots_index='no-index';
	$robots_follow='no-follow';

        $load_js['global_js'] = 'global_scripts';
        $load_js['stream'] = 'stream';
	
	
?>
<?php include_once 'head.php'; ?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
                </br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
                    <input type="hidden" value="<?=$uid;?>" name="uid" id="uid"/>
                    <input type="hidden" value="<?=$content_target_src;?>" name="content_target_src" id="content_target_src"/>
			<ul id="columns">
                            	<?php include_once 'cards/card_reminder_box.php'; ?>
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>