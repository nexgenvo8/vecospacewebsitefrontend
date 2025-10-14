<div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '396578940740378',
            status     : true,                                 
			  xfbml    : true   
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "https://connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
		 
      </script>
    <button type="button" onclick="updateUserSession();" class="fblogin"><i class="fa fa-facebook" aria-hidden="true"></i> Log in with Facebook </button>
<div class="fb-login-button" data-size="medium" data-scope="email" on-login="updateUserSession();" style="padding:0px; background-image:none; background-color:none;display: none;">
        Sign up with facebook</div>
	  
	  <script>
	  $('.fb-login-button').click(function(event){
  event.preventDefault();
});
	  </script>