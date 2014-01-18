<?php   
$post=($_REQUEST);

if(isset($post['q'])) {
    error_reporting(1);
    ob_start();
    session_start();

    if(!isset($_SESSION['uid'])) {
        //header("Status: 404 Not Found");
        header("Location:/?resp=Please_Sign_In");
        exit();
    }

    $uid = isset($_SESSION['uid'])?$_SESSION['uid']:"104219296596850018797";
    $requesting_uid = $uid;
    $content_target_src='tags';
    $timestamp = date("Y-m-d H:i:s");
    $content_type = 'all';
    $tag = $post['q'];
    $privacy='pri';
    include 'paths.php';

    
    $s = microtime(true);
    
    include $myclass_url;
    $ob = new myactions();

    

//api/search/?&action_object=tag_content&content_type=note&tag=hello
//&uid=101651219808545508511&requesting_uid=104219296596850018797
//&privacy=pri&time=2013-12-28+10%3A07%3A12

    //request the api
    $post = array('tag'=>urlencode($tag),'uid'=> urlencode($uid),'requesting_uid'=> urlencode($requesting_uid)
        ,'privacy'=>urlencode($privacy),"time"=>urlencode($timestamp));
    
    $url = $site_url.'api/search/?action_object=tag_content&content_type='.urlencode($content_type);
    $result = $ob->getApiContent($url, 'json',$post);
    
        
    $e = microtime(true);
    $ttl_span_time = round($e - $s, 2) . " Sec";

    $result['elapse_time'] = $ttl_span_time;

    //echo json_encode($result);
    
    echo '<h5>Shown in  = '.$result['elapse_time']."</h5>";
    
    if( isset($result['tags']) ) {
        foreach ($result['tags'] as $row) {
            //echo 'Tag ID = '.$row['tag_id'].'<br>';
            echo '<h4>Tag = '.$row['tag_string'].'</h4>';
        }
    }
    else {
        echo '<h4>No Matching Data.</h4>
            <p>Requested tag not having any information. Go back to <a href="'.$site_url.'stream">'.$site_url.'stream</a></p>';
    }
    
}
else {
    echo '<h4>No input</h4><p>Invalid access. Go back to <a href="'.$site_url.'stream">'.$site_url.'stream</a></p>';
}

?>