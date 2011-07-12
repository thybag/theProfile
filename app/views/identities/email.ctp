<div id="email_section" class="section">
<h4><img src="<?php echo PROFILE_ROOT; ?>/img/icons/email.png" alt="email" />&nbsp; E-mail Addresses</h4>
<div class='text'>

<?php



foreach($emails as $email)
{
	$primary ='';
	if($email['primary'] == 1){ $primary = '(Primary)'; }
	
	$link = "/emails/edit/".$email['id'];
	$edit = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/pencil.png" alt="Edit" title="Edit">', $link, array('escape' => false, "onClick" => "return showDialog('Edit {$email['email']}' ,'".PROFILE_ROOT.$link."' ,'email')"));
	$del = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/cross.png" alt="Delete" title="Delete">', "/emails/delete/{$email['id']}",array('escape' => false),'About to delete the email '.$email['email'].' from our records...');
	
	echo "<div class='sub_section'>
	
		<div class='email'>
			<span class='controls'>{$edit}&nbsp;{$del}</span>
				
			{$email['email']} {$primary}
		</div>

	</div>";
	/*		
	echo '<div class="sub_section">';
	
	echo 'E-mail Address: '.$email['email'].'<br/>';
	echo 'Primary: '.$primary[$email['primary']].'<br/>';
		
	$link = "/emails/edit/".$email['id'];
	echo $html->link('Edit', $link, array("onClick" => "return showDialog('Edit Email','".PROFILE_ROOT.$link."' ,'email')"));
	
	echo '&nbsp;';
	echo $html->link('Delete', "/emails/delete/{$email['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
	*/
}
	$link = "/emails/add/";
	echo $html->link('Add New', $link, array("onClick" => "return showDialog('Add Email','".PROFILE_ROOT.$link."' ,'email')"));
	

?>
</div>
</div>