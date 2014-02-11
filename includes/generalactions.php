<?php
require_once 'google/appengine/api/taskqueue/PushTask.php';
use \google\appengine\api\taskqueue\PushTask;

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
    elseif($action == 'updt_contacts') {
        $taskname = createTaskQueue($post);
        //$output = do_updateContacts($post);
    }
    else {
        $output="Invalid URL";
    }
    
}
echo ''.json_encode($output);

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
   
function createTaskQueue($post) {
    $task = new PushTask('/worker/update_contacts/', ['data' => $post['data'],'uid' => $post['uid'] ]);
    $task_name = $task->add();
    return $task_name;
}
    
    /*
    // update_contacts.php
    function do_updateContacts($post) {
        include "paths.php";
        include $db_file_url;
        // call task queue
        
            // store social contacts to db
           
            $insert_str='';
            $data = ($post['data']);
            $uid = mysql_real_escape_string($post['uid']);
            $ttl_num = count($data);
            if($ttl_num)
            foreach($data as $ui=>$entry) {
                //echo '<pre>'; print_r($entry);
                
                $arr[$ui]["uid"] = $uid;
                
                //$arr[$ui]["id"] = $id = mysql_real_escape_string($entry['id']['$t']);
                $arr[$ui]["name"] = $name = mysql_real_escape_string($entry['title']['$t']);
                foreach($entry['gd$email'] as $val){  $arr[$ui]['social_email'] = $socio_email = mysql_real_escape_string($val['address']); }
                //echo '<pre>'; print_r($arr); //die();"'.$entry['id']['$t'].'",
                
                $contact_set = mysql_query("select * from tbl_social_contacts where email='$socio_email' ",$linkid) or die("Internal Error:".mysql_error());
                if( mysql_num_rows($contact_set) > 0 ) {
                    // 'already exits';
                }
                else {
                    //new contact
                    if($ui<$ttl_num) $comma = ','; else $comma = '';
                    $insert_str .= '( "'.$entry['title']['$t'].'","'.$socio_email.'","'.$uid.'",now())'.$comma;
                }
             }
            //INSERT INTO suppliers (supplier_id, supplier_name) SELECT account_no, name FROM customers WHERE customer_id < 5000;
            if($insert_str != '') {
                echo $in_qry = "insert into tbl_social_contacts(`name`,`email`,`uid`,`created_on`) values ".rtrim($insert_str,",")."";
                mysql_query($in_qry,$linkid);
                echo "<br>".mysql_insert_id();
            }
            $result["status"] = 'success';
            return $result;
            //:-) contacts module done
    }*/
?>
