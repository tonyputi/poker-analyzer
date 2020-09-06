# Introduction

This poker analyzer software is based on PHP and Laravel and of course there are many other ways to get better 
results in terms of performance such as using bit math but this is not the purpose of this test.

Created by Filippo Sallemi

# Installation

First clone the project on github

`git clone git@github.com:tonyputi/united-remote.git`

jump inside the project

`cd united-remote/src`

install composer dependencies

`composer install`

copy the enviroment

`cp .env.example .env`

## Fast way using SQLite

open and update the .env file

```
...
...
DB_CONNECTION=sqlite
...
...
```

create the file where to store data

`touch database/database.sqlite`


## Standard way using MySQL

open and update the .env file in according to your mysql configuration

```
...
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=united-remote
DB_USERNAME=root
DB_PASSWORD=your-password
...
...
```

execute database migration

`php artisan migrate --seed`

generate the application key

`php artisan key:generate`

# Usage

You can use the software in two different ways.

## Web browser

In this way a web user interface will serve the application

`php artisan serve`

1. Open your browser and go to http://127.0.0.1:8000
2. Click on register link on top-right corner and proceed to register a new user
3. Upload the hands.txt file, click on analyze button and wait. The results will be showed after process finish

## Command line

In this way the software will evalute the input file and print the results on the command line as a table.

`php artisan poker:analyze ../docs/hands.txt`
