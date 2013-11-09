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
                        //if(!isset($get['uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
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
    //$uid=mysql_real_escape_string($get['uid']);
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
        //expense total
        $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses where `uid`=$uid",$linkid) or print_error(mysql_error($linkid));
        $row = mysql_fetch_array($rslt);
        $output['expense_total'] = $row['ttl_expense'];
        //reminders
        $rslt = mysql_query("select reminder_id,remind_time,reminder_name from tbl_reminders where `uid`=$uid",$linkid) or print_error(mysql_error($linkid));
        $i=0;
        while ($row=mysql_fetch_array($rslt)) {
            
            $data_array[$i]['reminder_id'] = $row['reminder_id'];
            $data_array[$i]['reminder_name'] = $row['reminder_name'];
            $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
            $i++;
        }
        $output['reminders'] = $data_array;
        //Notes
        $rslt = mysql_query("select n.note_id,n.note_text,c.timestamp from tbl_notes n
                            join tbl_content c on c.content_id=n.content_id
                            where n.`uid`=$uid",$linkid) or print_error(mysql_error($linkid));
        $i=0;$data_array=array();
        while ($row=mysql_fetch_array($rslt)) {
            
            $data_array[$i]['note_id'] = $row['note_id'];
            $data_array[$i]['note_text'] = $row['note_text'];
            $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
            $i++;
        }
        $output['notes'] = $data_array;
    }
    if($get['content_type'] == 'note') {
        //Notes
        $rslt = mysql_query("select n.note_id,n.note_text,c.timestamp from tbl_notes n
                            join tbl_content c on c.content_id=n.content_id
                            where n.`uid`=$uid",$linkid) or print_error(mysql_error($linkid));
        $i=0;$data_array=array();
        while ($row=mysql_fetch_array($rslt)) {
            
            $data_array[$i]['note_id'] = $row['note_id'];
            $data_array[$i]['note_text'] = $row['note_text'];
            $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
            $i++;
        }
        $output['notes'] = $data_array;
    }
    if($get['content_type'] == 'expense') {
            //expense total
            $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses where `uid`=$uid",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['expense_total'] = $row['ttl_expense'];

        if($get['filter_type']=='time') {
            $from= strtotime(urldecode($get['filter_from']));
            $to= strtotime(urldecode($get['filter_to']));
            $con .= ' and c.timestamp between '.$from.' and '.$to.' ';
        }
        /*$filter_from_str = urlencode(strtolower($get['filter_from']));
        if($get['filter_type']=='value') {
            $con = ' and e.title like "%'.$filter_from_str.'%" or e.desc like "%'.$filter_from_str.'%" ';
        }*/
        
            $rslt = mysql_query("select * from tbl_expenses e
                    join tbl_content c on c.content_id=e.content_id
                    where e.uid=$uid $con",$linkid) or print_error(mysql_error($linkid));
      
            if(mysql_errno($linkid)) {
                print_error(mysql_error($linkid));
            }
            else {
                $i=0;$data_array=array();
                while($row = mysql_fetch_assoc($rslt)) {
                    /*$data_array[$i]['expense_id']=$row['expense_id'];
                    $data_array[$i]['content_id']=$row['content_id'];
                    $data_array[$i]['expense_title']=$row['title'];
                    $data_array[$i]['expense_amount']=$row['amount'];
                    $data_array[$i]['timestamp']=date("Y-m-d H:i:s",$row['timestamp']);
                    */
                    /*****/
                    $month=date("M",$row['timestamp']);
                    $data_array[$month][$i]['expense_id']=$row['expense_id'];
                    $data_array[$month][$i]['content_id']=$row['content_id'];
                    $data_array[$month][$i]['expense_title']=$row['title'];
                    $data_array[$month][$i]['expense_amount']=$row['amount'];
                    $data_array[$month]['month_total']+=$row['amount'];
                    $i++;
                }
                $output['expenses'] = $data_array;
            }
    }
    if($get['content_type'] == 'reminder') {
            $rslt = mysql_query("select reminder_id,remind_time,reminder_name from tbl_reminders where `uid`=$uid",$linkid) or print_error(mysql_error($linkid));
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
        
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