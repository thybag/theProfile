<div class="content">
<div class="mainContent">
<h2>Upload a Profile Image</h2>
<?php
	echo $form->create('Image', array('action' => 'upload', 'enctype' => 'multipart/form-data' ));
	
	echo $form->input('image', array('after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
		onmouseover="toolTipr(this);" 
		alt="Choose an image from your computer to use as your profile image"
	>',
	 'label' => 'Image:', 'type' => 'file' ));
	
	echo $form->end('Add an Image');
?>
</div>
</div>
