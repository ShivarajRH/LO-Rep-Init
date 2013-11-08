<?php
$output= '';
$get = ($_GET);
switch($get['action_object']) {
    case 'user_profile':
                        if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        $output= get_user_profile($get['uid']); 
        break;
    case 'list_content': 
                        if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type.")); 
                        //if(!isset($get['filter_type'])) print_error(array("status"=>"fail","response"=>"Undefined filter type.")); 
                        $output= get_list_content_info($get); 
        break;
    case 'single_content': 
                        if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        if(!isset($get['content_id'])) print_error(array("status"=>"fail","response"=>"Undefined content id."));
                        if(!isset($get['content_type'])) print_error(array("status"=>"fail","response"=>"Undefined content type.")); 
                        $output= get_single_content_info($get); 
        break;
    default : unknown();
        break;
}
#echo '<pre>'; 
echo json_encode($output); 
#echo '</pre>';

function get_single_content_info($get) {
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
function get_list_content_info($get) {
    include "paths.php";
    include $db_file_url;
    //http://localhost:13080/apis/search/?action_object=list_content&uid=65858778973333
    //&content_type=all&filter_type=time&filter_from=2013-08-12&filter_to=2013-10-01
    $output=array(); $con='';
    $uid=mysql_real_escape_string($get['uid']);
       
    if($get['content_type'] == 'all') {
        $arr_res=array();
        
        $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses where `uid`=$uid",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        $output['expense_total'] = $row['ttl_expense'];
        
        $rslt = mysql_query("select remind_time,reminder_name from tbl_reminders where `uid`=$uid",$linkid) or print_error(mysql_error($linkid));
        $arr_rslt = mysql_fetch_array($rslt);
        foreach ($arr_res as $row) {
            $output[]['reminder_name'] = $row['reminder_name'];
            $output[]['remind_time'] = $row['remind_time'];
        }
//http://localhost:13080/api/search/?action_object=list_content&uid=54694568990687&content_type=all
        
        /*$sql = "select *
                from generic_profile g
                left join tbl_content c using(uid)
                join tbl_notes n on n.content_id=c.content_id
                where c.uid=$uid $con";
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
         */
    }
    if($get['content_type'] == 'note' || $get['content_type'] == 'all') {
        $arr_res=array();
        if($get['filter_type']=='value') {
            $con .= ' and n.note_text like "%'.$filter_from_str.'%" ';
        }
        $sql = "select *
                from generic_profile g
                left join tbl_content c using(uid)
                join tbl_notes n on n.content_id=c.content_id
                where c.uid=$uid $con";
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
    if($get['content_type'] == 'expense' || $get['content_type'] == 'all') {
        if($get['filter_type']=='time') {
            $from= strtotime(urldecode($get['filter_from']));
            $to= strtotime(urldecode($get['filter_to']));
            $con .= ' and c.timestamp between '.$from.' and '.$to.' ';
        }
        $filter_from_str = urlencode(strtolower($get['filter_from']));

        if($get['filter_type']=='value') {
            $con = ' and e.title like "%'.$filter_from_str.'%" or e.desc like "%'.$filter_from_str.'%" ';
        }
        
        $rslt = mysql_query("select * 
                    from generic_profile g
                    join tbl_content c  on c.uid=g.uid
                    join tbl_expenses e on e.content_id=c.content_id
                    where c.uid=$uid  $con",$linkid) or print_error(mysql_error($linkid));
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
    if($get['content_type'] == 'reminder' || $get['content_type'] == 'all') {
        if($get['filter_type']=='value') {
            $con = ' and r.reminder_name like "%'.$filter_from_str.'%" ';
        }
        $rslt = mysql_query("select * 
                    from generic_profile g
                    join tbl_content c  on c.uid=g.uid
                    join tbl_reminders r on r.content_id=c.content_id
                    where c.uid=$uid  $con",$linkid) or print_error(mysql_error($linkid));;
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

function get_user_profile($uid) {
    include "paths.php";
    include $db_file_url;
    
    $rslt=mysql_query("select * from generic_profile where uid=$uid",$linkid);
    if(mysql_errno($linkid)) {
        $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
    }
    else {
        while($row = mysql_fetch_assoc($rslt)) {
            $result['uid']=$row['uid'];
            $result['gid']=$row['gid'];
            $result['name']=$row['name'];
        }
        $rslt_arr = array($result);
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