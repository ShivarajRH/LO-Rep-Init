<?php
if(isset($_GET['action'])) {
    echo $action = $_GET['action'];
    die("error");
    $post= $_POST[];
    if($action == 'create') {
        do_create_sess($post);
    }
    
}
function do_create_sess($post)  {
    session_start();
    $_SESSION['uid']=$post['uid'];
    $_SESSION['gid']=$post['gid'];
    $_SESSION['email']=$post['email'];
    
}

?>
