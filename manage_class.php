<?php
include_once './includes.php';

class manage
{
	/**
     * Runs regex on arguments
     *
     * @param array $argv
     *
     * @return $arguments
     */
	public function processArguments($argv)
	{
		$arguments = array();
		if (count($argv) == 0 || !isset($argv[1]))
			return $arguments; //empty or !set

		foreach ($argv as $idx => $arg)
			$arguments[$idx] = $arg;

		if ($arguments[1] == '--create' || $arguments[1] == '--destroy' || $arguments[1] == '--ssh')
			return $arguments;
		else
		{
			// if there is a --something, assign it to the array as the only item
			$arguments = array();
			if (preg_match('/--(\w+)/', $arg))
				$arguments[0] = $arg;
			return $arguments;
		}
	}

	/**
     * Prints out help message.
     */
	function printHelp()
	{
		$buf = "Usage: php -q vmManage.php --arguments\n";
		$buf .= "\n";
		$buf .= "--list 			List VMs\n";
		$buf .= "--create hostname size location image                Create X VMs, local hostname of box, region of droplet, image of droplet\n";
		$buf .= "--destroy ID 			Kill VM with ID\n";
		$buf .= "--ssh ID 			SSH into the VM Droplet with ID\n";
		$buf .= "--help 			Shows this dialogue\n";
		echo $buf;
	}
}

?>