<?php
include_once './includes.php';

main($argv);

function main($argv)
{
	$arguments = manage::validateArguments($argv);
	//Assumed correct syntax
	if(!empty($arguments[1]))
    {
		$dr = new droplet();
	    if($arguments[1] == '--create')
	    {
	    	$resp = json_decode(
	    		$dr->buildDropletData($arguments[2], $arguments[3], $arguments[4], $arguments[5]),
	    		true
	    	);
	    	if(!empty($resp['droplet']))
	    	{
	    		manage::printMessage(0, "Droplet created successfully.");
	    		$newIP = digitalocean::getDropletIPByID($resp['droplet']['id']);
	    		if(!empty($newIP))
	    		{
	    			$dr->provisionDroplet($newIP);
	    			manage::printMessage(0, "IP successfully injected into Ansible hosts file.");
	    		}
	    	}
	    	else
	    		manage::printMessage(3, "Droplet failed to create! Please check your arguments and config.");
    	}
    	else if($arguments[1] == '--destroy')
    		digitalocean::destroyDroplet($arguments[2]);
    	else if($arguments[1] == '--list')
    	{
    		$droplets = digitalocean::listDroplets();
			if(!empty($droplets['droplets']))
			{
				echo "\033[1;32m      DROPLETS\033[0m\n";
				echo "     ==========\n";
				foreach($droplets['droplets'] as $idx)
				{
					$buf = "\033[1;34mNAME: \033[0m" . $idx['name'] . "\n";
					$buf .= "\033[1;34mID:   \033[0m" . $idx['id'] . "\n";
					$buf .= "\033[1;34mIP:   \033[0m" . $idx['networks']['v4'][0]['ip_address'] . "\n\n";
					echo $buf;
				}
			}
			else
				manage::printMessage(3, "The Droplets could not be received. Please check your config.");
    	}
    	else
    		manage::printHelp();
    }
    else
		manage::printHelp();
}
?>