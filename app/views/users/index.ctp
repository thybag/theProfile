<?php 
/*
 * Index page for when a user has logged in
 * @author Michael Pontin, Carl Saggs & David Couch
 * @created Nov 9 2010
 */
$knownuser = $knownuser['User'];
?>
<div class="content">
	<div class="mainContent">
		<?php if(!$hasIdent):?>
			<h1>Setting up your first profile</h1>
			<p>With TheProfile you can manage a profile across multiple sites like Google, Facebook, Youtube, Amazon and more.</p>
			<p>To get started we need to find out more about you..</p>
			<?php else:?>
			<h1>Setting up your profile</h1>
			<p>With TheProfile you can manage a profile across multiple sites like Google, Facebook, Youtube, Amazon and more.</p>
			<?php endif;?>
			<?php include 'facebook.ctp' ;?>
			<?php include 'google.ctp' ;?>
			<?php include 'openid.ctp' ;?>
			<div id="scratch_section">
			<h2>Or why not...</h2>
				<p>Enter the information yourself</p>
		    	<button dojoType='dijit.form.Button' onclick="document.location = '<?php echo PROFILE_ROOT; ?>/identities/add/';"><img src="<?php echo PROFILE_ROOT; ?>/img/icons/user_add.png" alt="add identity" />&nbsp;Create from scratch</button>
			</div>
			<div class="clear" ></div>
		</div>
</div>
