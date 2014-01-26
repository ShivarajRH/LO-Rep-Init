<?php   
if(isset($_GET['query'])) {
    $query = $_GET['query'];
    error_reporting(1);
    ob_start();session_start();
    $session = $_SESSION;
    $post = $_REQUEST;
   
    $s = microtime(true);
    if(!isset($session['uid'])) {
        //header("Status: 404 Not Found");//header("Location:/?resp=Please_Sign_In");exit();
        $result = array('status'=>'fail','response'=>'Please sign in.');
    }
    else
    {
            $uid = isset($session['uid']) ? $session['uid'] : "104219296596850018797";
            $requesting_uid = $uid;
            $content_type = isset($post['content_type']) ? $post['content_type'] : 'all';
            $lat = isset($post['lat'])?$post['uid'] : 85;
            $long = isset($post['long'])?$post['long'] : 172;

            $timestamp = date("Y-m-d H:i:s");

            $src = isset($post['src'])?$post['src'] : 'streamsearch';

            include 'paths.php';
            include $myclass_url;
            $ob = new myactions();

            //api/search/?action_object=search_content&content_type=note&requesting_uid=104219296596850018797&query=a&timestamp=2013-12-28+10%3A07%3A12&lat=112&long=76&src=stream

            //request the api
            $post = array('requesting_uid'=> urlencode($requesting_uid),'query'=>urlencode($query)
                ,"timestamp"=>urlencode($timestamp),'lat'=>urlencode($lat),'long'=>urlencode($long)
                ,'src'=>urlencode($src));

            $url = $site_url.'api/search/?action_object=search_content&content_type='.urlencode($content_type);
            $rdata = $ob->getApiContent($url, 'json',$post);

//            echo '<pre>';print_r($rdata);die();
            $e = microtime(true);
            $ttl_span_time = round($e - $s, 2) . " Sec";
            
            if( $rdata['status'] == 'success') {
                $result['status'] = 'success';
                $result['response'] = "Total: ".count($rdata['notes'])." notes, ".count($rdata['expenses'])." expenses, ".count($rdata['reminders'])." reminders matched with this keyword. ";//$rdata['tags'];
                $result['elapse_time'] = $ttl_span_time;
            }
            else {
                $result['status'] = 'fail';
                $result['response'] = $rdata['response'];
            }
    }
}
else {
    $result = array('status'=>'fail','response'=>  htmlspecialchars('<h4>No input</h4><p>Invalid access. Go back to <a href="'.$site_url.'stream">'.$site_url.'stream</a></p>'));
}
echo json_encode($result);
?>