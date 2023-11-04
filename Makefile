DOCKER_PROD = docker compose -f docker-compose-production.yml
DOCKER_PROD_PHP = $(DOCKER_PROD) exec php
DOCKER_PROD_ARTISAN = $(DOCKER_PROD_PHP) php artisan
DOCKER_PROD_COMPOSER = $(DOCKER_PROD) run --rm php php composer.phar

deploy: prod-build prod-up fix-permissions

prod-up:
	$(DOCKER_PROD) up php nginx mysql --build -d

prod-down:
	$(DOCKER_PROD) down

prod-artisan:
	$(DOCKER_PROD_ARTISAN)

composer.phar:
	$(DOCKER_PROD) run --rm php sh docker/download_composer.sh

prod-build: composer.phar
	$(DOCKER_PROD_COMPOSER) install
	$(DOCKER_PROD) run --rm npm run build-nocheck

fix-permissions:
	sudo chown -R gus3000:gus3000 .
	chmod 777 storage/framework/sessions
	chmod 644 storage/framework/sessions/*

