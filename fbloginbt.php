<div id="loadredoirect"></div>  
<div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '460244211058019',
            status     : true, 
            cookie     : true,
            xfbml      : true,
            oauth      : true
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
	  <div class="fb-login-button" data-width="100%" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"  data-scope="email,user_hometown,user_location" on-login="updateUserSession();">Login with Facebook</div>

	  <script language="javascript" type="text/javascript">
	  function updateUserSession()
{



 FB.api('/me', { locale: 'en_US', fields: 'name, email' },
function(response) { 
var facebookEmail=response.email;
var facebookName=response.name;

 
//window.location=""+fullurl+"fblogin.html?email="+facebookEmail+'&name='+facebookName; 
$('#loadredoirect').load('fblogin.html?email='+facebookEmail+'&name='+facebookName+'');
 parent.location.reload(fullurl);
}
);
 
}			
	  </script>
 
	  