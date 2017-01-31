# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/xenial64"

  # Check that the VirtualBox guest additions match the host software
  config.vbguest.auto_update = true

  # Set the hostname so we can identify the box from the command line
  # Also, with avahi-daemon, this should work as http://olestateagency.local/
  config.vm.hostname = "olestateagency"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Port forward MySQL so we can use local client software
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "10.254.254.128"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder ".", "/host"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  config.vm.provider "virtualbox" do |vb|
    # Display the VirtualBox GUI when booting the machine
    vb.gui = false

    # Customize the amount of memory on the VM:
    vb.memory = "1536"
  end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update

    # grab pwgen first, quickly, so we can sort out mysql passwords
    apt-get install -y pwgen
    mysql_root_pw="$(pwgen -s -c -n 32 1)"
    (
        echo "[mysql]"
        echo "user=root"
        echo "password=\"${mysql_root_pw}\""
        echo
        echo "[mysqladmin]"
        echo "user=root"
        echo "password=\"${mysql_root_pw}\""
    ) > ~/.my.cnf
    chmod 0600 ~/.my.cnf

    # preseed the mysql root password, assuming we're going to get muysql 5.7
    echo "mysql-server-5.7 mysql-server/root_password password ${mysql_root_pw}" | debconf-set-selections
    echo "mysql-server-5.7 mysql-server/root_password_again password ${mysql_root_pw}" | debconf-set-selections

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
    cp -v /vagrant/docs/vagrant/nginx_vagrant /etc/nginx/sites-available/vagrant_default
    ln -s /etc/nginx/sites-available/vagrant_default /etc/nginx/sites-enabled/vagrant_default
    systemctl restart nginx.service
  SHELL

  # User provisioning
  config.vm.provision "shell", inline: <<-SHELL, privileged: false
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
    vim -c "PluginInstall" -c "quit" -c "quit" 2>&1 > /dev/null

    # composer for php
    [ -d ~/bin ] || mkdir ~/bin
    curl -o ~/bin/composer.phar https://getcomposer.org/composer.phar
    chmod 755 ~/bin/composer.phar
    ln -s ~/bin/composer.phar ~/bin/composer

    # mysql. Y THIS NO WORKY?
    sudo cp -v ~root/.my.cnf ~$USER/.my.cnf
    sudo chown $USER: ~$USER/.my.cnf

    # environment setup is complete
    figlet provision complete
  SHELL
end
