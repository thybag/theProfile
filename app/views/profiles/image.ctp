
<div id="images_section" class="section">
<?php
/*
 * Image section for when a user has logged in
 * @author Michael Pontin
 * @created Nov 18 2010
 */
if(empty($images))
{
	echo $html->image('blank.gif', array( 'alt' => 'no profile picture' ));
}
foreach($images as $image)
{
	echo '<div class="sub_section">';
	if($image['url'] != null )
	{
		echo $html->image($image['url'], array( 'alt' => $image['name'] ));
	}
	else
	{
		echo $html->image('/img/uploads/'.$image['name'], array( 'alt' => $image['name'] ));
	}
	echo '<br />';
	echo $html->link('Delete', "/images/delete/{$image['id']}",null,'Are you sure?');
	echo '</div>';
}
?>
<h4><a href="<?php echo PROFILE_ROOT; ?>/images/upload" >Upload a Profile Image</a></h4>
</div>