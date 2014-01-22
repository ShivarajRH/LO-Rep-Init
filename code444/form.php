<?php   

include 'paths.php';
//echo ''.$_SERVER['SERVER_SOFTWARE'];
if(isset($_POST['search_btn']) ) {
    
    $s = microtime(true);
    
    $post=($_POST);
    $uid = $post['uid'];
    $query_str = $post['search_qry'];
    include $myclass_url;
    $ob = new myactions();

    $timestamp = date("Y-m-d H:i:s");
    $lat = $post['lat'];
    $long = $post['long'];
    $src = 'stream';
    $content_type = $post['content_type'];

    
    //request the api
    $post = array('requesting_uid'=> urlencode($uid),'query'=>urlencode($query_str),'content_type'=>urlencode($content_type),"timestamp"=>urlencode($timestamp),'lat'=>urlencode($lat),'long'=>urlencode($long),'src'=>urlencode($src));
    
    /*$get=$site_url.'api/search/?action_object=search_content&requesting_uid='.urlencode($uid).'&query='
        .urlencode($query_str).'&content_type='.urlencode($content_type).'&timestamp='.urlencode($timestamp).'&lat='.urlencode($lat).'&long='
        .urlencode($long).'&src='.urlencode($src).'';
    print_r($get);die();*/
    
    $url = $site_url.'api/search/?action_object=search_content';
    $result = $ob->getApiContent($url, 'json',$post);
    
        
    $e = microtime(true);
    $ttl_span_time = round($e - $s, 2) . " Sec";

    $result['elapse_time'] = $ttl_span_time;

    echo json_encode($result);
}
else {
    echo '<h4>No input</h4><p>Invalid access. Go back to <a href="'.$site_url.'stream">'.$site_url.'stream</a></p>';
}

?>