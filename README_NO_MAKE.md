# Mytheresa demo project environment
PHP8, Symfony, Nginx, MYSQL, Nelmio

A REST API endpoint.

### prerequisites on target system:

- docker
- git

Note: if your system has the "make" command available you can follow the steps outlined in [README](README.md) which uses shorter and easier commands lines

### First steps

1. Clone repository
####
        git clone git@github.com:rjacobs1969/mytheresaApiDemo.git

2. Cd into the project folder

###
        cd mytheresaApiDemo

3. Build the environment (this takes a while the first time as docker images are likely need to be pulled)

####
        docker-compose up -d --build  && docker-compose exec -u root php bash -c 'composer install -n'

4. Enjoy the API on your local host on port 8081, either using the Nelmio Interface (use the "try it out" button!) using a browser
or directly sending requests with your favorite tool (postman, curl, wget)

####
        http://localhost:8081

5. For your convience phpmyadmin is available to manipulate the data on port 8080

###
        http://localhost:8080

___

### Daily usage

Start the containers

###
        docker-compose up -d

Stop the containers

###
        docker-compose down

___

### Tests

1. To run the tests

###
        docker-compose up -d && docker-compose exec php bash -c './vendor/phpunit/phpunit/phpunit -c ./phpunit.xml.dist'

---

### More

You can recreate/initialize the database

###
        docker-compose up -d --force-recreate --renew-anon-volumes mysql

