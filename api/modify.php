<?php
$get = ($_GET);
//print_r($get);
switch($get['action']) {
    case 'single_content': 
                    if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                    if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type."));
                    if(!isset($get['field_name'])) print_error(array("status"=>"fail","response"=>"Undefined required field name."));
                    if(!isset($get['field_value'])) print_error(array("status"=>"fail","response"=>"Undefined field value."));
                    $output = put_single_content_info($get);
        break;
    default : unknown();
        break;
    
}
function put_single_content_info($get) {
    include "paths.php";
    include $db_file_url;
    $cond='';
    //http://localhost:13080/apis/write/?action_object=single_content&uid=6585877897&field_name=note_text&field_value=gsdfhgdsf%20asagfadslgfaeew%20v%20sadfjasdfsdkjfhadsf&content_id=2&content_type=note
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
        echo json_encode('{"status":"fail","response":"'.$error.'"}');
    }
    die();
}
function unknown() 
{
    return array("status"=>"fail","response"=>"Unknown url");
}
?>