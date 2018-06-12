# WordPress License Server

cd system
composer install --optimize-autoloader --no-dev

php artisan wpls:setup
php artisan wpls:finish