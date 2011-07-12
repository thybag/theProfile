<div id="numbers_section" class="section">
	<h4>
		<a href="<?php echo PROFILE_ROOT; ?>/numbers/add" >Add a Telephone Number</a>
	</h4>
	<br/>
	<?php
		foreach($numbers as $number)
			{
				$type = array( 'Mobile', 'Home');
				echo '<div class="sub_section">';
				echo $type[$number['type']].' Number: '.$number['number'].'<br/>';
				echo $html->link('Edit', '/numbers/edit/'.$number['id']);
				echo '&nbsp;';
				echo $html->link('Delete', "/numbers/delete/{$number['id']}",null,'Are you sure?');
				echo '</div>';
				echo '<br/>';
			}
	?>
</div>