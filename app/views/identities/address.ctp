<div id="address_section" class="section">
<h4><img src="<?php echo PROFILE_ROOT; ?>/img/icons/house.png" alt="address" />&nbsp; Address</h4>
<div class='text'>


<?php

$type = array('Home', 'Work');


foreach($addresses as $address)
{
	$link = '/addresses/edit/'.$address['id'];
	$edit = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/pencil.png" alt="Edit" title="Edit">', $link, array('escape' => false, "onClick" => "return showDialog('Edit Address','".PROFILE_ROOT.$link."' ,'address')"));
	$del = 	$html->link('<img src="'.PROFILE_ROOT.'/img/icons/cross.png" alt="Delete" title="Delete">', "/addresses/delete/{$address['id']}",array('escape' => false),'About to delete the address '.$address['addressline1'].' from our records...');
	
	if($address['addressline1'] != null){ $address['addressline1'] 	= $address['addressline1'].',<br/>'; }
	if($address['addressline2'] != null){ $address['addressline2'] 	= $address['addressline2'].',<br/>'; }
	if($address['town'] 		!= null){ $address['town'] 			= $address['town'].',<br/>'; }
	if($address['county'] 		!= null){ $address['county'] 		= $address['county'].',<br/>'; }
	if($address['country'] 		!= null){ $address['country']		= $address['country'].'<br/>'; }
	if($address['postcode'] 	!= null){ $address['postcode'] 		= $address['postcode'].',<br/>'; }
	
	echo "<div class='sub_section'>
	
		<div class='address ad_{$type[$address['type']]}'>
			<div class='addr'>
				
				<div class='type'>
					{$type[$address['type']]} address
					<span class='controls'>{$edit}&nbsp;{$del}</span>
				</div>
				<div>
					{$address['addressline1']}
					{$address['addressline2']}
					{$address['town']}
					{$address['county']}
					{$address['postcode']}
					{$address['country']}
					
				</div>
					
			</div>	
		</div>

	</div>";
			
		/*	
	echo '<div class="sub_section">';
	echo 'Type: '.$type[$address['type']].'<br/>';
	echo 'Address Line 1: '.$address['addressline1'].'<br/>';
	if($address['addressline2'] != null)
	{
		echo 'Address Line 2: '.$address['addressline2'].'<br/>';
	}
	echo 'Town: '.$address['town'].'<br/>';
	if($address['county'] != null)
	{
		echo 'County: '.$address['county'].'<br/>';
	}
	echo 'Country: '.$address['country'].'<br/>';
	echo 'Postcode: '.$address['postcode'].'<br/>';

	$link = '/addresses/edit/'.$address['id'];
	echo $html->link('Edit', $link, array("onClick" => "return showDialog('Edit Address','".PROFILE_ROOT.$link."' ,'address')"));
	
	echo '&nbsp;';
	echo $html->link('Delete', "/addresses/delete/{$address['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
	*/
}

$link = "/addresses/add/";
echo $html->link('Add New', $link, array("onClick" => "return showDialog('Add Address','".PROFILE_ROOT.$link."' ,'address')"));
	

?>
</div>
</div>