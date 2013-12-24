<?php

$get = ($_REQUEST);
//print_r($get);

//print_r(is_tag_exists('hello3','104219296596850018797'));


if(!isset($get['content_id'])) 
    print_error(array("status"=>"fail","response"=>"Undefined content id.")); 
else 
    $content_id=$get['content_id'];

if(!isset($get['content_type'])) 
    $content_type='all';
else 
    $content_type=$get['content_type'];

if(!isset($get['uid'])) 
    print_error(array("status"=>"fail","response"=>"Undefined uid.")); 
else 
    $uid=$get['uid'];

$content_arr = get_content_info($content_id,$content_type);
//echo '<pre>';        print_r($content_arr); die();

$hashtags_arr=array();
    
if($content_type == 'note') {
    foreach($content_arr['notes'] as $content) {
        $hashtags_arr['tags'] = getHashTags($content['note_text']);
    }
}
if($content_type == 'expense') {
    foreach($content_arr['expenses'] as $content) {
        $hashtags_arr['tags'] = getHashTags($content['expense_title']);
    }
}
if($content_type == 'reminder') {
    foreach($content_arr['reminders'] as $content) {
        $hashtags_arr['tags'] = getHashTags($content['reminder_name']);
    }
}

array_unique($hashtags_arr['tags']);
    
    /*echo '<ol>';
    foreach ($hashtags_arr['tags'] as $i=>$hastag) {
        echo '<li>'.$hastag."</li>";
    }
    echo '</ol>';die();*/
    
// get_anchor_tags($str);
//$rdata=delete_tag_info($get,$hashtags_arr);

$rdata = modify_tag_info($get,$hashtags_arr);

echo json_encode($rdata);

function modify_tag_info($get,$hashtags_arr) {
    include "paths.php";
    include $db_file_url;
    
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $content_id=mysql_real_escape_string(urldecode($get['content_id']));
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));
    
    $visibility=(!isset($get['visibility']))? 'pri' : mysql_real_escape_string(urldecode($get['visibility']));
    $timestamp=(!isset($get['timestamp']))? time() : strtotime(mysql_real_escape_string(urldecode($get['timestamp'])));//Unix timestamp
    $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
    $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
    
    //= Delete
    $rdata=delete_tag_info($get,$hashtags_arr);
    
    
    
    foreach ($hashtags_arr['tags'] as $i=>$tag) {
        
        $tags_status = is_tag_exists($tag, $uid);
        
        if($tags_status['status'] == 'fail') {
                mysql_query("insert into `tbl_tags`(`sno`,`tag_id`,`tag_string`,`tag_create_uid`) 
                    values ( NULL,NULL,'$tag','$uid')",$linkid);

                $slno = $tag_id = mysql_insert_id(); //"cnt".rand(8,getrandmax());

                mysql_query("update `tbl_tags` set `tag_id`='$tag_id' where `sno`=$slno") or print_error(mysql_error($linkid));
        }
        else {
            $tag_id = $tags_status['tag_id'];
        }
        
        mysql_query("insert into `tbl_tag_content`(`sno`,`tag_content_id`,`tag_id`,`tag_string`,`uid`,`content_id`,`content_type`,`privacy`,`timestamp`,`lat`,`long`)
            values ( NULL,NULL,'$tag_id','$tag','$uid','$content_id','$content_type','$visibility','$timestamp','$lat','$long')",$linkid);

        if(mysql_errno($linkid)) {
            print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
        }
        else { 
            $rslt_arr = array("status"=>"success","content_id"=>$content_id);
        }
        
        
    }
    return $rslt_arr;
}


function delete_tag_info($get,$hashtags_arr) {
    include "paths.php";
    include $db_file_url;
    
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $content_id=mysql_real_escape_string(urldecode($get['content_id']));
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));

    $query="select * from tbl_tag_content 
        where content_id='$content_id' and content_type='$content_type' and uid='$uid'";
    $rset=  mysql_query($query);
    
    if(mysql_errno($linkid)) {
            print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
    }
    else { 
        while($row = mysql_fetch_array($rset)) {
            $sno = $row['sno'];
            $tag_id = $row['tag_id'];
            $arr_tag_id[]=$tag_id;
//            echo 'Tag_id='.$tag_id.'<br>';
            mysql_query("delete from `tbl_tag_content` where `sno`=$sno");
        }
        $rslt_arr = array("status"=>"success","response"=>count($arr_tag_id)." Tags ".json_encode($arr_tag_id)." are deleted.");
    }
    return $rslt_arr;
}

function get_content_info($content_id,$content_type) {
    include "paths.php";
    include $db_file_url;
    $output=array(); $con='';
   
    if($content_type == 'note') {
            
            $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                join tbl_content c on c.content_id=n.content_id
                                where n.content_id = '$content_id' order by n.note_id desc",$linkid) or print_error(mysql_error($linkid));
            
            $i=0;$data_array=array();
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['note_id'] = $row['note_id'];
                $data_array[$i]['note_text'] = $row['note_text'];
                $i++;
            }
            $output['notes'] = $data_array;
    }
    elseif($content_type == 'expense' || $content_type== 'all') {

            $rslt = mysql_query("select * from tbl_expenses e
                    join tbl_content c on c.content_id=e.content_id
                    where e.content_id='$content_id' order by e.expense_id desc",$linkid) or print_error(mysql_error($linkid));
      
            if(mysql_errno($linkid)) {
                print_error(mysql_error($linkid));
            }
            else {
                
                $i=0;$data_array=array();
                while($row = mysql_fetch_assoc($rslt)) {
//                    $month=date("M",$row['timestamp']);
                    $data_array[$i]['expense_id']=$row['expense_id'];
                    $data_array[$i]['content_id']=$row['content_id'];
                    $data_array[$i]['expense_title']=$row['title'];
                    $i++;
                }
                $output['expenses'] = $data_array;
            }
    }
    elseif($content_type == 'reminder') {

            $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                join tbl_content c on c.content_id=r.content_id
                where r.`content_id`='$content_id' order by r.reminder_id desc",$linkid) or print_error(mysql_error($linkid));
            
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
//                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
    }
    else { $output = unknown(); }
    return $output;
}

function is_tag_exists($tag_string,$uid) {
    include "paths.php";
    include $db_file_url;
    
   
    $result =  mysql_query("select * from tbl_tags where tag_string='$tag_string' and tag_create_uid='$uid' limit 1");
    if(mysql_errno($linkid)) {
        print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
    }
    else {
        if(mysql_num_rows($result)>0) {
            
            $row= mysql_fetch_assoc($result);
            $tag_id = $row['tag_id'];
            return array("status"=>"success","response"=>"found",'tag_id'=>$tag_id,'num_rows'=>  mysql_num_rows($result));
        }
        else {
            return array("status"=>"fail","response"=>"Not found");
        }
    }
}

function get_anchor_tags($str) {
    $text= $str;
    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
    $regex .= "(\:[0-9]{2,5})?"; // Port 
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
    if(preg_match_all("/^$regex$/", $text,$arr_notes)) {
            return $arr_notes[1];
    }
}

function getHashTags($str) {
    $str = strip_tags($str);
    $matches = array();
    if (preg_match_all('/#([^\s]+)/', $str, $matches)) {
        return $matches[1];
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
function unknown() {
    return array("status"=>"fail","response"=>"Unknown url");
}
?>