
<!--  DO NOT MODIFY THIS FILE -->
<?php
$client_id=($_SERVER['HTTP_HOST'] == 'localhost:13080')?"209511642870-6vr479nj2mc9b0ablkobf61mbk1403a2.apps.googleusercontent.com"
    :"209511642870-rb5pa5elftt3paeiusqkf43ptoe2cat8.apps.googleusercontent.com";
 ?>
<span id="signinButton">
    <!-- Google+ Signin --> <!-- Insert Client ID-->
	<span
		class="g-signin"
		data-callback="signinCallback"
		data-clientid="<?=$client_id?>"
		data-cookiepolicy="single_host_origin"
		data-requestvisibleactions="http://schemas.google.com/AddActivity"
		data-theme="dark"
		data-width="wide"
		data-height="tall" 
		data-scope="https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login">
	</span>
    <!--
    data-cookiepolicy="http://lyfeon.com"-->
    <!-- IMP: Change data-height="short" when included in header  -->
	
</span>