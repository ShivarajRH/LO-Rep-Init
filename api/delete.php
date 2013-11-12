<?php
$get = ($_GET);
//print_r($get);
switch($get['action']) {
    case 'user_profile':  delete_user_profile();
        break;
    case 'single_content': del_single_content($get);
        break;
    case 'delete': 
        break;
    case 'modify': 
        break;
    default : unknown();
        break;
    
}
function delete_user_profile($get) {
    include "paths.php";
    include $db_file_url;
    $cond='';
    //http://localhost:13080/apis/delete/?action_object=user_profile&uid=8890977
    $output=array();
    $uid=mysql_real_escape_string($get['uid']);
    $content_id=mysql_real_escape_string($get['content_id']);
    $content_type=mysql_real_escape_string($get['content_type']);
    
    //Check uid 
    if(!check_uid($uid)) print_error(array("status"=>"fail","response"=>"Invalid uid."));
    $field_name=mysql_real_escape_string($get['field_name']); // required
    $field_value=mysql_real_escape_string($get['field_value']); // required
    
    if($uid != '') {       $cond .= " and c.uid=$uid "; }
    if($content_type != '') { $cond .= " and c.content_type='$content_type' ";  }
    
    if($content_type == 'note') {
        $arr_res=array();
        
        $sql = "UPDATE 
            `tbl_notes` n
            JOIN `tbl_content` c on c.content_id=n.content_id
            SET n.{$field_name} = '$field_value'
            WHERE c.content_id =$content_id $cond ";
        //echo '<pre>';die($sql);
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
        
        
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                
                $output['notes'] = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"Field is Updated.");
            }
    }
    if($content_type == 'expense') {
        
        $sql = "UPDATE 
            `tbl_expenses` e
            JOIN `tbl_content` c on c.content_id=e.content_id
            SET e.{$field_name} = '$field_value'
            WHERE c.content_id =$content_id $cond ";
        
            $rslt = mysql_query("$sql",$linkid) or print_error(mysql_error($linkid));
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                $output['expenses'] = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"Field is Updated.");
            }
    }
    if($content_type == 'reminder') {
        $sql = "UPDATE 
            `tbl_reminders` r
            JOIN `tbl_content` c on c.content_id=r.content_id
            SET r.{$field_name} = '$field_value'
            WHERE c.content_id =$content_id $cond ";
        
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
//                    echo '<pre>';die($sql);
            if(mysql_errno($linkid)) {
                print_error(array("status"=>"fail","response"=>mysql_error($linkid)));
            }
            else {
                $output['reminders'] = array("affected_rows"=>mysql_affected_rows($linkid),"result"=>"Field is Updated.");
            }
    }
    return $output;
}

function unknown() 
{
    echo '{"status":"fail","response":"Unknown url"}';
}
?>