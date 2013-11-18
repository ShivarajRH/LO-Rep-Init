function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
    
    //console.log("\n Token_info="+gapi.auth.getToken());
    //console.log("\n User_info=");
    //console.log(gapi.client.plus.people.get());
    
    $.each(authResult,function(key,val){
        console.log(key +' - ' + val);
        console.log(" \n");
    });
    
    $.post("https://www.googleapis.com/plus/v1/people/me",{},function(rdata){
        $.each(rdata,function(key,val){
            console.log(key +' <=> ' + val);
            console.log(" \n");
        });
            console.log(" post success ");
    }).fail(fail);
        
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