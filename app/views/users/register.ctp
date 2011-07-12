<?php 
/*
 * Registration page for new users
 * @author Michael Pontin, David Couch & Carl Saggs
 * @created Nov 9 2010
 */

?>
<div class="content">
	<div class="mainContent">
<h1>Register a user account</h1>

<?php
echo $form->create('User', array('id' => 'registerForm', 'action' => 'register', 'dojoType' => 'dijit.form.Form', 'onSubmit' => 'return this.validate()'));

echo $form->input('username', array('id' => 'RegUsername', 'after' => '<span id="username_ajax_result" ></span><img src="'.PROFILE_ROOT .'/img/icons/help.png"onmouseover="toolTipr(this);" alt="You will use this username to log in!"
>', 'onkeypress'=>'ajaxcheck();', 'dojoType' => 'dijit.form.ValidationTextBox', 'limit'=> '60', 'required' => 'true'));

echo $form->input('password', array('id'=> 'upass', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"onmouseover="toolTipr(this);" alt="You will use this password to log in!"
>',  'dojoType' => 'dijit.form.ValidationTextBox', 'required' => 'true', 'regExp' => '[a-zA-Z0-9$%!_]{8,24}', 'invalidMessage' => 'Passwords must be a minimum of 8 characters'));

echo $form->input('password_confirm', array('id' => 'pw_two','type' => 'password', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"onmouseover="toolTipr(this);" alt="Please enter your password again to confirm"
>', 'dojoType' => 'dijit.form.ValidationTextBox', 'required' => 'true'));

echo $form->input('email', array('label' => 'E-mail', 'after' => '<img src="'.PROFILE_ROOT .'/img/icons/help.png"onmouseover="toolTipr(this);" alt="We need an email to check your exist. Do not worry, it will not be visible on your profile"
>', 'dojoType' => 'dijit.form.ValidationTextBox', 'regExpGen' => 'dojox.validate.regexp.emailAddress','required' => 'true'));

echo '<br />By registering on this site, you accept our terms and conditions laid out <a href="'.PROFILE_ROOT.'/legal" target="_blank">here</a>.';

echo $form->end('Register');

?>

<script type="text/javascript" >
var searchTimeout;
var validname = true;

dojo.addOnLoad( function (){
	dijit.byId("RegUsername").validator = function (value, constraints) {
		
		var regex = /^[a-zA-Z0-9_-]*$/; 

		cval = dijit.byId("RegUsername").attr('value');
		//Ensure correct chars are used
		if(!cval.match(regex)){
			dijit.byId("RegUsername").attr("invalidMessage","Please ensure your usename only uses alphanumeric characters");
			return false;
		}
		// Ensure is long enough
		else if(cval.length < 3){
			dijit.byId("RegUsername").attr("invalidMessage","Username is too short.");
			return false;
		//Check is unused	
		}else{
	        return validname;
		}
	}
	dijit.byId("pw_two").validator = function (value, constraints) {
			dijit.byId("pw_two").attr("invalidMessage","This password does not match your first");
			return (dijit.byId("upass").attr('value') == value);
	}
});
function ajaxcheck(){

	if(dijit.byId('RegUsername').attr('value').length < 2){ return;}
	
	dojo.byId("username_ajax_result").innerHTML = '<img src="<?php echo PROFILE_ROOT; ?>/img/ajax-loader.gif" alt="Loading" />';
	if(!validname){
		validname = true;
		dijit.byId('RegUsername').validate();
	}
	
	if (searchTimeout) {
	    clearTimeout(searchTimeout);
  	}
	searchTimeout = setTimeout(function(){
		dojo.xhrPost({
			url: '<?php echo PROFILE_ROOT; ?>/ajax_check',
			load: function display(data) {  
				if (data == 1) {
					validname = true;
				}else{
					dijit.byId("RegUsername").attr("invalidMessage","Username is already in use");
					validname = false;
					setTimeout(function(){
						dijit.byId('RegUsername').validate();
						dijit.byId('RegUsername').displayMessage("Username is already in use");
					},100);
				}
				dojo.byId("username_ajax_result").innerHTML = '';
			},
			content: {
				username : dijit.byId('RegUsername').attr('value')
			}
		});
	},500);				
}
</script>

</div></div>