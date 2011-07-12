<div class="menu">
			<ul>				
				<?php if($this->Session->check('user')):?>	
					<?php 
					if($this->Session->check('ident')){
						echo "<li><a href='".PROFILE_ROOT."/profile/{$this->Session->read('ident')}' >Profiles</a></li>";
						
						}else{
							echo "<li><a href='".PROFILE_ROOT."/profile/{$this->Session->read('ident')}' >New Profile</a></li>";
							}
						
					?>
					<li><a href="<?php echo PROFILE_ROOT; ?>/account" >Account Settings</a></li>	
					<li><a href="<?php echo PROFILE_ROOT; ?>/logout" >Sign Out</a></li>
				<?php else:?>
					<li><a href="<?php echo PROFILE_ROOT; ?>/" >Home</a></li>
					<li><a href="<?php echo PROFILE_ROOT; ?>/register" >Register</a></li>
					<li><a href="<?php echo PROFILE_ROOT; ?>/login" >Log In</a></li>
				<?php endif;?>
			</ul>
</div>