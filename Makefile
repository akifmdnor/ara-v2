# ARA Car Rental - Docker Development Commands

.PHONY: help build up down restart logs shell install key migrate seed test

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker containers
	docker-compose build

up: ## Start Docker containers
	docker-compose up -d

down: ## Stop Docker containers
	docker-compose down

restart: ## Restart Docker containers
	docker-compose restart

logs: ## Show Docker container logs
	docker-compose logs -f

shell: ## Access PHP container shell
	docker-compose exec app bash

install: ## Install PHP dependencies
	docker-compose exec app composer install

key: ## Generate Laravel application key
	docker-compose exec app php artisan key:generate

migrate: ## Run database migrations
	docker-compose exec app php artisan migrate

seed: ## Seed the database
	docker-compose exec app php artisan db:seed

test: ## Run PHP tests
	docker-compose exec app php artisan test

cache: ## Clear Laravel caches
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

fresh: ## Reset and seed database
	docker-compose exec app php artisan migrate:fresh --seed
