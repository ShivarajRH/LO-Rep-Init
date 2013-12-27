<?php
$output= '';
$get = ($_REQUEST);
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
    case 'search_content': 
                        if(!isset($get['requesting_uid'])) print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        if(!isset($get['query'])) print_error(array("status"=>"fail","response"=>"Undefined query.")); 
                        //if(!isset($get['filter_type'])) print_error(array("status"=>"fail","response"=>"Undefined filter type.")); 
                        $output= get_search_content_info($get); 
        break;
    case 'single_content': 
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
    $output=array(); $con='';
    //$uid=mysql_real_escape_string($get['uid']);
    $content_id=mysql_real_escape_string($get['content_id']);
    $content_type=mysql_real_escape_string($get['content_type']);
    //uid,content_id,file_id,visibility
    if($content_type == 'note') {
        //Notes
        $rslt = mysql_query("select c.uid,c.content_id,n.visibility,c.timestamp,n.note_id,n.note_text,n.visibility from tbl_notes n
                            join tbl_content c on c.content_id=n.content_id
                            where n.`content_id`=$content_id
                            order by c.timestamp desc",$linkid) or print_error(mysql_error($linkid));
        $i=0;$data_array=array();
        while ($row=mysql_fetch_array($rslt)) {
                    
            $data_array[$i]['uid'] = $row['uid'];
            $data_array[$i]['content_id'] = $row['content_id'];
            $data_array[$i]['note_id'] = $row['note_id'];
            $data_array[$i]['note_text'] = $row['note_text'];
            $data_array[$i]['visibility'] = $row['visibility'];
            $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
            $i++;
        }
        $output['notes'] = $data_array;
    }
    elseif($content_type == 'expense') {
            $rslt = mysql_query("select e.content_id,e.expense_id,e.expense_title,e.expense_amount,e.visibility from tbl_expenses e
            join tbl_content c on c.content_id=e.content_id
            where e.content_id=$content_id $con
            order by c.timestamp desc",$linkid) or print_error(mysql_error($linkid));

            if(mysql_errno($linkid)) {
                print_error(mysql_error($linkid));
            }
            else {
                $i=0;$data_array=array();
                while($row = mysql_fetch_assoc($rslt)) {
                    
                    $data_array[$i]['expense_id']=$row['expense_id'];
                    $data_array[$i]['content_id']=$row['content_id'];
                    $data_array[$i]['expense_title']=$row['title'];
                    $data_array[$i]['expense_amount']=$row['amount'];
                    $data_array[$i]['visibility']=$row['visibility'];
                    $i++;
                }
                $output['expenses'] = $data_array;
            }
    }
    elseif($content_type == 'reminder') {
        $rslt = mysql_query("select c.content_id,reminder_id,remind_time,reminder_name,visibility
            from tbl_reminders where `content_id`=$content_id
            order by remind_time desc",$linkid) or print_error(mysql_error($linkid));
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
    }
    else { $output = unknown(); }
    return $output;
}
function get_list_content_info($get) {
    include "paths.php";
    include $db_file_url;
    //http://localhost:13080/apis/search/?action_object=list_content&uid=65858778973333
    //&content_type=all&filter_type=time&filter_from=2013-08-12&filter_to=2013-10-01
    $output=array(); $con='';
    $uid=mysql_real_escape_string($get['uid']);
    $limit_start = $lat=(!isset($get['limit_start']))? '0' : mysql_real_escape_string(urldecode($get['limit_start']))-1;
    $limit_end = $lat=(!isset($get['limit_end']))? '35' : mysql_real_escape_string(urldecode($get['limit_end']));
    
    
    if($get['content_type'] == 'all') {
        //expense total
            $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses e
                where e.`uid`=$uid limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['expense_total'] = $row['ttl_expense'];
                    
                    
            //reminders
            $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                                join tbl_content c on c.content_id=r.content_id
                                where r.`uid`='$uid' order by r.reminder_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
            
            //Notes
            $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                join tbl_content c on c.content_id=n.content_id
                                where n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $i=0;$data_array=array();
            while ($row=mysql_fetch_array($rslt)) {
                
                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['note_id'] = $row['note_id'];
                $data_array[$i]['note_text'] = $row['note_text'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
                $i++;
            }
            $output['notes'] = $data_array;
            
            
    }
    elseif($get['content_type'] == 'note') {
            
            $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                join tbl_content c on c.content_id=n.content_id
                                where n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            
            $i=0;$data_array=array();
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['note_id'] = $row['note_id'];
                $data_array[$i]['note_text'] = $row['note_text'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
                $i++;
            }
            $output['notes'] = $data_array;
        
    }
    elseif($get['content_type'] == 'expense') {
        
            //expense total
            $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses 
                where `uid`=$uid limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['expense_total'] = $row['ttl_expense'];
//            $output['currency'] = $row['currency'];

            if($get['filter_type']=='time') {
                if(!isset($get['filter_from'])) print_error(array("status"=>"fail","response"=>"Please specify filter from."));
                //if(!isset($get['filter_to'])) print_error(array("status"=>"fail","response"=>"Please specify filter to."));
                $from= strtotime(urldecode($get['filter_from']));
                $to= isset($get['filter_to'])? strtotime(urldecode($get['filter_to'])) : time();
                $con .= ' and c.timestamp between '.$from.' and '.$to.' ';
            }
            /*$filter_from_str = urlencode(strtolower($get['filter_from']));
            if($get['filter_type']=='value') {
                $con = ' and e.title like "%'.$filter_from_str.'%" or e.desc like "%'.$filter_from_str.'%" ';
            }*/
        
            $rslt = mysql_query("select * from tbl_expenses e
                    join tbl_content c on c.content_id=e.content_id
                    where e.uid='$uid' $con order by e.expense_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
      
            if(mysql_errno($linkid)) {
                print_error(mysql_error($linkid));
            }
            else {
                
                $i=0;$data_array=array();
                while($row = mysql_fetch_assoc($rslt)) {
                    /*****/
                    $month=date("M",$row['timestamp']);
                    /*$data_array[$month][$i]['expense_id']=$row['expense_id'];
                    $data_array[$month][$i]['content_id']=$row['content_id'];
                    $data_array[$month][$i]['expense_title']=$row['title'];
                    $data_array[$month][$i]['expense_amount']=$row['amount'];*/
//                    $data_array[$month]['month_total']+=$row['amount'];
                    
                    
                    $data_array[$i]['expense_id']=$row['expense_id'];
                    $data_array[$i]['content_id']=$row['content_id'];
                    $data_array[$i]['expense_title']=$row['title'];
                    $data_array[$i]['expense_amount']=$row['amount'];
                    $data_array[$i]['month']=date("M",$row['timestamp']);;
                    $data_array[$i]['visibility']=$row['visibility'];
//                    $data_array[$i]['currency']=$row['currency'];
//                    $data_array[$month]['month_total']+=$row['amount'];
                    $i++;
                }
                $output['expenses'] = $data_array;
            }
    }
    elseif($get['content_type'] == 'reminder') {
            
            $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                join tbl_content c on c.content_id=r.content_id
                where r.`uid`='$uid' order by r.reminder_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
        
    }
    else { $output = unknown(); }
    return $output;
}
function get_search_content_info($get) {
    include "paths.php";
    include $db_file_url;
    include $myclass_url;
    
   
    $output=array(); $con='';
    
    $requesting_uid = mysql_real_escape_string($get['requesting_uid']);
    $query_str = mysql_real_escape_string(urldecode($get['query']));
    $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
    $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
    $timestamp=  (!isset($get['time']))? date("Y-m-d H:i:s",time()) : strtotime(mysql_real_escape_string(urldecode($get['timestamp']))); //Unix timestamp
    $src = $lat=(!isset($get['src']))? '' : mysql_real_escape_string(urldecode($get['src']));
    
    //insert to table
    $rslt= mysql_query("insert into `tbl_queries`(`sno`,`query_id`,`query_string`,`uid`,`timestamp`,`lat`,`long`,`src`) 
        values ( NULL,NULL,'".$query_str."','".$uid."','".$timestamp."','.$lat.','.$long.','".$src."')", $linkid) or print_error(mysql_error($linkid));
    
    $sno = mysql_insert_id(); //"cnt".rand(8,getrandmax());
    
    mysql_query("update `tbl_queries` set `query_id`='$sno' where `sno`=$sno") or print_error(mysql_error($linkid));
    
    
    // skip stoping words
    $q_arr = explode(" ",$query_str);
    
    $ob = new myactions();
    $rdata = $ob->skip_stopwords($q_arr);
     $obj_query = json_encode($rdata);
    echo $obj_query;die();
    
//    $limit_start = $lat=(!isset($get['limit_start']))? '0' : mysql_real_escape_string(urldecode($get['limit_start']))-1;
//    $limit_end = $lat=(!isset($get['limit_end']))? '35' : mysql_real_escape_string(urldecode($get['limit_end']));
    
    
    if($get['content_type'] == 'all') {
        //expense total
            $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses e
                where e.`uid`=$uid limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['expense_total'] = $row['ttl_expense'];
                    
                    
            //reminders
            $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                                join tbl_content c on c.content_id=r.content_id
                                where r.`uid`='$uid' order by r.reminder_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
            
            //Notes
            $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                join tbl_content c on c.content_id=n.content_id
                                where n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $i=0;$data_array=array();
            while ($row=mysql_fetch_array($rslt)) {
                
                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['note_id'] = $row['note_id'];
                $data_array[$i]['note_text'] = $row['note_text'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
                $i++;
            }
            $output['notes'] = $data_array;
            
            
    }
    elseif($get['content_type'] == 'note') {
            
            $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                join tbl_content c on c.content_id=n.content_id
                                where n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            
            $i=0;$data_array=array();
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['note_id'] = $row['note_id'];
                $data_array[$i]['note_text'] = $row['note_text'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
                $i++;
            }
            $output['notes'] = $data_array;
        
    }
    elseif($get['content_type'] == 'expense') {
        
            //expense total
            $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses 
                where `uid`=$uid limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $row = mysql_fetch_array($rslt);
            $output['expense_total'] = $row['ttl_expense'];
//            $output['currency'] = $row['currency'];

            if($get['filter_type']=='time') {
                if(!isset($get['filter_from'])) print_error(array("status"=>"fail","response"=>"Please specify filter from."));
                //if(!isset($get['filter_to'])) print_error(array("status"=>"fail","response"=>"Please specify filter to."));
                $from= strtotime(urldecode($get['filter_from']));
                $to= isset($get['filter_to'])? strtotime(urldecode($get['filter_to'])) : time();
                $con .= ' and c.timestamp between '.$from.' and '.$to.' ';
            }
            /*$filter_from_str = urlencode(strtolower($get['filter_from']));
            if($get['filter_type']=='value') {
                $con = ' and e.title like "%'.$filter_from_str.'%" or e.desc like "%'.$filter_from_str.'%" ';
            }*/
        
            $rslt = mysql_query("select * from tbl_expenses e
                    join tbl_content c on c.content_id=e.content_id
                    where e.uid='$uid' $con order by e.expense_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
      
            if(mysql_errno($linkid)) {
                print_error(mysql_error($linkid));
            }
            else {
                
                $i=0;$data_array=array();
                while($row = mysql_fetch_assoc($rslt)) {
                    /*****/
                    $month=date("M",$row['timestamp']);
                    /*$data_array[$month][$i]['expense_id']=$row['expense_id'];
                    $data_array[$month][$i]['content_id']=$row['content_id'];
                    $data_array[$month][$i]['expense_title']=$row['title'];
                    $data_array[$month][$i]['expense_amount']=$row['amount'];*/
//                    $data_array[$month]['month_total']+=$row['amount'];
                    
                    
                    $data_array[$i]['expense_id']=$row['expense_id'];
                    $data_array[$i]['content_id']=$row['content_id'];
                    $data_array[$i]['expense_title']=$row['title'];
                    $data_array[$i]['expense_amount']=$row['amount'];
                    $data_array[$i]['month']=date("M",$row['timestamp']);;
                    $data_array[$i]['visibility']=$row['visibility'];
//                    $data_array[$i]['currency']=$row['currency'];
//                    $data_array[$month]['month_total']+=$row['amount'];
                    $i++;
                }
                $output['expenses'] = $data_array;
            }
    }
    elseif($get['content_type'] == 'reminder') {
            
            $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                join tbl_content c on c.content_id=r.content_id
                where r.`uid`='$uid' order by r.reminder_id desc limit $limit_start,$limit_end",$linkid) or print_error(mysql_error($linkid));
            $i=0;
            while ($row=mysql_fetch_array($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $row['reminder_name'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                $i++;
            }
            $output['reminders'] = $data_array;
        
    }
    else { $output = unknown(); }
    return $output;
}

function get_user_profile($uid) {
    include "paths.php";
    include $db_file_url;
    
    $rslt=mysql_query("SELECT * FROM `generic_profile` WHERE `uid`='$uid'",$linkid);
    if(mysql_errno($linkid)) {
        $rslt_arr=array("status"=>"fail","response"=>mysql_error($linkid));
    }
    else {
        if(mysql_affected_rows($linkid) > 0) {
            while($row = mysql_fetch_assoc($rslt)) {
                $result['uid']=$row['uid'];
                $result['gid']=$row['gid'];
                $result['fname']=$row['fname'];
                $result['lname']=$row['lname'];
                $result['name']=$row['name'];
                $result['img_url']=$row['img_url'];
                $result['currency']=$row['currency'];
            }
        }
        else {
            $result['fail']="No Records found.";
        }
        //$result['rows']=mysql_affected_rows($linkid);
        
        $rslt_arr = array($result);
    }
    return $rslt_arr;
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