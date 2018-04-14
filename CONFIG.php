<?php
include_once './includes.php';
set_time_limit(0);
ini_set('max_execution_time', 0);
define('VALID_ARGUMENTS', 'help list create destroy ssh');
define('API_TOKEN', '');
define('SSH_KEY_ID', array(00000000));
define('API_URL', 'https://api.digitalocean.com/v2/droplets');
define('BOOT_TIME', 40);
define('KEY_PATH', './id_rsa');
//define('DROPLET_TYPE', 'VPN');
define('DROPLET_TYPE', 'WEB');
?>