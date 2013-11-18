function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
    location.href="/stream.php";
    
    //console.log("\n Token_info="+gapi.auth.getToken());
    //console.log("\n User_info=");
    //console.log(gapi.client.plus.people.get());

    var access_token=authResult['access_token'];
    $.get("https://www.googleapis.com/plus/v1/people/me?access_token="+access_token,{},function(rdata){
        $.each(rdata,function(key,val){
            var gid=val.id;
            var uid=val.id;
            var name=val.displayName;
            var email=val.emails.value;
            
            var fname=val.emails.value;
            var mname=val.emails.value;
            var lname=val.emails.value;
            var uname=val.emails.value;
            var phone=val.emails.value;
            var verification=val.emails.value;
            var lat=val.emails.value;
            var long1=val.emails.value;
            var timestamp=val.emails.value;
            
            //store into session
            
            console.log(key +' <=> ' + val);
            console.log(" \n");
        });
            console.log(" post success ");
    }).fail(fail);
            
    /*$.each(authResult,function(key,val){
        console.log(key +' - ' + val);
        console.log(" \n");
    });*/
    
  } else if (authResult['error']) {
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    console.log('Sign-in state: ' + authResult['error']);
  }
}
function fail(resp) { console.log("FAIL"); console.log(resp); }
function signOut() {
    gapi.auth.signOut();
    location.href=document.URL;
}