<?php
/**
 * @author Shivaraj <mrshivaraj123@gmail.com.com>
 * @uses Create task queue to update contacts
 */
$post = ($_REQUEST);

if(!isset($post['data'])) 
    print_msg(array("status"=>"fail","response"=>"No input.")); 

$data = do_updatePeople($post);
print_msg($data);// echo data

    // update_contacts.php
    function do_updatePeople($post) {
            include "paths.php";
            include $db_file_url;
            // call task queue
        
            // store social contacts to db
            $insert_str='';
            $data = ($post['data']);
            $uid = mysql_real_escape_string($post['uid']);
            $ttl_num = count($data);
            if($ttl_num > 0) {
                foreach($data['items'] as $ui=>$entry) {
                    //echo '<pre>'; print_r($entry);

                    $c_id = mysql_real_escape_string($entry['id']);
                    $name = mysql_real_escape_string($entry['displayName']);
                    //foreach($entry['gd$email'] as $val){  $arr[$ui]['social_email'] = $socio_email = mysql_real_escape_string($val['address']); }

                    $contact_set = mysql_query("select * from tbl_social_contacts where c_gid='$c_id' ",$linkid) or die("Internal Error:".mysql_error());
                    if( mysql_num_rows($contact_set) > 0 ) {
                        // 'already exits';
                    }
                    else {
                        //new contact
                        if($ui<$ttl_num) $comma = ','; else $comma = '';
                        $insert_str .= '( "'.$uid.'","'.$uid.'","'.$c_id.'","'.$c_id.'","'.$name.'",now() )'.$comma;
                    }
                 }
            }
            
            $result=array();
            if($insert_str != '') {
                $in_qry = "insert into tbl_social_contacts(`uid`,`gid`,`c_uid`,`c_gid`,`name`,`created_on`) values ".rtrim($insert_str,",")."";
                
                // Insert qry
                mysql_query($in_qry,$linkid); 
                
                $result["status"] = 'success';
                $result["response"] = $in_qry;
            }
            else {
                $result["status"] = 'fail';
                $result["response"] = 'No data.';
            }
            return $result;
            //:-) contacts module done
    }
    
function print_msg($error) {
    if(is_array($error)) {
        echo json_encode($error);
    }
    else {
        echo json_encode(array("status"=>"fail","response"=>$error));
    }
    die();
}
function unknown() {
    return array("status"=>"fail","response"=>"Unknown url");
}
?>
