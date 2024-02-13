# stripe-payment
Payment Integration using Stripe API implemented in Laravel

Steps performed

php artisan make:migration create_products_table --create=products
php artisan migrate


php artisan make:seeder ProductSeeder
php artisan db:seed --class=ProductSeeder

php artisan make:controller ProductController

generate views

Cashier Installation
composer require laravel/cashier
php artisan vendor:publish --tag="cashier-migrations"
php artisan migrate


