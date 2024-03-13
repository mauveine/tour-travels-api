<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup

### Requirements
- php: `^8.1`
- composer: `^2.0`

### Composer
Install the project install all packages:
```shell
composer install
```

### Project start
Run the following commands to have a functional project:
```shell
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```
To start a local server to process API run the following command
```shell
php artisan serve
```

### Project tests
To run all the tests run the following command:
```shell
php artisan test
```

#### Coverage
To check the project's coverage run the following command (`xDebug required`):
```shell
XDEBUG_MODE=coverage php artisan test --coverage
```
### Linter and static analysis
#### Laravel Pint
Laravel Pint is an opinionated PHP code style fixer. To run it:
```shell
./vendor/bin/pint --preset laravel
```

To only check without actually making changes run:
```shell
./vendor/bin/pint --preset laravel --test
```

#### Rector
Rector instantly upgrades and refactors the PHP code.
```shell
./vendor/bin/rector
```

To run it without actually making the changes (for preview), run the following command:
```shell
./vendor/bin/rector --dry-run
```

## Business Logic
The business logic and requirements can be found [in this document](docs/README.md).

### Main endpoints
Main endpoints can be [found here](docs/endpoints.md).

### All Endpoints
Here is a list of endpoints that are available for the API:
```
POST            api/auth ......................................................... AuthController@auth
POST            api/travel ..................................... travel.store › TravelController@store
GET|HEAD        api/travel/{travel} .............................. travel.show › TravelController@show
PUT|PATCH       api/travel/{travel} .......................... travel.update › TravelController@update
DELETE          api/travel/{travel} ........................ travel.destroy › TravelController@destroy
POST            api/travel/{travel}/tour ..................... tour.store › TravelTourController@store
GET|HEAD        api/travel/{travel}/tour .................................. TravelTourController@index
GET|HEAD        api/travel/{travel}/tour/{tour} ................ tour.show › TravelTourController@show
PUT|PATCH       api/travel/{travel}/tour/{tour} ............ tour.update › TravelTourController@update
DELETE          api/travel/{travel}/tour/{tour} .......... tour.destroy › TravelTourController@destroy
```
