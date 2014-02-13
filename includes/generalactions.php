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
    elseif($action == 'updt_people') {
        //$taskname = createTaskQueue($post);
        $output = do_updatePeople($post);
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
    $task = new PushTask('/worker/update_people/', ['data' => $post['data'],'uid' => $post['uid'] ]);
    $task_name = $task->add();
    return $task_name;
}
    
    
    // update_contacts.php
    function do_updatePeople($post) {
            include "paths.php";
            include $db_file_url;
            // call task queue
        
            // store social contacts to db
            $insert_str='';
            $data = ($post['data']);
            $uid = mysql_real_escape_string($post['uid']);
            $ttl_num = count($data);
            if($ttl_num > 0) {
                foreach($data['items'] as $ui=>$entry) {
                    //echo '<pre>'; print_r($entry);

                    $c_id = mysql_real_escape_string($entry['id']);
                    $name = mysql_real_escape_string($entry['displayName']);
                    //foreach($entry['gd$email'] as $val){  $arr[$ui]['social_email'] = $socio_email = mysql_real_escape_string($val['address']); }

                    $contact_set = mysql_query("select * from tbl_social_contacts where c_gid='$c_id' ",$linkid) or die("Internal Error:".mysql_error());
                    if( mysql_num_rows($contact_set) > 0 ) {
                        // 'already exits';
                    }
                    else {
                        //new contact
                        if($ui<$ttl_num) $comma = ','; else $comma = '';
                        $insert_str .= '( "'.$uid.'","'.$uid.'","'.$c_id.'","'.$c_id.'","'.$name.'",now() )'.$comma;
                    }
                 }
            }
            
            $result=array();
            if($insert_str != '') {
                $in_qry = "insert into tbl_social_contacts(`uid`,`gid`,`c_uid`,`c_gid`,`name`,`created_on`) values ".rtrim($insert_str,",")."";
                
                // Insert qry
                mysql_query($in_qry,$linkid); 
                
                $result["status"] = 'success';
                $result["response"] = $in_qry;
            }
            else {
                $result["status"] = 'fail';
                $result["response"] = 'No data.';
            }
            return $result;
            //:-) contacts module done
    }
?>
