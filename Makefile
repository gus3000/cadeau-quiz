DOCKER_PROD = docker compose -f docker-compose-production.yml
DOCKER_PROD_PHP = $(DOCKER_PROD) exec php
DOCKER_PROD_ARTISAN = $(DOCKER_PROD_PHP) php artisan
DOCKER_PROD_COMPOSER = $(DOCKER_PROD) run --rm php php composer.phar

deploy: prod-up prod-build fix-permissions renew-ssl

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
	$(DOCKER_PROD) run --rm npm install
	$(DOCKER_PROD) run --rm npm run build-nocheck

migrations:
	$(DOCKER_PROD_PHP) php artisan migrate

fix-permissions:
	sudo chown -R $$(id -u):$$(id -g) .
	chmod -R g+w storage/logs
	chmod -R g+w storage/framework
	#chmod 755 storage/framework/sessions
	#chmod 644 storage/framework/sessions/* || echo "no sessions, skipping..."

renew-ssl:
	$(DOCKER_PROD) run --rm certbot renew
	$(DOCKER_PROD) restart nginx
#TODO find a way to make `artisan short-schedule:run` work
