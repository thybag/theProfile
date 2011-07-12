<?php
/*
 * Landing page for theProfile
 * @author Michael Pontin & David Couch
 * 25 Jan 2011
 */
 ?>
<div class="content">
	<div class="mainContent">
		<div id="home_page">
			<h2>Welcome to TheProfile.co.uk!</h2>
			<div id="signinbox" >
			
			<img src="<?php echo PROFILE_ROOT?>/img/front_logo.png" alt="Profile Logo" ></img>
			<br />
			<button onClick="document.location='<?php echo PROFILE_ROOT?>/users/register'" dojoType="dijit.form.Button">Sign Up</button>
			</div>
			<p>Sick of having to register an account with every website? Or having to change multiple websites when one small piece of information about you changes?</p>
			<p>theProfile is an online tool to help you manage and update your profile across multiple sites.</p>
			<p>Unlike other sites we enable you to manage several profiles at once.</p>
			<p>We also act as an OpenID provider so once you've registered with us you can use your information to log in to any OpenID enabled site.</p>
			<br />
			<p>Getting started is simple, just click on <a href="<?php echo PROFILE_ROOT?>/users/register" >Sign up</a></p>


			
			<div class="clear">&nbsp;</div>
		</div>
</div>