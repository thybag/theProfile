<div id="website_section" class="section">
<h4><a href="<?php echo PROFILE_ROOT; ?>/emails/add" >Add an website</a></h4>
<br/>
<?php
foreach($websites as $website)
{
	$primary = array('No', 'Yes');
	echo '<div class="sub_section">';
	
	echo 'Website Address: '.$website['website'].'<br/>';
	echo 'Primary: '.$primary[$email['primary']].'<br/>';
		
	echo $html->link('Edit', '/website/edit/'.$website['id']);
	echo '&nbsp;';
	echo $html->link('Delete', "/website/delete/{$website['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
}
?>
</div>