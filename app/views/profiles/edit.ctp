<?php 
/*
 * Edit/Add page for when a specific profile
 * @author Michael Pontin
 */
?>
<h1>Manage a Profile</h1>

<?php
echo $form->create('Identity', array('action' => 'edit'));
echo $form->input('name', array( 'label' => 'Profile name') );
echo $form->input('first_name', array('label' => 'Firstname') );
echo $form->input('last_name', array('label' => 'Lastname') );
echo $datePicker->picker('dob' , array( 'label' => 'Date of Birth', 'minYear' => 1800, 'maxYear' => date('Y') ));
echo $form->end('Save');
?>