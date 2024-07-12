# ![Laravel Example App]


> ### Example Laravel codebase containing real world examples (CRUD, auth and API)

----------

# Getting started

## Installation

Please check the official laravel Framework V11.0 installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/11.x/installation)

Install all the dependencies using composer

    composer install

Install Sanctum API Package

     composer require laravel/sanctum

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

 
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder to create dummy users

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh


After Run this http://localhost:8000 url on browser you can see the login page.

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).


## API Specification

This application adheres to the api specifications.This helps mix and match any backend with any other frontend without conflicts.
----------

# Code overview

## Dependencies

- [sanctum-auth](https://laravel.com/docs/11.x/sanctum) - For authentication using JSON Web Tokens
- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)
 
## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Bearer {Token}      	|

Refer the [api specification](#api-specification) for more info.

----------
 
# Authentication
 
This applications uses Bearer Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Bearer Token` scheme. The Sanctum  authentication middleware handles the validation and authentication of the token.
