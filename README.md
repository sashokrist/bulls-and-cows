<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



## Bulls and Cows

How to run

git clone git@github.com:sashokrist/bulls-and-cows.git

composer install

cp .env.example .env

php artisan key:generate

Set database credentials in .env

php artisan migrate

php artisan serve

npm run dev

The digits in use should have the following limitation:
- if in use, digits 1 and 8 should be right next to each other
- if in use, digits 4 and 5 shouldn't be on even index / position

