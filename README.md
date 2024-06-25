Version Use : PHP 8.2.12
Laravel 11

Step for Laravel 11 CRUD Operation With Admin and User and Login and Register using Breeze
Step 1: Install Laravel 11
Step 2: MySQL Database Configuration
Step 3: Create Migration
Step 4: Create Controller and Model
Step 5: Add Resource Route
Step 6: Update AppServiceProvider
Step 7: Add Blade Files

Create New Project
composer create-project laravel/laravel example-app
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run build
php artisan migrate

Install Yajra Data Tables
composer require yajra/laravel-datatables-oracle

To run app
php artisan serve

PS: After registered, to access admin page you need to manually edit the user_type field to database change to admin
