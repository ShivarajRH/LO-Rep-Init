
    function handleClientLoad() {
        // Step 2: Reference the API key
        var apiKey=$("#authorize-button").attr("data-apikey");
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
    }
    
    function handleAuthClick(event) {
        var clientId=$("#authorize-button").attr("data-clientid");
        var apiKey=$("#authorize-button").attr("data-apikey");
        var scopes=$("#authorize-button").attr("data-scope");

        // Step 3: get authorization to use private data
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
    }
    
    function checkAuth() {
        var clientId=$("#authorize-button").attr("data-clientid");
        var apiKey=$("#authorize-button").attr("data-apikey");
        var scopes=$("#authorize-button").attr("data-scope");
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
    }

    
    function handleAuthResult(authResult) {
      var authorizeButton = document.getElementById('authorize-button');
      if (authResult && !authResult.error) {
        authorizeButton.style.visibility = 'hidden';
        makeApiCall();
      } else {
        authorizeButton.style.visibility = '';
        authorizeButton.onclick = handleAuthClick;
      }
    }


    // Load the API and make an API call.  Display the results on the screen.
    function makeApiCall() {
        
            // Step 4: Load the Google+ API
            gapi.client.load('plus', 'v1', function() {
                
                // Step 5: Assemble the API request
                  var request = gapi.client.plus.people.get({
                    'userId': 'me'
                  });
                  
                  var uid = 0;
                // Step 6: Execute the API request
                  request.execute(function(resp) {

                        //var heading = document.createElement('h4');var image = document.createElement('img');image.src = resp.image.url;heading.appendChild(image);heading.appendChild(document.createTextNode(resp.displayName));document.getElementById('content').appendChild(heading);
                        var rdata = resp.result;
                    
                        //API WORK
                        var gid=rdata.id;
                        uid=rdata.id;
                        var name=rdata.displayName;
                        var emails =rdata.emails; $.each(emails,function(key,val){ email=val.value;});
                        var currency='$';
                        var fname=rdata.name.givenName;
                        var mname='';
                        var lname=rdata.name.familyName;
                        var img_url=rdata.image.url;
                        var postData = {gid:gid,uid:uid,name:name,email:email,fname:fname,lname:lname,img_url:enco(img_url),currency:enco(currency)};
                        console.log(postData);

                        //========STORE TO SESSION==============
                        $.post(site_url+"includes/generalactions/?action=sess_create",postData,function(rdata) {
                            console.log("SESSION RESPONSE: "+rdata);
                        });

                        var welcomemsg = "Welcome, "+name;
                        $(".login_card").html(welcomemsg);
                        
                        
                        //////PEOPLE INFO/////////////////
                        // This sample assumes a client object has been created. To learn more about creating a client, check out the starter:https://developers.google.com/+/quickstart/javascript
                        var request = gapi.client.plus.people.list({
                          'userId' : 'me',
                          'collection' : 'visible'
                        });

                        // Step 6: Execute the API request
                        request.execute(function(rdata) {
                            var numItems = rdata.totalItems;
                            $.post(site_url+"includes/generalactions/?action=updt_people",{data:rdata.result,uid:uid},function(contact_resp) {
                                //if(contact_resp.status == 'success') console.log("social contacts updated.");
                                console.log(contact_resp);
                            },"json");
                            
                            /*for (var i = 0; i < numItems; i++) {console.log(rdata.items[i].displayName);}*/
                          
                        });
                        ////////////////////////////////////

                        //////////////PROFILE INFO///////////
                        var uname=rdata.name.givenName;
                        var phone='';
                        var verification=rdata.verified;
                        var lat='77';
                        var long1='23';
                        var timestamp=getTimeStamp(); 

                        var apiurl = "&uid="+enco(uid)+"&gid="+enco(gid)+"&name="+enco(name)+"&email="+enco(email)+"&fname="+enco(fname)+"&mname="+enco(mname)+"&lname="
                            +enco(lname)+"&uname="+enco(uname)+"&phone="+enco(phone)+"&verification="+enco(verification)+"&lat="+enco(lat)+"&long="
                            +enco(long1)+"&time="+timestamp+"&img_url="+img_url+"&currency="+currency;
                        //console.log(apiurl);

                        //call profile api
                        $.post(site_url+"api/write/?action_object=user_profile"+apiurl,{},function(rdata) {
                            //console.log("API RESPONSE="+rdata);
                            //redirect to streams
            //                location.href=redirecturl;
                        });
                        
                        return false;
                      // end aspi work
                  });

            });
    }
    
