#!/bin/bash

# ImmiTrace Installation Verification Script
# This script checks if all requirements are met for ImmiTrace installation

echo "==================================="
echo "ImmiTrace Installation Checker"
echo "==================================="
echo ""

# Check PHP version
echo "🔍 Checking PHP version..."
php_version=$(php -v 2>/dev/null | head -n 1 | cut -d " " -f 2 | cut -d "." -f 1,2)
if [ $? -eq 0 ]; then
    echo "✅ PHP $php_version found"
    if [ "$(echo $php_version | cut -d. -f1)" -ge 8 ] && [ "$(echo $php_version | cut -d. -f2)" -ge 2 ]; then
        echo "✅ PHP version requirement met (8.2+)"
    else
        echo "❌ PHP 8.2+ required, found $php_version"
    fi
else
    echo "❌ PHP not found"
fi
echo ""

# Check Composer
echo "🔍 Checking Composer..."
composer_version=$(composer --version 2>/dev/null | head -n 1)
if [ $? -eq 0 ]; then
    echo "✅ Composer found: $composer_version"
else
    echo "❌ Composer not found"
fi
echo ""

# Check MySQL
echo "🔍 Checking MySQL..."
mysql_version=$(mysql --version 2>/dev/null)
if [ $? -eq 0 ]; then
    echo "✅ MySQL found: $mysql_version"
else
    echo "❌ MySQL not found (install XAMPP or MySQL separately)"
fi
echo ""

# Check Git
echo "🔍 Checking Git..."
git_version=$(git --version 2>/dev/null)
if [ $? -eq 0 ]; then
    echo "✅ Git found: $git_version"
else
    echo "❌ Git not found"
fi
echo ""

# Check PHP extensions
echo "🔍 Checking PHP extensions..."
extensions=("pdo" "mbstring" "tokenizer" "xml" "ctype" "json" "bcmath" "fileinfo" "gd" "openssl")
for ext in "${extensions[@]}"; do
    if php -m | grep -i $ext > /dev/null; then
        echo "✅ $ext extension found"
    else
        echo "❌ $ext extension missing"
    fi
done
echo ""

# Check if .env exists
echo "🔍 Checking configuration..."
if [ -f ".env" ]; then
    echo "✅ .env file found"
else
    echo "⚠️  .env file not found - copy from .env.example"
fi
echo ""

# Check if vendor directory exists
if [ -d "vendor" ]; then
    echo "✅ Vendor directory found"
else
    echo "⚠️  Vendor directory not found - run 'composer install'"
fi
echo ""

echo "==================================="
echo "Installation Check Complete"
echo "==================================="
echo ""
echo "Next steps:"
echo "1. Fix any ❌ issues above"
echo "2. Copy .env.example to .env"
echo "3. Run 'composer install'"
echo "4. Configure database in .env"
echo "5. Run 'php artisan migrate --seed'"
echo "6. Run 'php artisan serve'"
echo ""
