<?php   


include 'paths.php';

if(isset($_POST) ) {
    $post=($_POST);
    $uid = $post['uid'];
    $query_str = $post['search_qry'];
        include $myclass_url;
        $ob = new myactions();

    $timestamp = date("Y-m-d H:i:s");
    $lat = 112;
    $long = 76;
    $src = 'stream';

    $s = microtime(true);
    //request the api
    $post = array('requesting_uid'=>  urlencode($uid),'query'=>urlencode($query_str),"timestamp"=>urlencode($timestamp),'lat'=>urlencode($lat),'long'=>urlencode($long),'src'=>urlencode($src));
    
    $get=$site_url.'api/search/?action_object=search_content&requesting_uid='.urlencode($uid).'&query='
        .urlencode($query_str).'&timestamp='.urlencode($timestamp).'&lat='.urlencode($lat).'&long='
        .urlencode($long).'&src='.urlencode($src).'';
    
//    echo '<pre>';print_r($get);die();
    $url = $site_url.'api/search/?action_object=search_content';
    $result = $ob->getApiContent($url, 'json',$post);
    echo 'Success:<br>';
    print_r($result);
    $ttl_span_time = round($e - $s, 2) . " Sec";
    echo $ttl_span_time;
}
else {
    echo '<h4>No input</h4>';
}
    
$e = microtime(true);


?>