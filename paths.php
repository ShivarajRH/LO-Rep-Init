<?php
	
	/* GLOBAL PATHS */
	$global_header = 'header.php';
	$global_head = 'head.php';
	$global_footer = 'footer.php';
	$global_analytics = 'analyticstracking.php';
	$google_plus_signin_button = 'google_plus_signin_button.php';
	
	
	/* CSS AND JAVASCRIPT */
	$css_global = 'assets/css/global.css';
	$js_plusone = 'https://apis.google.com/js/plusone.js';
	$js_jquery = 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js';
	
	/* LOGOS */
	$logo_lyfeon = 'assets/logos/lyfeon.png';
	$logo_favicon = 'assets/logos/favicon.png';
        
        if($_SERVER['HTTP_HOST'] == 'localhost:13080') {
            $img_url="assets/images/";
        }
        else {
            $img_url="http://commondatastorage.googleapis.com/";
        }
        $db_file_url="includes/db_connection.php";
        
        $site_url='http://'.(($_SERVER['HTTP_HOST'] == 'localhost:13080')?"localhost:13080":$_SERVER['HTTP_HOST'])."/";
        
        $myclass_url = 'includes/myclasses.php';
?>