<?php 
/**
 * Index page for when a user has logged in
 * @author Michael Pontin
 * @created Nov 9 2010
 */
$knownuser = $knownuser['User'];
?>
<h1>Welcome Home <?php echo $knownuser['first_name']?></h1>
<?php
unset($knownuser['id']);
unset($knownuser['password']);
foreach($knownuser as $key => $userdata)
{
	echo ucfirst($key).': '.$userdata.'<br/>';
}
?>
<br/>
<a href="<?php echo PROFILE_ROOT; ?>/users/address" >Add an address</a>