//==================================================
/*function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Update the app to reflect a signed in user
   
        var access_token=authResult['access_token'];
        
        //Get auth user details
        var redirecturl= site_url+"stream#";
        getpeopleinfo(access_token,redirecturl); //Get auth user details
    
        // Hide the sign-in button now that the user is authorized, for example:
        //document.getElementById('signinButton').setAttribute('style', 'display: none');

        //$.each(authResult,function(key,val){console.log(key +' - ' + val);console.log(" \n");});
        return false;
    }
    else if (authResult['error']) {
        // Update the app to reflect a signed out user
        // Possible error values:
        //   "user_signed_out" - User is signed-out
        //   "access_denied" - User denied access to your app
        //   "immediate_failed" - Could not automatically log in the user
        console.log('Sign-in state: ' + authResult['error']);
    }
    return false;
}

function signinCallbackGeneral(authResult) {
    
  if (authResult['access_token']) {
    // Update the app to reflect a signed in user
    
    
    
        var access_token=authResult['access_token'];

        //var redirecturl= $(location).attr('href'); //site_url+"stream#";
        getpeopleinfo(access_token,locationurl); //Get auth user details

        // Hide the sign-in button now that the user is authorized, for example:
       //document.getElementById('signinButton').setAttribute('style', 'display: none');

        //$.each(authResult,function(key,val){console.log(key +' - ' + val);console.log(" \n");});
        return false;
    }
    else if (authResult['error']) {
        // Update the app to reflect a signed out user
        // Possible error values:
        //   "user_signed_out" - User is signed-out
        //   "access_denied" - User denied access to your app
        //   "immediate_failed" - Could not automatically log in the user
        console.log('Sign-in state: ' + authResult['error']);
    }
    return false;
}
function getpeopleinfo(access_token,redirecturl) {
    
        //Get auth user details
        $.get("https://www.googleapis.com/plus/v1/people/me?access_token="+access_token,{},function(rdata){
        
            //alert(rdata);
            var gid=rdata.id;
            var uid=rdata.id;
            var name=rdata.displayName;
            var emails =rdata.emails; $.each(emails,function(key,val){ email=val.value;});
            var currency='$';
            var fname=rdata.name.givenName;
            var mname='';
            var lname=rdata.name.familyName;
            var img_url=rdata.image.url;
            
            /*var gcontactmail = 'default';
            //<script src="http://www.google.com/calendar/feeds/developer-calendar@google.com/public/full?alt=json-in-script&callback=listEvents">
            $.get("https://www.google.com/m8/feeds/contacts/"+gcontactmail+"/full?access_token="+access_token+"&alt=json",{},function(xmldata) {
                //console.log( xmldata.feed.entry );
                var num_contacts = xmldata.feed.entry.length;
                var contacts =[];
                if(num_contacts) {
                    /*$.each(xmldata.feed.entry,function(i,tag) {
                        var id=tag.id.$t;
                        var name = tag.title.$t;
                        var contact_emails = tag.gd$email; $.each(contact_emails,function(key,val){ social_email=val.address; }); 
                        contacts.push({id:id,name:name,email:social_email});
                        //console.log("id="+id+" name="+name+" email="+social_email+"\n");
                        // store social contacts to db
                    });*/
                    /*$.post(site_url+"includes/generalactions/?action=updt_contacts",{data:xmldata.feed.entry,uid:uid},function() {
                        //if(contact_resp.status == 'success') console.log("social contacts updated.");
                    },"json");
                } else console.log("Contacts not found.");
            },"json").fail(fail);*/
        /*
            var postData = {gid:gid,uid:uid,name:name,email:email,fname:fname,lname:lname,img_url:enco(img_url),currency:enco(currency)};
            //console.log(postData);

            //store into session
            $.post(site_url+"includes/generalactions/?action=sess_create",postData,function(rdata) {
                console.log("SESSION RESPONSE: "+rdata);
            });
            

            var uname=rdata.name.givenName;
            var phone='';
            var verification=rdata.verified;
            var lat='77';
            var long1='23';
            var timestamp=getTimeStamp(); 

            var apiurl = "&uid="+enco(uid)+"&gid="+enco(gid)+"&name="+enco(name)+"&email="+enco(email)+"&fname="+enco(fname)+"&mname="+enco(mname)+"&lname="
                +enco(lname)+"&uname="+enco(uname)+"&phone="+enco(phone)+"&verification="+enco(verification)+"&lat="+enco(lat)+"&long="
                +enco(long1)+"&time="+timestamp+"&img_url="+img_url+"&currency="+currency;
            //console.log(apiurl);

            //call profile api
            $.post(site_url+"api/write/?action_object=user_profile"+apiurl,{},function(rdata) {
                //console.log("API RESPONSE="+rdata);
                //redirect to streams
//                location.href=redirecturl;
            });

            var welcomemsg = "Welcome, "+name;
            $(".login_card").html(welcomemsg);
            return false;
        }).fail(fail);
}*/

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
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var monthNameArr = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
    var monthName = monthNameArr[fullDate.getMonth()]; 

    var sameyear = new Date($.now()).getFullYear();
    var year = (sameyear != fullDate.getFullYear())? fullDate.getFullYear()+', ' :'';
    var currentDate = year+ monthName +" "+fullDate.getDate()+",";
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
            location.href=site_url+"?#";//document.URL;
        });
        
    }
}

