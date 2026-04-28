#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}🚀 AI Sales Page Generator Setup${NC}"
echo -e "${BLUE}========================================${NC}\n"

# Step 1: Start MySQL
echo -e "${BLUE}[1/5]${NC} Starting MySQL service..."
service mysql start
sleep 2
if mysql -u root -e "SELECT 1" > /dev/null 2>&1; then
    echo -e "${GREEN}✓ MySQL started successfully${NC}\n"
else
    echo -e "${RED}✗ MySQL failed to start${NC}"
    exit 1
fi

# Step 2: Create Database
echo -e "${BLUE}[2/5]${NC} Creating database..."
mysql -u root -e "DROP DATABASE IF EXISTS laravel_db;"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if mysql -u root -e "USE laravel_db" > /dev/null 2>&1; then
    echo -e "${GREEN}✓ Database created successfully${NC}\n"
else
    echo -e "${RED}✗ Database creation failed${NC}"
    exit 1
fi

# Step 3: Copy .env.production to .env
echo -e "${BLUE}[3/5]${NC} Setting up environment configuration..."
cp .env.production .env
echo -e "${GREEN}✓ .env configured${NC}\n"

# Step 4: Run Migrations
echo -e "${BLUE}[4/5]${NC} Running database migrations..."
php artisan migrate --force --no-interaction
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migrations completed successfully${NC}\n"
else
    echo -e "${RED}✗ Migrations failed${NC}"
    exit 1
fi

# Step 5: Seed Database
echo -e "${BLUE}[5/5]${NC} Seeding database with demo data..."
php artisan db:seed --no-interaction
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database seeded successfully${NC}\n"
else
    echo -e "${RED}✗ Database seeding failed${NC}"
    exit 1
fi

# Success message
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✓ Setup completed successfully!${NC}"
echo -e "${GREEN}========================================${NC}\n"

echo -e "${BLUE}📝 Demo Credentials:${NC}"
echo -e "  Admin:   admin@example.com / password123"
echo -e "  Manager: manager@example.com / password123"
echo -e "  User:    user@example.com / password123\n"

echo -e "${BLUE}🎯 Next steps:${NC}"
echo -e "  1. Click 'Run' button to start the server"
echo -e "  2. Open the web URL in your browser"
echo -e "  3. Login with one of the credentials above"
echo -e "  4. Go to 'Sales Pages' to test AI generation\n"

echo -e "${BLUE}📌 Database Info:${NC}"
echo -e "  Host: localhost"
echo -e "  Database: laravel_db"
echo -e "  User: root"
echo -e "  Password: (blank)\n"
