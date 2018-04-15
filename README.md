# DigitalOceanAPI

A project for handling Digital Ocean droplets on the unix commandline. Using the create utility currently runs a shell command to provision an ansible hosts file. This can be easily removed from the droplet class.

For setup,

You must generate a Digital Ocean API Token for your account, as well as add an SSH Key.
Add both of these to your CONFIG.php file.
Make sure you have the id_rsa private key file of the RSA SSH key you created in the root directory of this project or to change it's location in the config.

A typical creation command would look like:
`php -q vmManage.php --create TestHostname s-1vcpu-1gb SFO1 ubuntu-16-04-x64`

The overall process will take between 1 and 5 minutes to spin up and provision the server properly.

To access the server, you can ssh with the key linked in the CONFIG.php file


Commands:

```php -q vmManage.php --help```

```php -q vmManage.php --list```

```php -q vmManage.php --destroy <dropletID/dropletName>```

```php -q vmManage.php --create <hostname> <size> <location> <image>```

https://www.digitalocean.com/help/api/

### List all Locations

`curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer b7d03a6947b217efb6f3ec3bd3504582" "https://api.digitalocean.com/v2/regions"`

```
"regions": [
        "nyc1",
        "ams1",
        "sfo1",
        "nyc2",
        "ams2",
        "sgp1",
        "lon1",
        "nyc3",
        "ams3",
        "fra1",
        "tor1"
      ]
```

### List all Sizes
`curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer b7d03a6947b217efb6f3ec3bd3504582" "https://api.digitalocean.com/v2/sizes"`

```
"sizes": [
        "s-1vcpu-1gb",
        "s-1vcpu-2gb",
        "s-1vcpu-3gb",
        "s-2vcpu-2gb",
        "s-3vcpu-1gb",
        "s-2vcpu-4gb",
        "s-4vcpu-8gb",
        "s-6vcpu-16gb",
        "s-8vcpu-32gb",
        "s-12vcpu-48gb",
        "s-16vcpu-64gb",
        "s-20vcpu-96gb",
        "s-24vcpu-128gb",
        "s-32vcpu-192gb"
      ]
```
