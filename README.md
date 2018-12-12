# desiretec mvp laravel

## Introduction
* TODO

## Features
* TODO OR REMOVE

## Docker Setup

Install docker from [here](https://www.docker.com/)

Clone the repository

    git clone git@git.desiretec.com:desiretec/desiretec-mvp-laravel.git

Switch to the repository folder and clone laradock into it

    cd desiretec-mvp-laravel
    git clone https://github.com/laradock/laradock.git laradock

Switch to laradock/ and copy the env-example to .env

    cp env-example .env

Edit the .env file with your favorite editor and find&replace the following options! The DATA_PATH_HOST option will save all persistent data, like the db into the laradock/.data folder, so be careful with deleting stuff! You can choose an directory outside the repository if u think it will be a problem, but I like to keep all my project related stuff in one place.

    # Choose storage path on your machine. For all storage systems
    DATA_PATH_HOST=./.data
    
    # Define the prefix of container names. This is useful if you have multiple projects that use laradock to have seperate containers per project.
    COMPOSE_PROJECT_NAME=desiretecmvp

Now it's time to spin up some containers.

    1. to run docker-compose commands you have to be in the laradock directory!
    2. run 'docker-compose up -d nginx mariadb redis workspace'
    3. if u run this command for the first time the containers will be build and it can take some time! Grab a coffee :)
    4. run 'docker ps' and verify that all containers (6) are running (Status: up x seconds/minutes/...) if not run 'docker-compose down' and 'docker-compose up -d nginx mariadb redis workspace' (only needed after the first build of the containers and not all the time!)
    5. to install composer and npm packages run 'docker exec -it desiretec_workspace_1'! If u get an error 'No such container' please check 'docker ps' if the container is running and for the name and replace desiretec_workspace_1 with the right container name.
    6. now you are inside the workspace container and the /var/www folder is your project repository and u can execute composer etc.

Afterwards you can install your app and all its dependencies via the workspace container.


## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.6/installation#installation)


Clone the repository

    git clone https://github.com/viralsolani/laravel-adminpanel.git

Switch to the repo folder

    cd laravel-adminpanel

If you have linux system, you can execute below command only in your project root

    1) sudo chmod -R 777 install.sh
    2) ./install.sh

If you have windows system, you can run Artisan Command for database setup, connection and configuration.

    php artisan install:app

Generate a new application key

    php artisan key:generate

Generate a new JWT secret key (If you want to use API)
    php artisan jwt:secret

Generate a new JWT authentication secret key

    php artisan jwt:secret

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeders

    php artisan db:seed

Install the javascript dependencies using npm

    npm install

Compile the dependencies

    npm run development

For generating the files of unisharp file manager

    php artisan vendor:publish --tag=lfm_public

For linking storage folder in public

    php artisan storage:link


You can now access the server at http://localhost

**Command list**

    git clone https://github.com/viralsolani/laravel-adminpanel.git
    cd laravel-adminpanel
    cp .env.example .env
    composer install
    npm install
    npm run development
    php artisan storage:link
    php artisan key:generate
    php artisan jwt:secret
    php artisan vendor:publish --tag=lfm_public

## Logging In

`php artisan db:seed` adds three users with respective roles. The credentials are as follows:

* Administrator: `admin@admin.com`
* Backend User: `executive@executive.com`
* Default User: `user@user.com`

Password: `1234`

## ScreenShots

## Dashboard
![Screenshot](screenshots/dashboard.png)

## User Listing
![Screenshot](screenshots/users.png)

## Settings
![Screenshot](screenshots/settings.png)

