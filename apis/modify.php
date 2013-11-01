<?php
$get = ($_GET);
//print_r($get);
switch($get['action']) {
    case 'write': 
        break;
    case 'search': 
        break;
    case 'delete': 
        break;
    case 'modify': 
        break;
    default : unknown();
        break;
    
}
function 
function unknown() 
{
    echo '{"status":"fail","response":"Unknown url"}';
}
?>