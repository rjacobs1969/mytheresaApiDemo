# Mytheresa demo project environment
PHP8, Symfony, Nginx, MYSQL, Nelmio

A REST API endpoint.

### prerequisites on target system:

- docker
- git
- make

Note: "make" is optional, if your system does not has support for "make" you can follow the steps outlined in [README_NO_MAKE](README_NO_MAKE.md)

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

4. Enjoy the API on your local host on port 8081, either using the Nelmio Interface (use the "try it out" and "execute" buttons!) using a browser


####
        http://localhost:8081

or you can use it sending requests directly with your favorite tool (postman, curl, wget)

####
        curl http://localhost:8081/api/products?category=boots

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

---

### Clarification on design decisions taken:

Given that the job requires experience with PHP and Symfony, it was a natural decision to use these technologies for this assignment. The directory structure and naming conventions reflect the practices agreed upon in my previous company, including:

- Repositories are named with the suffix Repository.

- There is no distinction (naming and location in the source tree) between value objects and entities.

- The term Usecase is avoided and descriptive function names are favored instead of execute.

- Terms like tryToExecute or ExecuteOrFail are avoided

- Doctrine Querybuilder is used for database access, without employing the ORM component.

- Unit tests cover business logic but exclude the persistence layer.

I chose MySQL as the database, aligning the data structure with the provided test data. Since it was mentioned that the product count could grow to 20,000  both product selection and result limiting are handled at the query level for performance and memory usage reasons.
