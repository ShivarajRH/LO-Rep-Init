<?php

if(isset($_GET['action'])) {
    $action = $_GET['action'];
    
    $post= $_POST;
    if($action == 'sess_create') {
        if(!empty($post) and $post!='') {
            //print_r($post);
            $output=do_create_sess($post);
        }
        else {
            echo "No input data.";
        }
    }
    else {
        $output="Invalid URL";
    }
    
}
echo ''.$output;

function do_create_sess($post)  {
    session_start();
    $_SESSION['uid']=$post['uid'];
    $_SESSION['gid']=$post['gid'];
    $_SESSION['email']=$post['email'];
    return "session is set.";
}

?>
