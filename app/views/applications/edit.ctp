<div class="content">
	<div class="mainContent">
		<h1>Add an Application</h1>

		<?php include 'facebook.ctp' ;?>
		<?php include 'google.ctp' ;?>
		<?php include 'openid.ctp' ;?>
		<?php include 'twitter.ctp' ;?>
		
		<!--		<div id="fb-root"></div>
 <script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
            
            <?php if(isset($facebook)):?>
				appId   : '<?php echo $facebook->getAppId(); ?>',
				session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
			<?php endif;?>
			status  : true, // check login status
			cookie  : true, // enable cookies to allow the server to access the session
			xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
        	window.location = '<?php echo PROFILE_ROOT; ?>/facebook';
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
	<ul id="app_select" >
		<li><fb:login-button autologoutlink="false" perms="email,user_birthday,status_update,publish_stream">Sign in with Facebook</fb:login-button></li>
		<li><a href="<?php echo PROFILE_ROOT; ?>/google"><button><img alt="Google Login" src="https://www.google.com/favicon.ico">&nbsp; Sign in with Google</button></a></li>
		<li><a href="<?php echo PROFILE_ROOT; ?>/twitter" ><img src="<?php echo PROFILE_ROOT; ?>/img/sign-in-with-twitter.png" alt="Twitter Login" width="159px" /></a></li>
	</ul>-->


		<div class="clear" ></div>
	</div>
</div>