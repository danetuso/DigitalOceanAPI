#!/bin/bash
apt-get update
bash /root/composerinstall.sh
#bash /root/mysql_secure.sh

rm -rf /var/www/html
mkdir -p /var/www/site/public_html
sudo chmod -R 755 /var/www
ln -s /etc/nginx/sites-available/site.com /etc/nginx/sites-enabled/
IP=$(curl ipinfo.io/ip)
sed "8a\server_name ${IP};" /etc/nginx/sites-available/site.com
systemctl restart nginx
touch /var/www/site/public_html/index.html
echo "hello world" >> /var/www/site/public_html/index.html

rm -rf /etc/update-motd.d/99-one-click
ufw disable
apt-get remove ufw --purge

#install yarn
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update && apt-get install -y yarn

#Install NodeJS
apt-get install -y nodejs npm
npm cache clean -f
npm install -g npm
n stable

iptables --flush
iptables -A INPUT -p tcp --dport 22 -j ACCEPT
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 443 -j ACCEPT
iptables -A INPUT -j DROP
iptables-save > /root/iptables.conf
sed '$iiptables-restore /root/iptables.conf' /etc/rc.local