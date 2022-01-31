install:
	composer install
	yarn install
lint:
	./vendor/bin/phpcs -- --standard=PSR12 src tests/Form tests/Controller
lint-fix:
	./vendor/bin/phpcbf -- --standard=PSR12 src tests/Form tests/Controller
cache:
	php bin/console cache:clear
db-fixtures:
	php bin/console doctrine:fixtures:load
db-migrations:
	php bin/console doctrine:migrations:migrate
test:
	php ./vendor/bin/phpunit
docker:
	sudo docker-compose up --build
db-ip:
	sudo docker inspect feedback__db | grep IPAddres