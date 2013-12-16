<?php 
    error_reporting(1);
    ob_start();
    session_start();
    
    $fname=isset($_SESSION['fname'])?$_SESSION['fname']:"";
    $lname=isset($_SESSION['lname'])?$_SESSION['lname']:"";
    $gid = isset($_SESSION['gid'])?$_SESSION['gid']:""; 
    $uid = isset($_SESSION['uid'])?$_SESSION['uid']:"104219296596850018797";
    
    $site_url='http://'.(($_SERVER['HTTP_HOST'] == 'localhost:13080')?"localhost:13080":$_SERVER['HTTP_HOST'])."/";
    
    $load_js['global_js'] = 'global_scripts';
//        $load_js['stream'] = 'stream';
        
    include 'includes/myclasses.php';
    $ob = new myactions();
    $content_id=  urldecode($_GET['cid']);
    $url=$site_url.'api/search/?action_object=single_content&content_id='.$content_id.'&content_type=note';
    $content = $ob->getApiContent($url,"json");
    $arr_notes = $content['notes'][0];
//    echo '<pre>';  print_r($arr_notes); die();// uid,content_id,file_id,visibility
    
    $visibility = $arr_notes['visibility'];
    $uid=$arr_notes['uid'];
    $uid_visit=$uid;
    $note_id=$arr_notes['note_id'];
    $content_id= $arr_notes['content_id'];
    $file_id = '';
    $note_text=$arr_notes['note_text'];
    $note_image='';

    if ($visibility == 'pri') {
                    
            if(isset($_SESSION['email']))
            {
                    if($uid==$uid_visit) //if owner 
                    {
                        if($note_options_req=='yes') {
                                include 'cards/note_options.php';
                                $get_note_options = get_note_options();
                        }
                    }
                    else {//if not owner 
                        $note_image='';
                        $note_text='Oops ! The content you have requested is private.';
                    }

            }
            else {

                    $note_image='';
                    $note_text='Oops ! The content you have requested is private.';
            }
    }
    elseif ($visibility == 'pub') {
            if(isset($_SESSION['email']))
            {
                    if($uid==$uid_visit) //if owner 
                    {

                        if($note_options_req=='yes') {
                                include 'cards/note_options.php'; 
                                $get_note_options = get_note_options();
                        }
                    }
                    //else {//if not owner 
                    //}
            }
            else { //User not logged in
                }
    }
    
        #=================
        
	$metatitle='LyfeOn - '.substr($note_text, 0, 60).'';
	$metadescription='LyfeOn - '.substr($note_text, 0, 170).'';
	$metaabstract='LyfeOn - '.substr($note_text, 0, 90).'';
	$metasubject='LyfeOn - '.substr($note_text, 0, 90).'';
	$metapagename='LyfeOn - '.substr($note_text, 0, 90).'';
	$metasubtitle='LyfeOn - '.substr($note_text, 0, 90).'';
	$metacopyright=$fname . " " . $lname;
	$image_url='';
	$image_height='';
	$image_width='';
	$content_target_src='note_pop_page';
	
	
        
	$note_options_req='yes';
	if($visibility=="pub")
	{
		$robots_index='index';
		$robots_follow='follow';
	}
	else 
	{
		$robots_index='no-index';
		$robots_follow='no-follow';	
	}
	if(isset($note_content_image))
	{
		$twitter_card_content = 'summary_large_image';
	}
	else 
		$twitter_card_content='summary';
    ?>

<?php include_once 'head.php'; ?>

<body>
	<?php include_once 'header.php'; ?>
	<div class="center mw45em">
		</br>
		<?php
                /*if ($visibility == 'pri') {
                    
	        	if(isset($_SESSION['email']))
	        	{
                                if($uid==$uid_visit) //if owner 
	        		{
                                    if($note_options_req=='yes') {
                                            include 'cards/note_options.php'; 
                                    }
	        		}
                                else {//if not owner 
                                    $note_image='';
                                    $note_text='Oops ! The content you have requested is private.';
                                }
                                
	        	}
                        else {
                           
                                $note_image='';
                                $note_text='Oops ! The content you have requested is private.';
                        }
                }
                elseif ($visibility == 'pub') {
                        if(isset($_SESSION['email']))
	        	{
                                if($uid==$uid_visit) //if owner 
	        		{
                            
                                    if($note_options_req=='yes') {
                                            include 'cards/note_options.php'; 
                                    }
	        		}
                                //else {//if not owner 
                                //}
	        	}
                        else { //User not logged in
                            }
                }*/
                ?>
		<img src="<?php echo $note_image; ?>" /> 
		</br>
        <p><?php echo $note_text; ?></p>
        <p>
        <?=$get_note_options;?>
        </p>
	</div>
	</br>
	<?php include_once 'footer_reg.php'; ?>
</body>
</html>