<div id="website_section" class="section">
<h4>Websites</h4>
<br/>
<?php
foreach($websites as $website)
{
	$primary = array('No', 'Yes');
	echo '<div class="sub_section">';
	
	echo 'Website Address: '.$website['website'].'<br/>';
	echo 'Primary: '.$primary[$website['primary']].'<br/>';
		
	echo $html->link('Edit', '/websites/edit/'.$website['id']);
	echo '&nbsp;';
	echo $html->link('Delete', "/websites/delete/{$website['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
}
?>
<a href="<?php echo PROFILE_ROOT; ?>/websites/add" >Add a website</a>
</div>