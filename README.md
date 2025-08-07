# ImmiTrace – Immigration Tracing and Mapping System

**Comprehensive Foreign Nationals Management System for Immigration Offices**  
A Laravel-based dashboard for tracking and visualizing foreign nationals data with interactive mapping capabilities.

![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [System Requirements](#-system-requirements)
- [Installation Guide](#-installation-guide)
- [Configuration](#-configuration)
- [Database Schema](#-database-schema)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)

## 🎯 Overview

ImmiTrace is a comprehensive web-based system designed for Immigration Offices to manage foreign nationals data with advanced features including:

- **Interactive mapping** with location visualization
- **Real-time analytics** and reporting
- **Automated permit status tracking** with expiry notifications
- **Multi-level user permissions** system
- **Excel import/export** functionality
- **Responsive design** optimized for all devices

## ✨ Features

### 🏛️ Core Immigration Features
- **Residence Permit Management**: Track ITK, ITAS, and ITAP permits
- **Automated Status Updates**: Daily scheduled checks for expiring permits
- **195+ Nationalities**: Complete nationality dropdown with proper validation
- **Document Management**: Passport and permit document tracking
- **Photo Management**: Upload and manage foreigner photos

### 📊 Analytics & Reporting
- **Interactive Dashboard**: Real-time statistics and charts
- **Geographical Distribution**: Location-based analytics
- **Permit Status Tracking**: Active, expiring, and expired permits monitoring
- **Nationality Statistics**: Distribution by country of origin
- **Age Demographics**: Age group analysis

### 🗺️ Interactive Mapping
- **Leaflet.js Integration**: High-performance map visualization
- **Location Markers**: Precise foreigner location mapping
- **Automatic Geocoding**: Address-to-coordinates conversion
- **Regional Focus**: Customizable for specific administrative areas
- **Click-to-Add**: Interactive map-based data entry

### 🛡️ Security & Authentication
- **Role-based Access Control**: Admin, operator, and viewer permissions
- **Session Management**: Secure authentication system
- **Data Validation**: Comprehensive input validation
- **Error Handling**: Graceful error management

### 📱 User Experience
- **Responsive Design**: Bootstrap 5.3 framework
- **Indonesian Localization**: Complete Indonesian language interface
- **Modern UI**: Clean, professional interface design
- **Mobile Optimization**: Touch-friendly mobile interface

## 🖥️ System Requirements

### Minimum Requirements
- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Node.js**: 16+ (for asset compilation)
- **PostgreSQL**: 12+ or higher
- **Apache/Nginx**: Web server
- **Git**: Version control system

### Recommended Environment
- **XAMPP with PostgreSQL**: For local development (or separate PostgreSQL installation)
- **VS Code**: Recommended IDE with PHP extensions
- **pgAdmin**: PostgreSQL administration tool
- **Postman**: For API testing (optional)

### PHP Extensions Required
```
- OpenSSL PHP Extension
- PDO PHP Extension  
- PDO PostgreSQL Extension (pdo_pgsql)
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- Fileinfo PHP Extension
- GD PHP Extension (for image processing)
```

## 🚀 Installation Guide

### Step 1: Clone the Repository

```bash
# Clone the project
git clone https://github.com/feludi/dashboard_laravel.git
cd dashboard_laravel

# Or download ZIP and extract
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies (if using Vite/Mix)
npm install

# Generate application key
php artisan key:generate
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Edit .env file with your database credentials
```

**Configure `.env` file:**
```bash
APP_NAME="ImmiTrace Dashboard"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=foreigner_dashboard
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### Step 4: Database Setup

```bash
# Create database using psql command line
psql -U postgres -h localhost

# In PostgreSQL shell:
CREATE DATABASE foreigner_dashboard;
CREATE USER laravel_user WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE foreigner_dashboard TO laravel_user;
\q

# Or using pgAdmin GUI:
# 1. Open pgAdmin
# 2. Create new database: foreigner_dashboard
# 3. Create user: laravel_user with appropriate permissions

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

### Step 5: Storage Configuration

**Important**: The storage directory structure is automatically preserved when you clone this repository (via `.gitignore` files in each directory). If you experience 500 errors related to missing storage directories, they should already be present.

```bash
# Create symbolic link for storage (required for file uploads)
php artisan storage:link

# Set proper permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows (run as administrator)
# The project should work without additional permission changes

# If you still get storage-related errors, manually create directories:
# mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views
# mkdir -p storage/app/public storage/logs bootstrap/cache
```

### Step 6: Start the Application

```bash
# Development server
php artisan serve

# Specific port
php artisan serve --port=8001

# Access via browser
http://localhost:8000 (or your configured port)
```

## ⚙️ Configuration

### Default User Accounts

**Administrator Account:**
- **Username**: `admin`
- **Password**: `password123`
- **Permissions**: Full system access

**Operator Account:**
- **Username**: `operator`
- **Password**: `password123`
- **Permissions**: Add and import data

## 💾 Database Schema

### Core Tables

**foreigners** - Main foreign nationals data
```sql
- id (Primary Key)
- first_name, last_name
- nationality, passport_number
- residence_permit_type, residence_permit_expiry_date
- current_address, city, state_province, village
- latitude, longitude
- status (active, expiring_soon, expired, etc.)
- created_at, updated_at
```

**users** - System users
```sql
- id (Primary Key)
- username, password
- role (admin, operator, viewer)
- created_at, updated_at
```

## 🐛 Troubleshooting

### Common Issues

**1. Database Connection Error**
```bash
# Check database credentials in .env
# Ensure PostgreSQL service is running
# Test connection:
php artisan tinker
DB::connection()->getPdo();

# Check PostgreSQL service status:
# Windows: Check Services or use: pg_ctl status
# Linux: sudo systemctl status postgresql
```

**2. Permission Denied Errors**
```bash
# Linux/Mac
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Windows
# Run terminal as administrator
```

**3. Key Generation Issues**
```bash
php artisan key:generate --force
```

**4. Clear Caches**
```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework Team
- OpenStreetMap Contributors
- Bootstrap Team
- Leaflet.js Team

---

**© 2025 ImmiTrace – Immigration Tracing and Mapping System**  
*Professional Immigration Management Solution*
