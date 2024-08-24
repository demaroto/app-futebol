<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## App Futebol
Este projeto foi desenvolvido utilizando em Laravel 11, o propósito app é agendar as partidas de futebol.

### Instalação para ambiente de desenvolvimento (SQLite)
1. Duplique o arquivo .env.example e renomeie para .env
2. Crie o arquivo database.sqlite na pasta database do projeto, caso não exista.
3. Execute a criação das tabelas, com o comando abaixo no terminal:
```
php artisan migrate
```
4. Caso queira criar alguns usuários jogadores fake, execute o comando abaixo no terminal:
```
php artisan db:seed
```
5. Execute o servidor com o comando abaixo:
```
php artisan serve
``` 
6. Acesse no seu navegador:
[http://localhost:8000](http://localhost:8000)

