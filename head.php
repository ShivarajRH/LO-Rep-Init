<!DOCTYPE html>
    <head>
        <?php
        if($_SERVER['HTTP_HOST'] == 'localhost:13080') {
                $js_url="/assets/js/";
            }
            else {
                $js_url="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/";
            }
        ?>
        <meta charset="utf-8" >
        <?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>

        <link rel="stylesheet" href="/assets/css/global.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/assets/css/fonts/font.css">
        <link rel="shortcut icon" type="image/png" href="/assets/logos/favicon.png"/>
        <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/ddpmfmlfaonpbigeobfkjeklaloplepn">  

        <script src="<?=$js_url;?>jquery.min.js"></script>
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

        <title><?php echo $metatitle; ?></title>
        <meta name="description" content=" <?php echo $metadescription; ?> " >
        <meta name="abstract" content=" <?php echo $metaabstract; ?> " >
        <meta name="subject" content=" <?php echo $metasubject; ?> ">
        <meta name="pagename" content=" <?php echo $metapagename; ?> ">
        <meta name="subtitle" content=" <?php echo $metasubtitle; ?> ">
        <meta name="copyright" content=" <?php echo $metacopyright; ?> ">
        <meta name="Classification" content="Business">
        <meta name="owner" content="LyfeOn">
        <meta name="url" content="http://www.lyfeon.com">
        <meta name="rating" content="General">
        <meta name="target" content="all">
        <meta name="HandheldFriendly" content="True">  
        <meta http-equiv="window-target" content="_top">
        <meta http-equiv="Cache-control" content="private">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="distribution" content="Global">
        <meta name="robots" content="index,follow">
        <meta name="p:domain_verify" content="75195ddad850871ba3953967a8819516"/>
        <?php
        if(isset($css_arr)) {
            foreach($css_arr as $css) {
                echo '<link rel="stylesheet" href="/assets/css/'.$css.'.css" type="text/css" media="screen" />';
            }
        }
        if(isset($load_js)) {
            foreach($load_js as $js_filenm) {
                echo '<script src="/assets/js/'.$js_filenm.'.js" type="text/javascript"></script>';
            }
        }
        ?>
</head>	