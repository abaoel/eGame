YouTube Tutorial </br>
https://www.youtube.com/watch?v=GkL_Y4Ptc0A
</br></br>

Docker Instructions
<br>

1. Install Docker

// Update apt package </br>
sudo apt-get update
</br></br>
// Install packages to use a repository over HTTPS </br>
sudo apt-get install \
	apt-transport-https \
	ca-certificates \
	curl \
	gnupg \
	lsb-release
</br></br>
// Add docker’s official GPG key </br>
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
</br></br>
// Setup the docker repository </br>
echo \
  "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
</br></br>
// Install docker engine </br>
sudo apt-get update </br>
sudo apt-get install docker-ce docker-ce-cli containerd.io
</br></br>
// verify docker engine is installed </br>
sudo docker run hello-world
</br></br>
2. Install Docker Compose
</br></br>
// Download stable release of docker compose </br>
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

</br></br>
// Apply executable permissions to the binary</br>
sudo chmod +x /usr/local/bin/docker-compose
</br></br>
// check if installed successfully</br>
docker-compose —version
</br></br>
// if error, create a symbolic link </br>
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

</br></br>
3. Install Composer</br>
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04
</br></br>
4. Install NodeJs and NPM</br>
Only Option 1 on the link below:
https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04
</br></br>
5. Clone Project Repo</br>

Create a folder on server and clone this repository to the folder. </br> command: git clone https://github.com/abaoel/eGame.git .
</br></br>
Copy the file .env.example to .env </br>
command: cp .env.example .env
</br></br>

Replace all localhost with the IP address of your server on the .env file.
</br>
Run command: sudo npm install in the folder.
</br></br>
6. Build and run docker containers</br>

// Build using docker-compose</br>
sudo docker-compose build
</br></br>
// Run containers in the background</br>
sudo docker-compose up -d
</br></br>
// Show list of containers</br>
sudo docker-compose ps

</br></br>
7. Create Database egame in the MySql container</br>

Sudo docker exec -it {container_id} bash</br>
command: mysql -u root -p;</br>
Password: abao3023</br>
</br></br>
Show databases, if egame is not created then create it.</br>
Command: create database egame;
</br></br>
8. Exit from MySql container then bash into the larvalapp container.</br>
Command: sudo docker exec -it {container_id} bash
</br></br>
Run composer install</br>
Command: composer install
</br></br>
Run migration</br>
Command: php artisan migrate
</br></br>
Run seeder</br>
Command: php artisan db:seed --class=UserSeeder
</br></br>
Laravel generate key and clear config cache</br>
Command: php artisan key:generate</br>
command: php artisan config:cache
</br></br>
Storage Permission</br>
Command: chmod o+w ./storage/ -R
</br></br>
Exit from the laravelapp container and visit
http://ipaddress:8000

