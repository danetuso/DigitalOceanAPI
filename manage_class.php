<?php
$root = dirname( __FILE__ );
include_once $root . '/includes.php';

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

		foreach ($argv as $idx => $arg)
			$arguments[$idx] = $arg;

		$size = false;
		$region = false;
		$valid = false;
		if ($arguments[1] == '--create')
		{
			//size
			foreach (SIZES as $s)
			{
				if($arguments[3] == $s)
					$size = true;
			}
			//region
			foreach (REGIONS as $r)
			{
				if($arguments[4] == $r)
					$region = true;
			}
			if(!$region)
			{
				manage::printMessage(3, "Syntax Error, please provide a proper droplet region. See https://github.com/danetuso/DigitalOceanAPI for a list.");
				exit;
			}
			if(!$size)
			{
				manage::printMessage(3, "Syntax Error, please provide a proper droplet size. See https://github.com/danetuso/DigitalOceanAPI for a list.");
				exit;
			}
			return $arguments;
		}
		else
		{
			foreach (VALID_ARGUMENTS as $v)
			{
				if($arguments[1] == "--" . $v)
				{
					$valid = true;
					return $arguments;
				}
			}
			if(!$valid)
				return null;
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
			if(JSON_OUTPUT && $level == 3)
			{
				$out = array("error" => $output);

				echo json_encode($out);
			}
			else
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
}
?>