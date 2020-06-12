
<p  align="center">

<img  src="https://www.supinfo.com/articles/resources/143096/1784/0.png"  alt="PHP Logo svg vector"  width="400px">
</p>
 
## Description

BileMo API was developed in php with use the symfony framework.

## Installation
  
Recover the project

    git clone https://github.com/fafax/bilemo.git
    composer install

Create database

copy .env file and rename this in .env.local

Change line DATABASE_URL=mysql:// in .env.local file with your setting database

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate


## Set data
for example data

    php bin/console doctrine:fixtures:load
    
## Start the server

symfony server:start
    
## How to get an authentication token

With method post http://127.0.0.1:8000/api/login_check with like body

{"username":"admin1@admin.fr","password":"test1"}

## Functionality of the BileMo API project
- Consult the list of BileMo products
- View BileMo product details
- Consult the list of registered users linked to a client on the website
- View the details of a registered user linked to a client
- Add a new user linked to a client
- Delete a user added by a client

## Test code climate
   
[![Maintainability](https://api.codeclimate.com/v1/badges/3019b7fb47b4c56e65a6/maintainability)](https://codeclimate.com/github/fafax/SnowTricks/maintainability)

## Stay in touch

- Author - [Fabien HAMAYON](https://www.linkedin.com/in/fabien-hamayon-2b072698/)

- Website - [code assembly dev](http://codeassemblydev.fr/)

- Youtube - [Youtube channel](https://www.youtube.com/channel/UCBB2pQPkS2jmI3LPhUCxYgA)