Docker Instructions

1. Install Docker

// Update apt package </br>
sudo apt-get update
</br>
// Install packages to use a repository over HTTPS </br>
sudo apt-get install \
	apt-transport-https \
	ca-certificates \
	curl \
	gnupg \
	lsb-release
</br>
// Add docker’s official GPG key </br>
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
</br>
// Setup the docker repository </br>
echo \
  "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
</br>
// Install docker engine </br>
sudo apt-get update </br>
sudo apt-get install docker-ce docker-ce-cli containerd.io
</br>
// verify docker engine is installed </br>
sudo docker run hello-world
</br>
2. Install Docker Compose

// Download stable release of docker compose
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

// Apply executable permissions to the binary
sudo chmod +x /usr/local/bin/docker-compose

// check if installed successfully
docker-compose —version

// if error, create a symbolic link 
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose


3. Install Composer
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04

4. Install NodeJs and NPM
Only Option 1 on the link below:
https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04

5. Clone Project Repo

Create a folder on server and clone this repository to the folder. </br> command: git clone https://github.com/abaoel/eGame.git .

Copy the file .env.example to .env </br>
command: cp .env.example .env

Replace all localhost with the IP address of your server on the .env file.
</br>
Run command: sudo npm install in the folder.
</br>
6. Build and run docker containers

// Build using docker-compose
sudo docker-compose build

// Run containers in the background
sudo docker-compose up -d

// Show list of containers
sudo docker-compose ps


7. Create Database egame in the MySql container

Sudo docker exec -it {container_id} bash
command: mysql -u root -p;
Password: abao3023

Show databases, if egame is not created then create it.
Command: create database egame;

8. Exit from MySql container then bash into the larvalapp container.
Command: sudo docker exec -it {container_id} bash

Run composer install
Command: composer install

Run migration
Command: php artisan migrate

Run seeder
Command: php artisan db:seed --class=UserSeeder

Laravel generate key and clear config cache
Command: php artisan key:generate
command: php artisan config:cache

Storage Permission
Command: chmod o+w ./storage/ -R

Exit from the laravelapp container and visit
http://ipaddress:8000

