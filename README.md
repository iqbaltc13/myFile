# Laravel 6.2 - Template Scutum

## Very Quick start
- git clone 'https://gitlab.com/artcak/starterProject/web/laravel6.2-scutum.git'
- composer install
- composer run-script post-root-package-install
- setting .env
- php artisan migrate
- php artisan key:generate
- php artisan passport:install --force
- php artisan db:seed --class=DatabaseSeeder

## Permission
- chmod -R 775 storage
- chmod -R 775 bootstrap/cache
- chmod -R 775 public/uploads