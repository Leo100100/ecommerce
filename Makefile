# ==============================================================================
# E-Commerce Challenge — Makefile
# Uso: make <comando>
# ==============================================================================

COMPOSE = docker compose
APP     = $(COMPOSE) exec app

.PHONY: help setup up down restart build logs shell \
        migrate seed fresh artisan composer tinker test

# ------------------------------------------------------------------------------
help: ## Lista todos os comandos disponíveis
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-18s\033[0m %s\n", $$1, $$2}'

# ------------------------------------------------------------------------------
# Setup inicial
# ------------------------------------------------------------------------------

setup: ## Configuração completa do zero (copia .env, builda e sobe)
	@echo "--> Copiando .env.docker para .env..."
	cp .env.docker .env
	@echo "--> Buildando imagens..."
	$(COMPOSE) build --no-cache
	@echo "--> Subindo containers..."
	$(COMPOSE) up -d
	@echo ""
	@echo "✓ Pronto! Acesse: http://localhost:$${APP_PORT:-8000}"
	@echo "  Para popular o banco com dados de exemplo: make seed"

# ------------------------------------------------------------------------------
# Containers
# ------------------------------------------------------------------------------

up: ## Sobe todos os containers em background
	$(COMPOSE) up -d

down: ## Para e remove os containers
	$(COMPOSE) down

restart: ## Reinicia todos os containers
	$(COMPOSE) restart

build: ## Reconstrói a imagem da aplicação
	$(COMPOSE) build app

logs: ## Exibe logs em tempo real (Ctrl+C para sair)
	$(COMPOSE) logs -f

logs-app: ## Exibe logs apenas do container app
	$(COMPOSE) logs -f app

ps: ## Lista o status dos containers
	$(COMPOSE) ps

# ------------------------------------------------------------------------------
# Artisan / Laravel
# ------------------------------------------------------------------------------

shell: ## Abre um shell bash no container app
	$(APP) bash

artisan: ## Executa artisan: make artisan CMD="route:list"
	$(APP) php artisan $(CMD)

migrate: ## Executa as migrações
	$(APP) php artisan migrate

migrate-fresh: ## Recria o banco e executa todas as migrações
	$(APP) php artisan migrate:fresh

seed: ## Popula o banco com dados de exemplo
	$(APP) php artisan db:seed

fresh: ## Recria banco + popula (migrate:fresh --seed)
	$(APP) php artisan migrate:fresh --seed

tinker: ## Abre o Laravel Tinker
	$(APP) php artisan tinker

# ------------------------------------------------------------------------------
# Dependências
# ------------------------------------------------------------------------------

composer: ## Executa composer: make composer CMD="require pacote/nome"
	$(APP) composer $(CMD)

composer-install: ## Instala dependências PHP dentro do container
	$(APP) composer install

# ------------------------------------------------------------------------------
# Qualidade
# ------------------------------------------------------------------------------

test: ## Executa a suite de testes
	$(APP) php artisan test

# ------------------------------------------------------------------------------
# Banco de dados
# ------------------------------------------------------------------------------

db-shell: ## Abre o cliente MySQL no container db
	$(COMPOSE) exec db mysql -u$${DB_USERNAME:-laravel} -p$${DB_PASSWORD:-secret} $${DB_DATABASE:-ecommerce_challenge}
