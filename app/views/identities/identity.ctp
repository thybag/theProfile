<div id="profile_section" class="section">
<?php

	$identity['gender'] = strtolower($identity['gender']);
	if($identity['gender'] == 'male' OR $identity['gender'] =='female'){
		$identity['gender'] = '<img src="../img/icons/'.$identity['gender'].'.png" alt="'.$identity['gender'].'" title="'.$identity['gender'].'">';
	}else {
		$identity['gender'] ='';
	}
	
	$link = "/identities/edit/".$identity['id'];
	$edit = $html->link('Edit Profile', $link, array('escape' => false, "onClick" => "return showDialog('Edit {$identity['name']}' ,'".PROFILE_ROOT.$link."' ,'identity')"));
	$del = $html->link('Delete Profile', "/identities/delete/{$identity['id']}",array('escape' => false),'This will delete the profile called '.$identity['name'].'...');
	
	

				
	echo '<div class="sub_section">';

	
	echo "<h1> {$identity['first_name']} {$identity['last_name']}</h1>";
	if(strtotime($identity['dob']) > strtotime('1/12/1700')){
		echo 'Born: '.date('d M Y', strtotime($identity['dob'])).'<br/>';
	}
	echo 'Nickname: '.$identity['nickname'].'<br/>';
	
	if($identity['gender']!=''){
		echo 'Gender: '.$identity['gender'].'<br />';
	}
	
	
	echo "{$edit}";
	echo " | ";
	echo "{$del}";
	echo '</div>';

	
	
	
	echo '<br/>';
	
				
?>
</div>