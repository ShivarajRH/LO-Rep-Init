<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$output= '';
$get = ($_REQUEST);
include "paths.php";
include $myclass_url;

class api_actions extends myactions {
    
    function get_expense_det_bytime($get) {
        $linkid=$this->db_conn();$cond=$sel_cond='';
        include "paths.php";
        $rdata = $expense_arr=$expenses=array();
        
        $uid=  mysql_escape_string($get['uid']);
        $content_type=  mysql_escape_string($get['content_type']);
        $interval =  mysql_escape_string($get['interval']);
        $filter_type = 'time';
        
        //get interval time and derive the from and to dates
        $s=time();
        
        //if 1 week  -7days
        if($interval == '1w') {
            $filter_from = date('Y-m-d 23:59:59',$s - (60*60*24*7) );
            $filter_to = date('Y-m-d 23:59:59',$s);
            $sel_cond .= " c.timestamp,from_unixtime(c.timestamp,'%Y-%m-%d') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= ' and c.timestamp between unix_timestamp("'.$filter_from.'") and unix_timestamp("'.$filter_to.'")';
        }
        elseif($interval == '1m') {
            $filter_from = date('Y-m-d 23:59:59',$s - (60*60*24*7*4) );
            $filter_to = date('Y-m-d 23:59:59',$s );
            $sel_cond .= " from_unixtime(c.timestamp,'%Y-%m') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= ' and c.timestamp between unix_timestamp("'.$filter_from.'") and unix_timestamp("'.$filter_to.'")';
        }
        elseif($interval == '1q') {
            $filter_from = 
            date('Y-m-d 23:59:59',$s - ( 
                                        ( 
                                            ( 
                                                ( 60*60*24*7 ) * 4
                                            )
                                        ) * 6 
                                    ) 
                );
            
            $filter_to = date('Y-m-d 23:59:59',$s );
            $sel_cond .= " from_unixtime(c.timestamp,'%Y-%m') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= ' and c.timestamp between unix_timestamp("'.$filter_from.'") and unix_timestamp("'.$filter_to.'")';
        }
        elseif($interval == '1y') {
            $filter_from = date('Y-m-d 23:59:59',$s - ( 60*60*24*7*4*12 ) );
            $filter_to = date('Y-m-d 23:59:59',$s );
            $sel_cond .= " from_unixtime(c.timestamp,'%Y-%m') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= ' and c.timestamp between unix_timestamp("'.$filter_from.'") and unix_timestamp("'.$filter_to.'")';
        }
        elseif($interval == '2y') {
            $filter_from = date('Y-m-d 23:59:59',$s - ( 60*60*24*7*4*24 ) );
            $filter_to = date('Y-m-d 23:59:59',$s );
            $sel_cond .= " from_unixtime(c.timestamp,'%Y-%m') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= ' and c.timestamp between unix_timestamp("'.$filter_from.'") and unix_timestamp("'.$filter_to.'")';
        }
        elseif($interval == '5y') {
            $filter_from = date('Y-m-d 23:59:59',$s - ( 60*60*24*7*4*60 ) );
            $filter_to = date('Y-m-d 23:59:59',$s );
            $sel_cond .= " from_unixtime(c.timestamp,'%Y-%m') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= ' and c.timestamp between unix_timestamp("'.$filter_from.'") and unix_timestamp("'.$filter_to.'")';
        }
        else { //max-no filter
            $filter_from = date('Y-m-d 23:59:59',$s - (60*60*24*7*4) );
            $filter_to = date('Y-m-d 23:59:59',$s );
            $sel_cond .= " from_unixtime(c.timestamp,'%Y-%m') as day,sum(e.amount) as amount ";
            $group_con .=' group by day ';
            $cond .= '';
        }
        //$post = array('uid'=> urlencode($uid),'content_type'=>urlencode($content_type),'filter_type'=>urlencode($filter_type),"filter_from"=>urlencode($filter_from),'filter_to'=>urlencode($filter_to));
        //$url=$site_url.'api/search/?action_object=list_content';
        //$expense_arr = $this->getApiContent($url,'json',$post);
        $sql="select $sel_cond from tbl_expenses e
                join tbl_content c on c.content_id = e.content_id
                where e.uid='$uid' $cond
                $group_con
                order by c.timestamp asc";
//       echo '<pre>'.$sql; die();
        $rslt = mysql_query($sql,$linkid) or $this->print_error($sql.''.mysql_error($linkid));

        if(mysql_errno($linkid)) {
            $this->print_error(mysql_error($linkid));
        }
        else {

            $i=0;$data_array=array();
            while($row = mysql_fetch_assoc($rslt)) {
                /*****/
                if($interval == '1w') {
                    $days=date("Y-m-d",strtotime($row['day']));
                    $data_array[$i]['expense_amount'] += $row['amount'];
                    $data_array[$i]["title"]=$days;
                }
                else {
                    $month=date("M",strtotime($row['day']));
                    $data_array[$i]['expense_amount']=$row['amount'];
                    $data_array[$i]['title']=$month;
                }
                $i++;
            }
            //$expense_arr['expenses'] = $data_array;
        }
        
//        echo '<pre>';print_r($expense_arr);    die();
        /*if($interval=='1w') {
            //divide expenses to days
            for($d=1;$d<=7;$d++) {
                foreach ($expense_arr['expenses'] as $i=>$expense) {
                    //$exp_date = $expense['timestamp'];
                    $month=date('M',$s-60*60*24*$d);
                    $day=date('d',$s-60*60*24*$d);
                    $expenses[$month][$day] += $expense['expense_amount'];
                }
            }
        }
        elseif($interval=='1m') {
            //$month = date('M',$s-60*60*24*7*4);
            foreach ($expense_arr['expenses'] as $i=>$expense) {
                //$created_month = $expense['month'];
                //if($month == $created_month) {
                    $expenses[$expense['month']] += $expense['expense_amount'];
                //}
            }
        }*/
        $rdata=array("status"=>"success","expenses"=>$data_array);
        return $rdata;
    }
}



$ob = new api_actions();
if( isset($get['action']) ) {
    
    switch ($get['action']) {
        
        case 'time_filter':
                $output=$ob->get_expense_det_bytime($get);
            break;
        
        default:
            break;
    }
    
}
else {
    $output=array("status"=>"fail");
}
echo json_encode($output);
?>
