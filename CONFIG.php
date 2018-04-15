<?php
include_once './includes.php';
set_time_limit(0);
ini_set('max_execution_time', 0);

define('DEBUG_MODE', TRUE);
define('VALID_ARGUMENTS', 'help list create destroy');
define('API_TOKEN', '');
define('SSH_KEY_ID', array());
define('API_URL', 'https://api.digitalocean.com/v2/droplets');
define('BOOT_TIME', 40);
define('KEY_PATH', './id_rsa');
define('ANSIBLE_DIR', './Ansible');
?>