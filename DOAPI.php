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
		return $resp;
	}

	/**
     * Lists current droplets attached to current API token
     *
     * @return array $resp Results of curl request
     */
	public static function listDroplets()
	{
		$curl = curl_init(API_URL . '?page=1&per_page=50');
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . API_TOKEN
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp, true);
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
		//Sleep required for creation process
		sleep(5);
		$curl = curl_init(API_URL . '/' . $ID);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . API_TOKEN
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);

		$ret = json_decode($resp, true);
		return $ret['droplet']['networks']['v4'][0]['ip_address'];
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
		$curl = curl_init(API_URL . '/' . $dropletID);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . API_TOKEN
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp, true);
	}
}