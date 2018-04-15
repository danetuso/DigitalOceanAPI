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
	public function validateArguments($argv)
	{
		$arguments = array();
		if (count($argv) == 0 || !isset($argv[1]))
			return $arguments; //empty or !set

		//TODO: 
		//Pull declared array of accepted arguments and foreach check against that
		//if false, set $arguments = array(); and return it
		foreach ($argv as $idx => $arg)
			$arguments[$idx] = $arg;

		if ($arguments[1] == '--create')
		{
			if(!empty($arguments[5]))
				return $arguments;
		}
		return $arguments;
	}

	/**
     * Prints out help message.
     */
	function printHelp()
	{
		$buf = "Usage: php -q vmManage.php --arguments\n";
		$buf .= "\n";
		$buf .= "--list 			                           List VMs\n";
		$buf .= "--create <hostname> <size> <location> <image>      Create a VM with hostname, size, region, and image of droplet\n";
		$buf .= "                                               Ex: php -q vmManage.php --create test s-1vcpu-1gb sfo1 ubuntu-16-04-x64\n";
		$buf .= "--destroy <ID/Hostname> 			   Kill VM with ID or Hostname\n";
		$buf .= "--help 			                           Shows this dialogue\n";
		$buf .= "\n";
		echo $buf;
	}

	/**
     * Displays message to the console (Only in DEBUG_MODE)
     *
     * @param int $level Level of Message authority
     * @param string $output String to be displayed
     *
     */
	function printMessage($level, $output)
	{
		if(DEBUG_MODE || $level == 3)
		{
			$buf = "";
			switch($level)
			{
				case 0:
					$buf .= "\033[1;32m[OKAY] \033[0m";
					break;
				case 1:
					$buf .= "\033[1;34m[INFO] \033[0m";
					break;
				case 2:
					$buf .= "\033[1;33m[WARN] \033[0m";
					break;
				case 3:
					$buf .= "\033[1;31m[CRIT] \033[0m";
					break;
			}
			$buf .= $output . "\n";
			echo $buf;
		}
	}
}
?>