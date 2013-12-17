<?php
    error_reporting(1);
    ob_start();
    session_start();
    $sess_uid='';
    include 'includes/myclasses.php';
    $site_url='http://'.(($_SERVER['HTTP_HOST'] == 'localhost:13080')?"localhost:13080":$_SERVER['HTTP_HOST'])."/";

    if(isset($_SESSION['uid'])) {
        
        $sess_uid = $uid = $_SESSION['uid'];
        if(isset($_GET['uid'])) { //show someones or his own profile
            $uid_visit = isset($_GET['uid'])?$_GET['uid']:"104219296596850018797";
            if($uid_visit == $uid){
                //show all details
                //else 
                // show only note & profile details
                $ob = new myactions();

                $uid = urldecode($_GET['uid']);
                $url=$site_url.'api/search/?action_object=user_profile&uid='.$uid;
                $rprofile = $ob->getApiContent($url,"json");
                $rprofile=$rprofile[0];

            }
        }
        else {
            $rprofile = $_SESSION;
            
        }
//        else show user profile
    }
    else {
        
        if(isset($_GET['uid'])) { //show someones or his own profile
                $uid = isset($_GET['uid'])? urldecode($_GET['uid']) :"104219296596850018797";
                
                // show only note & profile details
                $ob = new myactions();
                
                $url=$site_url.'api/search/?action_object=user_profile&uid='.$uid;
                
                $rprofile = $ob->getApiContent($url,"json");
                $rprofile=$rprofile[0];
//                echo '<pre>';print_r($rprofile);die("Testing");
        }
                
    }


    
//            echo '<pre>';print_r($rprofile); die();
        $gid = $rprofile['gid']; 
        $name=$rprofile['name'];
        $fname=isset($rprofile['fname'])?$rprofile['fname']: "";
        $lname=isset($rprofile['lname'])?$rprofile['lname']:"";
        $currency=isset($rprofile['currency'])?$rprofile['currency']:"";
        $img_url=isset($rprofile['img_url'])?$rprofile['img_url']:"https://lh5.googleusercontent.com/-uEEWBbYe0IY/AAAAAAAAAAI/AAAAAAAACME/a1-LUkWDEIY/photo.jpg?sz=50";
        
        //$uid=$arr_notes['uid'];
        $uid_visit=$uid;


    
//    $fname=isset($_SESSION['fname'])?$_SESSION['fname']:"";
//    $lname=isset($_SESSION['lname'])?$_SESSION['lname']:"";
//    $gid = isset($_SESSION['gid'])?$_SESSION['gid']:""; 
    //$uid = isset($_SESSION['uid'])?$_SESSION['uid']:"104219296596850018797";
        
    $content_target_src='u';
    
	$metatitle='LyfeOn - '.$name.' \'s Stuff';
	$metadescription='LyfeOn - '.$name.' \'s Stuff';
	$metaabstract='LyfeOn - '.$name.' \'s Stuff';
	$metasubject='LyfeOn - '.$name.' \'s Stuff';
	$metapagename='LyfeOn - '.$name.' \'s Stuff';
	$metasubtitle='LyfeOn - '.$name.' \'s Stuff';
       
	$metacopyright=$fname." ".$lname;
        
        $robots_index='index';
	$robots_follow='follow';

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
                                    include_once 'cards/card_profile_box.php';

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