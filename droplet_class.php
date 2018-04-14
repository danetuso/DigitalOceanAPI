<?php

include_once './includes.php';

class droplet
{
	public $digi;

	public function __construct()
	{
		$this->digi = new digitalocean();
	}

	/**
     * Builds droplet and instantiates API class (kinda)
     *
     * @param string $hostname
     * @param string $size Typically s-1vcpu-1gb
     * @param string $location Typically sfo1 or nyc1
     * @param string $image Typically ubuntu-16-04-x64
     *
     * @return Droplet creation curl response
     */
	public function buildDropletData($hostname, $size, $location, $image)
	{
		global $digi;
		$dropletData = array();
		$dropletData[0] = $hostname;
		$dropletData[1] = $size;
		$dropletData[2] = $location;
		$dropletData[3] = $image;

		return $this->digi->createDroplet($dropletData);
	}

	/**
     * Called after spinup, moves install file and runs it, pulls back config upon completion.
     *
     * @param string $IP
     *
     * @return Response of last scp transfer of .ovpn client file
     */
	public function provisionDroplet($IP)
	{
		global $digi;
		sleep(BOOT_TIME);
		if(DROPLET_TYPE == "WEB")
		{
			print_r(exec("scp -o StrictHostKeyChecking=no -i " . KEY_PATH . " mysql_secure.sh root@" . $IP . ":/root/"));
			print_r(exec("scp -o StrictHostKeyChecking=no -i " . KEY_PATH . " install_script.sh root@" . $IP . ":/root/"));
			print_r(exec("scp -o StrictHostKeyChecking=no -i " . KEY_PATH . " site.com root@" . $IP . ":/etc/nginx/sites-available/"));
			print_r(exec("scp -o StrictHostKeyChecking=no -i " . KEY_PATH . " composerinstall.sh root@" . $IP . ":/root/"));
			//expect command does not work over ssh, switching to ansible soon :D
			print_r(exec('ssh -o StrictHostKeyChecking=no -i ' . KEY_PATH . ' root@' . $IP . ' "bash /root/install_script.sh"'));
			return exec('ssh -o StrictHostKeyChecking=no -i ' . KEY_PATH . ' root@' . $IP . ' "rm -f /root/*.sh"');
		}
		else if(DROPLET_TYPE == "VPN")
		{
			exec("scp -o StrictHostKeyChecking=no -i " . KEY_PATH . " openvpn-install.sh root@" . $IP . ":/root/");
			exec('ssh -o StrictHostKeyChecking=no -i ' . KEY_PATH . ' root@' . $IP . ' "bash /root/openvpn-install.sh"');
			return exec("scp -o StrictHostKeyChecking=no -i " . KEY_PATH . " root@" . $IP . ":/root/testClient.ovpn .");
		}
		else
			return null;
	}
}