$(document).ready(function() {
    $(".header").click(function(){
       window.scrollTo(0,0); 
    });
});
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
            var emails =rdata.emails;$.each(emails,function(key,val){email=val.value;});
            var fname=rdata.name.givenName;
            var mname='';
            var lname=rdata.name.familyName;
            
            var postData = {gid:gid,uid:uid,name:name,email:email,fname:fname,lname:lname};
            //console.log(postData);
      
            //store into session
            //console.log(postData);
            $.post(site_url+"includes/generalactions/?action=sess_create",postData,function(rdata) {
                console.log("SESSION RESPONSE: "+rdata);
            });
            
              //console.log("Test"); return false;
              
            
            var uname=rdata.name.givenName;
            var phone='';
            var verification=rdata.verified;
            var lat='77';
            var long1='23';
            var timestamp=getTimeStamp(); 

            var apiurl = "&uid="+enco(uid)+"&gid="+enco(gid)+"&name="+enco(name)+"&email="+enco(email)+"&fname="+enco(fname)+"&mname="+enco(mname)+"&lname="
                +enco(lname)+"&uname="+enco(uname)+"&phone="+enco(phone)+"&verification="+enco(verification)+"&lat="+enco(lat)+"&long="
                +enco(long1)+"&time="+timestamp;
            //console.log(apiurl);
            
            //call profile api
            $.post(site_url+"api/write/?action_object=user_profile"+apiurl,{},function(rdata) {
                console.log("API RESPONSE="+rdata);
                
                
                //redirect to streams
                location.href=site_url+"stream#";
            });
            
            
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
function getTimeStamp() {
    var fullDate = new Date($.now());
    //convert month to 2 digits
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
    return currentDate+" "+fullDate.getHours()+":"+fullDate.getMinutes()+":"+fullDate.getSeconds();
}
function showTimeStamp(dateString) {
    dateString.split(' ').join('T');
    var fullDate = new Date(dateString);
    //convert month to 2 digits
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    
    var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
    
    return currentDate+" "+fullDate.getHours()+":"+fullDate.getMinutes();//+":"+fullDate.getSeconds();
}
function nl2br (str, is_xhtml) {
    
    var breakTag = '<br>';//(is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function enco(str) {
    return encodeURIComponent(str);
}
function fail(resp) { console.log("FAIL"); console.log(resp); }
function signOut() {
    
    if(gapi === "undefined") {
        alert("Not Connected.");
        location.href=site_url+"?#";
    }
    else {
        gapi.auth.signOut();
    
        $.post(site_url+"includes/generalactions/?action=sess_destroy",{},function(rdata) {
            alert("SESSION RESPONSE: "+rdata);
            location.href=document.URL;
        });
        
    }
}

/*
function disconnectUser() {var access_token=gapi.auth.getToken;
  var revokeUrl = 'https://accounts.google.com/o/oauth2/revoke?token=' +
      access_token;

  // Perform an asynchronous GET request.
  $.ajax({
    type: 'GET',
    url: revokeUrl,
    async: false,
    contentType: "application/json",
    dataType: 'jsonp',
    success: function(nullResponse) {
        alert("revoked");
      // Do something now that user is disconnected
      // The response is always undefined.
    },
    error: function(e) {alert("notrevoked");
      // Handle the error
       console.log(e);
      // You could point users to manually disconnect if unsuccessful
      // https://plus.google.com/apps
    }
  });
}
// Could trigger the disconnect on a button click
$('#revokeButton').click(disconnectUser);*/

function show_actions(content_type) {
    if(content_type=='note') {
        $(".note_creator").removeClass("hide");
        $(".reminder_creator").addClass("hide");
        $(".expense_creator").addClass("hide");
    }
    else if(content_type=='reminder') {
        $(".note_creator").addClass("hide");
        $(".reminder_creator").removeClass("hide");
        $(".expense_creator").addClass("hide");
    }
    else if(content_type=='expense') {
        $(".note_creator").addClass("hide");
        $(".reminder_creator").addClass("hide");
        $(".expense_creator").removeClass("hide");
    }
}