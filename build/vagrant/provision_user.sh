#!/bin/sh

##
# vagrant "user" provision (set up interactive environment, application)
##

# make a convenient symlink
[ -h ~/application ] || ln -s /vagrant ~/application

# grab the skeleton
[ -d ~/setup_files ] && rm -rf ~/setup_files
mkdir ~/setup_files
git clone https://github.com/aphlor/skellington.git ~/setup_files/skellington

# setup the shell with zsh and our desired setup
[ -d ~/.antigen ] && rm -rf ~/.antigen
mkdir ~/.antigen
git clone https://github.com/zsh-users/antigen.git ~/.antigen/antigen
cp -v ~/setup_files/skellington/zsh/.zshrc ~/setup_files/skellington/zsh/.zprofile ~/
sudo chsh -s /bin/zsh $USER

# setup vim
[ -d ~/.vim ] && rm -rf ~/.vim
mkdir -p ~/.vim/{bundle,doc}
git clone https://github.com/VundleVim/Vundle.vim.git ~/.vim/bundle/Vundle.vim
cp -v ~/setup_files/skellington/vim/.vimrc ~/
vim -c "PluginInstall" -c "quitall" 2>&1 > /dev/null

# composer for php
[ -d ~/bin ] || mkdir ~/bin
curl -so ~/bin/composer.phar https://getcomposer.org/composer.phar
chmod 755 ~/bin/composer.phar
ln -s ~/bin/composer.phar ~/bin/composer

# steal root's my.cnf created earlier during provision
sudo cp -v ~root/.my.cnf "$HOME/.my.cnf"
sudo chown $USER: ~/.my.cnf

# create two database accounts, and grant rights
_web_password="$(pwgen -s -c -n 32 1)"
_dba_password="$(pwgen -s -c -n 32 1)"

cat <<-EOF | mysql
CREATE DATABASE olestateagency;
CREATE USER web_user@'%' IDENTIFIED BY '${_web_password}';
CREATE USER dba_user@'%' IDENTIFIED BY '${_dba_password}';
GRANT SELECT, INSERT, UPDATE, DELETE ON olestateagency.* TO web_user@'%';
GRANT ALL PRIVILEGES ON olestateagency.* TO dba_user@'%';
FLUSH PRIVILEGES
EOF

# generate a crypto secure random string for the APP_KEY value
_crypto_key="base64:$(php -r 'print base64_encode(random_bytes(32));')"

# generate the $ROOT/.env file from build/env.build
sed "s#\#\#APP_KEY\#\##${_crypto_key}#g;
     s/##APP_URL##/http:\/\/localhost/g;
     s/##DB_WEB_HOST##/127.0.0.1/g;
     s/##DB_WEB_DATABASE##/olestateagency/g;
     s/##DB_WEB_USERNAME##/web_user/g;
     s/##DB_WEB_PASSWORD##/${_web_password}/g;
     s/##DB_DBA_HOST##/127.0.0.1/g;
     s/##DB_DBA_DATABASE##/olestateagency/g;
     s/##DB_DBA_USERNAME##/dba_user/g;
     s/##DB_DBA_PASSWORD##/${_dba_password}/g" \
    < /vagrant/build/env.build > /vagrant/.env

# environment setup is complete
figlet provision complete
cat <<-EOF
Please check the home directory of the '$USER' user for '.my.cnf' to
obtain the database password for desktop client software.

Your application is located in '~/application/'.
EOF
