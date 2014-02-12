<?php
$client_id=($_SERVER['HTTP_HOST'] == 'localhost:13080')?"209511642870-6vr479nj2mc9b0ablkobf61mbk1403a2.apps.googleusercontent.com"
    :"209511642870-rb5pa5elftt3paeiusqkf43ptoe2cat8.apps.googleusercontent.com";
if(isset($fn_signin_callback))
    $fn_signin_callback = $fn_signin_callback;
else $fn_signin_callback = "signinCallback";
$apiKey = 'AIzaSyBt514eUceQLLd8b_KI2XKD_tsaVtwm4E8';
?>

<!--Add a button for the user to click to initiate auth sequence -->
    <button id="authorize-button" style="visibility: hidden">Authorize</button>
    
    <script type="text/javascript">

      var clientId = "<?=$client_id;?>";

      var apiKey = "<?=$apiKey;?>";

      var scopes = 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login https://www.google.com/m8/feeds https://www.google.com/m8/feeds/user';////https://www.googleapis.com/auth/plus.me

      function handleClientLoad() {
        // Step 2: Reference the API key
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
      }

      function checkAuth() {
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

      function handleAuthClick(event) {
        // Step 3: get authorization to use private data
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
      }

      // Load the API and make an API call.  Display the results on the screen.
      function makeApiCall() {
                // Step 4: Load the Google+ API
                gapi.client.load('plus', 'v1', function() {
                   // Step 5: Assemble the API request
//                  var request = gapi.client.plus.people.get({
//                    'userId': 'me'
//                  });

                    ////////////////////
                    // This sample assumes a client object has been created.
                    // To learn more about creating a client, check out the starter:
                    //  https://developers.google.com/+/quickstart/javascript
                    var request = gapi.client.plus.people.list({
                      'userId' : 'me',
                      'collection' : 'visible'
                    });

                    request.execute(function(resp) {
                      var numItems = resp.items.length;
                      for (var i = 0; i < numItems; i++) {
                        console.log(resp.items[i].displayName);
                      }
                    });
                   ///////////////////////


                  // Step 6: Execute the API request
//                  request.execute(function(resp) {
//                    var heading = document.createElement('h4');
//                    var image = document.createElement('img');
//                    image.src = resp.image.url;
//                    heading.appendChild(image);
//                    heading.appendChild(document.createTextNode(resp.displayName));
//        
//                    document.getElementById('content').appendChild(heading);
//                  });
        });
      }
    </script>
<!--// Step 1: Load JavaScript client library-->
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
    
<!--https://developers.google.com/oauthplayground/#step3&apisSelect=https%3A//www.google.com/m8/feeds/&scopes=https%3A//www.googleapis.com/auth/userinfo.email%20https%3A//www.googleapis.com/auth/plus.login%20https%3A//www.google.com/m8/feeds&auth_code=4/OSoW_LMrhszLbKlLtlykM-PYKZcU.otYWOffErwoRXE-sT2ZLcbRlD90KiAI&refresh_token=1/WFjHelbW3JSQ02WZASs_YCT3DpnjIHN8vleJ9skDj2A&access_token_field=ya29.1.AADtN_XNlD4oR4cA9ldKIGYGlhq9v8eS4C2mEjUuJGB2DtGvJGgYwFB4yKrfSeGm&url=https%3A//www.google.com/m8/feeds/contacts/default/full/&content_type=application/json&http_method=GET&useDefaultOauthCred=unchecked&oauthEndpointSelect=Google&oauthAuthEndpointValue=https%3A//accounts.google.com/o/oauth2/auth&oauthTokenEndpointValue=https%3A//accounts.google.com/o/oauth2/token&expires_in=3599&access_token_issue_date=1391661390&for_access_token=ya29.1.AADtN_XNlD4oR4cA9ldKIGYGlhq9v8eS4C2mEjUuJGB2DtGvJGgYwFB4yKrfSeGm&headerList=GData-Version%3D3.0&includeCredentials=checked&accessTokenType=bearer&autoRefreshToken=unchecked&accessType=offline&forceAprovalPrompt=checked&response_type=code-->
    
<?php 
#RESPONSE:
/*
[
 {
  "id": "gapiRpc",
  "result": {
   "kind": "plus#peopleFeed",
   "etag": "\"KmFlUTDKo0bNqNhpeBygvIv8XvA/iEvUPfyk3AlJXeRFgoZgDAJhR6c\"",
   "title": "Google+ List of Visible People",
   "nextPageToken": "CGQQgoixnsIo",
   "totalItems": 392,
   "items": [
    {
     "kind": "plus#person",
     "etag": "\"KmFlUTDKo0bNqNhpeBygvIv8XvA/QIsGl0ZQ6uJ6zf04ugKsss0055k\"",
     "objectType": "person",
     "id": "115443345828221940378",
     "displayName": "AMIT SINGH",
     "url": "",
     "image": {
      "url": "https://lh5.googleusercontent.com/--IoQD3jhbnY/AAAAAAAAAAI/AAAAAAAAAAA/1QA8PO-4Y9k/photo.jpg?sz=50"
     }
    },
    {
     "kind": "plus#person",
     "etag": "\"KmFlUTDKo0bNqNhpeBygvIv8XvA/Iv90rq-LVOHgwOCAl7z4WsIPdAo\"",
     "objectType": "person",
     "id": "111945664047461919234",
     "displayName": "ANILKUMAR CH",
     "url": "https://plus.google.com/111945664047461919234",
     "image": {
      "url": "https://lh4.googleusercontent.com/-NgKkm2Hf6p4/AAAAAAAAAAI/AAAAAAAAAEw/mlXnOI_hEKc/photo.jpg?sz=50"
     }
    },
    {
     "kind": "plus#person",
     "etag": "\"KmFlUTDKo0bNqNhpeBygvIv8XvA/1LPebfFiQgtOOYbrIenv3wFC1vE\"",
     "objectType": "person",
     "id": "103605066476661218025",
     "displayName": "Kavana N",
     "url": "https://plus.google.com/103605066476661218025",
     "image": {
      "url": "https://lh6.googleusercontent.com/-Hg2_YmmjreM/AAAAAAAAAAI/AAAAAAAAAc0/b3vGyqzC2gw/photo.jpg?sz=50"
     }
    }
   ]
  }
 }
]
            */


/*REPONSE:
    //$data = "<?xml version='1.0' encoding='UTF-8'?><feed xmlns='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearch/1.1/' xmlns:gContact='http://schemas.google.com/contact/2008' xmlns:batch='http://schemas.google.com/gdata/batch' xmlns:gd='http://schemas.google.com/g/2005' gd:etag='W/&quot;Ck4DRHwyeyt7I2A9Wh9SFks.&quot;'>";
    //<id>publish@lyfeon.com</id><updated>2014-02-06T04:29:35.293Z</updated>
    //<category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/>
    //<title>Sarah Collin's Contacts</title>
    //<link rel='alternate' type='text/html' href='http://www.google.com/'/>
    //<link rel='http://schemas.google.com/g/2005#feed' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full'/>
    //<link rel='http://schemas.google.com/g/2005#post' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full'/>
    //<link rel='http://schemas.google.com/g/2005#batch' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/batch'/>
    //<link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full?max-results=25'/>
    //<author><name>Sarah Collin</name><email>publish@lyfeon.com</email></author>
    //<generator version='1.0' uri='http://www.google.com/m8/feeds'>Contacts</generator>
    //<openSearch:totalResults>12</openSearch:totalResults><openSearch:startIndex>1</openSearch:startIndex><
    //openSearch:itemsPerPage>25</openSearch:itemsPerPage><entry gd:etag='&quot;RXk6fzVSLyt7I2A9Wh5RGUkLRQY.&quot;'>
    //<id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/2fc67238aede7ff</id><updated>2013-10-28T06:20:24.717Z</updated>
    //<app:edited xmlns:app='http://www.w3.org/2007/app'>2013-10-28T06:20:24.717Z</app:edited>
    //<category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/>
    //<title>Uday Sekhar</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/2fc67238aede7ff' gd:etag='&quot;WWhPA1lAWit7I2BWRFMba013IX08IFE_cgw.&quot;'/>
    //<link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/2fc67238aede7ff'/>
    //<link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/2fc67238aede7ff'/>
    //<gd:name><gd:fullName>Uday Sekhar</gd:fullName><gd:givenName>Uday</gd:givenName><gd:familyName>Sekhar</gd:familyName></gd:name>
    //<gd:email rel='http://schemas.google.com/g/2005#other' address='usekhar4@gmail.com'/></entry><entry gd:etag='&quot;Qnk7fTVSLit7I2A9WhNUF0QOTgI.&quot;'>
    //<id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/1bc8c91d8947b04d</id><updated>2013-01-10T05:16:03.705Z</updated>
    //<app:edited xmlns:app='http://www.w3.org/2007/app'>2013-01-10T05:16:03.705Z</app:edited>
    //<category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/>
    //<title></title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/1bc8c91d8947b04d'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/1bc8c91d8947b04d'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/1bc8c91d8947b04d'/><gd:email rel='http://schemas.google.com/g/2005#other' address='ee@ee.com' primary='true'/></entry><entry gd:etag='&quot;Q389fTVSLit7I2A9WhNUF0QOTgc.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/1ef1e8108fe8cb0f</id><updated>2013-01-10T05:15:32.165Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-01-10T05:15:32.165Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title></title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/1ef1e8108fe8cb0f' gd:etag='&quot;KGRNL3lFfCt7I2BhW1IxQ0RQInFCImECa1U.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/1ef1e8108fe8cb0f'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/1ef1e8108fe8cb0f'/><gd:email rel='http://schemas.google.com/g/2005#other' address='anil.taraka@permeative.com' primary='true'/></entry><entry gd:etag='&quot;Rnc5fzVSLit7I2A9Wh5TEkUORgY.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/25ff6f6f8c5bef75</id><updated>2013-09-27T12:15:27.927Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-09-27T12:15:27.927Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title></title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/25ff6f6f8c5bef75' gd:etag='&quot;LRZBAkImSit7I2BgM2cZSDdNEWtHB04yMxI.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/25ff6f6f8c5bef75'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/25ff6f6f8c5bef75'/><gd:email rel='http://schemas.google.com/g/2005#other' address='sweetygarapati@gmail.com'/></entry><entry gd:etag='&quot;QHY8ezVSLit7I2A9WhFXEk8MRQ0.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/2bbae74c0dba1359</id><updated>2013-07-19T09:31:31.873Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-07-19T09:31:31.873Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Nagaveni BM</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/2bbae74c0dba1359'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/2bbae74c0dba1359'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/2bbae74c0dba1359'/><gd:name><gd:fullName>Nagaveni BM</gd:fullName><gd:givenName>Nagaveni</gd:givenName><gd:familyName>BM</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#other' address='nagaveni.bm@permeative.com' primary='true'/></entry><entry gd:etag='&quot;RnY9eDVSLit7I2A9Wh5TEkUJRQQ.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/2efd6b390f69f74e</id><updated>2013-09-27T12:00:07.860Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-09-27T12:00:07.860Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Shivaraj R H</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/2efd6b390f69f74e' gd:etag='&quot;WRkqPUMoSit7I2BhKlU8aUxjAlcDI1gfSAk.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/2efd6b390f69f74e'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/2efd6b390f69f74e'/><gd:name><gd:fullName>Shivaraj R H</gd:fullName><gd:givenName>Shivaraj</gd:givenName><gd:additionalName>R</gd:additionalName><gd:familyName>H</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#work' address='mrshivaraj123@gmail.com'/></entry><entry gd:etag='&quot;SXk7fTVSLit7I2A9Wh5VGUQLQQ0.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/441d51da8fb4d60e</id><updated>2013-12-14T03:28:18.705Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-12-14T03:28:18.705Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Neal Smith</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/441d51da8fb4d60e' gd:etag='&quot;cTNVOnkZSit7I2BIUFUBTjxqL0AXGm0ZTyE.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/441d51da8fb4d60e'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/441d51da8fb4d60e'/><gd:name><gd:fullName>Neal Smith</gd:fullName><gd:givenName>Neal</gd:givenName><gd:familyName>Smith</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#other' address='contact@lyfeon.com' primary='true'/><gContact:website href='http://www.google.com/profiles/101651219808545508511' rel='profile'/></entry><entry gd:etag='&quot;RHs_eTVSLit7I2A9WhFXEU4NQgc.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/4a53d7490d5c9988</id><updated>2013-07-18T08:52:15.541Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-07-18T08:52:15.541Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title></title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/4a53d7490d5c9988'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/4a53d7490d5c9988'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/4a53d7490d5c9988'/><gd:email rel='http://schemas.google.com/g/2005#other' address='pabitra.ranjansahu@permeative.com'/></entry><entry gd:etag='&quot;SXs7cDVSLit7I2A9WhFbEEgCRAE.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/4a7184ae0e7776c2</id><updated>2013-09-01T17:59:18.508Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-09-01T17:59:18.508Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Roopchand Gurjar</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/4a7184ae0e7776c2' gd:etag='&quot;RWgrZ1ZGfCt7I2BPDRMkDSJ3MWwXN2cMSiY.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/4a7184ae0e7776c2'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/4a7184ae0e7776c2'/><gd:name><gd:fullName>Roopchand Gurjar</gd:fullName><gd:givenName>Roopchand</gd:givenName><gd:familyName>Gurjar</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#other' address='roopchand.gurjar@permeative.com'/></entry><entry gd:etag='&quot;Q3cycDVSLit7I2A9WhFbEEgCRAU.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/4dfce465081ddb0a</id><updated>2013-09-01T17:58:32.998Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-09-01T17:58:32.998Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Shivaraja Kumara</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/4dfce465081ddb0a' gd:etag='&quot;fgNMD0seSit7I2A1GncLYTwMKGsVAjslYyM.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/4dfce465081ddb0a'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/4dfce465081ddb0a'/><gd:name><gd:fullName>Shivaraja Kumara</gd:fullName><gd:givenName>Shivaraja</gd:givenName><gd:familyName>Kumara</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#other' address='shivaraja@permeative.com' primary='true'/></entry><entry gd:etag='&quot;RXk6fzVSLyt7I2A9Wh5RGUkLRQY.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/6f429b168a394102</id><updated>2013-10-28T06:20:24.717Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2013-10-28T06:20:24.717Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Uday Sekhar</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/6f429b168a394102' gd:etag='&quot;czNtGloWbCt7I2BFJVQERxlwGgQyJHsbQVI.&quot;'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/6f429b168a394102'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/6f429b168a394102'/><gd:name><gd:fullName>Uday Sekhar</gd:fullName><gd:givenName>Uday</gd:givenName><gd:familyName>Sekhar</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#other' address='udaysekhar4@gmail.com'/></entry><entry gd:etag='&quot;SHo_fDVSLit7I2A9WhNWGEQMTgA.&quot;'><id>http://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/base/6f999b3e8ec310b4</id><updated>2012-12-19T06:02:29.444Z</updated><app:edited xmlns:app='http://www.w3.org/2007/app'>2012-12-19T06:02:29.444Z</app:edited><category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/><title>Mahesh Ashok Bijapur</title><link rel='http://schemas.google.com/contacts/2008/rel#photo' type='image/*' href='https://www.google.com/m8/feeds/photos/media/publish%40lyfeon.com/6f999b3e8ec310b4'/><link rel='self' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/6f999b3e8ec310b4'/><link rel='edit' type='application/atom+xml' href='https://www.google.com/m8/feeds/contacts/publish%40lyfeon.com/full/6f999b3e8ec310b4'/><gd:name><gd:fullName>Mahesh Ashok Bijapur</gd:fullName><gd:givenName>Mahesh</gd:givenName><gd:additionalName>Ashok</gd:additionalName><gd:familyName>Bijapur</gd:familyName></gd:name><gd:email rel='http://schemas.google.com/g/2005#other' address='maheshashok.bijapur@permeative.com' primary='true'/><gContact:website href='http://www.google.com/profiles/110532130771183365339' rel='profile'/></entry></feed>';
    */
?>