#!/bin/bash
echo "backend entrypoint.sh starting..."
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
  echo "Creating env files"
  cp .env.example .env
else
      echo "Env file exists"
fi

echo "backend php artisan commands starting..."
#If APP_ENV is production skip generating the key
if [ "$APP_ENV" != "production" ]; then
    echo "Generating key"
    php artisan key:generate
fi

echo "Running artisan migrate"
php artisan migrate #--force

echo "Running artisan db:seed"
php artisan db:seed #--force

echo "Running artisan cache:clear"
php artisan cache:clear

echo "Running artisan config:clear"
php artisan config:clear

echo "backend php artisan commands completed!"

exec docker-php-entrypoint "$@"

echo "backend entrypoint.sh completed!"
