<?php
//$linkid = mysql_connect(":/cloudsql/lyfeon-init:lyfeondb", "root", "");
//mysql_select_db("mysql",$conn);
//org.eclipse.jdt.core.manipulation

$dbhost=":/cloudsql/lyfeon-init:lyfeondb";
$dbusername="root";
$dbpasswd="";
$database="lyfeon_db";

$linkid = @mysql_connect($dbhost,$dbusername,$dbpasswd) or die ('<br/><span style="color:red;font-weight:bold;padding:5px 0 50px 10px">Could not connect to the database server. Contact IT Support Team.</span>');


$db = mysql_select_db($database,$linkid)
 or die ('<br/><span style="color:red;font-weight:bold;padding:5px 0 50px 10px;">Could not connect to the database. Contact IT Support Team.</span>');

$server_name=$_SERVER['SERVER_NAME'];

mysql_query('SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"');

//error_reporting(0);
?>