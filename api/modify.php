<?php
$get = ($_GET);
//print_r($get);
switch($get['action_object']) {
    case 'single_content':
                    if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                    if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type."));
                    if(!isset($get['content_id'])) print_error(array("status"=>"fail","response"=>"Undefined content id."));
//                    if(!isset($get['field_name'])) print_error(array("status"=>"fail","response"=>"Undefined required field name."));
//                    if(!isset($get['field_value'])) print_error(array("status"=>"fail","response"=>"Undefined field value."));
                    $output = modify_single_content_info($get);
        break;
    default : unknown();
        break;
}
echo json_encode($output);
function modify_single_content_info($get) {
    include "paths.php";
    include $db_file_url;
    $cond='';
    $output=array();
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));
    $content_id=mysql_real_escape_string(urldecode($get['content_id']));
    
    $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
    $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
    
    $timestamp=(!isset($get['timestamp']))? '' : strtotime(mysql_real_escape_string(urldecode($get['timestamp'])));//Unix timestamp
    
    $rslt = mysql_query("select `uid` from generic_profile where `uid`='$uid'",$linkid) or print_error(mysql_error($linkid));
    $row = mysql_fetch_array($rslt);
    if($row['uid']=='') { print_error("User/uid does not exits."); }
    
    $rslt = mysql_query("select `content_id` from `tbl_content` where `content_id`=$content_id",$linkid) or print_error(mysql_error($linkid));
    $row = mysql_fetch_array($rslt);
    if($row['content_id']=='') { print_error("Content id does not exits in contents record."); }
        
    
    if($content_type == 'note') {
        $note_text =(!isset($get['note_text']))? '' : mysql_real_escape_string(urldecode($get['note_text']));

        $rslt = mysql_query("select `content_id` from `tbl_notes` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        if($row['content_id']=='') { print_error("Content id does not exits in notes record."); }
        
        if($note_text != '') {    if($cond!='') $cond .= ",";    $cond .= "n.note_text='".$note_text."'";        }
        if($lat != '') {     if($cond!='') $cond .= ",";         $cond .= "c.lat=".$lat;        }
        if($long != '') {     if($cond!='') $cond .= ",";        $cond .= "c.long=".$long;        }
        if($timestamp != '') {     if($cond!='') $cond .= ",";        $cond .= "c.timestamp=".$timestamp;        }
        
        $sql = "UPDATE 
            `tbl_notes` n
            JOIN `tbl_content` c on c.content_id=n.content_id
            SET $cond
            WHERE c.content_id =$content_id";
        //echo '<pre>';die($sql);
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
        
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                
                $output = array("status"=>"success","result"=>"Content is Updated.");
            }
    }
    elseif($content_type == 'expense') {
                
        $title =(!isset($get['title']))? '' : mysql_real_escape_string(urldecode($get['title']));
        $desc =(!isset($get['desc']))? '' : mysql_real_escape_string(urldecode($get['desc']));
        $amount =(!isset($get['amount']))? '' : mysql_real_escape_string(urldecode($get['amount']));
        
        $rslt = mysql_query("select `content_id` from `tbl_expenses` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        if($row['content_id']=='') { print_error("Content id does not exits in expenses record."); }
        
        if($title != '') {   if($cond!='') $cond .= ",";     $cond .= "e.title='".$title."'";        }
        if($desc != '') {       if($cond!='') $cond .= ",";       $cond .= "e.desc='".$desc."'";        }
        if($amount != '') {      if($cond!='') $cond .= ",";       $cond .= "e.amount='".$amount."'";        }
        if($timestamp != '') {    if($cond!='') $cond .= ",";    $cond .= "c.timestamp='".$timestamp."'";        }
        
        $sql = "UPDATE 
            `tbl_expenses` e
            JOIN `tbl_content` c on c.content_id=e.content_id
            SET $cond
            WHERE c.content_id =$content_id";
            //echo '<pre>';die($sql);
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                $output = array("status"=>"success","result"=>"Content is Updated.");
            }
    }
    elseif($content_type == 'reminder') {
        $remind_time =(!isset($get['remind_time'])) ? '' : mysql_real_escape_string(urldecode($get['remind_time']));
        $reminder_name =(!isset($get['reminder_name'])) ? '' : mysql_real_escape_string(urldecode($get['reminder_name']));
        
        $rslt = mysql_query("select `content_id` from `tbl_reminders` where `content_id`='$content_id'",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        if($row['content_id']=='') { print_error("Content id does not exits in reminders record."); }
        
        if($remind_time != '') {      $cond .= "r.remind_time='".$remind_time."'";        }
        if($reminder_name != '') {     
            if($cond!='') $cond .= ",";
            $cond .= "r.reminder_name='".$reminder_name."'";
        }
        if($amount != '') {   if($cond!='') $cond .= ",";  $cond .= "r.amount='".$amount."'";        }
        if($timestamp != '') {  if($cond!='') $cond .= ",";  $cond .= "c.timestamp='".$timestamp."'";        }
        
        $sql = "UPDATE
            `tbl_reminders` r
            JOIN `tbl_content` c on c.content_id=r.content_id
            SET $cond
            WHERE c.content_id = $content_id";
        //echo '<pre>';die($sql);
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));


        if(mysql_errno($linkid)) {
            print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
        }
        else {
            $output = array("status"=>"success","result"=>"Content is Updated.");
        }
        
    }
    else { $output = unknown(); }
    return $output;
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