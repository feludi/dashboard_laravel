@echo off
echo ===================================
echo ImmiTrace Installation Checker
echo ===================================
echo.

echo Checking PHP version...
php -v >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ PHP found
    for /f "tokens=2 delims= " %%a in ('php -v ^| findstr "PHP"') do set php_version=%%a
    echo ✅ PHP version: %php_version%
) else (
    echo ❌ PHP not found - install XAMPP or PHP
)
echo.

echo Checking Composer...
composer --version >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Composer found
) else (
    echo ❌ Composer not found - download from getcomposer.org
)
echo.

echo Checking MySQL...
mysql --version >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ MySQL found
) else (
    echo ❌ MySQL not found - install XAMPP or MySQL
)
echo.

echo Checking Git...
git --version >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Git found
) else (
    echo ❌ Git not found - download from git-scm.com
)
echo.

echo Checking configuration...
if exist ".env" (
    echo ✅ .env file found
) else (
    echo ⚠️  .env file not found - copy from .env.example
)

if exist "vendor" (
    echo ✅ Vendor directory found
) else (
    echo ⚠️  Vendor directory not found - run 'composer install'
)
echo.

echo ===================================
echo Installation Check Complete
echo ===================================
echo.
echo Next steps:
echo 1. Fix any ❌ issues above
echo 2. Copy .env.example to .env
echo 3. Run 'composer install'
echo 4. Configure database in .env
echo 5. Run 'php artisan migrate --seed'
echo 6. Run 'php artisan serve'
echo.
pause
