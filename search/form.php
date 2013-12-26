<?php   include 'paths.php';
    include $myclass_url;
    if(isset($_POST) ) {
        $post=($_POST);
        $uid = $post['uid'];
        $query_str = $post['search_qry'];
        $q_arr = explode(" ",$query_str);
        $ob = new myactions();
        $rdata = $ob->skip_stopwords($q_arr);

        $obj_query = json_encode($rdata);
        
        //request the api
        $post = array('requesting_uid'=>$uid,'query_str'=>$query_str,'obj_query'=>$obj_query);
        $url = $site_url.'api/search/?action_object=search_content';
        $result = $ob->getApiContent($url, 'json',$post);
        print_r($result);
        
    }
    else {
        echo '<h4>No input</h4>';
    }
?>