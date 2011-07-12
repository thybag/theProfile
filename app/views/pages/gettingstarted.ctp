<?php
/*
 * Getting Started Page
 *	Tells the user what to do next
 *
 * @author Michael, Carl and Dave
 */
?>
<div class="content">
	<div class="mainContent">
		<div id="welcome_page">

			<h1>Getting Started...</h1>

			<p class="bold" >Thanks for creating an account on theProfile.co.uk!</p>
			<p>This site will allow you to manage multiple profiles from the same user interface, and give you the ability to import 
				your profile information from popular sites such as Facebook, Twitter and Google. Sadly at the moment Facebook will not let us push data into it, but we are actively investigating other methods to get this done.
			</p>
			<p>We have provided you with an OpenID endpoint, which you can use to log in to other sites and services with your account. A good example of this is <a href='http://www.neowin.net'>Neowin</a> - a technology news website/forum. Click <a href="http://openid.net/get-an-openid/individuals/" target="_blank" >here</a> to read more about OpenID and why it's awesome.
			 </p>
			 <p>
			 	This is only just the beginning... Over time, more and more sites will support your profile, and you will be able to 
			 	sign into these sites using the user-name and password you registered here. We will also be adding more features to 
			 	this site, making it even more useful. The days of entering the same information onto each website are almost over!
			 </p>
			 <p class="center" ><button dojoType='dijit.form.Button' onclick="document.location = '<?php echo PROFILE_ROOT; ?>/create';"><img src="<?php echo PROFILE_ROOT; ?>/img/icons/thumb_up.png" alt="add identity" />&nbsp; Start using your profile right now!</button></p>
		</div>
	</div>