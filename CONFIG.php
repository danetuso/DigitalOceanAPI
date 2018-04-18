<?php
$root = dirname( __FILE__ );
include_once $root . '/includes.php';

#Allows script to run for as long as needed
set_time_limit(0);
ini_set('max_execution_time', 0);

#Toggle to show debug output log
define('DEBUG_MODE', TRUE);

#Toggle json format outputs, friendly for other things reading from stdout
#DEBUG MODE MUST BE SET TO FALSE
define('JSON_OUTPUT', FALSE);

#Toggle optional provisioning function to run after droplet is spun up
define('PROVISION', FALSE);

#Digital Ocean API URL
define('API_URL', 'https://api.digitalocean.com/v2/droplets');

#Usually around 30 seconds, amount of time before running any provisioning
define('BOOT_TIME', 40);

#Used for quickly validating syntax locally
define('VALID_ARGUMENTS', array('help','list','create','destroy'));
define('REGIONS', array("nyc1","ams1","sfo1","nyc2","ams2","sgp1","lon1","nyc3","ams3","fra1","tor1"));
define('SIZES', array("s-1vcpu-1gb","s-1vcpu-2gb","s-1vcpu-3gb","s-2vcpu-2gb","s-3vcpu-1gb","s-2vcpu-4gb","s-4vcpu-8gb","s-6vcpu-16gb","s-8vcpu-32gb","s-12vcpu-48gb","s-16vcpu-64gb","s-20vcpu-96gb","s-24vcpu-128gb","s-32vcpu-192gb"));

//CHANGE THESE
define('API_TOKEN', '');
define('SSH_KEY_ID', array());
define('KEY_PATH', $root . '/res/id_rsa');
define('ANSIBLE_DIR', $root . '/Ansible');
?>