
#!/usr/bin/env bash

# Environement Setup for Vagrant box ubuntu/trusty64

PASSWORD='12345678'
echo "------Production Environment Bash Script v0.1"

Update () {
    echo ""
    echo "-- Update packages --"
    echo ""
    apt-get -y update
    apt-get -y upgrade
    dpkg --configure -a
}
Update


echo "------PHP 7.0 Installation"

apt-get install -y git acl zip pkg-config build-essential
apt-get install -y php7.0 libapache2-mod-php7.0 php7.0-cli php7.0-common php7.0-mbstring php7.0-gd php7.0-intl php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-zip php-pear php-curl


echo "------Mysql 5.7 Installation "

debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
apt-get install -y mysql-server

echo "------equivalent of mysql_secure_installation in mysql command line"

mysql -u root --password='12345678' <<-EOF
UPDATE mysql.user SET authentication_string=PASSWORD('mysqlrootuserpassword') WHERE User='root';
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('127.0.0.1','localhost','::1');
DELETE FROM mysql.user WHERE User='';
DELETE FROM mysql.db WHERE Db='test' OR Db='test\_%';
FLUSH PRIVILEGES;

CREATE DATABASE community;
CREATE USER 'communityuser'@'%' IDENTIFIED BY 'communityuserpassword';
GRANT ALL PRIVILEGES ON community.* TO 'communityuser'@'%';
FLUSH PRIVILEGES;
EOF


sed '/\[mysqld\]/a \
collation-server = utf8mb4_general_ci\
character-set-server = utf8mb4\
' -i /etc/mysql/my.cnf
# sql_mode= STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
# in /etc/mysql/mysql.conf.d/mysqld.cnf
service mysql restart


echo "------Composer Installation"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


echo "------Setting date.timezone in php.ini of CLI and Apache2 SAPIs"
sed -i 's/;date.timezone =/date.timezone = "Europe\/Paris"/g' /etc/php/7.0/apache2/php.ini
sed -i 's/;date.timezone =/date.timezone = "Europe\/Paris"/g' /etc/php/7.0/cli/php.ini

export SYMFONY_ENV=prod
set | grep SYMFONY_ENV


echo "------ Configure Apache2 Sites-Available"

cp /vagrant/.provision/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf
chmod 644 /etc/apache2/sites-available/000-default.conf
ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf
ln -s /vagrant /var/www
a2enmod rewrite
service apache2 restart


echo "------- PHPMYADMIN installation"
apt-get install -y debconf-utils
export DEBIAN_FRONTEND=noninteractive

echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2" | debconf-set-selections
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-user string root" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password mysqlrootuserpassword" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password phpmyadminpass" |debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password phpmyadminpass" | debconf-set-selections

apt-get install -y phpmyadmin

mysql -u root --password="mysqlrootuserpassword" <<-EOF
GRANT ALL PRIVILEGES ON community.* TO 'phpmyadmin'@'localhost';
FLUSH PRIVILEGES;
EOF

echo "------- ElasticSearch 6.2.3"

add-apt-repository -y ppa:webupd8team/java
apt-get update
echo debconf shared/accepted-oracle-license-v1-1 select true | sudo debconf-set-selections
debconf shared/accepted-oracle-license-v1-1 seen true | sudo debconf-set-selections
apt-get -y install oracle-java8-installer

wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-6.2.3.deb
dpkg -i elasticsearch-6.2.3.deb

update-rc.d elasticsearch defaults 95 10
/etc/init.d/elasticsearch start


echo "------- NodeJS NPM Gulp"

apt-get install -y  nodejs npm
ln -s /usr/bin/nodejs /usr/bin/node

cd /vagrant

npm install gulp 
npm install gulp-cli
npm install gulp-if
npm install gulp-uglify
npm install gulp-cssmin
npm install gulp-concat
npm install gulp-sass
npm install browser-sync



