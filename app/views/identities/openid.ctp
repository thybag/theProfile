<?php

$endpoint = 'http://'.$_SERVER["SERVER_NAME"].PROFILE_ROOT.'/p/'.$this->Session->read("user");
?>
<div id="openid" class="section">
<h4><img alt="OpenID Login" src="http://openid.net/favicon.ico"> Open ID Endpoint</h4>
<div class='text'>
<span class='bigtext'>
<?php 
	echo '<a href="'.$endpoint.'">'.$endpoint.'</a>';
?>
</span>
<br/>
<span class='smalltext'>
What is this?
<?php
echo '<img src="'.PROFILE_ROOT .'/img/icons/help.png" alt="You can use the above link to log in to websites with your theProfile account every time you see the OpenID logo!" onmouseover="toolTipr(this);"';
?>
</span>
</div>
</div>