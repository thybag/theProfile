<?php
/*
 * Developers Page
 * @author David Couch
 * 15 Feb 2011
 */
 ?>
<div class="content">
	<div class="mainContent">
			<h2>Developers</h2>
			<p>TheProfile.co.uk loves developers!</p>
			<p>We provide an API that will allow you to access and use our profile data on your site.</p>
			<p>To access a user's data, please use the address http://www.theprofile.co.uk/api/ followed by the username you want to access with the extension of either xml or json.</p>
			
			
			<?php
				if($this->Session->check("user")){
					echo 'For example...';
					echo '<ul>';
					echo '<li>to get an XML file of your account data you would use: http://theprofile.co.uk/api/'.$this->Session->read("user").'.xml</li>';
					echo '<li>to get a JSON file of your account data you would use: http://theprofile.co.uk/api/'.$this->Session->read("user").'.json</li>';
					echo '</ul>';
				}
				else{
					echo 'For example...';
					
					echo '<ul>';
					echo '<li>to get an XML file for an account called test you would use: http://theprofile.co.uk/api/test.xml</li>';
					echo '<li>to get a JSON file ofor an account called test you would use: http://theprofile.co.uk/api/test.json</li>';
					echo '</ul>';
				}

			?>
<div class="codeOutput">
<h3>Example of expected XML output</h3>			
<pre>
	&lt;<span class="tag">user</span>&gt;
		&lt;<span class="tag">nickName</span>&gt;TestO&lt;/<span class="tag">nickName</span>&gt;
		&lt;<span class="tag">title</span>&gt;Mr&lt;/<span class="tag">title</span>&gt;
		&lt;<span class="tag">firstname</span>&gt;Joe&lt;/<span class="tag">firstname</span>&gt;
		&lt;<span class="tag">lastname</span>&gt;Bloggs&lt;/<span class="tag">lastname</span>&gt;
		&lt;<span class="tag">dateOfBirth</span>&gt;1960-01-01&lt;/<span class="tag">dateOfBirth</span>&gt;
		&lt;<span class="tag">gender</span>&gt;Male&lt;/<span class="tag">gender</span>&gt;
		&lt;<span class="tag">email</span>&gt;test@theprofile.co.uk&lt;/<span class="tag">email</span>&gt;
		&lt;<span class="tag">imageURL</span>&gt;http://theprofile.co.uk/img/blank.gif&lt;/<span class="tag">imageURL</span>&gt;
	&lt;/<span class="tag">user</span>&gt;
</pre>
</div>
<div class="codeOutput">
<h3>Example of expected JSON output</h3>			
<pre>
	{"user": {	
		"nickName": "Testo", 
		"title": "Mr", 
		"firstname": "Joe", 
		"lastname": "Bloggs", 
		"dateOfBirth": "1960-01-01", 
		"gender": "Male", 
		"email": "test@theprofile.co.uk", 
		"imageURL": "http://theprofile.co.uk/img/blank.gif", 
		"datasource": "theprofile.co.uk"
		}
	}			
</pre>
</div>
			<div class="clear">&nbsp;</div>
		</div>
</div>