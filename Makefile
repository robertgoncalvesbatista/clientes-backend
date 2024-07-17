# Executables (local)
DOCKER_COMPOSE = docker compose

# Docker containers
PHP_CONTAINER = $(DOCKER_COMPOSE) exec cliente-api-php

# Executables
ARTISAN = $(PHP_CONTAINER) php artisan $(c)

# Misc
.DEFAULT_GOAL = help
.PHONY = help build up up-d start stop down logs logs-f ps php-bash artisan list-ip-containers force swagger optimize set-permissions test pint pint-test

## 👷 Makefile
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

build: ## Builds container(s)
	@$(DOCKER_COMPOSE) build --pull --no-cache $(c)

up: ## Start container(s)
	@$(DOCKER_COMPOSE) up $(c)

up-d: ## Start container(s) in detached mode (no logs)
	@$(DOCKER_COMPOSE) up --detach $(c)

start: build up-d ## Build and start the containers

stop: ## Stop container(s)
	@$(DOCKER_COMPOSE) stop $(c)

down: ## Stop and remove container(s)
	@$(DOCKER_COMPOSE) down $(c) --remove-orphans

logs: ## Show logs
	@$(DOCKER_COMPOSE) logs $(c)

logs-f: ## Show live logs
	@$(DOCKER_COMPOSE) logs --tail=0 --follow $(c)

ps: ## Show containers' statuses
	@$(DOCKER_COMPOSE) ps

php-bash: ## Connect to the PHP FPM container via BASH
	@$(PHP_CONTAINER) bash

artisan: force ## Laravel's Artisan
	@$(ARTISAN)

list-ip-containers: ## List all ip containers
	docker network inspect cliente-api-php | grep --color -E 'IPv4Address|Name'

swagger: ## Creates Swagger API documentation
	@$(PHP_CONTAINER) php artisan l5-swagger:generate

optimize: ## Clear caches
	@$(PHP_CONTAINER) php artisan optimize

set-permissions: ## Fix permissions
	@$(PHP_CONTAINER) chown -R 1000.1000 .

test: ## Clear config to avoid .env test database tenant variable null and run tests
	@$(PHP_CONTAINER) php artisan test --stop-on-failure

pint: ## Run Laravel's code style fixer (apply changes)
	@$(PHP_CONTAINER) ./vendor/bin/pint || true

pint-test: ## Run Laravel's code style fixer in test mode (do not apply changes)
	@$(PHP_CONTAINER) ./vendor/bin/pint --test || true

force:
	@true
