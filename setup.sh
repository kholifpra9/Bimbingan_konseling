#!/bin/bash

echo "========================================"
echo "   SISTEM BIMBINGAN KONSELING SETUP"
echo "========================================"
echo

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[$1/12]${NC} $2"
}

print_error() {
    echo -e "${RED}ERROR:${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}WARNING:${NC} $1"
}

# Check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

print_status 1 "Checking PHP..."
if ! command_exists php; then
    print_error "PHP tidak ditemukan! Install PHP terlebih dahulu."
    exit 1
fi
php --version

print_status 2 "Checking Composer..."
if ! command_exists composer; then
    print_error "Composer tidak ditemukan! Install Composer terlebih dahulu."
    exit 1
fi
composer --version

print_status 3 "Installing PHP dependencies..."
if ! composer install; then
    print_error "Gagal install PHP dependencies!"
    exit 1
fi

print_status 4 "Installing JavaScript dependencies..."
if ! npm install; then
    print_error "Gagal install JavaScript dependencies!"
    exit 1
fi

print_status 5 "Copying environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "File .env berhasil dibuat!"
else
    echo "File .env sudah ada, skip..."
fi

print_status 6 "Generating application key..."
php artisan key:generate

print_status 7 "Creating storage link..."
php artisan storage:link

print_status 8 "Building assets..."
npm run build

print_status 9 "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

print_status 10 "Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

print_status 11 "Setup completed!"
echo

echo "========================================"
echo "   LANGKAH SELANJUTNYA:"
echo "========================================"
echo "1. Edit file .env untuk konfigurasi database"
echo "2. Buat database: CREATE DATABASE bimbingan_konseling;"
echo "3. Jalankan: php artisan migrate"
echo "4. Jalankan: php artisan db:seed"
echo "5. Jalankan: php artisan serve"
echo
echo "Baca INSTALLATION_GUIDE.md untuk detail lengkap!"
echo "========================================"
