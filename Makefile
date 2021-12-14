.RECIPEPREFIX +=
.DEFAULT_GOAL := help

help:
	@echo "Welcome to IT Support, have you tried turning it off and on again?"

install:
	@composer install

test:
	@docker exec crm_php ./vendor/bin/pest --parallel

coverage:
	@docker exec crm_php ./vendor/bin/pest --coverage

migrate:
	@docker exec crm_php php artisan migrate

seed:
	@docker exec crm_php php artisan db:seed

fresh:
	@docker exec crm_php php artisan migrate:fresh

analyse:
	./vendor/bin/phpstan analyse --memory-limit=256m

generate:
	@docker exec crm_php php artisan ide-helper:models --write

nginx:
	@docker exec -it crm_nginx /bin/sh

php:
	@docker exec -it crm_php /bin/sh

mysql:
	@docker exec -it crm_mysql /bin/sh

redis:
	@docker exec -it crm_redis /bin/sh
