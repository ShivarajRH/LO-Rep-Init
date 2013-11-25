<?php

if(isset($_GET['action'])) {
    $action = $_REQUEST['action'];
    
    $post = $_POST;
    if($action == 'sess_create') {
        if(!empty($post) and $post!='') {
            //print_r($post);die();
            $output=do_create_sess($post);
        }
        else {
            $output="No input data.";
        }
    }
    elseif($action == 'sess_destroy') {
        $output = do_destroy_session();
    }
    elseif($action == 'getAllNotes') {
        $output = do_getAllNotes();
    }
    else {
        $output="Invalid URL";
    }
    
}
echo ''.$output;

function do_getAllNotes() {
    print_r($_SESSION);
}
function do_create_sess($post)  {
    session_start();
    $_SESSION['uid']=$post['uid'];
    $_SESSION['name']=$post['name'];
    $_SESSION['gid']=$post['gid'];
    $_SESSION['email']=$post['email'];
    $_SESSION['fname']=$post['fname'];
    $_SESSION['lname']=$post['lname'];
    
    return "Session is set.";
}

function do_destroy_session()  {
    session_start();
    if(isset($_SESSION['uid'])) {
        session_destroy();
        return "Session destroyed.";
    }
    else {
        return "No session to destroy.";
    }
    
}

?>
