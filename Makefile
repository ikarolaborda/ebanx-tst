.DEFAULT_GOAL := help

help:
	@echo "Por favor escolha o que voce quer fazer: \n" \
	" make build: construir as imagens e subir os containers \n" \
	" make dup: subir os containers (quando já criados) \n" \
	" make ddw: parar os containers e remover os volumes persistentes \n" \
	" make drs: reiniciar os containers \n" \
	" make dci: instalar as dependencias dentro do container php \n" \
	" make dcu: atualizar as dependencias dentro do container php \n" \
	" make db: rodar o shell no container mysql \n" \
	" make php: rodar o shell no container php \n"

env:
	cp app/.env.example app/.env

build:
	export COMPOSE_FILE=docker-compose.yml; docker-compose --env-file app/.env up -d --build && sudo chown -R $(USER):$(shell id -g) app/

dup:
	export COMPOSE_FILE=docker-compose.yml; docker-compose --env-file app/.env up -d && sudo chown -R $(USER):$(shell id -g) app/

ddw:
	export COMPOSE_FILE=docker-compose.yml; docker-compose --env-file app/.env down --volumes

drs:
	export COMPOSE_FILE=docker-compose.yml; docker-compose down --volumes && docker-compose --env-file app/.env up -d

dci:
	docker exec -it php composer install && sudo chown -R $(USER):$(shell id -g) app/vendor

dcu:
	docker exec -it php composer update && sudo chown -R $(USER):$(shell id -g) app/vendor

db:
	docker exec -it database bash

php:
	docker exec -it php bash

mig:
	docker exec -it php php bin/console doctrine:migrations:migrate && docker exec -it php php bin/console doctrine:migrations:migrate -e test

seed:
	docker exec -it php php bin/console doctrine:fixtures:load && docker exec -it php php bin/console doctrine:fixtures:load --env=test

test:
	docker exec -it php php bin/phpunit