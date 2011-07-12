<div id="application_section" class="section">
<h4><img src="<?php echo PROFILE_ROOT; ?>/img/icons/link.png" alt="connected" />&nbsp; Connected Accounts</h4>
<div class='text'>
<?php

$types = array( 'Facebook', 'Google', 'Twitter', 'OpenID');
$attach = array('No', 'Yes');

foreach($apps as $app)
{
	if($app['account_identifier'] == ''){$app['account_identifier'] = 'unknown';}
	
	//'.PROFILE_ROOT.'/img/ajax-loader.gif
	$sync_f = "app_update('/sync/{$types[$app['name']]}/{$app['id']}', this);";
	$sync = '<img src="'.PROFILE_ROOT.'/img/icons/arrow_refresh_small.png" onclick="'.$sync_f.'"  title="Sync" style="cursor:pointer;">';
	
	$del = $html->link('<img src="'.PROFILE_ROOT.'/img/icons/cross.png" alt="Delete" title="Delete">', "/applications/delete/{$app['id']}",array('escape' => false),'About to delete your '.$types[$app['name']].' account from our records...');
	echo "<div class='sub_section'>
	
		<div class='application app_{$types[$app['name']]}'>
			<div class='app'>
				<span class='controls'>{$sync}&nbsp;{$del}</span>
				
				{$app['account_identifier']} ({$types[$app['name']]})
			</div>			
		</div>

	</div>";
	
}

?>
<a href="<?php echo PROFILE_ROOT; ?>/applications/add" >Connect another service</a> |
<a href="<?php echo PROFILE_ROOT; ?>/applications/clean" >Clear cache</a>
</div>
</div>

