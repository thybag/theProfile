<?php 
/*
 * Facebook mini page used to allow the 
 * user to login to facebook so as to create a profile
 * @author Michael Pontin
 */
?>
<div id="facebook_section" class="section">
<div id="fb-root"></div>
<h2>Facebook</h2>
<p>Use Facebook to gather information</p>
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

<fb:login-button autologoutlink="false" perms="email,user_birthday,status_update,publish_stream">Sign in with Facebook</fb:login-button>

</div>