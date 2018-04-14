<?php
include_once './includes.php';

main($argv);

function main($argv)
{
	$arguments = manage::processArguments($argv);
	//Incorrect Syntax
	if(empty($arguments)){
		manage::printHelp();
		exit;
	}
	//Assumed correct syntax
	if(isset($arguments[1]))
    {
		$dr = new droplet();
	    if($arguments[1] == '--create')
	    {
	    	$resp = json_decode(
	    		$dr->buildDropletData($arguments[2], $arguments[3], $arguments[4], $arguments[5]),
	    		true
	    	);
	    	$newIP = digitalocean::getDropletIPByID($resp['droplet']['id']);

	    	//Prints output of provisioning
	    	print_r($dr->provisionDroplet($newIP));
    	}
    	else if($arguments[1] == '--destroy')
    	{
    		// TODO:
    		// add an "are you sure?" flag (quickdelete config addition as well)
    		print_r(digitalocean::destroyDroplet($arguments[2]));
    	}
    	else if($arguments[1] == '--ssh')
    	{
    		$droplets = digitalocean::listDroplets();
    		$ip = '';
			foreach($droplets['droplets'] as $idx){
				if($arguments[2] == $idx['name'] || $arguments[2] == $idx['id']){
					$ip = $idx['networks']['v4'][0]['ip_address'];
				}
			}
			if(empty($ip))
			{
				//Display SSH help, list droplets
				echo "Usage: php vmManage.php --ssh <name/id> \n\n";
				echo "Droplets: \n";
				foreach($droplets['droplets'] as $idx){
						$buf = "name: " . $idx['name'] . "\n";
						$buf .= "ID: " . $idx['id'] . "\n";
						$buf .= "ip: " . $idx['networks']['v4'][0]['ip_address'] . "\n\n";
						echo $buf;
				}
			}
			else
			{
				shell_exec('ssh root@' . $ip . ' -o StrictHostKeyChecking=no -i ./id_rsa');
			}
    	}
    	else
    	{
    		manage::printHelp();
			exit;
    	}
    }
    else
    {
    	//Was added to first slot in array during argument processing for future additions
		if($arguments[0] == '--list'){
			$droplets = digitalocean::listDroplets();

			echo "Droplets: \n";
			foreach($droplets['droplets'] as $idx){
					$buf = "name: " . $idx['name'] . "\n";
					$buf .= "ID: " . $idx['id'] . "\n";
					$buf .= "ip: " . $idx['networks']['v4'][0]['ip_address'] . "\n\n";
					echo $buf;
			}
    	}
    	else if($arguments[0] == '--help')
    	{
    		manage::printHelp();
			exit;
    	}
    	else
    	{
    		//Other
			manage::printHelp();
			exit;
		}
	}
}

?>