 <?php 

echo '<br/><br/><br/>';

if(!isset($output) ){
echo '

<form id="openidAuthorizeForm" method="post" action="?openid.mode=authorize" accept-charset="utf-8">

<label for="openidUsername">Username</label>
<input name="user" type="text" maxlength="100" id="openidUsername" />

<label for="openidPassword">Password</label>
<input type="password" name="pw" id="openidPassword" />

<input type="submit" value="Login" />

</form>

';
}else{
	echo $output;
}
 ?>