<div class="userControl">
	<?php 
		if(!$this->Session->check("user")){
			echo "Already a user? Log in!<br/><br/>";
			echo $form->create('User', array('action' => 'login',
											'dojoType' => 'dijit.form.Form'));
			echo $form->input('username', array('dojoType' => 'dijit.form.ValidationTextBox',
												'required' => 'true',
												'style' => 'width:145px;'));
			echo $form->input('password', array('dojoType' => 'dijit.form.TextBox',
												'style' => 'width:145px;'));
			echo ' <span class="white">Forgotten your password? Reset it <a href="'.PROFILE_ROOT.'/reset">here</a></span>';
			echo ' <div class="submit"><button dojoType="dijit.form.Button" type="submit" value="Log In">Log In</button></div></form>';
			
		}else {
		
			echo "Welcome back <strong>".$this->Session->read("user")."</strong><br/>";
			echo "<span>(<a href='".PROFILE_ROOT."/users/logout'>Not you? Click here.</a>)</span>";
		}
	?>
</div>