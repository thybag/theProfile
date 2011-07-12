<div class="content">
<div class="mainContent">

<h1>Manage a Telephone Number</h1>

<?php
$types = array( 'Mobile', 'Home', 'Work');
echo $form->create('Number', array('action' => 'edit', 'dojoType' => 'dijit.form.Form', 'onSubmit' => 'return dialogSave(this);'));

echo $form->input('type', array('type' => 'select', 'options' => $types, 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
	onmouseover="toolTipr(this);" 
	alt="What type of number is this?"
>', 'dojoType' => 'dijit.form.FilteringSelect',  'required' => 'false'));

echo $form->input('number', array('after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
	onmouseover="toolTipr(this);" 
	alt="Enter the phone number you would like to use with this identity"
>','dojoType' => 'dijit.form.ValidationTextBox',	'regExp' => '[0-9]+', 'invalidMessage' => "Invalid phone number, try removing spaces and any dashes!", 'required' => 'true'));
echo $form->end('Save');
?>
</div>