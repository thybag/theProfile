<div id="email_section" class="section">
<h4><a href="<?php echo PROFILE_ROOT; ?>/emails/add" >Add an E-mail Address</a></h4>
<br/>
<?php
foreach($emails as $email)
{
	$primary = array('No', 'Yes');
	echo '<div class="sub_section">';
	
	echo 'E-mail Address: '.$email['email'].'<br/>';
	echo 'Primary: '.$primary[$email['primary']].'<br/>';
		
	echo $html->link('Edit', '/emails/edit/'.$email['id']);
	echo '&nbsp;';
	echo $html->link('Delete', "/emails/delete/{$email['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
}
?>
</div>