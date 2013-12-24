<?php
require_once 'google/appengine/api/taskqueue/PushTask.php';
use \google\appengine\api\taskqueue\PushTask;

$get = ($_REQUEST);
//print_r($get);
switch($get['action_object']) {
    #case 'user_profile':  $output = delete_user_profile();
    #    break;
    case 'single_content': 
            if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
            if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type."));
            if(!isset($get['content_id'])) print_error(array("status"=>"fail","response"=>"Undefined content id."));
            $output = del_single_content($get);
        break;
    default : unknown();
        break;
    
}
echo json_encode($output);

function del_single_content($get) {
    include "paths.php";
    include $db_file_url;
    $cond='';
    //http://localhost:13080/apis/delete/?action_object=user_profile&uid=8890977
    $output=array();
    $uid=mysql_real_escape_string($get['uid']);
    $content_id=mysql_real_escape_string($get['content_id']);
    $content_type=mysql_real_escape_string($get['content_type']);
    
    $rslt = mysql_query("select `uid` from `generic_profile` where `uid`='$uid'",$linkid) or print_error(mysql_error($linkid));
    $row = mysql_fetch_array($rslt);
    if($row['uid']=='') { print_error("User/uid does not exits."); }
    
    $rslt = mysql_query("select `content_id` from `tbl_content` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
    $row = mysql_fetch_array($rslt);
    if($row['content_id']=='') { print_error("Content id does not exits in contents record."); }
    
    if($content_type == 'note') {
        
            $rslt = mysql_query("select `content_id` from `tbl_notes` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            if($row['content_id']=='') { print_error("Content id does not exits in notes record."); }

            $sql = "DELETE from `tbl_notes` where `content_id`=$content_id";
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));

            $sql = "DELETE from `tbl_content` WHERE `content_id`= $content_id";
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                
                $output = array("status"=>"success","result"=>"Content removed successfully.");
                $taskname = createTaskQueue($content_id,$content_type,$uid);
            }
    }
    elseif($content_type == 'expense') {
            $rslt = mysql_query("select `content_id` from `tbl_expenses` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            if($row['content_id']=='') { print_error("Content id does not exits in expenses record."); }

            $sql = "DELETE from `tbl_expenses` where `content_id`=$content_id";
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));

            $sql = "DELETE from `tbl_content` WHERE `content_id`= $content_id";
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                
                $output = array("status"=>"success","result"=>"Content removed successfully.");
                $taskname = createTaskQueue($content_id,$content_type,$uid);
            }
            
    }
    elseif($content_type == 'reminder') {
        
            $rslt = mysql_query("select `content_id` from `tbl_reminders` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            if($row['content_id']=='') { print_error("Content id does not exits in reminders record."); }

            $sql = "DELETE from `tbl_reminders` where `content_id`=$content_id";
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));

            $sql = "DELETE from `tbl_content` WHERE `content_id`= $content_id";
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                
                $output = array("status"=>"success","result"=>"Content removed successfully.");
                $taskname = createTaskQueue($content_id,$content_type,$uid);
            }
            
    }
    else { $output = unknown(); }
    return $output;
}

function createTaskQueue($content_id,$content_type,$uid) {
    $task = new PushTask('/worker/tagremover/', ['content_id' => $content_id, 'content_type' => $content_type,"uid"=>$uid]);
    $task_name = $task->add();
    return $task_name;
}

function print_error($error) {
    if(is_array($error)) {
        echo json_encode($error);
    }
    else {
        echo json_encode(array("status"=>"fail","response"=>$error));
    }
    die();
}

function unknown() 
{
    return array("status"=>"fail","response"=>"Unknown url");
}

?>