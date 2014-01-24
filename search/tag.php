<?php   
$get=($_GET);

$result=array();
if(isset($get['q'])) {
    error_reporting(1);
    ob_start();session_start();
    //echo ''.$_SESSION['uid'];
    $post = $_SESSION;//$_REQUEST;
//    print_r($post);    die();
    if(!isset($post['uid'])) {
        //header("Status: 404 Not Found");
//        header("Location:/?resp=Please_Sign_In");
        $result = array("status"=>'fail',"response"=>"Please_Sign_In");
//        exit();
    }
    else {
            $s = microtime(true);
            $uid = isset($post['uid'])?$post['uid']:"104775511952184246952";
            $requesting_uid = $uid;
            $content_type = 'all';
            $tag = $get['q'];
            $privacy='pri';
            $timestamp = date("Y-m-d H:i:s");
            include 'paths.php';
            include $myclass_url;
            $ob = new myactions();

            //api/search/?&action_object=tag_content&content_type=note&tag=mayyu&uid=104775511952184246952&requesting_uid=104775511952184246952&privacy=pri&time=2014-01-19+10%3A07%3A12
            //api/search/?&action_object=tag_content&content_type=note&tag=ashu&uid=104775511952184246952&requesting_uid=104775511952184246952&privacy=pri&time=2014-01-19+10%3A07%3A12
            //request the api
            $postData = array('tag'=>urlencode($tag),'uid'=> urlencode($uid),'requesting_uid'=> urlencode($requesting_uid)
                ,'privacy'=>urlencode($privacy),"time"=>urlencode($timestamp));

            $url = $site_url.'api/search/?action_object=tag_content&content_type='.urlencode($content_type);
            
//            print_r($postData);die();
                        
            $rdata = $ob->getApiContent($url, 'json',$postData);
            
            //echo '<pre>';print_r($rdata); die();
            
            $e = microtime(true);
            $ttl_span_time = round($e - $s, 2) . " Sec";

            //echo '<h5>Shown in  = '.$result['elapse_time']."</h5>";
            if( $rdata['status'] == 'success') {
            //if( isset($rdata['tags']) && !empty($rdata['tags'])) {
                /*foreach ($result['tags'] as $row) {
                    echo 'Tag ID = '.$row['tag_id'].'<br>';
                    echo '<h4>Tag = '.$row['tag_string'].'</h4>';
                }*/
                $result['status'] = 'success';
                $result['response'] = "Total: ".count($rdata['notes'])." notes, ".count($rdata['expenses'])." expenses, ".count($rdata['reminders'])." reminders matched with this tag. ";//$rdata['tags'];
                $result['elapse_time'] = $ttl_span_time;
            }
            else {
                $result['status'] = 'fail';
                $result['response'] = 'Requested tag not found.';
            }
    }
}
else {
    $result['status'] = 'fail';
    $result['response'] = 'No input or Invalid access. Go back to <a href="'.$site_url.'stream">'.$site_url.'stream</a>';
}
echo json_encode($result);
?>