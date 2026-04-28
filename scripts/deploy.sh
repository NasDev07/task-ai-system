#!/bin/bash

# Auto-deployment script for GitHub webhook
# This script is triggered automatically when code is pushed to main branch

set -e

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting deployment..."

# Navigate to project root
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_ROOT"

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Project path: $PROJECT_ROOT"

# Git pull latest changes
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Pulling latest from GitHub..."
git pull origin main 2>&1

# Install/update dependencies if composer.json changed
if git diff --name-only HEAD@{1} HEAD | grep -q "composer.lock"; then
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader 2>&1
fi

# Run pending migrations
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Running migrations..."
php artisan migrate --force 2>&1

# Clear application cache
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Clearing cache..."
php artisan cache:clear 2>&1
php artisan config:clear 2>&1
php artisan view:clear 2>&1

# Clear route cache if using it
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Clearing route cache..."
php artisan route:clear 2>&1

# Restart queue if using jobs
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Restarting queue..."
php artisan queue:restart 2>&1

# Optimize autoloader
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Optimizing autoloader..."
composer dump-autoload --optimize 2>&1

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Deployment completed successfully!"
