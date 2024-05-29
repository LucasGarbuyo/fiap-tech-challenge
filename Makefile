PATH  := $(PATH):$(PWD)/bin:
SHELL := /bin/bash

.PHONY: help clone enter copy-env up access-container install-deps generate-key migrate seed
.DEFAULT_GOAL = help

phpmd := vendor/bin/phpmd
phpcs := vendor/bin/phpcs
phpcbf := vendor/bin/phpcbf
phpunit := vendor/bin/phpunit

CONTAINER := fiap-tech-challenge-php-1
PATH_CONTAINER := /var/www/html
COMPOSE_DEV := docker-compose.yml

## —— Inicia o Projeto 🚀  ————————————————————————————————————————————————————
start: ## Inicia o projeto com o Docker e executa as migrações, seed
	make start1

start1 : copy-env up set-container-php-name install-deps generate-key migrate seed restart msg_success

## —— Comandos ⚙️  ————————————————————————————————————————————————————————————
set-container-php-name: ## Define a variável CONTAINER com o nome do container da aplicação PHP
	@$(eval CONTAINER=$(shell \
		container_id=$$(docker-compose ps -q php); \
		container_name=$$(docker inspect --format '{{.Name}}' $${container_id} | sed 's/^.\(.*\)/\1/'); \
		echo $${container_name} \
	)) \
	echo "Nome do container PHP: $(CONTAINER)"

copy-env: ## Copia o arquivo .env.example para .env se ele não existir
	@if [ ! -f .env ]; then cp .env.example .env; fi

up: ## Inicia os containers do Docker
	docker compose -f $(COMPOSE_DEV) up -d
	@printf "\033[32mDocker iniciado com sucesso!\033[0m\n"

access-container: ## Acessa o container da aplicação
	docker exec -it $(CONTAINER) bash
	@printf "\033[32mAcesso ao container realizado com sucesso!\033[0m\n"

install-deps: ## Instala as dependências do projeto
	docker exec -it $(CONTAINER) composer install
	@printf "\033[32mComplementos instaladas com sucesso!\033[0m\n"

generate-key: ## Cria uma chave para a aplicação
	docker exec -it $(CONTAINER) php artisan key:generate
	@printf "\033[32mChave gerada com sucesso!\033[0m\n"

clean: ## Remove todos os containers, volumes, imagens, networks e arquivos de cache do projeto	 e os arquivos de volume do mysql dentro da pasta docker/database/volumes/mysql
	@printf "\033[5;1m\033[33m\033[41mLimpando!\033[0m\n"
	@printf "\033[93mDesligando Docker... Removendo volumes, imagens, networks e arquivos de cache...\033[0m\n"
	@docker compose -f $(COMPOSE_DEV) down --volumes --rmi all --remove-orphans
	@printf "\033[93mRemovendo imagens sem uso...\033[0m\n"
	@docker image prune -a -f
	@printf "\033[93mRemovendo volumes sem uso...\033[0m\n"
	@docker volume prune -f
	@printf "\033[93mRemovendo networks sem uso...\033[0m\n"
	@docker network prune -f
	@printf "\033[93mDocker desligado com sucesso! Volumes, imagens, networks e arquivos de cache removidos!\033[0m\n"
	@printf "\033[93mRemovendo arquivos composer lock, vendor e .env do projeto...\033[0m\n"
	@rm -rf .env vendor composer.lock
	@printf "\033[93mArquivos do composer lock, vendor e .env removidos!\033[0m\n"
	@rm -rf docker/database/volumes/mysql
	@printf "\033[93mArquivos de volume do MySQL removidos!\033[0m\n"
	@printf "\033[32mProjeto limpo com sucesso!\033[0m\n"

restart: ## Reinicia o container da aplicação
	@printf "\033[32mReiniciando os containers...para previnir erros ao conectar!\033[0m\n"
	@docker compose -f $(COMPOSE_DEV) restart
	@printf "\033[32mAcesse o proejeto em http://localhost:8080\033[0m\n"

## —— Mysql 🐬  ————————————————————————————————————————————————————————————————
migrate: ## Cria as tabelas no banco de dados
	docker exec -it $(CONTAINER) php artisan migrate:fresh

seed: ## Popula o banco de dados
	docker exec -it $(CONTAINER) php artisan db:seed

clean-mysql: ## Remove o volume de dados do MySQL do projeto
	docker exec -it $(CONTAINER) rm -rf ./docker/database/volumes/mysql/*

## —— Docker 🐳  ———————————————————————————————————————————————————————————————
docker-start: ## Iniciar Docker
	docker compose -f $(COMPOSE_DEV) up -d

docker-build: ## Iniciar Docker com build
	docker compose -f $(COMPOSE_DEV) up -d --build

docker-stop: ## Desligar Docker
	docker compose -f $(COMPOSE_DEV) down

docker-shell: ## Acessar container do php
	docker exec -it $(CONTAINER) sh

docker-rebuild-all: ## Rebuild em todos os containers
	make docker-stop docker-build

docker-reload-nginx: ## Reload no nginx
	docker exec -it $(CONTAINER) nginx -s reload

## —— Mensagens 📝  ————————————————————————————————————————————————————————————
msg_success: ## Mensagem de sucesso
	@printf "\033[32mProjeto iniciado com sucesso!\033[0m\n"

msg_error: ## Mensagem de erro
	@printf "\033[31mOcorreu um erro!\033[0m\n"

## —— Ajuda 🛠️️  —————————————————————————————————————————————————————————————
help: ## Mostra os comandos disponíveis:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
	| awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-24s\033[0m %s\n", $$1, $$2}' \
	| sed -e 's/\[32m## /[33m/' && printf "\n"
