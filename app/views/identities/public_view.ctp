<?php 
/*
 * Index page for when a specific identity
 * @author Michael Pontin, Carl Saggs & David Couch
 * @created Nov 25 2010
 */

?>
<div class="content">
<div class="mainContent">
		
		<?php
		if($identity == NULL){
			echo '<h4>User "'.$name.'" could not be found. Sorry.</h4>';
		}else if($privacy == 1){
			echo '<h4>This account is Private</h4>
			<p>This page acts as an OpenID endpoint.</p>
			<p> If this is your profile, you will still  be able
			to use this url to login to websites via openID, even though the public profile is hidden.</p>
			
			';
		}else{
			echo '<div class="userDetails">';
			echo '<div id="images_section" class="section">';
			$image = array_shift($images); //gets the first image from the array (the newest image)
			if(empty($image))
			{
				echo $html->image('blank.gif', array( 'alt' => 'no profile picture' ));
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
					echo $html->image('/img/uploads/'.$image['name'], array( 'alt' => $image['name'] ));
				}
				echo '</div>';
			}
			echo '</div>';

			echo '<div id="profile_section" class="section"><div class="sub_section">';
			
			echo "<h1>".$identity['title']." ".$identity['first_name']." ".$identity['last_name'].'</h1>';
			echo 'Gender: '.$identity['gender'].'<br/>';
			echo 'Nickname: '.$identity['nickname'].'<br/>';
			echo '<p>'.$identity['tagline'].'</p>';
			
			echo '</div></div>';
			echo '<div class="clear"></div>';
			echo '<div class ="openid" class="section">';
			echo '<p style="float: left">This page acts as an OpenID endpoint. That means that if this is your profile, you can use this url to login to any website that supports OpenID!</p>';
			echo '</div>';
			echo '<div class="clear">&nbsp;</div>';
		echo '</div>';
		}
		?>

	<div class="clear"></div>
</div>
</div>
