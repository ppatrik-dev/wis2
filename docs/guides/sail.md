# Laravel Sail Guide

This guide explains how to use Laravel Sail in this project, including setup, dependency installation, and development workflow.

## Prerequisites

- Docker and Docker Compose installed
- Git
- Node.js and npm (handled inside Sail)

---

## Sail Commands

We provide a `sail.sh` helper script to simplify common tasks.

### Start Containers

```bash
./sail.sh up
```

- Starts all Sail containers in detached mode
- Installs Composer dependencies if missing
- Installs npm dependencies if missing
- Starts Tailwind/Vite watcher

### Stop Containers

```bash
./sail.sh down
```

- Stops all running Sail containers

### Restart Containers

```bash
./sail.sh restart
```

- Stops and starts containers
- Installs missing dependencies
- Starts Tailwind/Vite watcher

### Install Dependencies Only

#### Composer

```bash
./sail.sh composer
```

#### npm

```bash
./sail.sh npm
```

### Start Tailwind/Vite Watcher

```bash
./sail.sh dev
```

- Watches CSS, Blade, and JS files
- Automatically rebuilds Tailwind CSS on file changes

### Setting Permissions

Make sure the `sail.sh` script has execute permission:

```bash
chmod +x sail.sh
```

## Notes

- `.env` files are not versioned. Copy from `.env.example` and set your local configuration.
- `vendor` and `node_modules` directories are not versioned; they are installed via Sail.
- Use `./sail.sh up` for initial setup. Team members do not need to run `composer install` or `npm install` manually unless adding new packages.
