<?php
$output= '';
$get = ($_REQUEST);
include "paths.php";
include $myclass_url;

/**
 * Search api
 */
class search extends myactions {
    function __construct() {
    }
    /**
     * Get single content api
     * @param type $get
     * @return type array
     */
    function get_single_content_info($get) {
        $linkid=$this->db_conn();
        
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
                                order by c.timestamp desc",$linkid) or $this->print_error(mysql_error($linkid));
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
                order by c.timestamp desc",$linkid) or $this->print_error(mysql_error($linkid));

                if(mysql_errno($linkid)) {
                    $this->print_error(mysql_error($linkid));
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
                order by remind_time desc",$linkid) or $this->print_error(mysql_error($linkid));
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
    /**
     * Get list content
     * @param type $get
     * @return type array
     */
    function get_list_content_info($get) {
        $linkid=$this->db_conn();
        $output=array(); $con='';
        $uid=mysql_real_escape_string($get['uid']);
        $limit_start = $lat=(!isset($get['limit_start']))? '0' : mysql_real_escape_string(urldecode($get['limit_start']))-1;
        $limit_end = $lat=(!isset($get['limit_end']))? '35' : mysql_real_escape_string(urldecode($get['limit_end']));


        if($get['content_type'] == 'all') {
            //expense total
                $rslt = mysql_query("select sum(amount) as ttl_expense from tbl_expenses e
                    where e.`uid`=$uid limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));
                $row = mysql_fetch_array($rslt);
                $output['expense_total'] = $row['ttl_expense'];


                //reminders
                $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                                    join tbl_content c on c.content_id=r.content_id
                                    where r.`uid`='$uid' order by r.reminder_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));
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
                                    where n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));
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
                                    where n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));

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
                    where `uid`=$uid limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));
                $row = mysql_fetch_array($rslt);
                $output['expense_total'] = $row['ttl_expense'];
    //            $output['currency'] = $row['currency'];

                if($get['filter_type']=='time') {
                    if(!isset($get['filter_from'])) $this->print_error(array("status"=>"fail","response"=>"Please specify filter from."));
                    //if(!isset($get['filter_to'])) $this->print_error(array("status"=>"fail","response"=>"Please specify filter to."));
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
                        where e.uid='$uid' $con order by e.expense_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));

                if(mysql_errno($linkid)) {
                    $this->print_error(mysql_error($linkid));
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
                    where r.`uid`='$uid' order by r.reminder_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));
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
    
    /**
     * 
     * @param type $get
     * @return array array
     */
    function get_search_content_info($get) {
        $linkid=$this->db_conn();
        $output=array(); $con='';

        $requesting_uid = mysql_real_escape_string(urldecode($get['requesting_uid']));
        $query_str = mysql_real_escape_string(urldecode($get['query']));
        $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
        $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
        $timestamp=  (!isset($get['time']))? date("Y-m-d H:i:s",time()) : strtotime(mysql_real_escape_string(urldecode($get['timestamp']))); //Unix timestamp
        $src = $lat=(!isset($get['src']))? '' : mysql_real_escape_string(urldecode($get['src']));

        $content_type = mysql_real_escape_string(urldecode($get['content_type']));
        
        //insert to table
        $rslt= mysql_query("insert into `tbl_queries`(`sno`,`query_id`,`query_string`,`uid`,`timestamp`,`lat`,`long`,`src`) 
            values ( NULL,NULL,'".$query_str."','".$uid."','".$timestamp."','.$lat.','.$long.','".$src."')", $linkid) or $this->print_error(mysql_error($linkid));

        $sno = mysql_insert_id(); //"cnt".rand(8,getrandmax());

        mysql_query("update `tbl_queries` set `query_id`='$sno' where `sno`=$sno") or $this->print_error(mysql_error($linkid));
        
        
        // search core query
        $list_content_info=  $this->get_query_content($query_str,$requesting_uid,$content_type);
        
        
        
        // skip stoping words
        $q_arr = explode(" ",$query_str);

        
        $rdata = $this->skip_stopwords($q_arr);
        //loop through each query words
        foreach ($rdata as $qry) {

            $temp_res = $this->get_query_content($qry,$requesting_uid,$content_type);
            
            $type = 'expenses';
            if(count($temp_res[$type])) {
                foreach($temp_res[$type] as $i=>$res) {
                    $content_id=$res['content_id'];
                    if(in_array($content_id, $list_content_info[$type])) {
//                        echo 'already in array..';
                    }
                    else {
                        //skipped
                        $list_content_info[$type][]=$res;
                    }
                }
            }
            $type='reminders';
            if(count($temp_res[$type])) {
                foreach($temp_res[$type] as $i=>$res) {
                    $content_id=$res['content_id'];
                    if(in_array($content_id, $list_content_info[$type])) {
//                        echo 'already in array..';
                    }
                    else {
                        //skipped
                        $list_content_info[$type][]=$res;
                    }
                }
            }
            
            $type='notes';
            if(count($temp_res[$type])) {
                foreach($temp_res[$type] as $i=>$res) {
                    $content_id=$res['content_id'];
                    
                    foreach($list_content_info[$type] as $prior) {
                        
//                        echo '<br>'.$content_id.'=='.$prior['content_id'].'<br>';
                        
                        if(in_array($content_id, $prior)) {
                            
//                            echo 'already in array..';
                            
                        }
                        else {
                            //skipped
                            $list_content_info[$type][]=$res;
                            
                            //array_unique($list_content_info[$type]);
                        }
                    }
                }
            }
            
            
        }
        
//        echo '<pre>';print_r($list_content_info); die();
        $output = $list_content_info;
//        $obj_query = json_encode($rdata);echo $obj_query;exit();

        return $output;
    }
    
    /**
     * Get matched content ids
     * @param type $query_str
     * @param type array
     */
    function get_query_content($query_str,$uid,$content_type) {
        $linkid=$this->db_conn();
        
        //limit $limit_start,$limit_end
            if($content_type == 'all') {
                    $sql="select * from tbl_expenses e where (e.title like '%$query_str%' or e.desc like '%$query_str%' )  and e.`uid`=$uid";
                    $rslt = mysql_query($sql,$linkid) or $this->print_error(mysql_error($linkid));
                    
                    $i=0;$data_array=array();
                    while ($row=mysql_fetch_array($rslt)) {
                            
                            $data_array[$i]['expense_id'] = $row['expense_id'];
                            $data_array[$i]['content_id'] = $row['content_id'];
                            $data_array[$i]['title'] = $row['title'];
                            $data_array[$i]['desc'] = $row['desc'];
                            $data_array[$i]['amount'] = $row['amount'];
                            $data_array[$i]['visibility'] = $row['visibility'];
                            $i++;
                    }
                    $output['expenses'] = $data_array;
                    
                    //reminders limit $limit_start,$limit_end
                    $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                                        join tbl_content c on c.content_id=r.content_id
                                        where r.reminder_name like '%$query_str%' and r.`uid`='$uid' order by r.reminder_id desc",$linkid) or $this->print_error(mysql_error($linkid));
                    $i=0;$data_array=array();
                    while ($row=mysql_fetch_array($rslt)) {

                        $data_array[$i]['content_id'] = $row['content_id'];
                        $data_array[$i]['reminder_id'] = $row['reminder_id'];
                        $data_array[$i]['reminder_name'] = $row['reminder_name'];
                        $data_array[$i]['visibility'] = $row['visibility'];
                        $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                        $i++;
                    }
                    $output['reminders'] = $data_array;
                    
                    //Notes limit $limit_start,$limit_end
                    $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                        join tbl_content c on c.content_id=n.content_id
                                        where n.note_text like '%$query_str%' and n.`uid`='$uid' order by n.note_id desc",$linkid) or $this->print_error(mysql_error($linkid));
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
            elseif($content_type == 'note') {

                    $rslt = mysql_query("select c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                                        join tbl_content c on c.content_id=n.content_id
                                        where n.note_text like '%$query_str%' and n.`uid`='$uid' order by n.note_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));

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
            elseif($content_type == 'expense') {

                    $rslt = mysql_query("select * from tbl_expenses e
                            join tbl_content c on c.content_id=e.content_id
                            where (e.title like '%$query_str%' or e.desc like '%$query_str%') and e.uid='$uid' $con order by e.expense_id desc limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));

                    if(mysql_errno($linkid)) {
                        $this->print_error(mysql_error($linkid));
                    }
                    else {

                        $i=0;$data_array=array();
                        while($row = mysql_fetch_assoc($rslt)) {
                            $month=date("M",$row['timestamp']);
                            $data_array[$i]['expense_id']=$row['expense_id'];
                            $data_array[$i]['content_id']=$row['content_id'];
                            $data_array[$i]['expense_title']=$row['title'];
                            $data_array[$i]['expense_amount']=$row['amount'];
                            $data_array[$i]['month']=$month;
                            $data_array[$i]['visibility']=$row['visibility'];
        //                    $data_array[$i]['currency']=$row['currency'];
        //                    $data_array[$month]['month_total']+=$row['amount'];
                            $i++;
                        }
                        $output['expenses'] = $data_array;
                    }
            }
            elseif($content_type == 'reminder') {
                    // limit $limit_start,$limit_end
                    $rslt = mysql_query("select c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                        join tbl_content c on c.content_id=r.content_id
                        where r.reminder_name like '%$query_str%' and r.`uid`='$uid' order by r.reminder_id desc",$linkid) or $this->print_error(mysql_error($linkid));
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
            else { $output = $this->unknown(); }
            return $output;
    }
        
    /**
     * Get user profile by uid
     * @param type $uid int
     * @return type array
     */
    function get_user_profile($uid) {
        $linkid=$this->db_conn();

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
    
}


$ob = new search();
switch($get['action_object']) {
    case 'user_profile':
                        if(!isset($get['uid'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        $output= $ob->get_user_profile($get['uid']); 
        break;
    case 'list_content': 
                        if(!isset($get['uid'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        if(!isset($get['content_type'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined content type.")); 
                        //if(!isset($get['filter_type'])) print_error(array("status"=>"fail","response"=>"Undefined filter type.")); 
                        $output= $ob->get_list_content_info($get); 
        break;
    case 'search_content': 
                        if(!isset($get['requesting_uid'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        if(!isset($get['query'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined query.")); 
                        //if(!isset($get['filter_type'])) print_error(array("status"=>"fail","response"=>"Undefined filter type.")); 
                        $output= $ob->get_search_content_info($get); 
        break;
    case 'single_content': 
        
                        if(!isset($get['content_id'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined content id."));
                        if(!isset($get['content_type'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined content type.")); 
                        $output= $ob->get_single_content_info($get); 
        break;
    default : $output= $ob->unknown();
        break;
}
#echo '<pre>'; 
echo json_encode($output); 
#echo '</pre>';
?>