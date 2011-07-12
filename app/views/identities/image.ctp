<div id="images_section" class="section">
<?php
/*
 * Image section for when a user has logged in
 * @author Michael Pontin
 * @edit David Couch -added ajax
 * @created Nov 18 2010
 */
$image = array_shift($images); //gets the first image from the array (the newest image)
if(empty($image))
{
	echo $html->image('blank.gif', array( 'alt' => 'no profile picture' ));
	$link = "/images/upload/";
	echo $html->link('Set avatar', $link, array("onClick" => "return showDialog('Add Image','".PROFILE_ROOT.$link."' ,'numbers')"));
}
else
{
	echo '<div class="sub_section">';
	if($image['url'] != null )
	{
		echo $html->image($image['url'], array( 'alt' => $image['name'] ));
	}
	else
	{
		echo $html->link($html->image('/img/uploads/'.$image['name'], array( 'alt' => $image['name'] )), '/img/uploads/'.$image['name'], array('escape' => false));
	}
	echo '<div id="image_del">';
	$link = "/images/upload/";
	echo $html->link('Upload', $link, array("onClick" => "return showDialog('Add Image','".PROFILE_ROOT.$link."' ,'numbers')"));
	echo ' | ';
	echo $html->link('Delete', "/images/delete/{$image['id']}", array('escape' => false),'About to delete this profile picture...');
	
	
	echo '</div></div>';
}


?>
</div>
