#!/bin/bash

# ARA Car Rental - Docker Development Script

set -e

COMPOSE_FILE="docker-compose.yml"

if [ -f "docker-compose.override.yml" ]; then
    COMPOSE_FILE="$COMPOSE_FILE:docker-compose.override.yml"
fi

function show_help() {
    echo "ARA Car Rental - Docker Development Script"
    echo ""
    echo "Usage: $0 [command]"
    echo ""
    echo "Commands:"
    echo "  build     Build Docker containers"
    echo "  up        Start Docker containers"
    echo "  down      Stop Docker containers"
    echo "  restart   Restart Docker containers"
    echo "  logs      Show Docker container logs"
    echo "  shell     Access PHP container shell"
    echo "  install   Install PHP dependencies"
    echo "  key       Generate Laravel application key"
    echo "  migrate   Run database migrations"
    echo "  seed      Seed the database"
    echo "  test      Run PHP tests"
    echo "  cache     Clear Laravel caches"
    echo "  fresh     Reset and seed database"
    echo "  help      Show this help message"
}

function run_compose() {
    docker-compose -f $COMPOSE_FILE "$@"
}

case "${1:-help}" in
    build)
        echo "Building Docker containers..."
        run_compose build
        ;;
    up)
        echo "Starting Docker containers..."
        run_compose up -d
        echo "Containers started. Access the app at: http://localhost:8000"
        ;;
    down)
        echo "Stopping Docker containers..."
        run_compose down
        ;;
    restart)
        echo "Restarting Docker containers..."
        run_compose restart
        ;;
    logs)
        echo "Showing Docker container logs..."
        run_compose logs -f
        ;;
    shell)
        echo "Accessing PHP container shell..."
        run_compose exec app bash
        ;;
    install)
        echo "Installing PHP dependencies..."
        run_compose exec app composer install
        ;;
    key)
        echo "Generating Laravel application key..."
        run_compose exec app php artisan key:generate
        ;;
    migrate)
        echo "Running database migrations..."
        run_compose exec app php artisan migrate
        ;;
    seed)
        echo "Seeding the database..."
        run_compose exec app php artisan db:seed
        ;;
    test)
        echo "Running PHP tests..."
        run_compose exec app php artisan test
        ;;
    cache)
        echo "Clearing Laravel caches..."
        run_compose exec app php artisan cache:clear
        run_compose exec app php artisan config:clear
        run_compose exec app php artisan route:clear
        run_compose exec app php artisan view:clear
        ;;
    fresh)
        echo "Resetting and seeding database..."
        run_compose exec app php artisan migrate:fresh --seed
        ;;
    help|*)
        show_help
        ;;
esac
