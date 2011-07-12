<?php 
/*
 * Account settings page
 * @author Michael Pontin, Carl Saggs and David Couch
 * @created Jan 26th 2010
 */

?>
<script type="text/javascript" >
dojo.addOnLoad( function (){
	dijit.byId("pw_confirm").validator = function (value, constraints) {
			dijit.byId("pw_confirm").attr("invalidMessage","This password does not match your first");
			return (dijit.byId("newpw").attr('value') == value);
	}
});
</script>
<div class="content">
	<div class="mainContent">
		<h1>Account Settings</h1>
		<h2>Change your password</h2>
		<?php
			echo $form->create('User', array('action' => 'edit','dojoType' => 'dijit.form.Form', 'onSubmit' => 'return this.validate()'));
			
			echo $form->input('current_password', array('after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
				onmouseover="toolTipr(this);" 
				alt="Enter your current password"
			>','dojoType' => 'dijit.form.ValidationTextBox', 'type' => 'password', 'required' => 'true', 'regExp' => '[a-zA-Z0-9$%!_]{8,24}'));
			
			echo $form->input('password', array('id'=>'newpw', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
				onmouseover="toolTipr(this);" 
				alt="Enter the password you would like to use instead"
			>','dojoType' => 'dijit.form.ValidationTextBox', 'required' => 'true', 'regExp' => '[a-zA-Z0-9$%!_]{8,24}', 'invalidMessage' => 'Passwords must be a minimum of 8 characters'));
			
			echo $form->input('password_confirm', array('id' => 'pw_confirm', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
				onmouseover="toolTipr(this);" 
				alt="Confirm your new password"
			>',
			'type' => 'password', 'dojoType' => 'dijit.form.ValidationTextBox'));
			
			echo $form->end('Change Password');
		?>

		<h2>Which profile should be default?</h2>
		<?php
			if($hasIdent){
				$ident_array = array();
				foreach($identities as $ident )
				{
					if($ident['id'] != $default){ $ident_array[$ident['id']] = $ident['name'];}  
					else{ $name = $ident['name'];}
				}
				if(!empty($name))
				{
					$ident_array=array($default => $name)+$ident_array;//make sure to add the default value on to the front of the array
				}
				echo $form->create('User', array('action' => 'set_default'));
				
				echo $form->input('profile_default', array('label'=> 'Default:', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
					onmouseover="toolTipr(this);" 
					alt="Select which account you would like to use by default when logging into other sites"
				>',
				'type' => 'select', 'dojoType'=> 'dijit.form.FilteringSelect', 'options' => $ident_array ));
				
				echo $form->end('Change default');
				}
				else{
					echo "You can't set a profile if you do not have one!";
				}
		?>
		<h2>Privacy Settings</h2>
		<?php 
		if($privacy == 0){
			$priv = array('0' => 'Public', '1' => 'Private');
		}else{
			$priv = array('1' => 'Private', '0' => 'Public');
		}
			echo $form->create('User', array('action' => 'set_priv'));
				
			echo $form->input('privacy', array('label'=> 'Make my data: ', 'dojoType'=> 'dijit.form.FilteringSelect', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
					onmouseover="toolTipr(this);" 
					alt="Public: Setting this to public allows applications to access your profile data freely using our API.			Private: Setting this to private only allows applications to access your data on authentication via OpenID."
				>',
				'type' => 'select', 'options' => $priv ));
				
				echo $form->end('Set Privacy level');
		?>
		
		
	</div>
</div>