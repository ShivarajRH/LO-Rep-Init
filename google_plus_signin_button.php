
<!--  DO NOT MODIFY THIS FILE -->
<?php
//client-id
$client_id=($_SERVER['HTTP_HOST'] == 'localhost:13080')?"209511642870-6vr479nj2mc9b0ablkobf61mbk1403a2.apps.googleusercontent.com"
    :"209511642870-rb5pa5elftt3paeiusqkf43ptoe2cat8.apps.googleusercontent.com";

//callback function
if(isset($fn_signin_callback))
    $fn_signin_callback = $fn_signin_callback;
else $fn_signin_callback = "defaultpg";

// api key
$apiKey = 'AIzaSyBt514eUceQLLd8b_KI2XKD_tsaVtwm4E8';
 ?>
<!-- Google+ Signin --> <!-- Insert Client ID-->
<!--<span id="signinButton">
	<span
		class="g-signin"
		data-callback="<?php //echo $fn_signin_callback;?>"
		data-clientid="<?php//echo $client_id;?>"
		data-cookiepolicy="single_host_origin"
		data-requestvisibleactions="http://schemas.google.com/AddActivity"
		data-theme="dark"
		data-width="wide"
		data-height="tall"
		data-scope="https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login https://www.google.com/m8/feeds https://www.google.com/m8/feeds/user">
	</span>
</span>-->
<!--    https://www.googleapis.com/auth/plus.me   https://www.googleapis.com/auth/userinfo.profile-->
<!-- data-cookiepolicy="http://lyfeon.com"-->
<!-- IMP: Change data-height="short" when included in header  -->


<!--Add a button for the user to click to initiate auth sequence -->
<button id="authorize-button" style="visibility: hidden;"
                class="g-signin"
		pageredirect="<?=$fn_signin_callback;?>"
		data-clientid="<?=$client_id;?>"
                data-apikey="<?=$apiKey;?>"
		data-cookiepolicy="single_host_origin"
		data-requestvisibleactions="http://schemas.google.com/AddActivity"
		data-theme="dark"
		data-width="wide"
		data-height="tall"
		data-scope="https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login https://www.google.com/m8/feeds https://www.google.com/m8/feeds/user">Google + Login</button>

<script>var pageredirect='<?=$fn_signin_callback;?>';</script>
<!--// Step 1: Load JavaScript client library-->
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>