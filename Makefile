DOCKER_PROD = docker compose -f docker-compose-production.yml
DOCKER_PROD_PHP = $(DOCKER_PROD) exec php
DOCKER_PROD_ARTISAN = $(DOCKER_PROD_PHP) php artisan

prod-up:
	$(DOCKER_PROD) up php nginx mysql --build -d

prod-down:
	$(DOCKER_PROD) down

prod-artisan:
	$(DOCKER_PROD_ARTISAN)

prod-build:
	$(DOCKER_PROD) run --rm npm run build-nocheck
	chown -R
