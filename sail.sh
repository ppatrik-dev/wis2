#!/bin/bash

# Go to project root
cd "$(dirname "$0")"

# Check if tools/bin/sail exists, otherwise use vendor/bin/sail
if [ -f "tools/bin/sail" ]; then
    ./tools/bin/sail "$@"
elif [ -f "vendor/bin/sail" ]; then
    ./vendor/bin/sail "$@"
else
    echo "❌ Laravel Sail not found! Run 'composer install' first."
    exit 1
fi
