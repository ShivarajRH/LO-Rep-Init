<?php
//header("404");
$fname="";
$lname='';
$gid = '';

$metatitle='Error 404 !';
$metadescription='404 error - The requested page could not be found.';
$metaabstract='Error 404';
$metasubject='Error 404';
$metapagename='Error 404';
$metasubtitle='Error 404';
$metacopyright='LyfeOn';
$robots_index = 'no-index';
$robots_follow = 'no-follow';

include 'paths.php';
include_once 'head.php'; ?>
<body>
<?php include_once 'header.php '; ?>
<div class="center">
</br>
<div style="max-width: 45em;margin: 0 auto;">
<p><strong></strong> That&#39;s an error.</br></br>The requested page was having internal errors. That&#39;s all we know.</p>
<a class="back" href="<?=$site_url;?>">Back to LyfeOn</a>
</div>
</div>
<?php include_once 'footer_reg.php '; ?>
</body>