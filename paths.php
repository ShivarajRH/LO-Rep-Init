<?php
	
	/* CO INFO PAGES */
	$user_tos = '/co/services/terms.php';
	$user_contact = '/co/services/contact.php';
	$user_help = '/co/services/help.php';
	$user_company_info = '/co/services/company.php';
	
	$landing_co = '/co/co.php';
	$landing_investor = '/co/investors/investors.php';
	$landing_analytics = '/co/analytics/analytics.php';
	$landing_people = '/co/people/people.php';
	$landing_home = '/welcome_page.php';
	
	$reach_email = 'contact@lyfeon.com';
	$reach_googleplus = 'https://plus.google.com/118335972259503633372/posts';
	$reach_googleplus_community = '';
	$reach_facebook = '';
	$reach_twitter = '';
	
	/* GLOBAL PATHS */
	$global_header = 'header.php';
	$global_head = 'head.php';
	$global_footer = 'footer.php';
	$global_analytics = 'analyticstracking.php';
	$google_plus_signin_button = 'google_plus_signin_button.php';
	
	/* CARDS */
	$creator_box_card = 'cards/creator_box_card.php';
	$expenses_list_card = 'cards/expenses_list_card.php';
	$note_single_stream_card = 'cards/note_single_stream_card.php';
	$reminder_list_card = 'cards/reminder_list_card.php';
	$single_expense_list_card = 'cards/single_expense_list_card.php';
	$single_reminder_list_card = 'cards/single_reminder_list_card.php';
	
	/* ICONS */
	$icon_chrome_24 = 'assets/images/chrome-24.png';
	$icon_clock = 'assets/images/clock.png';
	$icon_note = 'assets/images/note.png';
	$icon_expenses = 'assets/images/expenses.png';
	$icon_delete = 'assets/images/delete.png';
	$icon_edit = 'assets/images/edit.png';
	$icon_google_play_48 = 'assets/images/Google_Play_Store_48.png';
	$icon_info = 'assets/images/info.png';
	$icon_settings = 'assets/images/settings.png';
	
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