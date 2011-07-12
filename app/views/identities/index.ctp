<?php 
/*
 * Index page for when a specific identity
 * @author Michael Pontin, Carl Saggs & David Couch
 * @created Nov 25 2010
 */
$identity;
$identities = $user['Identity'];
?>
<div class="content">
	<ul class="secondLevelTabs">
	<?php
		foreach($identities as $ident )
		{
			if($this->Session->read('ident') == $ident['id'])
			{
				echo '<li class="current" >'.$html->link($ident['name'], '/profile/'.$ident['id']).'</li>';
			}
			else
			{
				echo '<li>'.$html->link($ident['name'], '/profile/'.$ident['id']).'</li>';
			}
		}	
	?>
		<li class="new"><a href="<?php echo PROFILE_ROOT; ?>/create" ><img src="<?php echo PROFILE_ROOT; ?>/img/add.png" alt="+"></img></a></li>
	</ul>
<div class="mainContent">
	<div class="userDetails">
		<?php include 'image.ctp' ;?>
		<div id='z_identity'><?php include 'identity.ctp' ;?></div>
		<div class="module topmod"><?php include 'openid.ctp' ;?></div>
	</div>
	
	<div id='z_about'><?php include 'about.ctp' ;?></div>
	
	<div class="column">
		<div class="module" id='z_address'><?php include 'address.ctp' ;?></div>
		<div class="module" id='z_email'><?php include 'email.ctp' ;?></div>
	</div>
	<div class="column">
		<div class="module" id='z_numbers'><?php include 'numbers.ctp' ;?></div>
		<div class="module" id='z_applications'><?php include 'application.ctp' ;?></div>
	</div>
	<div class="clear"></div>
</div>
</div>