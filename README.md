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
- [Usage](#-usage)
- [Database Schema](#-database-schema)
- [API References](#-api-references)
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

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dashboard_laravel_db
DB_USERNAME=postgres
DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Step 4: Database Setup

```bash
# Create database using psql command line
psql -U postgres -h localhost

# In PostgreSQL shell:
CREATE DATABASE dashboard_laravel_db;
CREATE USER laravel_user WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE dashboard_laravel_db TO laravel_user;
\q

# Or using pgAdmin GUI:
# 1. Open pgAdmin
# 2. Create new database: dashboard_laravel_db
# 3. Create user: laravel_user with appropriate permissions

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

### Step 5: Storage Configuration

```bash
# Create symbolic link for storage
php artisan storage:link

# Set proper permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows (run as administrator)
# The project should work without additional permission changes
```

### Step 6: Configure Scheduled Tasks (Optional)

Add to your system's cron tab (Linux/Mac) or Task Scheduler (Windows):

```bash
# Linux/Mac crontab
* * * * * cd /path/to/dashboard_laravel && php artisan schedule:run >> /dev/null 2>&1

# Windows Task Scheduler
# Create a task that runs: php artisan schedule:run
# Set to run every minute
```

### Step 7: Start the Application

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

### System Configuration

**Cache Management:**
```bash
# Clear all caches
php artisan optimize:clear

# Individual cache clearing
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
```

**Asset Compilation:**
```bash
# Development
npm run dev

# Production
npm run build
```

### Database Seeding

The system includes comprehensive seeders:

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ForeignerSeeder
php artisan db:seed --class=RegionSeeder
```

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

**regions** - Administrative regions
```sql
- id (Primary Key)
- name, type (city, district, village)
- parent_id (for hierarchical structure)
- coordinates (optional)
```

## 🔧 API References

### REST Endpoints

**Authentication:**
```
POST /login - User login
POST /logout - User logout
GET /profile - Get current user profile
```

**Foreigners Management:**
```
GET /foreigners - List all foreigners
POST /foreigners - Create new foreigner
GET /foreigners/{id} - Get specific foreigner
PUT /foreigners/{id} - Update foreigner
DELETE /foreigners/{id} - Delete foreigner
```

**Dashboard & Analytics:**
```
GET /dashboard - Dashboard view
GET /dashboard/analytics - Analytics data
GET /dashboard/map - Map data
```

**Import/Export:**
```
POST /imports - Import Excel file
GET /exports - Export data to Excel
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

**3. Composer Dependencies**
```bash
# Update dependencies
composer update

# Clear autoload
composer dump-autoload

# Install missing extensions (Ubuntu example)
sudo apt-get install php8.2-mbstring php8.2-xml php8.2-gd php8.2-pgsql

# Windows: Enable extensions in php.ini
# extension=pdo_pgsql
# extension=pgsql
```

**4. Key Generation Issues**
```bash
php artisan key:generate --force
```

**5. Migration Errors**
```bash
# Reset database
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

**6. Map Not Loading**
- Check internet connection (required for OpenStreetMap tiles)
- Verify coordinates data in database
- Check browser console for JavaScript errors

**7. Import/Export Issues**
- Ensure `storage/app` directory is writable
- Check file size limits in `php.ini`
- Verify Excel file format compatibility

### Performance Optimization

**Database Optimization:**
```bash
# Optimize database tables
php artisan optimize

# Create database indexes (if needed)
# Add indexes for frequently queried columns
```

**Cache Configuration:**
```bash
# Enable route caching (production)
php artisan route:cache

# Enable config caching (production)
php artisan config:cache

# Enable view caching (production)
php artisan view:cache
```

### Log Files

Check log files for detailed error information:
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Web server logs (Apache/Nginx)
# Check your web server's error log location
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write comprehensive tests
- Update documentation for new features
- Use semantic commit messages

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework Team
- OpenStreetMap Contributors
- Bootstrap Team
- Font Awesome Team
- Chart.js Team
- Leaflet.js Team

## 📞 Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Review troubleshooting section

---

**© 2025 ImmiTrace – Immigration Tracing and Mapping System**  
*Professional Immigration Management Solution*
