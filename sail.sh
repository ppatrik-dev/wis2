#!/bin/bash
# chmod +x sail.sh
# Usage: ./sail.sh {up|down|restart|composer|npm|dev}
# Function: start Tailwind watcher
function start_tailwind() {
    echo "Starting Tailwind/Vite watcher..."
    ./vendor/bin/sail npm run dev
}

# Function: install composer dependencies if they don't exist
function install_composer() {
    if [ ! -d "vendor" ]; then
        echo "Installing composer dependencies..."
        ./vendor/bin/sail composer install
    else
        echo "Composer dependencies already installed"
    fi
}

# Function: install npm dependencies if they don't exist
function install_npm() {
    if [ ! -d "node_modules" ]; then
        echo "Installing npm dependencies..."
        ./vendor/bin/sail npm install
    else
        echo "Npm dependencies already installed"
    fi
}

# Main switch
case "$1" in
  up)
    echo "Starting Laravel Sail containers..."
    ./vendor/bin/sail up -d

    install_composer
    install_npm
    start_tailwind
    ;;
  down)
    echo "Stopping containers..."
    ./vendor/bin/sail down
    ;;
  restart)
    echo "Restarting containers..."
    ./vendor/bin/sail down
    ./vendor/bin/sail up -d

    install_composer
    install_npm
    start_tailwind
    ;;
  composer)
    install_composer
    ;;
  npm)
    install_npm
    ;;
  dev)
    start_tailwind
    ;;
  *)
    echo "Usage: ./sail.sh {up|down|restart|composer|npm|dev}"
    exit 1
    ;;
esac
