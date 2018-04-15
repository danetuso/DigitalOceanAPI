<?php
include_once './includes.php';

class digitalocean
{
	/**
     * Creates the droplet array object and sends it via curl
     *
     * @param array $dropletData
     *
     * @return string $resp Droplet creation curl response
     */
	public function createDroplet($dropletData)
	{
		manage::printMessage(1, "Building request.");
		$ssh_keys = SSH_KEY_ID;
		$backups = false;
		$ipv6 = false;
		$user_data = null;
		$private_networking = null;
		$volumes = null;
		$tags = null;

		$data = array(
		        "name" => $dropletData[0],
		        "region" => $dropletData[2],
		        "size" => $dropletData[1],
		        "image" => $dropletData[3],
		        "ssh_keys" => $ssh_keys,
		        "backups" => $backups,
		        "ipv6" => $ipv6,
		        "user_data" => $user_data,
		        "private_networking" => $private_networking,
		        "volumes" => $volumes,
		        "tags" => $tags
		    );
		$data_string = json_encode($data);
		manage::printMessage(1, "Establishing Connection.");
		$curl = curl_init(API_URL);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . API_TOKEN,
			'Content-Length: ' . strlen($data_string)
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		manage::printMessage(1, "Request sent. Response Received.");
		return $resp;
	}

	/**
     * Lists current droplets attached to current API token
     *
     * @return array $resp Results of curl request
     */
	public static function listDroplets()
	{
		return json_decode(digitalocean::makeRequest('?page=1&per_page=50'), true);
	}

	/**
     * Gets the Droplet's IPv4 address via it's Droplet ID
     *
     * @param int $ID
     *
     * @return string $ret IPv4 Address
     */
	public static function getDropletIPByID($ID)
	{
		manage::printMessage(1, "Sleeping for 5 seconds to give the API a moment to catch up.");
		//Sleep required for creation process
		sleep(5);
		$ret = json_decode(digitalocean::makeRequest('/' . $ID), true);
		if(!empty($ret['droplet']))
		{
			manage::printMessage(0, "Successfully found Droplet.");
			return $ret['droplet']['networks']['v4'][0]['ip_address'];
		}
		else
		{
			manage::printMessage(3, "The Droplet for the ID provided can not be found.");
			return null;
		}
		
	}

	/**
     * Destroy's a droplet by it's ID
     *
     * @param int $dropletID
     *
     * @return array $ret curl response
     */
	public static function destroyDroplet($dropletID)
	{
		if(is_string($dropletID))
		{
			$dropletID = digitalocean::getDropletIDByName($dropletID);
			if(empty($dropletID))
			{
				manage::printMessage(3, "Droplet not found!");
				return null;
			}
		}
		manage::printMessage(1, "Establishing Connection.");
		$curl = curl_init(API_URL . '/' . $dropletID);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . API_TOKEN
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		//TODO Response error check
		manage::printMessage(0, "Droplet successfully destroyed!");
		return json_decode($resp, true);
	}

	/**
     * Gets the Droplet's ID based on it's name
     *
     * @param string $dName Droplet's hostname
     *
     * @return int Droplet ID
     */
	public static function getDropletIDByName($dName)
	{
		manage::printMessage(1, "Hitting API for all Droplets");
		$ret = json_decode(digitalocean::makeRequest(""), true);
		if(!empty($ret['droplets']))
		{
			foreach($ret['droplets'] as $idx)
			{
				if($idx['name'] == $dName)
				{
					manage::printMessage(0, "Found a matching Droplet by name.");
					return $idx['id'];
				}
			}
		}
		return null;
	}

	/**
     * Creates and sends the curl request (Will be switched to Guzzle soon)
     *
     * @param string $appUrl String to be appended to the API URL
     *
     * @return string $resp json_encoded curl response
     */
	public static function makeRequest($appUrl)
	{
		manage::printMessage(1, "Establishing Connection.");
		$curl = curl_init(API_URL . $appUrl);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . API_TOKEN
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		return $resp;
	}
}