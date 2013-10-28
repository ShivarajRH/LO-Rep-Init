<?php 
include '/includes/db_connection.php';

$rslt=mysql_query("show tables",$linkid);
if(mysql_errno()) {
    print mysql_error($linkid);
}
$rslt_arr = mysql_affected_rows($linkid);

echo $rslt_arr."";

?>
