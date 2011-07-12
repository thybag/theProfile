<?php
/*
 * Reset password
 * @author Michael Pontin
 * 5 March 2011
 */
 ?>
<div class="content">
	<div class="mainContent">
		<h2>Reset my Password</h2>
			<p>If you have forgotten your password you can reset it by telling us your username</p>
			<?php 
				echo $form->create('User', array('action' => 'reset',
											'dojoType' => 'dijit.form.Form'));
				echo $form->input('user', array('dojoType' => 'dijit.form.ValidationTextBox',
												'required' => 'true',
												'style' => 'width:145px;'));
				
				echo ' <div class="submit"><button dojoType="dijit.form.Button" type="submit" value="Reset">Reset</button></div></form>';
			
			?>
					<div class="clear">&nbsp;</div>
		</div>
</div>