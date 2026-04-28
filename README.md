# 🤖 AI Sales Page Generator

Generate professional sales landing pages using Google Gemini AI in seconds. Perfect for entrepreneurs, marketers, and small businesses who need high-converting sales pages without design skills.

![Laravel](https://img.shields.io/badge/Laravel-13.6.0-red?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📋 Table of Contents

- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Quick Start](#-quick-start)
- [Setup Instructions](#-setup-instructions)
- [Demo Credentials](#-demo-credentials)
- [Testing Workflow](#-testing-workflow)
- [Database Schema](#-database-schema)
- [Environment Variables](#-environment-variables)
- [Troubleshooting](#-troubleshooting)
- [Support](#-support)

---

## ✨ Features

### Dashboard

- System overview
- Real-time statistics
- Quick access to features

### Sales Pages (Main Feature)

- **AI-Powered Generation**: Create complete sales pages using Google Gemini
- **Smart Preview**: View rendered landing page in real-time
- **Easy Editing**: Regenerate entire page or specific sections
- **Export to HTML**: Download ready-to-use HTML files
- **Version History**: Browse and manage all saved pages
- **Product Management**: Organize sales pages by product

### User Management (Admin/Manager Only)

- View all users with detailed information
- Add new team members
- Assign and manage roles
- Track user activity

### User Profile

- Edit personal information
- Change password securely
- Update account settings
- View profile completion

### Role-Based Access Control

- **Admin**: Full system access
- **Manager**: User and sales page management
- **User**: Personal sales page creation

---

## 🔧 Technology Stack

| Component          | Technology         | Version         |
| ------------------ | ------------------ | --------------- |
| **Backend**        | Laravel            | 13.6.0          |
| **Database**       | MySQL              | 8.0+            |
| **PHP**            | PHP                | 8.3+            |
| **Frontend**       | Bootstrap          | 5.3             |
| **Templating**     | Blade              | -               |
| **AI**             | Google Gemini      | 3 Flash Preview |
| **Authentication** | Laravel Auth       | Built-in        |
| **Authorization**  | Spatie Permissions | Latest          |

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.3 or higher
- MySQL 8.0 or higher
- Composer
- Node.js 18+ (for assets)
- Google Gemini API Key

### Installation (3 Steps)

```bash
# Step 1: Clone and install dependencies
git clone https://github.com/NasDev07/task-ai-system.git
cd task-ai-system
composer install
npm install

# Step 2: Setup environment
cp .env.example .env
php artisan key:generate

# Step 3: Initialize database
php artisan migrate --seed
php artisan serve
```

Access the app at: `http://localhost:8000`

---

## 📖 Setup Instructions

### Step 1: Start Database

```bash
# For local development with MySQL
mysql -u root -p
# OR if using Homebrew
brew services start mysql
```

### Step 2: Create Database

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 3: Configure Environment

```bash
# Copy example environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Update .env with your settings:
# - Database credentials
# - Google Gemini API Key (get from https://aistudio.google.com/apikey)
```

### Step 4: Run Migrations

```bash
php artisan migrate --seed
```

This will:

- Create all database tables
- Seed demo users and roles
- Setup permissions

### Step 5: Install Frontend Assets (Optional)

```bash
npm install
npm run dev
```

### Step 6: Start Development Server

```bash
php artisan serve
```

Server runs at: `http://localhost:8000`

---

## 📝 Demo Credentials

Use these to test the application:

| Role    | Email               | Password    | Access Level   |
| ------- | ------------------- | ----------- | -------------- |
| Admin   | admin@example.com   | password123 | Full System    |
| Manager | manager@example.com | password123 | Users + Pages  |
| User    | user@example.com    | password123 | Personal Pages |

---

## 🎯 Testing Workflow

Follow these steps to test the complete workflow:

### 1. Login

```
Email: user@example.com
Password: password123
```

### 2. Navigate to Sales Pages

Click "Sales Pages" → "Create New"

### 3. Fill Product Details

- **Product Name**: E.g., "Premium Email Marketing Software"
- **Description**: Brief description of your product
- **Features**: List key features (comma-separated)
- **Target Audience**: Who should buy this?
- **Price**: Product pricing
- **Unique Selling Point**: What makes it special?

### 4. Generate with AI

Click "Generate Page" - Gemini AI will create:

- Compelling headline
- Engaging subheadline
- Benefit statements
- Feature breakdowns
- Social proof section
- Pricing display
- Call-to-action button

### 5. Preview Results

View rendered landing page with:

- Professional styling
- Responsive design
- Mobile-friendly layout

### 6. Export HTML

Click "Export" to download ready-to-use HTML file

### 7. Regenerate (Optional)

Edit product details and click "Generate" again

### 8. View History

Browse all previously created sales pages

---

## 📁 Database Schema

### Users Table

```
Columns:
- id (primary key)
- name, email, password
- phone, address, city, country, postal_code
- profile_completion_percentage
- is_active, email_verified_at, verified_at
- last_login_at
- timestamps (created_at, updated_at)

Relationships:
- hasMany(SalesPage)
- belongsToMany(Role)
- belongsToMany(Permission)
```

### Sales_Pages Table

```
Columns:
- id (primary key)
- user_id (foreign key → Users)
- product_name, description, features
- target_audience, price
- unique_selling_point
- headline, subheadline, benefits
- features_breakdown, social_proof
- pricing_display, call_to_action
- timestamps (created_at, updated_at)

Relationships:
- belongsTo(User)
```

### Roles Table

```
Columns:
- id, name, guard_name
- timestamps

Predefined Roles:
- Admin
- Manager
- User
```

### Permissions Table

```
Columns:
- id, name, guard_name
- timestamps

Sample Permissions:
- manage users
- manage sales pages
- view reports
```

### Role & Permission Pivot Tables

```
- model_has_roles (links Users to Roles)
- model_has_permissions (links Users to Permissions)
- role_has_permissions (links Roles to Permissions)
```

---

## 🔑 Environment Variables

Copy `.env.example` to `.env` and configure these key variables:

### Application

```env
APP_NAME="AI Sales Page Generator"
APP_ENV=local                          # local, staging, production
APP_DEBUG=true                         # false in production
APP_KEY=base64:xxxxx                   # Generated by php artisan key:generate
APP_URL=http://localhost               # Your application URL
```

### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=                           # Leave empty if no password
```

### Google Gemini API

```env
GEMINI_API_KEY=your_api_key_here       # Get from https://aistudio.google.com/apikey
GEMINI_MODEL=gemini-3-flash-preview    # Model to use
```

### Session & Cache

```env
SESSION_DRIVER=database                # Database-backed sessions
SESSION_LIFETIME=120                   # Minutes
CACHE_STORE=database                   # Database-backed cache
```

### Queue & Jobs

```env
QUEUE_CONNECTION=database              # Use database for queued jobs
```

---

## 🐛 Troubleshooting

### Database Connection Error

```bash
# Check MySQL is running
mysql -u root -e "SHOW DATABASES;"

# Verify .env database credentials
cat .env | grep DB_

# Reconnect and try migrations again
php artisan migrate:fresh --seed
```

### Migrations Fail

```bash
# Reset and try again
php artisan migrate:reset --force
php artisan migrate --force

# Or use fresh (caution: deletes all data)
php artisan migrate:fresh --seed
```

### Gemini API Errors

- ✅ Verify API key in `.env` is correct
- ✅ Check API quota hasn't been exceeded
- ✅ Verify internet connection
- ✅ Check error logs: `storage/logs/laravel.log`

### Assets Not Loading

```bash
# Clear cache and rebuild assets
php artisan cache:clear
php artisan view:clear
php artisan config:cache

# Rebuild frontend
npm run dev
```

### Permissions Error

```bash
# Fix storage directory permissions
chmod -R 775 storage bootstrap/cache

# On macOS:
chmod -R 777 storage bootstrap/cache
```

### Class Not Found Error

```bash
# Regenerate Composer autoloader
composer dump-autoload

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📞 Support

If you encounter issues:

1. **Check Logs**: Review `storage/logs/laravel.log`
2. **Clear Cache**:
    ```bash
    php artisan cache:clear && php artisan view:clear
    ```
3. **Verify Setup**:
    ```bash
    php artisan config:cache
    composer install
    npm install
    ```
4. **Database Reset** (Development Only):
    ```bash
    php artisan migrate:fresh --seed
    ```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

**Last Updated**: April 28, 2026  
**Status**: ✅ Production Ready  
**Maintainer**: Development Team
