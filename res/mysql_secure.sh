#!/bin/bash

apt-get update
apt-get install -y expect

INPUT=$(cat /root/.digitalocean_password)
SUBSTRING=$(echo $INPUT| cut -d'"' -f 2)
MYSQL_ROOT_PASSWORD=$SUBSTRING

SECURE_MYSQL=$(expect -c "
set timeout 10
spawn mysql_secure_installation
expect \"Enter current password for root:\"
send \"$MYSQL\r\"
expect \"Would you like to setup VALIDATE PASSWORD plugin?\"
send \"n\r\" 
expect \"Change the password for root ?\"
send \"n\r\"
expect \"Remove anonymous users?\"
send \"y\r\"
expect \"Disallow root login remotely?\"
send \"y\r\"
expect \"Remove test database and access to it?\"
send \"y\r\"
expect \"Reload privilege tables now?\"
send \"y\r\"
expect eof
")

echo "$SECURE_MYSQL"

apt-get remove expect --purge -y