.RECIPEPREFIX +=
.DEFAULT_GOAL := help
PROJECT_NAME=jump
include .env

help:
	@echo "Welcome to $(PROJECT_NAME) IT Support, have you tried turning it off and on again?"

install:
	@composer install

test:
	@docker exec $(PROJECT_NAME)_php ./vendor/bin/pest --parallel

coverage:
	@docker exec $(PROJECT_NAME)_php ./vendor/bin/pest --coverage

migrate:
	@docker exec $(PROJECT_NAME)_php php artisan migrate

seed:
	@docker exec $(PROJECT_NAME)_php php artisan db:seed

fresh:
	@docker exec crm_php php artisan migrate:fresh

analyse:
	./vendor/bin/phpstan analyse --memory-limit=256m

generate:
	@docker exec $(PROJECT_NAME)_php php artisan ide-helper:models --write

nginx:
	@docker exec -it $(PROJECT_NAME)_nginx /bin/sh

php:
	@docker exec -it $(PROJECT_NAME)_php /bin/sh

mysql:
	@docker exec -it $(PROJECT_NAME)_mysql /bin/sh

redis:
	@docker exec -it $(PROJECT_NAME)_redis /bin/sh
