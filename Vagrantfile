Vagrant.configure(2) do |config|
	config.vm.box = "ubuntu/trusty64"

	config.vm.network :forwarded_port, guest: 80, host: 9000
	config.vm.network :forwarded_port, guest: 8080, host: 8080
	# config.vm.network "private_network", ip: "192.168.30.25"

	config.vm.synced_folder "html", "/var/www/html"
	config.vm.provider "virtualbox" do |vb|
		vb.name = "CompFit_Dev"
	end
	config.vm.provider "virtualbox" do |v|
		v.customize ['modifyvm', :id, '--natdnshostresolver1', 'on', "--memory", "2048"]
	end

	config.vm.provision "shell", inline: <<-SHELL
	    PASSWORD='root'
	    sudo apt-get update
		sudo apt-get -y upgrade
	    sudo apt-get install -y apache2
	    sudo apt-get install -y php5
	    sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
	    sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
	    sudo apt-get -y install mysql-server
	    sudo apt-get -y install php5-mysql
		sudo apt-get -y install php5-mcrypt
		sudo a2enmod rewrite
	    service apache2 restart
		curl -s https://getcomposer.org/installer | php
		mv composer.phar /usr/local/bin/composer

		curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
		sudo apt-get install -y nodejs
		sudo apt-get install -y build-essential

		sudo apt-get install git -y
		sudo npm install gulp -g
    SHELL
end
