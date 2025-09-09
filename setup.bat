@echo off
echo ========================================
echo   SISTEM BIMBINGAN KONSELING SETUP
echo ========================================
echo.

echo [1/12] Checking PHP...
php --version
if %errorlevel% neq 0 (
    echo ERROR: PHP tidak ditemukan! Install PHP terlebih dahulu.
    pause
    exit /b 1
)

echo [2/12] Checking Composer...
composer --version
if %errorlevel% neq 0 (
    echo ERROR: Composer tidak ditemukan! Install Composer terlebih dahulu.
    pause
    exit /b 1
)

echo [3/12] Installing PHP dependencies...
composer install
if %errorlevel% neq 0 (
    echo ERROR: Gagal install PHP dependencies!
    pause
    exit /b 1
)

echo [4/12] Installing JavaScript dependencies...
npm install
if %errorlevel% neq 0 (
    echo ERROR: Gagal install JavaScript dependencies!
    pause
    exit /b 1
)

echo [5/12] Copying environment file...
if not exist .env (
    copy .env.example .env
    echo File .env berhasil dibuat!
) else (
    echo File .env sudah ada, skip...
)

echo [6/12] Generating application key...
php artisan key:generate

echo [7/12] Creating storage link...
php artisan storage:link

echo [8/12] Building assets...
npm run build

echo [9/12] Clearing cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo [10/12] Setting permissions...
if exist storage (
    echo Setting storage permissions...
)

echo [11/12] Setup completed!
echo.
echo ========================================
echo   LANGKAH SELANJUTNYA:
echo ========================================
echo 1. Edit file .env untuk konfigurasi database
echo 2. Buat database: CREATE DATABASE bimbingan_konseling;
echo 3. Jalankan: php artisan migrate
echo 4. Jalankan: php artisan db:seed
echo 5. Jalankan: php artisan serve
echo.
echo Baca INSTALLATION_GUIDE.md untuk detail lengkap!
echo ========================================

pause
