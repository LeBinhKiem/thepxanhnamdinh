echo "Start init system ..."
composer install
cp .env.example .env
php artisan key:generate
npm install

echo "1. Run webpack..."
npm run render
npm run module-dev --name=Base
npm run module-dev --name=Auth
npm run module-dev --name=Accounts

echo "2. Run migration"
php artisan migrate

echo "3. run Seeder"
#Keywords
php artisan db:seed --class=Modules\\Accounts\\Database\\Seeders\\AdminSeeder
php artisan db:seed --class=Modules\\Products\\Database\\Seeders\\BlogCategoriesSeeder
php artisan db:seed --class=Modules\\Sell\\Database\\Seeders\\CategorySeeder

echo "Finish webpack!"
