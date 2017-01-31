#!/bin/sh

##
# vagrant "user" provision (set up interactive environment, application)
##

# make a convenient symlink
ln -s /vagrant ~/application

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

# environment setup is complete
figlet provision complete
cat <<-EOF
Please check the home directory of the '$USER' user for '.my.cnf' to
obtain the database password for desktop client software.

Your application is located in '~/application/'.
EOF
