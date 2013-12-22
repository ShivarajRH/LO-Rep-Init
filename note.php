<?php 
//print_r($_SERVER['REQUEST_URI']);die();
    error_reporting(1);
    ob_start();
    session_start();
    $site_url='http://'.(($_SERVER['HTTP_HOST'] == 'localhost:13080')?"localhost:13080":$_SERVER['HTTP_HOST'])."/";
        
    include 'includes/myclasses.php';
    $ob = new myactions();
    
    if(isset($_GET['uid'])) {
        $uid = urldecode($_GET['uid']);
        $url=$site_url.'api/search/?action_object=user_profile&uid='.$uid;
        $rprofile = $ob->getApiContent($url,"json");
        $rprofile=$rprofile[0];
        
        if(count($rprofile)>0) {
            //header("Location:/?resp=Please_Sign_In");
            //exit();
        }
    }
    else {
        $uid = urldecode($_SESSION['uid']);
        $rprofile=$_SESSION;
//        echo 'By session';
    }
    //echo '<pre>';print_r($rprofile); die();
    $gid = $rprofile['gid']; 
    $name=$rprofile['name'];
    $fname=isset($rprofile['fname'])?$rprofile['fname']: "";
    $lname=isset($rprofile['lname'])?$rprofile['lname']:"";
    $img_url=isset($rprofile['img_url'])?$rprofile['img_url']:"";
    
    
    
    $load_js['global_js'] = 'global_scripts';
//        $load_js['stream'] = 'stream';
    
    $content_id=  urldecode($_GET['content_id']);
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
                    
            if(isset($rprofile['email']))
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
            if(isset($rprofile['email']))
            {
                    if($uid==$uid_visit) //if owner 
                    {

                        if($note_options_req=='yes') {
                                include 'cards/note_options.php'; 
                                $get_note_options = get_note_options();
                        }
                    }
                    //else {//if not owner    //}
            }//User not logged in
            else {                 }
    }
    
        #=================
//        echo $note_text;
        
	$metatitle='LyfeOn - '.strip(substr($note_text, 0, 60)).'';
	$metadescription='LyfeOn - '.strip(substr($note_text, 0, 170)).'';
	$metaabstract='LyfeOn - '.strip(substr($note_text, 0, 90)).'';
	$metasubject='LyfeOn - '.strip(substr($note_text, 0, 90)).'';
	$metapagename='LyfeOn - '.strip(substr($note_text, 0, 90)).'';
	$metasubtitle='LyfeOn - '.strip(substr($note_text, 0, 90)).'';
	$metacopyright= $fname . " " . $lname;
	$image_url=$img_url;
        if($img_url!='') { $height=$width=100; } else { $height=$width=0; }
	$image_height=$height;
	$image_width=$width;
	$content_target_src='note';
	
        
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
    
        include_once 'head.php'; 
?>

<body>
	<?php include_once 'header.php'; ?>
	<div class="center mw45em">
		</br>
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
<?php
function strip($str)
{
    return strip_tags($str);
}
?>
</html>