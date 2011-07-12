<div class="content">
<div class="mainContent">
<h1>Manage an E-mail</h1>

<?php
echo $form->create('Email', array('action' => 'edit', 'dojoType' => 'dijit.form.Form', 'onSubmit' => 'return dialogSave(this);'));

echo $form->input('email', array( 'label' => 'E-mail Address:', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
	onmouseover="toolTipr(this);" 
	alt="Enter the email address you would like to use with this identity"
>', 'dojoType' => 'dijit.form.ValidationTextBox', 'regExpGen' => 'dojox.validate.regexp.emailAddress', 'required' => 'true') );

echo $form->input('primary', array('label' => 'Primary?', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
	onmouseover="toolTipr(this);" 
	alt="Is this your main email address?"
>', 'dojoType' => 'dijit.form.CheckBox'));

echo $form->end('Save');
?>
</div>
</div>