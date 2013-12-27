<?php 
 class myactions {
     /**
      * GET API Data
      * @param type $url
      * @param type $outtype
      * @param type $post
      * @return type array
      */
    function getApiContent($url,$outtype,$post='') {
            $content ='';
            if($post != '') {
                $post = http_build_query($post);
                $content = array(
                    "http" => array(
                        "method"=>"POST"
                        ,"header"=> "custom-header: if-any\r\n" .
                                    "custom-header-two: custome-value-2\r\n"
                        ,"content" => $post
                    )
                );
                $content = stream_context_create($content);
                $rdata = file_get_contents($url,false,$content);
            }
            else {
                $rdata = file_get_contents($url,false);
            }
            
            if($outtype=='json') {
                return json_decode($rdata,true);
            }
            else {
                return $rdata;
            }
    }
    
    /**
     * Stopping words will be removed from array
     * @param type $q_arr array
     * @return type array
     * @example "Like: name,is,this,"
     */
    function skip_stopwords($q_arr) {
        $r_arr= array();
        foreach ($q_arr as $i=>$query) {
            if($this->chk_stop_word($query)) {
                //skip the word
            }
            else {
                $r_arr[]=$query;
            }
        }
        return $r_arr;
    }
    
    /**
     * Checks stoping words 
     * @param type $query string
     * @return boolean
     */
    function chk_stop_word($query) {
            $stopwords = array("a", "about", "above", "above", "across", "after", "afterwards", "again",
            "against", "all", "almost", "alone", "along", "already",
            "also","although","always","am","among", "amongst", "amoungst", "amount", "an", "and",
            "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around",
            "as", "at", "back","be","became", "because","become","becomes", "becoming", "been",
            "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond",
            "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could",
            "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg",
            "eight", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever",
            "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find",
            "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front",
            "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here",
            "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how",
            "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself",
            "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me",
            "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move",
            "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next",
            "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off",
            "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours",
            "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re",
            "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should",
            "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone",
            "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten",
            "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter",
            "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this",
            "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too",
            "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon",
            "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence",
            "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon",
            "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom",
            "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours",
            "yourself", "yourselves", "the");
            // check these words are in a
            if(in_array($query,$stopwords)) {
                return true;
            }
            else {
                return false;
            }
    }
    
}
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
     * Establish the database connection
     * @return type int or array
     */
    function db_conn() {
        include "paths.php";
        include $db_file_url;
        
        if(mysql_error($linkid)) {
            echo json_encode(array("status"=>"fail","response"=>mysql_error($linkid)));die();
        }
        else {
            return $linkid;
        }
        
    }
    /**
     * 
     * @param type $get
     * @return array array
     */
    function get_search_content_info($get) {
        $linkid=$this->db_conn();
        $output=array(); $con='';

        $requesting_uid = mysql_real_escape_string($get['requesting_uid']);
        $query_str = mysql_real_escape_string(urldecode($get['query']));
        $lat=(!isset($get['lat']))? '' : mysql_real_escape_string(urldecode($get['lat']));
        $long=(!isset($get['long']))? '' : mysql_real_escape_string(urldecode($get['long']));
        $timestamp=  (!isset($get['time']))? date("Y-m-d H:i:s",time()) : strtotime(mysql_real_escape_string(urldecode($get['timestamp']))); //Unix timestamp
        $src = $lat=(!isset($get['src']))? '' : mysql_real_escape_string(urldecode($get['src']));

        //insert to table
        $rslt= mysql_query("insert into `tbl_queries`(`sno`,`query_id`,`query_string`,`uid`,`timestamp`,`lat`,`long`,`src`) 
            values ( NULL,NULL,'".$query_str."','".$uid."','".$timestamp."','.$lat.','.$long.','".$src."')", $linkid) or $this->print_error(mysql_error($linkid));

        $sno = mysql_insert_id(); //"cnt".rand(8,getrandmax());

        mysql_query("update `tbl_queries` set `query_id`='$sno' where `sno`=$sno") or $this->print_error(mysql_error($linkid));

        // search core query
        //$list_content_info[]=  $this->get_query_content($query_str,$uid);

        // skip stoping words
        $q_arr = explode(" ",$query_str);

        
        $rdata = $this->skip_stopwords($q_arr);
        $obj_query = json_encode($rdata);
        echo $obj_query;
//        exit();

        return $output;
    }
    /**
     * Get matched content ids
     * @param type $query_str
     * @param type array
     */
    function get_query_content($query_str,$uid) {
        $linkid=$this->db_conn();
            if($get['content_type'] == 'all') {
                //expense total
                    $rslt = mysql_query("select * from tbl_expenses e
                        where e.e.`uid`=$uid limit $limit_start,$limit_end",$linkid) or $this->print_error(mysql_error($linkid));
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
            else { $output = $this->unknown(); }
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
    /**
     * print all kind of errors of type array and string
     * @param type array or exit execution
     */
    function print_error($error) {
        if(is_array($error)) {
            echo json_encode($error);
        }
        else {
            echo json_encode(array("status"=>"fail","response"=>$error));
        }
        die();
    }
    /**
     * Default error message
     * @return type array
     */
    function unknown() 
    {
        return array("status"=>"fail","response"=>"Unknown url");
    }
}
?>