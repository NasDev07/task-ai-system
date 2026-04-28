# AI Sales Page Generator - Setup Instructions

## 🚀 Quick Start for Replit

### Automatic Setup (Recommended)

1. Open Replit: https://replit.com/@NasDev07/task-syste-ai
2. Click the **"Run"** button
3. The setup script will automatically:
    - Start MySQL database
    - Create database
    - Run migrations
    - Seed demo users
    - Start Laravel server

### Manual Setup (if automatic fails)

#### Step 1: Start MySQL

```bash
service mysql start
```

#### Step 2: Create Database

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### Step 3: Setup Environment

```bash
cp .env.production .env
```

#### Step 4: Run Migrations

```bash
php artisan migrate --force
```

#### Step 5: Seed Database

```bash
php artisan db:seed
```

#### Step 6: Start Server

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

---

## 📝 Demo Credentials

Use these to login:

| Role    | Email               | Password    |
| ------- | ------------------- | ----------- |
| Admin   | admin@example.com   | password123 |
| Manager | manager@example.com | password123 |
| User    | user@example.com    | password123 |

---

## ✨ Features to Test

### 1. Dashboard

- View system overview
- Check statistics

### 2. Sales Pages (Main Feature)

- **Create**: Generate AI sales page with Gemini
- **Preview**: See rendered landing page
- **Edit**: Regenerate entire page
- **Export**: Download as HTML file
- **History**: Browse all saved pages

### 3. User Management (Admin/Manager Only)

- View users
- Add new users
- Assign roles

### 4. Profile

- Edit personal information
- Change password
- Update settings

---

## 🔧 Technology Stack

- **Backend**: Laravel 13.6.0
- **Database**: MySQL 8.0+
- **Frontend**: Bootstrap 5.3 + Blade templates
- **AI**: Google Gemini API (3 Flash Preview)
- **Authentication**: Laravel Auth + Spatie Permissions
- **PHP**: 8.3+

---

## 📁 Database Schema

### Users Table

- id, name, email, password, phone, address, city, country, postal_code
- profile_completion_percentage, is_active, email_verified_at, verified_at, last_login_at
- timestamps

### Roles Table

- id, name, guard_name, created_at, updated_at

### Permissions Table

- id, name, guard_name, created_at, updated_at

### Model_has_Roles Table

- role_id, model_id, model_type

### Model_has_Permissions Table

- permission_id, model_id, model_type

### Role_has_Permissions Table

- permission_id, role_id

### Sales_Pages Table

- id, user_id (FK), product_name, description, features, target_audience, price
- unique_selling_point, headline, subheadline, benefits, features_breakdown
- social_proof, pricing_display, call_to_action
- created_at, updated_at

---

## 🎯 Testing Workflow

1. **Register** a new account (if needed)
2. **Login** with credentials
3. **Navigate** to "Sales Pages" → "Create New"
4. **Fill form** with product details:
    - Product Name
    - Description
    - Features
    - Target Audience
    - Price
    - Unique Selling Point
5. **Generate** - AI will create sales copy
6. **Preview** - See rendered landing page
7. **Export** - Download HTML
8. **Edit** - Regenerate with new info
9. **History** - View all pages

---

## 🔑 Environment Variables

Key variables in `.env`:

```
APP_NAME=AI Sales Page Generator
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:vQZZvuhXNpiYkeH9AsbceM2RK03oAthF980c4r5jiPU=

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=

GEMINI_API_KEY=AIzaSyDznF5U1XwgVHC_VDVfKWYLiJ2TvWtYNSo
GEMINI_MODEL=gemini-3-flash-preview

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

---

## 🐛 Troubleshooting

### MySQL Won't Start

```bash
# Kill existing MySQL process
pkill -f mysql

# Start fresh
service mysql start
```

### Migrations Fail

```bash
# Reset and try again
php artisan migrate:reset --force
php artisan migrate --force
```

### Can't Connect to Database

```bash
# Check MySQL is running
mysql -u root -e "SHOW DATABASES;"

# Check .env has correct DB credentials
cat .env | grep DB_
```

### Gemini API Errors

- Check API key is valid in `.env`
- Verify quota not exceeded
- Check internet connection

---

## 📞 Support

If issues persist:

1. Check error logs: `storage/logs/laravel.log`
2. Verify all dependencies installed: `composer install && npm install`
3. Clear cache: `php artisan cache:clear && php artisan view:clear`
4. Rebuild: `php artisan config:cache`

---

**Last Updated**: April 28, 2026
**Status**: ✅ Production Ready
