<?php
$output= '';
$get = ($_REQUEST);
//print_r($get);
switch($get['action_object']) {
    case 'user_count': 
                    if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined Content Type."));
                    $output = get_user_count($get);
        break;
        
    case 'table_actions': $output = table_actions($get);
        break;
    
    case 'content_count': 
                    if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined Content Type."));
                    if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined UID."));
                    $output = get_content_count($get);
                    
        break;
    default : $output = unknown();
        break;
    
}
echo json_encode($output);



function get_user_count($get) {
    include "paths.php"; include $db_file_url;
    
    $output=array(); $con='';
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));
    
    
    if($content_type == 'user_count') {
        $sql = "select count(*) as user_count from generic_profile";
        //echo '<pre>';die($sql);
        $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
            if(mysql_errno($linkid)) {
                $output=array("status"=>"fail","response"=>mysql_error($linkid));
            }
            else {
                $row = mysql_fetch_array($rslt);
                
                $output['user_count'] = $row['user_count'];
            }
    }
 else {
        $output = unknown();
    }
    return $output;
}

function get_content_count($get) {
    include "paths.php"; include $db_file_url;
    $cond=''; $output=array();
    $uid=mysql_real_escape_string(urldecode($get['uid']));
    $content_type=mysql_real_escape_string(urldecode($get['content_type']));
    #$timestamp=strtotime(mysql_real_escape_string(urldecode($get['timestamp'])));//Unix timestamp
    
    if($uid != 'all') {
        $rslt = mysql_query("select `uid` from `generic_profile` where `uid`='$uid'",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        if($row['uid']=='') { print_error("User/uid does not exits."); }

        $cond .= ' uid="'.$uid.'" ';
    }

    if($content_type == 'all') {
        if($cond != '') $cond = ' where '.$cond;
        $rslt = mysql_query("select count(*) as content_count from tbl_content $cond",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        $output['content_count'] = $row['content_count'];
    }
    elseif($content_type == 'note') {
            if($cond != '') $cond = ' and '.$cond.'" ';
            $sql="select count(*) as content_count from tbl_content where 1=1 and `content_type`='".$content_type."' $cond";
//            die($sql);
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['content_count'] = $row['content_count'];
    }
    elseif($content_type == 'expense') {
            if($cond != '') $cond = ' and '.$cond.'" ';
            $sql="select count(*) as content_count from tbl_content where 1=1 and `content_type`='".$content_type."' $cond";
//            die($sql);
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['content_count'] = $row['content_count'];
    }
    elseif($content_type == 'reminder') {
            if($cond != '') $cond = ' and '.$cond.'" ';
            $sql="select count(*) as content_count from tbl_content where 1=1 and `content_type`='".$content_type."' $cond";
//            die($sql);
            $rslt = mysql_query($sql,$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['content_count'] = $row['content_count'];
    }
    return $output;
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