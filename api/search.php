<?php
$output= '';
$get = ($_REQUEST);
include "paths.php";
include $myclass_url;
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
    default : $ob->unknown();
        break;
}
#echo '<pre>'; 
echo json_encode($output); 
#echo '</pre>';

?>