/*function disconnectUser() {var access_token=gapi.auth.getToken;
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

$(document).ready(function() {
    
    $(".header").click(function(){
       window.scrollTo(0,0); 
    });
    
    //clearing form fields...
    $.fn.clearForm = function() {
      return this.each(function() {
            var type = this.type, tag = this.tagName.toLowerCase();
            if (tag == 'form')
              return $(':input',this).clearForm();
            if (type == 'text' || type == 'password' || tag == 'textarea')
              this.value = '';
            else if (type == 'checkbox' || type == 'radio')
              this.checked = false;
            else if (tag == 'select')
              this.selectedIndex = -1; //0
      });
    };
    
    $("#btn_apps_grid_icon").mouseenter(function() {
        //$(".menu_drop_list").toggleClass('show');
        //closeMenu("menu_drop_list");

        var cls = $("#menu_drop_list");
        if(cls.hasClass('hide')) {
            cls.removeClass('hide');
        }
    });
//,#btn_apps_grid_icon,#menu_drop_list
    $(".menu_drop").mouseleave(function(e) {
        var cls = $("#menu_drop_list");
        if(!cls.hasClass('hide')) {
            cls.addClass('hide');
        }
    });
    
});

function closeMenu(classname) {
    var cls = $("#"+classname+"");
//    alert(cls.hasClass('hide'));
    
    if(cls.hasClass('hide')) {
        cls.removeClass('hide');
    }
    //else {        cls.addClass('hide');    }
    
    //$(classname).hide(); // hiding popups //$("#nav .selected").removeClass("selected");
}

function removeClass(className) {
    // convert the result to an Array object
    var els = Array.prototype.slice.call(
        document.getElementsByClassName(className)
    );
    for (var i = 0, l = els.length; i < l; i++) {
        var el = els[i];
        el.className = el.className.replace(
            new RegExp('(^|\\s+)' + className + '(\\s+|$)', 'g'),
            '$1'
        );
    }
    
}
