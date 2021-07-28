<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Chạy composer và npm để cài đặt các gói cần thiết trong dự án
composer install <br>
npm install

## thực hiện lệnh sau để copy ra file env:
cp .env.example .env

## Cập nhật file env của bạn như sau:
DB_CONNECTION=mysql          
DB_HOST=127.0.0.1            
DB_PORT=3306                 
DB_DATABASE=laravel-5-boilerplate       
DB_USERNAME=root             
DB_PASSWORD=

## Tạo ra các bảng và dữ liệu mẫu cho database
php artisan migrate
php artisan db:seed

## Để xử lý mã hóa mã thông báo, hãy tạo khóa bí mật bằng cách thực hiện lệnh sau.

php artisan jwt:secret
