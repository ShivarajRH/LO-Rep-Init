<?php
$output= '';
require_once 'google/appengine/api/taskqueue/PushTask.php';
use \google\appengine\api\taskqueue\PushTask;

$get = ($_REQUEST);
//print_r($get);
switch($get['action_object']) {
    case 'user_profile': 
                    if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                    if(!isset($get['gid'])) print_error(array("status"=>"fail","response"=>"Undefined gid."));
                    if(!isset($get['name'])) print_error(array("status"=>"fail","response"=>"Undefined name."));
                    if(!isset($get['email'])) print_error(array("status"=>"fail","response"=>"Undefined email."));
                    if(!isset($get['currency'])) print_error(array("status"=>"fail","response"=>"Undefined currency."));
                    $output = put_user_details($get);
        break;
        
    case 'table_actions': $output = table_actions($get);
        break;
    
    case 'single_content': 
                if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type."));
                if(!isset($get['timestamp'])) print_error(array("status"=>"fail","response"=>"Undefined timestamp."));
                $output = put_single_content_info($get);
                   
        break;
    default : $output = unknown();
        break;
    
}
echo json_encode($output);

function put_single_content_info($get) {
    include "paths.php";
    include $db_file_url;
    
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));
    
    $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
    $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
    $visibility=(!isset($get['visibility']))? 'pri' : mysql_real_escape_string(urldecode($get['visibility']));
    
    $timestamp=strtotime(mysql_real_escape_string(urldecode($get['timestamp'])));//Unix timestamp
    
    $rslt = mysql_query("select `uid` from `oneapp_db`.`generic_profile` where `uid`=".$uid,$linkid) or print_error(mysql_error($linkid));
    $row = mysql_fetch_array($rslt);
    if(mysql_num_rows($rslt) == 0) { print_error("User/uid does not exits.".mysql_error()."".$uid); }
    
    mysql_query("insert into `tbl_content`(`sno`,`content_id`,`uid`,`timestamp`,`lat`,`long`,`content_type`,`visibility`) 
                        values ( NULL,NULL,'".$uid."','".$timestamp."','".$lat."','".$long."','".$content_type."','".$visibility."')",$linkid) or print_error(mysql_error($linkid));
    $slno = $content_id = mysql_insert_id(); //"cnt".rand(8,getrandmax());
    
    mysql_query("update `tbl_content` set `content_id`='$content_id' where `sno`=$slno") or print_error(mysql_error($linkid));
    
    if($content_type == 'note') {
        if(!isset($get['note_text'])) print_error(array("status"=>"fail","response"=>"Undefined note text."));
        if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type."));
                
            $note_text=  mysql_escape_string(urldecode($get['note_text']));
            mysql_query("insert into `tbl_notes`(`sno`,`note_id`,`content_id`,`uid`,`note_text`,`visibility`,`file_id`) 
                                values ( NULL,NULL,'".$content_id."','".$uid."','".$note_text."','".$visibility."',NULL);",$linkid) or print_error(mysql_error($linkid));
            $insert_id = mysql_insert_id();
            mysql_query("update `tbl_notes` set `note_id`='".$insert_id."' where `sno`=$insert_id") or print_error(mysql_error($linkid));
            
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                $rslt_arr = array("status"=>"success","content_id"=>$content_id);
                
                $taskname = createTaskQueue($content_id,$content_type,$uid,$visibility);
            }
    }
    elseif($content_type == 'expense') {
        if(!isset($get['title'])) print_error(array("status"=>"fail","response"=>"Please specify expense title."));
        if(!isset($get['desc'])) print_error(array("status"=>"fail","response"=>"Please specify expense description."));
        if(!isset($get['amount'])) print_error(array("status"=>"fail","response"=>"Please specify amount."));
            
            $title=mysql_real_escape_string(urldecode($get['title']));
            $desc=mysql_real_escape_string(urldecode($get['desc']));
            $amount=mysql_real_escape_string(urldecode($get['amount']));
            
            mysql_query("insert into `tbl_expenses`(`sno`,`expense_id`,`content_id`,`uid`,`title`,`desc`,`amount`,`visibility`) 
                                values ( NULL,NULL,'".$content_id."','".$uid."','".$title."','".$desc."','".$amount."','".$visibility."');",$linkid) or print_error(mysql_error($linkid));
            $insert_id = mysql_insert_id();
            mysql_query("update `tbl_expenses` set `expense_id`='".$insert_id."' where `sno`=$insert_id") or print_error(mysql_error($linkid));
            
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else { 
                $rslt_arr = array("status"=>"success","content_id"=>$content_id);
                
                $taskname = createTaskQueue($content_id,$content_type,$uid,$visibility);
            }
    }
    elseif($content_type == 'reminder') {
        if(!isset($get['remind_time'])) print_error(array("status"=>"fail","response"=>"Please specify remind time."));
        if(!isset($get['reminder_name'])) print_error(array("status"=>"fail","response"=>"Please specify reminder name."));
        
            $remind_time=strtotime(mysql_real_escape_string(urldecode($get['remind_time'])));
            $reminder_name=mysql_real_escape_string(urldecode($get['reminder_name']));
            
            mysql_query("insert into `tbl_reminders`(`sno`,`reminder_id`,`content_id`,`uid`,`remind_time`,`reminder_name`,`visibility`) 
                                         values ( NULL,NULL,'".$content_id."','".$uid."',".$remind_time.",'".$reminder_name."','".$visibility."')",$linkid) or print_error(mysql_error($linkid));
            $insert_id = mysql_insert_id();
            mysql_query("update `tbl_reminders` set `reminder_id`='".$insert_id."' where `sno`=$insert_id") or print_error(mysql_error($linkid));;
            
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                $rslt_arr = array("status"=>"success","content_id"=>$content_id);

                $taskname = createTaskQueue($content_id,$content_type,$uid,$visibility);
            }
    }
    else { $output = unknown(); }
    
    return $rslt_arr;
}

function createTaskQueue($content_id,$content_type,$uid,$visibility) {
    $task = new PushTask('/worker/tagextractor/', ['content_id' => $content_id, 'content_type' => $content_type,"uid"=>$uid,"visibility"=>$visibility]);
    $task_name = $task->add();
    return $task_name;
}

function put_user_details($get) {
    include "paths.php";
    include $db_file_url;
    #uid=6647586&gid=6647586&fname=Shiva&mname=R&lname=H&name=shivaraj&uname=ShivarajRH&email=shiv@test.net
    //&phone=99776559966&verification=0&lat=77&long=23&time=2013-02-01+22%3A11%3A00
    $uid=mysql_real_escape_string(urldecode($get['uid'])); //req
    $gid=mysql_real_escape_string(urldecode($get['gid'])); //req
    $name=mysql_real_escape_string(urldecode($get['name'])); //req
    $email=mysql_real_escape_string(urldecode($get['email'])); //req
    $currency=mysql_real_escape_string(urldecode($get['currency'])); //req
    
    $content_type=(!isset($get['content_type']))? '' : mysql_real_escape_string(urldecode($get['content_type']));
    $fname=(!isset($get['fname']))? '' : mysql_real_escape_string(urldecode($get['fname']));
    $mname=(!isset($get['mname']))? '' : mysql_real_escape_string(urldecode($get['mname']));
    $lname=(!isset($get['lname']))? '' : mysql_real_escape_string(urldecode($get['lname']));
    $uname=(!isset($get['uname']))? '' : mysql_real_escape_string(urldecode($get['uname']));
    $phone=(!isset($get['phone']))? '' : mysql_real_escape_string(urldecode($get['phone']));
    $verification=(!isset($get['verification']))? '' : mysql_real_escape_string(urldecode($get['verification']));
    $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
    $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
    $timezone=  (!isset($get['time']))? '' : strtotime(mysql_real_escape_string(urldecode($get['time']))); //Unix timestamp
    $img_url=  (!isset($get['img_url']))? '' : mysql_real_escape_string(urldecode($get['img_url'])); //google+ image url
    
    $sql="insert into `generic_profile`(`sno`,`uid`,`gid`,`fname`,`mname`,`lname`,`name`,`uname`,`email`,`currency`,`phone`,`verification`,`lat`,`long`,`timezone`,`img_url`) values( NULL,'".$uid."','".$gid."','".$fname."','".$mname."','".$lname."','".$name."','".$uname."','".$email."','".$currency."','".$phone."','".$verification."',".$lat.",".$long.",".$timezone.",'".$img_url."')";
    mysql_query($sql,$linkid);
    if(mysql_errno($linkid)) {
        print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
    }
    else { 
        $rslt_arr = array("success");
    }
    return $rslt_arr;
}

function table_actions() {
    include "paths.php";
    include $db_file_url;
    mysql_query('alter table `oneapp_db`.`tbl_reminders` add column `remainder_name` varchar (150)  NULL  after `timestamp`,change `note_id` `content_id` varchar (100)  NULL  COLLATE latin1_swedish_ci');
    //mysql_query('alter table `oneapp_db`.`generic_profile` change `slno` `sno` bigint (20)  NOT NULL AUTO_INCREMENT;',$linkid);
    //mysql_query('alter table `oneapp_db`.`generic_profile` change `uid` `uid` bigint(20) NOT NULL UNIQUE;',$linkid);
    if(mysql_errno($linkid)) {
        print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
    }
    else { 
        $rslt_arr = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"User info has inserted.");
    }
    return $rslt_arr;
}
function check_uid($uid) {
    include "paths.php";
    include $db_file_url;
    $rslt=mysql_query('select * from `oneapp_db`.`generic_profile` where uid="'.$uid.'" limit 1',$linkid);
    
    $rslt_arr=mysql_fetch_row($rslt);
    if(mysql_num_rows($rslt)) {
        return TRUE; //uid exits
    }
    else { 
        return FALSE;//uid doen't exits
    }
    
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