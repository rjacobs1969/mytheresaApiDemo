SHELL := /bin/bash

all: help

##
## Repository Docker Helper Commands
## Available commands:
##

.PHONY: help up debug stop pull down logs shell unit composer rector arm64-build

help: Makefile
	@sed -n 's/^##//p' $<

## composer:             Install packages
composer:
	make up && docker-compose exec -u root php bash -c 'composer install -n'

## up:                   Start the containers
up:
	docker-compose up -d

## down:                 Stop the containers
down:
	docker-compose down

## shell:                Open a shell in the container
shell:
	docker-compose exec php bash

## build:                Build the containers, start the containers, install packages (first run)
build:
	docker-compose up -d --build  && docker-compose exec -u root php bash -c 'composer install -n'

## initdb:		load initial data to the db
initdb:
	docker-compose up -d --force-recreate --renew-anon-volumes mysql

## pull:                 Download new docker image
pull:
	docker-compose pull

## logs:                 Container logs
logs:
	docker-compose logs -f --tail="20"

## unit:                 Run unit tests
unit:
	make up && docker-compose exec php bash -c './vendor/phpunit/phpunit/phpunit -c ./phpunit.xml.dist'
