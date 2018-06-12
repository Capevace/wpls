# WordPress License Server

cd system
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan db:seed --class=TestUserSeeder