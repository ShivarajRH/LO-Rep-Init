<?php
/**
 * @author Shivaraj <mrshivaraj123@gmail.com.com>
 * @uses Create task queue to update contacts
 */
$post = ($_REQUEST);

if(!isset($post['data'])) 
    print_msg(array("status"=>"fail","response"=>"No input.")); 

$data = do_updateContacts($post);
print_msg($data);

    // update_contacts.php
    function do_updateContacts($post) {
        include "paths.php";
        include $db_file_url;
        // call task queue
        
            // store social contacts to db
           
            $insert_str='';
            $data = ($post['data']);
            $uid = mysql_real_escape_string($post['uid']);
            $ttl_num = count($data);
            if($ttl_num)
            foreach($data as $ui=>$entry) {
                //echo '<pre>'; print_r($entry);
                
                $arr[$ui]["uid"] = $uid;
                
                //$arr[$ui]["id"] = $id = mysql_real_escape_string($entry['id']['$t']);
                $arr[$ui]["name"] = $name = mysql_real_escape_string($entry['title']['$t']);
                foreach($entry['gd$email'] as $val){  $arr[$ui]['social_email'] = $socio_email = mysql_real_escape_string($val['address']); }
                //echo '<pre>'; print_r($arr); //die();"'.$entry['id']['$t'].'",
                
                $contact_set = mysql_query("select * from tbl_social_contacts where email='$socio_email' ",$linkid) or die("Internal Error:".mysql_error());
                if( mysql_num_rows($contact_set) > 0 ) {
                    // 'already exits';
                }
                else {
                    //new contact
                    if($ui<$ttl_num) $comma = ','; else $comma = '';
                    $insert_str .= '( "'.$entry['title']['$t'].'","'.$socio_email.'","'.$uid.'",now())'.$comma;
                }
             }
            //INSERT INTO suppliers (supplier_id, supplier_name) SELECT account_no, name FROM customers WHERE customer_id < 5000;
            if($insert_str != '') {
                echo $in_qry = "insert into tbl_social_contacts(`name`,`email`,`uid`,`created_on`) values ".rtrim($insert_str,",")."";
                mysql_query($in_qry,$linkid);
                echo "<br>".mysql_insert_id();
            }
            $result["status"] = 'success';
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
