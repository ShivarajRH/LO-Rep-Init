<?php
$output= '';
$get = ($_GET);
//print_r($get);
switch($get['action_object']) {
    case 'user_profile': 
                    if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                    
                    $output = put_user_details($get);
        break;
        
    case 'table_actions': $output = table_actions($get);
        break;
    
    case 'list_content': 
                    if(!isset($get['uid'])) {
                        $output= array("status"=>"fail","response"=>"Undefined uid.");
                    }
                    else {
                        $output = put_contents($get);
                    }
        break;
    case 'single_content': 
                    if(!isset($get['uid'])) {
                        $output= array("status"=>"fail","response"=>"Undefined uid.");
                    }
                    elseif(!isset($get['field_name'])) {
                        $output= array("status"=>"fail","response"=>"Undefined required field name.");
                    }
                    elseif(!isset($get['field_value'])) {
                        $output= array("status"=>"fail","response"=>"Undefined field value.");
                    }
                    else {
                        put_single_content_info($get);
                    }
        break;
    default : $output = unknown();
        break;
    
}
echo json_encode($output);

function put_single_content_info($get) {
    include "paths.php";
    include $db_file_url;
    //http://localhost:13080/apis/search/?action_object=single_content&uid=65858778973333&content_id=2&content_type=note
    $output=array(); $con='';
    $uid=mysql_real_escape_string($get['uid']);
    $content_id=mysql_real_escape_string($get['content_id']);
    $content_type=mysql_real_escape_string($get['content_type']);
        
    if($content_type == 'note') {
        $arr_res=array();
        
        $sql = "select c.*,n.*
                from generic_profile g
                left join tbl_content c using(uid)
                join tbl_notes n on n.content_id=c.content_id
                where c.uid='$uid' and c.content_id=$content_id and c.content_type='$content_type'";
        //echo '<pre>';die($sql);
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
        
            if(mysql_errno($linkid)) {
                $output=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else {
                while($row = mysql_fetch_assoc($rslt)) {
                    $arr_res[]=$row;
                }
                
                $output['notes'] = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>$arr_res);
            }
    }
    if($content_type == 'expense') {
        
        $rslt = mysql_query("select c.*,e.* 
                    from generic_profile g
                    join tbl_content c  on c.uid=g.uid
                    join tbl_expenses e on e.content_id=c.content_id
                    where c.uid=$uid  and c.content_id=$content_id and c.content_type='$content_type'",$linkid) or print_error(mysql_error($linkid));
            if(mysql_errno($linkid)) {
                $output=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else {
                while($row = mysql_fetch_assoc($rslt)) {
                    $arr_res[]=$row;
                }
                $output['expenses'] = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>$arr_res);
            }
    }
    if($content_type == 'reminder') {
        $sql="select c.*,r.* 
                    from generic_profile g
                    join tbl_content c  on c.uid=g.uid
                    join tbl_reminders r on r.content_id=c.content_id
                    where c.uid=$uid  and c.content_id=$content_id and c.content_type='$content_type'";
        
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
//                    echo '<pre>';die($sql);
            if(mysql_errno($linkid)) {
                $output=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else {
                while($row = mysql_fetch_assoc($rslt)) {
                    $arr_res[]=$row;
                }
                $output['reminders'] = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>$arr_res);
            }
    }
    return $output;
}

function put_contents($get) {
    include "paths.php";
    include $db_file_url;
    //http://localhost:13080/apis/write/?action_object=list_content&uid=6585877897&content_type=note&
    //note_text=jdsjfkhdsfsdf&lat=77&long=33&timestamp=2013-02-01%2022:11:00
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));
    
    $lat=mysql_real_escape_string(urldecode($get['lat']));
    $long=mysql_real_escape_string(urldecode($get['long']));
    $timestamp=strtotime(mysql_real_escape_string(urldecode($get['timestamp'])));//Unix timestamp
    
    mysql_query("insert into `tbl_content`(`sno`,`content_id`,`uid`,`timestamp`,`lat`,`long`,`content_type`) 
                        values ( NULL,NULL,'".$uid."','".$timestamp."','".$lat."','".$long."','".$content_type."')",$linkid) or print_error(mysql_error($linkid));
    $content_id = mysql_insert_id(); //"cnt".rand(8,getrandmax());
    
    mysql_query("update `tbl_content` set `content_id`='$content_id' where `sno`=$content_id") or print_error(mysql_error($linkid));
    
    if($content_type == 'note') {
            $note_text=urldecode($get['note_text']);
            mysql_query("insert into `tbl_notes`(`sno`,`note_id`,`content_id`,`note_text`,`file_id`) 
                                values ( NULL,NULL,'".$content_id."','".$note_text."',NULL);",$linkid) or print_error(mysql_error($linkid));
            $insert_id = mysql_insert_id();
            mysql_query("update `tbl_notes` set `note_id`='".$insert_id."' where `sno`=$insert_id") or print_error(mysql_error($linkid));
            
            if(mysql_errno($linkid)) {
                $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else { 
                $rslt_arr = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"Note info has inserted.");
            }
    }
    elseif($content_type == 'expense') {
            $title=mysql_real_escape_string(urldecode($get['title']));
            $desc=mysql_real_escape_string(urldecode($get['desc']));
            $amount=mysql_real_escape_string(urldecode($get['amount']));
            mysql_query("insert into `tbl_expenses`(`sno`,`expense_id`,`content_id`,`title`,`desc`,`amount`) 
                                values ( NULL,NULL,'".$content_id."','".$title."','".$desc."','".$amount."');",$linkid) or print_error(mysql_error($linkid));
            $insert_id = mysql_insert_id();
            mysql_query("update `tbl_expenses` set `expense_id`='".$insert_id."' where `sno`=$insert_id") or print_error(mysql_error($linkid));
            
            if(mysql_errno($linkid)) {
                $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else { 
                $rslt_arr = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"Expense info has inserted.");
            }
    }
    elseif($content_type == 'reminder') {
            $remind_time=strtotime(mysql_real_escape_string(urldecode($get['remind_time'])));
            $reminder_name=mysql_real_escape_string(urldecode($get['reminder_name']));
            
            mysql_query("insert into `tbl_reminders`(`sno`,`reminder_id`,`content_id`,`remind_time`,`reminder_name`) 
                                         values ( NULL,NULL,'".$content_id."',".$remind_time.",'".$reminder_name."')",$linkid) or print_error(mysql_error($linkid));
            $insert_id = mysql_insert_id();
            mysql_query("update `tbl_reminders` set `reminder_id`='".$insert_id."' where `sno`=$insert_id") or print_error(mysql_error($linkid));;
            
            if(mysql_errno($linkid)) {
                $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else { 
                $rslt_arr = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"Reminder info has inserted.");
            }
    }
    return $rslt_arr;
}

function put_user_details($get) {
    
    
    include "paths.php";
    include $db_file_url;
    #uid=6647586&gid=6647586&fname=Shiva&mname=R&lname=H&name=shivaraj&uname=ShivarajRH&email=shiv@test.net
    //&phone=99776559966&verification=0&lat=77&long=23&time=2013-02-01+22%3A11%3A00
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $gid=mysql_real_escape_string(urldecode($get['gid']));
    $fname=mysql_real_escape_string(urldecode($get['fname']));
    $mname=mysql_real_escape_string(urldecode($get['mname']));
    $lname=mysql_real_escape_string(urldecode($get['lname']));
    $name=mysql_real_escape_string(urldecode($get['name']));
    $uname=mysql_real_escape_string(urldecode($get['uname']));
    $email=mysql_real_escape_string(urldecode($get['email']));
    $phone=mysql_real_escape_string(urldecode($get['phone']));
    $verification=mysql_real_escape_string(urldecode($get['verification']));
    $lat=mysql_real_escape_string(urldecode($get['lat']));
    $long=mysql_real_escape_string(urldecode($get['long']));
    $timezone=  strtotime(mysql_real_escape_string(urldecode($get['time']))); //Unix timestamp
    
    
    mysql_query("insert into `generic_profile`(`sno`,`uid`,`gid`,`fname`,`mname`,`lname`,`name`,`uname`,`email`,`phone`,`verification`,`lat`,`long`,`timezone`) values 
                    ( NULL,'".$uid."','".$gid."','".$fname."','".$mname."','".$lname."','".$name."','".$uname."','".$email."','".$phone."','".$verification."',".$lat.",".$long.",".$timezone.")",$linkid);
    if(mysql_errno($linkid)) {
        $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
    }
    else { 
        $rslt_arr = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"User info has inserted.");
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
        $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
    }
    else { 
        $rslt_arr = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"User info has inserted.");
    }
    return $rslt_arr;
}
function print_error($error) {
    if(is_array($error)) {
        echo json_encode($error);
    }
    else {
        echo json_encode('{"status":"fail","response":"'.$error.'"}');
    }
    die();
}
function unknown() 
{
    return array("status"=>"fail","response"=>"Unknown url");
}
?>