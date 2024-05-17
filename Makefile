.DEFAULT_GOAL := app

ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))
$(eval $(ARGS):;@:)

COMPOSE = docker compose --env-file docker/.env.local -f compose.yml -p datetimeinterval
PHP = $(COMPOSE) exec php

#####################################################################################################################
## DOCKER                                                                                                          ##
#####################################################################################################################

down: ## Stop the containers
	$(COMPOSE) down --remove-orphans

log: ## Follow the given container's logs
	$(COMPOSE) logs -f php

up: ~/.composer ./docker/.env.local ## Start the containers
	$(COMPOSE) up -d

in: ## Enter the php container
	$(PHP) ash

.PHONY: build down logs up in

#####################################################################################################################
## COMPOSER                                                                                                        ##
#####################################################################################################################

composer:
	$(PHP) composer $(firstword $(ARGS))

.PHONY: composer

#####################################################################################################################
## QUALITY                                                                                                         ##
#####################################################################################################################

fix: vendor ## Execute linters and check style
	$(PHP) vendor/bin/ecs --fix

check: vendor ## Execute linters and check style
	$(PHP) composer check

tests: vendor ## Run tests suites
	$(PHP) vendor/bin/ecs
	$(PHP) vendor/bin/phpstan
	$(PHP) vendor/bin/phpunit

.PHONY: fix check tests

#####################################################################################################################
## FILES                                                                                                           ##
#####################################################################################################################

~/.composer: ## Initialize composer directory with proper permissions
	mkdir ~/.composer

./docker/.env.local:
	cp ./docker/.env.example ./docker/.env.local
	sed -i "s#{uid}#`id -u`#g" ./docker/.env.local
	sed -i "s#{gid}#`id -g`#g" ./docker/.env.local

composer.lock: composer.json ## Update composer.lock
	$(PHP) composer update --lock --no-scripts
	touch composer.lock

vendor: composer.lock ## Install composer dependencies
	$(PHP) composer install --no-scripts
	touch vendor
