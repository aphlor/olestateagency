#!/bin/sh

##
# vagrant "root" provision (install packages, configure, etc)
##

apt-get update

# grab pwgen first, quickly, so we can sort out mysql passwords
apt-get install -y pwgen
touch ~/.my.cnf
chmod 0600 ~/.my.cnf
mysql_root_pw="$(pwgen -s -c -n 32 1)"

cat <<-EOF >> ~/.my.cnf
[mysql]
user=root
password="${mysql_root_pw}"

[mysqladmin]
user=root
password="${mysql_root_pw}"
EOF

# preseed the mysql root password, assuming we're going to get mysql 5.7
cat <<-EOF | debconf-set-selections
mysql-server-5.7 mysql-server/root_password password ${mysql_root_pw}
mysql-server-5.7 mysql-server/root_password_again password ${mysql_root_pw}
EOF

# get some initial packages
apt-get install -y \
    avahi-daemon \
    ca-certificates \
    curl \
    figlet \
    git \
    mysql-server-5.7 \
    nginx-light \
    php-fpm \
    php-cli \
    php-curl \
    php-json \
    php-mbstring \
    php-mysql \
    php-opcache \
    php-phpdbg \
    php-xdebug \
    php-xml \
    vim-nox \
    zsh

# start setting up nginx to work with php
# deactivate the 'default' vhost
sed -i 's/^/#DISABLED BY VAGRANTFILE#/g' /etc/nginx/sites-available/default

# replace the default with our vagrant default
cp -v /vagrant/build/vagrant/nginx_vagrant /etc/nginx/sites-available/vagrant_default
ln -s /etc/nginx/sites-available/vagrant_default /etc/nginx/sites-enabled/vagrant_default

# restart nginx
systemctl restart nginx.service
