# Mytheresa demo project environment
PHP8, Symfony, Nginx, MYSQL, Nelmio

A REST API endpoint.

### First steps

1. Clone repository
####
        git clone git@github.com:rjacobs1969/mytheresaApiDemo.git

2. Cd into the project folder

###
        cd mytheresaApiDemo

3. Build the environment (this takes a while the first time as docker images are likely need to be pulled)

####
        make build

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
        make up

Stop the containers

###
        make down

___

### Tests

1. To run the tests

###
        make unit

---

### More

You can discover more actions available executing

###
        make help
