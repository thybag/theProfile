<div id="application_section" class="section">
<h4><a href="<?php echo PROFILE_ROOT; ?>/applications/add" >Add an Application</a></h4>
<br/>
<?php
foreach($apps as $app)
{
	$types = array( 'Facebook', 'Google', 'Twitter');
	$attach = array('No', 'Yes');
	echo '<div class="sub_section">';
	echo $types[$app['name']];
	
	//echo '<br/>'.$html->link('Edit', '/applications/edit/'.$app['id']);
	echo '&nbsp;';
	echo $html->link('Delete', "/applications/delete/{$app['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
}
?>
</div>

