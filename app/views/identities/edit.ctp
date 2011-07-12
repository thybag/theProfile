<?php 
/*
 * Edit/Add page for when a specific profile
 * @author Michael Pontin, Carl Saggs & David Couch
 */
?>

<style>
.tundra .dijitTooltipAbove .dijitTooltipConnector {
}
</style>

<div class="content">
	<div class="mainContent">
		<h1>Update Identity Details</h1>

		<?php
			//Get dojo valid method
			if($isAjax){
				$djvalid = 'dialogSave(this);'; 
			}
			else{
				$djvalid = 'this.validate();'; 
			}
			
			echo $form->create('Identity', array('action' => 'edit', 'dojoType' => 'dijit.form.Form', 'onSubmit' => 'return '.$djvalid));
			
			echo $form->input('name', array('label' => 'Profile name: ',
											'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
												onmouseover="toolTipr(this);" 
												alt="Please give this identity a nickname so you can keep track of it"
											>',
											'dojoType' => 'dijit.form.ValidationTextBox',
											'required' => 'true',
											'maxlength' => '14'
			));
								
			
			echo $form->input('nickname', array('label' => 'Nickname: ',			
														'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
															 onmouseover="toolTipr(this);"
															 alt="Set the alias, handle or nickname you want to use for this identity"
															 >',
														'dojoType' => 'dijit.form.ValidationTextBox',
														'required' => 'false',
														'maxlength' => '30'
			));
			
			$titles = array( 'Mr' => 'Mr', 'Mrs' => 'Mrs', 'Ms' => 'Ms', 'Miss' => 'Miss', 'Dr.' => 'Dr.', 'Prof.' => 'Prof.', 'Sir' => 'Sir',  'Dame' => 'Dame', 'Rev.' => 'Rev.', 'Lord' => 'Lord',  'Count' => 'Count', 'Duke' => 'Duke', 'Baron' => 'Baron');
			
			echo $form->input('title', array('label'  => 'Title: ',
											 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
														onmouseover="toolTipr(this);"
														alt="Select a title"
											 >',
											 'type' => 'select', 
											 'options' => $titles, 
											 'dojoType' => 'dijit.form.FilteringSelect',
											 'required' => 'false'
											 
			));
												
			echo $form->input('first_name', array('label'  => 'First Name: ',
											 	'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
														onmouseover="toolTipr(this);"
														alt="What is your first name?"
											 	>',
												'dojoType' => 'dijit.form.ValidationTextBox',
												'required' => 'true',
												'maxlength' => '18'
			) );
												
			echo $form->input('last_name', array('label'  => 'Lastname: ',
											 	'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
														onmouseover="toolTipr(this);"
														alt="What is your last name?"
											 	>',
												'dojoType' => 'dijit.form.ValidationTextBox',
												'required' => 'true',
												'maxlength' => '18'
			));
											
			echo $form->input('dob', array('type' => 'text', 
											'label'  => 'Date of Birth: ',
										 	'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
													onmouseover="toolTipr(this);"
													alt="Care to share your birthday?"
										 	>',
											'dojoType' => 'dijit.form.DateTextBox',
											'required' => 'true'	
			));
			
			$gender = array( 'Undisclosed' => 'Undisclosed', 'Male' => 'Male', 'Female' => 'Female' );
			
			echo $form->input('gender', array(	'label'  => 'Gender: ',
										 		'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"
													onmouseover="toolTipr(this);"
													alt="What is your gender?"
										 		>',
										 		'type' => 'select', 
												'options' => $gender, 
												'dojoType' => 'dijit.form.FilteringSelect',
												'required' => 'false' ) );
			
			echo ' <div class="submit"><button dojoType="dijit.form.Button" type="submit" value="Save Changes">Save Changes</button></div></form>';

		?>
	</div>
</div>