#!/bin/bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate:fresh --seed
npm install
npm run build
npm run dev
php artisan serve --host=0.0.0.0 --port=$PORT
