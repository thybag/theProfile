<div id="profile_section" class="section">

<?php
	echo '<div class="sub_section">';
	echo '<br/>';
	
	echo 'Profile Name: '.$identity['name'].'<br/>';
	<!--echo 'Firstname: '.$identity['first_name'].'<br/>'; -->
	<!--echo 'Lastname: '.$identity['last_name'].'<br/>'; -->
	<!--echo 'Date of Birth: '.date('d M Y', strtotime($identity['dob'])).'<br/>';-->
	
	echo '<button dojoType='dijit.form.Button' onclick="document.location = '<?php echo PROFILE_ROOT; ?>/identities/edit/'.$identity['id'];">Edit</button>';
	echo '&nbsp;';
	echo $html->link('Delete', "/identities/delete/{$identity['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
?>
</div>