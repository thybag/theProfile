<div class="content">
	<div class="mainContent">
		<h1>Validation</h1>
		<p>The e-mail address you provided should be receiving a validation e-mail soon.</p>
		<p>Please check it and either click the link provided or enter your validation code below.</p>
		<?php
			echo $form->create('User', array('action' => 'activate', 'type' => 'get'));
			echo $form->input('code', array('type' => 'text', 'label' => 'Validation Code'));
			echo $form->end('Validate');
		?>
	</div>
</div>