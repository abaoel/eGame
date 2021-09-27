## Game Test

<img src="./images/gameimage.png" alt="Italian Trulli">

## YouTube Tutorial
https://www.youtube.com/watch?v=FPVnFZPErN4

## Docker Environment
 
 - Linux/Ubuntu
 - Apache
 - Php 7.4
 - Mysql 8


## How to setup the game

1. Create a folder on your Desktop and clone this repository to the folder.</br>
   command: git clone https://github.com/abaoel/eGame.git

2. Change directory to the egame directory</br>
   command: cd egame

   Copy the file .env.example to .env</br>
   command: cp .env.example .env

   Edit the following in the .env to your own credentials. </br>
   DB_DATABASE=egame</br>
   DB_USERNAME=root</br>
   DB_PASSWORD=*******</br>
   
   Edit the database credentials to your own credentials in the .env and docker-compose.yml file.
   <img src="./images/envfile.png" alt="">
   <img src="./images/dockercompose.png" alt="">
   
3. Make sure you have Composer and NPM. Run Composer Install and NPM Install</br>
   command: composer install</br>
   command: NPM install
   
4. Make sure your Docker software is running and run the command below.</br>
   command: docker-compose up -d

5. Open Docker for Mac or PC, then loging to the docker mysql container (see image below)
<img src="./images/mysqlcli2.png" alt="">

6. Create the database egame.
<img src="./images/mysqlcli3.png" alt="">
<img src="./images/mysqlcli4.png" alt="">
</br>
Exit from MySql container and go back to the main terminal/command in the egame folder.
</br>

7. Run the command: docker-compose exec php php /var/www/html/artisan migrate
8. Run the command: docker-compose exec php php /var/www/html/artisan db:seed --class=UserSeeder

Navigate to http://127.0.0.1:8000/

see images below for instructions on how to play the game.
<img src="./images/entergame.png" alt="">
<img src="./images/entergame2.png" alt="">


