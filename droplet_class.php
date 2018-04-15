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
		manage::printMessage(0, "Building Droplet Data");
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
		manage::printMessage(1, "Waiting for Droplet to spin up. (" . BOOT_TIME . " seconds)");
		sleep(BOOT_TIME);
		return exec('echo "' . $IP . '" >> '. ANSIBLE_DIR .'/hosts');
	}
}