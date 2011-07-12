<div class="content">
<div class="mainContent">
<h1>About you</h1>

<?php

if($isAjax){
	$djvalid = 'dialogSave(this);'; 
}
else{
	$djvalid = 'this.validate();'; 
}
echo $form->create('Identity', array('action' => 'editTagline', 'dojoType' => 'dijit.form.Form', 'onSubmit' => 'return '.$djvalid));

echo $form->input('Identity.tagline', array( 'label' => 'About you:', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
	onmouseover="toolTipr(this);" 
	alt="Enter some information about yourself"
>', 'dojoType' => 'dijit.form.Textarea', 'style' => 'min-height:60px;width:200px;', 'required' => 'true', 'type'=>'textarea') );

echo $form->end('Save');
?>
</div>
</div>