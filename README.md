<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Backend: Laravel 11 / PHP 8.2+
Frontend: Bootstrap 5  y Axios 
Base de datos: MySQL 

para ejecutarse necesitas:
XAMPP intalado, encender Apache y MySQL
Composer instalado
Git instalado

comandos a ejecutar en la terminar para instalar:

    git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git
    cd TU_REPOSITORIO
    composer install
    cp .env.example .env
    php artisan key:generate

configura la base de datos en XAMPP
    inicia apache y MySQL
    Entra a http://localhost/phpmyadmin y crea una base de datos llamada agenda_db
    En  .env,  la configuración debe ser:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=agenda_db
        DB_USERNAME=root
        DB_PASSWORD=

migracion ejecuta los siguientes comandos en vs
    php artisan migrate
    php artisan serve

