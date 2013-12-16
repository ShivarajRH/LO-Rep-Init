<?php 
    error_reporting(1);
    ob_start();
    session_start();
    $sess_uid='';
    if(isset($_SESSION['uid'])) {
        
        $sess_uid = $_SESSION['uid'];
        if(isset($_GET['uid'])) { //show someones or his own profile
            $uid = isset($_GET['uid'])?$_GET['uid']:"104219296596850018797";
            if($uid_visit == $uid){
                //show all details
                //else 
                // show only note & profile details
            }
        }
//        else show user profile
        
    }
    else {
        if(isset($_GET['uid'])) {
            
        }
        if(isset($_SESSION['uid'])) {
            
        }
        else {
            
        }
        $uid_visit=$_SESSION['uid'];
        //and if session is set
        $uid = isset($_SESSION['uid'])?$_SESSION['uid']:"104219296596850018797";
        
    }

    $fname=isset($_SESSION['fname'])?$_SESSION['fname']:"";
    $lname=isset($_SESSION['lname'])?$_SESSION['lname']:"";
    $gid = isset($_SESSION['gid'])?$_SESSION['gid']:""; 
    //$uid = isset($_SESSION['uid'])?$_SESSION['uid']:"104219296596850018797";
    $content_target_src='u';
    
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
        $load_js['u'] = 'user_profile';
	
?>
<?php include 'paths.php'; ?>
<?php include_once 'head.php'; ?>
<body>
	<?php include_once 'header.php'; ?>
	<div class="center">
		</br>
		<div id="wrapper"> <!-- http://cssdeck.com/labs/css-only-pinterest-style-columns-layout -->
                    <input type="hidden" value="<?=$uid;?>" name="uid" id="uid"/>
                    <input type="hidden" value="<?=$content_target_src;?>" name="content_target_src" id="content_target_src"/>
                    <input type="hidden" id="max_notes_count" name="max_notes_count" value=""/>
                    <input type="hidden" value="<?=$sess_uid;?>" name="sess_uid" id="sess_uid"/>
                    
			<ul id="columns">
				<?php 
                                    include_once 'cards/user_profile_card.php';

                                    if(isset($_SESSION['uid'])) { 
                                            include_once 'cards/card_expenses_box.php';
                                            include_once 'cards/card_reminder_box.php';
                                    }
                                        
                                       // $total_reminders=count($result['reminders']);
//                                        include_once 'cards/card_reminder_box.php'; 
                                        ?>
                            
                                        <!--<div class="reminders_block"></div>-->
                            <?php            
                                        //$expenses_filter_total = $result['expense_total'];
//                                        include_once 'cards/card_expenses_box.php';
                                        
                                    /*  $max_notes_count = count($result['notes']);
					if($max_notes_count==0) {
                                                $max_notes_count=1;
                                                $note_text='';
                                                $note_image='';
                                        }
					foreach($result['notes'] as $note) {
                                            	$content_id= $note['content_id'];
						$note_id= $note['note_id'];
						$note_text = $note['note_text'];
						$note_image='';
						$note_options_req='yes';
					} */
                                       //include 'cards/card_note_box.php';
                                        
				?>
                                <span class="all_note_list_box"></span>
                                <!--<div class="stream_replace_content"></div>-->
			</ul>
		</div>
	</div>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>