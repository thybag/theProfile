<?php 
/*
 * Profile Page. Acts as openID endpoint and Public Profile
 * @author Carl Saggs
 * @created Nov 15 2010
 */

if($user_exists){
	
	$knownuser = $knownuser['User'];
?>

<h1><?php echo $knownuser['username']?>'s Public Profile</h1>



<?php 
}
else
{
	echo'<h2>User not found! </h2>';
}

?>