<div id="numbers_section" class="section">
<h4><img src="<?php echo PROFILE_ROOT; ?>/img/icons/phone.png" alt="phone" />&nbsp; Contact Numbers</h4>
<div class='text'>
<style>


</style>
<?php

$type = array( 'Mobile', 'Home', 'Work');

foreach($numbers as $number)
{
	$link = '/numbers/edit/'.$number['id'];
	$edit = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/pencil.png" alt="Edit" title="Edit">', $link, array('escape' => false, "onClick" => "return showDialog('Edit number','".PROFILE_ROOT.$link."' ,'numbers')"));
	$del = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/cross.png" alt="Delete" title="Delete">', "/numbers/delete/{$number['id']}",array('escape' => false),'About to delete the number '.$number['number'].' from our records...');
	
	echo "<div class='sub_section'>
	
		<div class='number n_{$type[$number['type']]}'>
			<div class='tel'>
			{$number['number']}
				
			<span class='controls'>{$edit}&nbsp;{$del}</span>
				
			</div>
			
			{$type[$number['type']]}
			
			
		</div>

	</div>";
}
	$link = "/numbers/add/";
	echo $html->link('Add New', $link, array("onClick" => "return showDialog('Add Number','".PROFILE_ROOT.$link."' ,'numbers')"));
?>

</div>
</div>