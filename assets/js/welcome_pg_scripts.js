function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
    
    var access_token=authResult['access_token'];
    //Get auth user details
    $.get("https://www.googleapis.com/plus/v1/people/me?access_token="+access_token,{},function(rdata){
        
            var gid=rdata.id;
            var uid=rdata.id;
            var name=rdata.displayName;
            var emails =rdata.emails;
            
            $.each(emails,function(key,val){
                email=val.value;
            });
            
            var postData = {gid:gid,uid:uid,name:name,email:email};
        
            //console.log(key +' <=> ' + val.value);
            
            //store into session
            //console.log(postData);
            $.post(site_url+"includes/generalactions/?action=sess_create",postData,function(rdata) {
                //console.log("SESSION RESPONSE: "+rdata);
            });
            
            var fname=rdata.name.givenName;
            var mname='';
            var lname=rdata.name.familyName;
            var uname=rdata.name.givenName;
            var phone='';
            var verification=rdata.verified;
            var lat='77';
            var long1='23';
            
            var fullDate = new Date($.now());
            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
            var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
            
            var timestamp=currentDate+" "+fullDate.getHours()+":"+fullDate.getMinutes()+":"+fullDate.getSeconds();

            var apiurl = "&uid="+enco(uid)+"&gid="+enco(gid)+"&name="+enco(name)+"&email="+enco(email)+"&fname="+enco(fname)+"&mname="+enco(mname)+"&lname="
                +enco(lname)+"&uname="+enco(uname)+"&phone="+enco(phone)+"&verification="+enco(verification)+"&lat="+enco(lat)+"&long="
                +enco(long1)+"&time="+timestamp;
            //console.log(apiurl);
            
            //call profile api
            $.post(site_url+"api/write/?action_object=user_profile"+apiurl,{},function(rdata) {
                console.log("API RESPONSE="+rdata);
            });
            
            //redirect to streams
            location.href=site_url+"stream.php";
    }).fail(fail);
  
    /*$.each(authResult,function(key,val){
        console.log(key +' - ' + val);
        console.log(" \n");
    });*/
        return true;
  } else if (authResult['error']) {
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    console.log('Sign-in state: ' + authResult['error']);
  }
  return false;
}
function enco(str) {
    return encodeURIComponent(str);
}
function fail(resp) { console.log("FAIL"); console.log(resp); }
function signOut() {
    gapi.auth.signOut();
    location.href=document.URL;
}