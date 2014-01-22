<?php
$output= '';
$get = ($_REQUEST);
include "paths.php";
include $myclass_url;

/**
 * Search api
 */
class search extends myactions {
    function __construct() { }
    /********************************************************************************************/
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
                $sql="select * from tbl_expenses e
                        join tbl_content c on c.content_id=e.content_id
                        where e.uid='$uid' $con 
                        order by c.timestamp asc
                        limit $limit_start,$limit_end";
                $rslt = mysql_query($sql,$linkid) or $this->print_error($sql.''.mysql_error($linkid));

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
    
    /********************************************************************************************/
    
    /**
     * Search in tag content table using tag, content_type and uid(optional).
     * Display public content and private content of uid_requesting return JSON.
     * @example WITH UID= /api/search/?&action_object=tag_content&content_type=note&tag=food
     * &uid=101651219808545508511&requesting_uid=104219296596850018797&privacy=pub&time=2013-12-28+10%3A07%3A12
     * &lat=112&long=76
     * @example WITHOUT UID=/api/search/?&action_object=tag_content&content_type=note&tag=hello&uid=
     * &requesting_uid=&privacy=&time=2013-12-28+10%3A07%3A12
     * @param type Array
     * @return array Array
     */
    function get_tag_content_info($get) {
        $linkid=$this->db_conn();
        $output=array(); $con='';

        $tag_str = mysql_real_escape_string(urldecode($get['tag']));
        $requesting_uid = mysql_real_escape_string(urldecode($get['requesting_uid']));
        
        $content_type = (!isset($get['content_type']))? 'all' : mysql_real_escape_string(urldecode($get['content_type']));
        $uid = (!isset($get['uid']))? '' : mysql_real_escape_string(urldecode($get['uid']));
//        $privacy=(!isset($get['privacy']))? 'pub' : mysql_real_escape_string(urldecode($get['privacy']));
//        $timestamp=  (!isset($get['time']))? date("Y-m-d H:i:s",time()) : strtotime(mysql_real_escape_string(urldecode($get['timestamp']))); //Unix timestamp
//        $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
//        $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
//        $src=(!isset($get['src']))? 'pub' : mysql_real_escape_string(urldecode($get['src']));
        
        
        //insert to table
        $rslt= mysql_query("insert into `tbl_queries`(`sno`,`query_id`,`query_string`,`uid`,`timestamp`,`lat`,`long`,`src`) 
            values ( NULL,NULL,'".$tag_str."','".$uid."','".$timestamp."','.$lat.','.$long.','".$src."')", $linkid) or $this->print_error(mysql_error($linkid));
//        $sno = mysql_insert_id(); //"cnt".rand(8,getrandmax());
//        mysql_query("update `tbl_queries` set `query_id`='$sno' where `sno`=$sno") or $this->print_error(mysql_error($linkid));
       
        
        // search core query
        $list_content_info =  $this->get_srch_tags_data($tag_str,$requesting_uid,$uid,$content_type,$privacy);
//        echo '<pre>';print_r($list_content_info); die();
        if($list_content_info['status']=='fail') {
            $this->print_error($list_content_info);
        }
         else {
                foreach ($list_content_info as $type => $data_arr) {
                    if(!empty($data_arr)) {
                        $output[$type] = array_map("unserialize", array_unique(array_map("serialize", $data_arr)));
                    }
                    else {
                        $output[$type] =$data_arr;
                    }
                }
    //            echo '<pre>';print_r($output); die();
                return $output;
        }
    }
    /**
     * Search in tag content table using tag, content_type and uid(optional).
     * Display public content and private content of uid_requesting return JSON.
     * @example WITH UID= /api/search/?&action_object=tag_content&content_type=note&tag=food
     * &uid=101651219808545508511&requesting_uid=104219296596850018797&privacy=pub&time=2013-12-28+10%3A07%3A12
     * &lat=112&long=76
     * @example WITHOUT UID=/api/search/?&action_object=tag_content&content_type=note&tag=hello&uid=
     * &requesting_uid=&privacy=&time=2013-12-28+10%3A07%3A12
     * @param type Array
     * @return array Array
     */
    function get_srch_tag_content_info($get) {
        $linkid=$this->db_conn();
        $output=array(); $con='';

        $tag_str = mysql_real_escape_string(urldecode($get['tag']));
        $requesting_uid = mysql_real_escape_string(urldecode($get['requesting_uid']));
        
        $content_type = (!isset($get['content_type']))? 'all' : mysql_real_escape_string(urldecode($get['content_type']));
        $uid = (!isset($get['uid']))? '' : mysql_real_escape_string(urldecode($get['uid']));
        $privacy=(!isset($get['privacy']))? 'pub' : mysql_real_escape_string(urldecode($get['privacy']));
        $timestamp=  (!isset($get['time']))? date("Y-m-d H:i:s",time()) : strtotime(mysql_real_escape_string(urldecode($get['timestamp']))); //Unix timestamp
        $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
        $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
        $src=(!isset($get['src']))? 'pub' : mysql_real_escape_string(urldecode($get['src']));
        
        
        //insert to table
        $rslt= mysql_query("insert into `tbl_queries`(`sno`,`query_id`,`query_string`,`uid`,`timestamp`,`lat`,`long`,`src`) 
            values ( NULL,NULL,'".$tag_str."','".$uid."','".$timestamp."','.$lat.','.$long.','".$src."')", $linkid) or $this->print_error(mysql_error($linkid));
        $sno = mysql_insert_id(); //"cnt".rand(8,getrandmax());
        mysql_query("update `tbl_queries` set `query_id`='$sno' where `sno`=$sno") or $this->print_error(mysql_error($linkid));
       
        
        // search core query
        $list_content_info =  $this->get_srch_tags_data($tag_str,$requesting_uid,$uid,$content_type,$privacy);
//        echo '<pre>';print_r($list_content_info); die();
        if($list_content_info['status']=='fail') {
            $this->print_error($list_content_info);
        }
         else {
                foreach ($list_content_info as $type => $data_arr) {
                    if(!empty($data_arr)) {
                        //if($type == 'tags')
                            $output[$type] = array_map("unserialize", array_unique(array_map("serialize", $data_arr)));
                        //else
                         //   $output[$type] = $data_arr;
                    }
                    else {
                        $output[$type] = $data_arr;
                    }
                }
                echo '<pre>';print_r($output); die();
                return $output;
        }
    }
    
    /**
     * Get matched tag ids
     * @param type $query_str string
     * @param type $uid big int
     * @param type $content_type string
     * @param type $privacy string
     * @return type String
     */
    function get_srch_tags_data($query_str,$requesting_uid,$uid,$content_type,$privacy='pub') {
        $linkid=$this->db_conn();$cond = '';
        
        if($content_type == 'all' || $content_type == 'note' || $content_type == 'reminder' 
                || $content_type == 'expense' ) {
            
                    if($content_type == 'all') {
                        //$cond .= '';
                    }
                    else {
                        $cond .= " and content_type='$content_type' and ";
                    }
                    
                    // return all pub
                    // if uid => return private content of uid
                    
                    if($cond == '') { $cond .= " and "; }
                    
                    $cond .= " tc.privacy='pub' and tc.tag_string like '%$query_str%' ";
                    
                    if($requesting_uid != '') {
                        $cond .= " or ( tc.`uid`='".$requesting_uid."' and tc.privacy='pri' and tc.tag_string like '%$query_str%' ) ";
                    }
                    
                    if($content_type == 'note' || $content_type == 'all') {
                            //limit $limit_start,$limit_end
                            $sql = "select * from tbl_tag_content tc
                                    join tbl_notes n on n.content_id = tc.content_id
                                                where tc.tag_string like '%$query_str%' $cond ";

                            $rslt= mysql_query($sql,$linkid) or $this->print_error(mysql_error($linkid).' Query='.$sql);

        //                    $this->print_error($sql);
                            $i=0;$data_array=array();
                            while ($row=mysql_fetch_array($rslt)) {
                                    $data_array[$i]['tag_id'] = $row['tag_id'];
                                    $data_array[$i]['content_id'] = $row['content_id'];
                                    $data_array[$i]['note_id'] = $row['note_id'];
                                    $data_array[$i]['note_text'] = $row['note_text'];
                                    $data_array[$i]['visibility'] = $row['visibility'];
                                    $data_array[$i]['tag_string'] = $this->format_text($row['tag_string']);
                                    $data_array[$i]['uid'] = $this->format_text($row['uid']);
                                    $data_array[$i]['timestamp'] = $row['timestamp'];
                                    //$data_array[$i]['privacy'] = $row['privacy'];
                                    $i++;
                            }
                            //$output['sql'] = $sql;
                            $output['notes'] = $data_array;
                    }
                    elseif($content_type == 'expense' || $content_type == 'all') {
                            //limit $limit_start,$limit_end
                            $sql = "select * from tbl_tag_content tc
                                    join tbl_expenses e on e.content_id = tc.content_id
                                                where tc.tag_string like '%$query_str%' $cond ";

                            $rslt= mysql_query($sql,$linkid) or $this->print_error(mysql_error($linkid).' Query='.$sql);

        //                    $this->print_error($sql);
                            $i=0;$data_array=array();
                            while ($row=mysql_fetch_array($rslt)) {
                                    $data_array[$i]['tag_id'] = $row['tag_id'];
                                    $data_array[$i]['content_id'] = $row['content_id'];
                                    $month=date("M",$row['timestamp']);
                                    $data_array[$i]['expense_id'] = $row['expense_id'];
                                    $data_array[$i]['content_id'] = $row['content_id'];
                                    $data_array[$i]['title'] = $this->format_text($row['title']);
                                    $data_array[$i]['expense_title']=$this->format_text($row['title']);
                                    $data_array[$i]['desc'] = $this->format_text($row['desc']);
                                    $data_array[$i]['amount'] = $row['amount'];
                                    $data_array[$i]['expense_amount']=$row['amount'];
                                    $data_array[$i]['visibility'] = $row['visibility'];
                                    $data_array[$i]['uid'] = $row['uid'];
                                    $data_array[$i]['month']=$month;
                
                                    $i++;
                            }
                            //$output['sql'] = $sql;
                            $output['expenses'] = $data_array;
                    }
                    elseif($content_type == 'reminder' || $content_type == 'all') {
                            //limit $limit_start,$limit_end
                            $sql = "select * from tbl_tag_content tc
                                    join tbl_reminders r on r.content_id = tc.content_id
                                                where tc.tag_string like '%$query_str%' $cond ";

                            $rslt= mysql_query($sql,$linkid) or $this->print_error(mysql_error($linkid).' Query='.$sql);

        //                    $this->print_error($sql);
                            $i=0;$data_array=array();
                            while ($row=mysql_fetch_array($rslt)) {
                                    $data_array[$i]['tag_id'] = $row['tag_id'];
                                    $data_array[$i]['content_id'] = $row['content_id'];
                                    $data_array[$i]['reminder_id'] = $row['reminder_id'];
                                    $data_array[$i]['reminder_name'] = $this->format_text($row['reminder_name']);
                                    $data_array[$i]['visibility'] = $row['visibility'];
                                    $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
                                    $i++;
                            }
                            //$output['sql'] = $sql;
                            $output['reminders'] = $data_array;
                    }
            }
            else { $output = $this->unknown(); }
            return $output;
    }
    
    /**
     * 
     * @param type array
     * @return array array
     * @example 1./api/search/?action_object=search_content&requesting_uid=101651219808545508511
     * &query=sh&content_type=reminder&time=2013-12-28+10%3A07%3A12&lat=112&long=76&src=stream With UID(All public & pri of UID)
     * @example 2./api/search/?action_object=search_content&requesting_uid=&query=finish
     * &content_type=all&time=2013-12-28+10%3A07%3A12&lat=112&long=76&src=stream Without UID(All public)
     */
    function get_srch_content_info($get) {
        $linkid=$this->db_conn();
        $output=array(); $con='';

        $requesting_uid = mysql_real_escape_string(urldecode($get['requesting_uid']));
        $query_str = mysql_real_escape_string(urldecode($get['query']));
        $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
        $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
        $timestamp=  (!isset($get['time']))? date("Y-m-d H:i:s",time()) : strtotime(mysql_real_escape_string(urldecode($get['time']))); //Unix timestamp
        $src = $lat=(!isset($get['src']))? '' : mysql_real_escape_string(urldecode($get['src']));
//        $visibility =(!isset($get['visibility']))? 'pub' : mysql_real_escape_string(urldecode($get['visibility']));

        $content_type = (!isset($get['content_type']))? 'all' : mysql_real_escape_string(urldecode($get['content_type']));
        
        //insert to table
        $rslt= mysql_query("insert into `tbl_queries`(`sno`,`query_id`,`query_string`,`uid`,`timestamp`,`lat`,`long`,`src`) 
            values ( NULL,NULL,'".$query_str."','".$uid."','".$timestamp."','.$lat.','.$long.','".$src."')", $linkid) or $this->print_error(mysql_error($linkid));

        $sno = mysql_insert_id(); //"cnt".rand(8,getrandmax());

        mysql_query("update `tbl_queries` set `query_id`='$sno' where `sno`=$sno") or $this->print_error(mysql_error($linkid));
        
        
        // search core query
        $list_content_info =  $this->get_query_content($query_str,$requesting_uid,$content_type);
        
        if($list_content_info['status']=='fail') {
            $this->print_error($list_content_info);
        }
         else {
             /*
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

                                if(!in_array($content_id, $prior)) {

                                    $list_content_info[$type][]=$res;
                                }
                            }
                        }
                    }
                    $type='profile';
                    if(count($temp_res[$type])) {
                        foreach($temp_res[$type] as $i=>$res){
                            foreach($list_content_info[$type] as $prior) {
                                    $list_content_info[$type][]=$res;
                            }
                        }
                    }
                }//Keyword loop ends
                */
//             if($list_content_info)
             
             
                foreach ($list_content_info as $type => $data_arr) {
                    if(!empty($data_arr)) {
                        $output[$type] = array_map("unserialize", array_unique(array_map("serialize", $data_arr)));
                    }
                    else {
                        $output[$type] =$data_arr;
                    }
                }
    //            echo '<pre>';print_r($output); die();
                return $output;
        }
       
    }
    
    function get_srch_expense($query_str,$cond) {      
        $linkid=$this->db_conn();

        // limit $limit_start,$limit_end
        $sql="select * from tbl_expenses e 
            join tbl_content c on c.content_id=e.content_id
            where (e.title like '%$query_str%' or e.desc like '%$query_str%') 
            and ( $cond ) 
            order by e.expense_id desc";
        $rslt = mysql_query($sql,$linkid) or $this->print_error(mysql_error($linkid));

        $i=0;$data_array=array();
        while ($row=mysql_fetch_assoc($rslt)) {
                $month=date("M",$row['timestamp']);
                $data_array[$i]['expense_id'] = $row['expense_id'];
                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['title'] = $this->format_text($row['title']);
                $data_array[$i]['expense_title']=$this->format_text($row['title']);
                $data_array[$i]['desc'] = $this->format_text($row['desc']);
                $data_array[$i]['amount'] = $row['amount'];
                $data_array[$i]['expense_amount']=$row['amount'];
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['uid'] = $row['uid'];
                $data_array[$i]['month']=$month;
//                    $data_array[$i]['currency']=$row['currency'];
//                    $data_array[$month]['month_total']+=$row['amount'];
                $i++;
        }
        return $data_array;
    }
    
    function get_srch_reminder($query_str,$cond) {
            $linkid=$this->db_conn();
        
            //reminders limit $limit_start,$limit_end
            $rslt = mysql_query("select c.uid,c.content_id,r.reminder_id,r.remind_time,r.reminder_name,r.visibility from tbl_reminders r
                                join tbl_content c on c.content_id=r.content_id
                                where r.reminder_name like '%$query_str%'  
                                and ( $cond ) 
                                order by r.reminder_id desc",$linkid) or $this->print_error(mysql_error($linkid));
            $i=0;$data_array=array();
            while ($row=mysql_fetch_assoc($rslt)) {

                $data_array[$i]['content_id'] = $row['content_id'];
                $data_array[$i]['reminder_id'] = $row['reminder_id'];
                $data_array[$i]['reminder_name'] = $this->format_text($row['reminder_name']);
                $data_array[$i]['visibility'] = $row['visibility'];
                $data_array[$i]['remind_time'] = date("Y-m-d H:i:s",$row['remind_time']);
//                $data_array[$i]['uid'] = $row['uid'];
                $i++;
            }
            return $data_array;
    }
    
    function get_srch_note($query_str,$cond) {
        $linkid=$this->db_conn();
        //Notes limit $limit_start,$limit_end
        $rslt = mysql_query("select c.uid,c.content_id,n.note_id,n.note_text,n.visibility,c.timestamp from tbl_notes n
                            join tbl_content c on c.content_id=n.content_id
                            where n.note_text like '%$query_str%'  
                            and ( $cond )
                            order by n.note_id desc",$linkid) or $this->print_error(mysql_error($linkid));
        $i=0;$data_array=array();
        while ($row=mysql_fetch_assoc($rslt)) {

            $data_array[$i]['content_id'] = $row['content_id'];
            $data_array[$i]['note_id'] = $row['note_id'];
            $data_array[$i]['note_text'] = $this->format_text($row['note_text']);
            $data_array[$i]['visibility'] = $row['visibility'];
            $data_array[$i]['timestamp'] = date("Y-m-d H:i:s",$row['timestamp']);
//            $data_array[$i]['uid'] = $row['uid'];
            $i++;
        }
        return $data_array;
    }
    
    function get_srch_profile($query_str,$cond) {
        $linkid=$this->db_conn();
        //Profile
        $rslt = mysql_query("select p.fname,p.lname,p.img_url,p.uid from generic_profile p 
                                where p.fname like '%$query_str%' or p.mname like '%$query_str%' 
                                or p.name like '%$query_str%' or p.uname like '%$query_str%'
                                order by p.fname desc",$linkid) or $this->print_error(mysql_error($linkid));
        $i=0;$data_array=array();
        while ($row=mysql_fetch_assoc($rslt)) {

            $data_array[$i]['fname'] = $this->format_text($row['fname']);
            $data_array[$i]['lname'] = $this->format_text($row['lname']);
            $data_array[$i]['name'] = $this->format_text($row['name']);
            $data_array[$i]['uname'] = $this->format_text($row['uname']);
//            $data_array[$i]['uid'] = $row['uid'];
            $i++;
        }
        return $data_array;
    }
    
    /**
     * Get matched content ids
     * @param type $query_str
     * @param type array
     */
    function get_query_content($query_str,$uid,$content_type) {

            $cond .= " ( c.visibility='pub' ) ";
            if($uid != '') {
                $cond .= " or ( c.`uid`='".$uid."' and c.visibility='pri' ) ";
            }
            
            
            if($content_type == 'all') {
               
                $output['expenses'] = $this->get_srch_expense($query_str,$cond);
                $output['reminders'] = $this->get_srch_reminder($query_str,$cond);
                $output['notes'] = $this->get_srch_note($query_str,$cond);
                $output['profile'] = $this->get_srch_profile($query_str,$cond);
                   
            }
            elseif($content_type == 'note') {
                    $output['notes'] = $this->get_srch_note($query_str,$cond);
            }
            elseif($content_type == 'expense') {
                
                $output['expenses'] = $this->get_srch_expense($query_str,$cond);
            }
            elseif($content_type == 'reminder') {
                $output['reminders'] = $this->get_srch_reminder($query_str,$cond);
                
            }
            elseif($content_type == 'profile') {
                $output['profile'] = $this->get_srch_profile($query_str,$cond);
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
                        if(!isset($get['content_type'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined content type."));
                        $output= $ob->get_srch_content_info($get);
                        break;
    
    case 'tag_content': 
                        if(!isset($get['requesting_uid'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined uid."));
                        if(!isset($get['tag'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined tag.")); 
//                        if(!isset($get['content_type'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined content type."));
                        $output= $ob->get_srch_tag_content_info($get); 
                        break;
                        
    case 'list_tag_content': 
                        if(!isset($get['requesting_uid'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined uid."));
//                        if(!isset($get['tag'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined tag.")); 
//                        if(!isset($get['content_type'])) $ob->print_error(array("status"=>"fail","response"=>"Undefined content type."));
                        $output= $ob->get_tag_content_info($get); 
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