<div class='module fullwidth'>	
	<h4><img src="<?php echo PROFILE_ROOT ?>/img/icons/comment.png" alt="about" />&nbsp;About you:</h4>
	<div class='text'>
	
		<?php 
		if($identity['tagline'] != '' AND $identity['tagline'] != null){
			echo $identity['tagline'];
		}else{
		 	echo "Tell us a little something about yourself...";
		}
		 ?>
	

	<?php
		$link = "/identities/editTagline/";
		$edit = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/pencil.png" alt="Edit" title="Edit" style="float:right; margin: 4px;">', $link, array('escape' => false,"onClick" => "return showDialog('Edit Tagline','".PROFILE_ROOT.$link."' ,'about')"));
		
		echo "<span class='controls'>{$edit}</span>";
		
		
	?>
	
	
	<div class='clear'></div>
	</div>
</div>