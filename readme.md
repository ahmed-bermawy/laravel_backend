# Laravel Backend for laravel 5.6
## #Steps to install
### 1) Clone current repository
    git@github.com:ahmed-al-bermawy/laravel-backend.git

### 2) Install dependencies
    composer install

### 3) Change database name, username and password in .env file
for example

    DB_DATABASE=backend
    DB_USERNAME=root
    DB_PASSWORD=root

### 4) Generate Key

    php artisan key:generate

### 5) Cache the configuration in .env file

    php artisan config:cache

### 6) Run migrate to install databases

    php artisan migrate

### 7) Run this seeder to add roles to database

    php artisan db:seed --class=RolesTableSeeder

### 8) To add admin to backend run

    php artisan create:admin

and add your email, name and password

### 9) Run the server
    php artisan serve


### 10) Go to backend

    http://localhost:8000/login
And login with you email and password you have created in step 7

## #Create Backend pages
you can see example for page in  app/Http/Controllers/ArticlesController.php

i will add more description soon

## #Inspired

Theme: [AdminLTE](https://github.com/almasaeed2010/AdminLTE)

Authentication: [sentinel](https://github.com/cartalyst/sentinel)