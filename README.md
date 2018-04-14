# DigitalOceanAPI

A project for handling Digital Ocean droplets on the unix commandline. Using the create utility currently provisions the server with an OpenVPN server, and starts it up. It also pulls the client.ovpn configuration to the local machine.

In the future, this will be it's own consolidated utility, and versions for provisioning VPN and web servers will be forked. The post provisioning code can easily be removed from the droplet class.

https://www.digitalocean.com/help/api/

For setup,

You must generate a Digital Ocean API Token for your account, as well as add an SSH Key.
Add both of these to your CONFIG.php file.
Make sure you have the id_rsa private key file of the RSA SSH key you created in the root directory of this project or to change it's location in the config.

You can run `php -q vmManage.php --help` for help.

A typical creation command would look like:
`php -q vmManage.php --create TestHostname 512mb SFO1 ubuntu=16-04-x64`

The overall process will take between 1 and 5 minutes to spin up and provision the server properly.

To access the server, you can ssh with the key linked in the CONFIG.php file
