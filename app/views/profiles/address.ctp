<div id="address_section" class="section">
<h4><a href="<?php echo PROFILE_ROOT; ?>/addresses/add" >Add an address</a></h4>
<br/>
<?php
foreach($addresses as $address)
{
	$type = array('Home', 'Work');
	echo '<div class="sub_section">';
	echo 'Type: '.$type[$address['type']].'<br/>';
	echo 'Address: '.$address['addressline1'].'<br/>';
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

	echo $html->link('Edit', '/addresses/edit/'.$address['id']);
	echo '&nbsp;';
	echo $html->link('Delete', "/addresses/delete/{$address['id']}",null,'Are you sure?');
	echo '</div>';
	echo '<br/>';
}
?>
</div>