# Instructions to start the project
### With yourl Linux bash:
### clone the project to your pc
        cd /myprojects/
        git clone git@github.com:abdonor/mapon.git
### Create a docker network called app-network
        docker network create --subnet 171.22.0.0/24 app-network
### Access the directory of your project and start it with docker-compose:
        cd /myprojects/mapon
        docker-compose up -d
        docker-compose exec app-mapon composer install
### With the Workbench:
#### The credentials to access the database are:
        host: 127.0.0.1
        port: 3321
        login: root
        password: 123
#### Run the script after log in on workbench
The script is located in:

        /myprojects/mapon/docker/mysql/init.sql

#### With Firefox:
To access your app use the following address:

        http://127.0.0.1:8088

#### App credentials:

        Login: albert.abdonor@gmail.com
        Password: 123

#### Ok it should shork now!