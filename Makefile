.DEFAULT_GOAL := app

ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))
$(eval $(ARGS):;@:)

COMPOSE = docker-compose --env-file docker/.env.local -f docker-compose.yml -p datetimeinterval
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

.PHONY: build down logs up

#####################################################################################################################
## QUALITY                                                                                                         ##
#####################################################################################################################

fix: vendor ## Execute linters and check style
	$(PHP) composer fix

check: vendor ## Execute linters and check style
	$(PHP) composer check

test: vendor ## Run tests suites
	$(PHP) composer test

ci: vendor ## Run tests suites
	$(PHP) composer test-ci

.PHONY: fix check test ci

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