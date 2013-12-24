<?php
$get = ($_REQUEST);
//print_r($get);

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

$rdata=delete_tag_info($get,$hashtags_arr);
echo json_encode($rdata);

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