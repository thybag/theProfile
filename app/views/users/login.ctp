<?php 
/*
 * Login page
 * @author Michael Pontin, Carl Saggs & David Couch
 * @created Nov 9 2010
 */

?>
<div class="content">
	<div class="mainContent">
<h1><?php echo $this->pagetitle = 'Log In';?> to your user account</h1>

<?php
echo $form->create('User', array('action' => 'login', 'dojoType' => 'dijit.form.ValidationTextBox'));
echo $form->input('username', array('dojoType' => 'dijit.form.ValidationTextBox'));
echo $form->input('password', array('dojoType' => 'dijit.form.ValidationTextBox'));
echo $form->end('Log In');

?>
	</div>
</div>