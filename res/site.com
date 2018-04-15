server {
        listen 80;
        listen [::]:80;

        root /var/www/site/public_html;
        index index.html index.htm index.nginx-debian.html;

        server_name site.com www.site.com;

        location / {
                try_files $uri $uri/ =404;
        }
}