<h1>THIS PAGE IS NO LONGER USED, IF YOU ARE HERE LET MIKE KNOW AND TELL HIM WHAT YOU DID TO GET HERE!</h1>
<div id="identity_section" class="section">
<p>To create a new Profile from scratch click the Add a Profile button</p>
<h4><a href="<?php echo PROFILE_ROOT; ?>/identities/add" >Add a new profile</a></h4>


<?php
foreach($identities as $identity)
{
	echo '<div class="sub_section">';
	echo $html->link('View this Profile', '/identities/index/'.$identity['id']);
	echo '<br/>';
	
	echo 'Profile Name: '.$identity['name'].'<br/>';
	echo 'Firstname: '.$identity['first_name'].'<br/>';
	echo 'Lastname: '.$identity['last_name'].'<br/>';
	echo 'Date of Birth: '.date('d M Y', strtotime($identity['dob'])).'<br/>';

	echo '</div>';
	echo '<br/>';
}
?>
</div>