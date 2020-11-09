# My File - Template Scutum

## Very Quick start Install
- git clone 'https://gitlab.com/iqbaltc13/tes_digimaasia.git'
- composer install
- composer run-script post-root-package-install
- setting .env copy from .env.example
- php artisan migrate
- php artisan key:generate
- php artisan passport:install --force
- php artisan db:seed --class=DatabaseSeeder

## Permission
- chmod -R 775 storage
- chmod -R 775 bootstrap/cache
- chmod -R 775 public/uploads