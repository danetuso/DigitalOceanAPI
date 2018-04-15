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
}