<div id="openid_section" class="section">
<h2>OpenID</h2>
<?php

echo '<p>Use an existing OpenID to gather information</p>';

//echo '<img alt="OpenID Login" src="http://openid.net/favicon.ico">';
echo $form->create('Openid', array('type' => 'post', 'action' => 'login'));
echo $form->input('OpenidUrl.openid', array('label' => false, 'before' => '<img alt="OpenID Login" src="http://openid.net/favicon.ico">'));
echo $form->hidden('type', array('value' => 'openidapp')); //where do we want this data to eventually end up?
echo $form->end('Login');
?>
</div>