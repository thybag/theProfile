<div class="content">
	<div class="mainContent">
			<h2>OpenID Login</h2>
<?php

echo $form->create('Openid', array('type' => 'post', 'action' => 'login'));
echo $form->input('OpenidUrl.openid', array('label' => false));
echo $form->end('Login');
?>

<div class="clear">&nbsp;</div>
		</div>
</div>