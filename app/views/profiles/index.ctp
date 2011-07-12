<?php 
/*
 * Index page for when a specific identity
 * @author Michael Pontin
 * @created Nov 25 2010
 */
$identity;
$identities = $user['Identity'];
?>
<div id="identity_page" >
<ul>
<?php
	foreach($identities as $ident )
	{
		if($this->Session->read('ident') == $ident['id'])
		{
			echo '<li class="current" >'.$html->link($ident['name'], '/identities/index/'.$ident['id']).'</li>';
		}
		else
		{
			echo '<li>'.$html->link($ident['name'], '/identities/index/'.$ident['id']).'</li>';
		}
	}	
?>
	<li><a href="<?php echo PROFILE_ROOT; ?>/users/index" >Create New</a></li>
</ul>
<div class="identity_content" >
	<?php include 'image.ctp' ;?>
	<?php include 'identity.ctp' ;?>
	<?php include 'address.ctp' ;?>
	<?php include 'numbers.ctp' ;?>
	<?php include 'email.ctp' ;?>
	<?php include 'application.ctp' ;?>
	<div class="clear" ></div>
</div>
</div>