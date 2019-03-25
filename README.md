# Domotic Management - 0.1.0

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sineverba/domotic-management/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sineverba/domotic-management/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/sineverba/domotic-management/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sineverba/domotic-management/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/sineverba/domotic-management/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sineverba/domotic-management/build-status/master) [![Build Status](https://travis-ci.org/sineverba/domotic-management.svg?branch=master)](https://travis-ci.org/sineverba/domotic-management) [![codecov](https://codecov.io/gh/sineverba/domotic-management/branch/master/graph/badge.svg)](https://codecov.io/gh/sineverba/domotic-management) [![StyleCI](https://github.styleci.io/repos/177451340/shield?branch=master)](https://github.styleci.io/repos/177451340)

Domotic Management is a domotic panel, written in PHP with Laravel, that helps to manage a domotic installation.
It provides several features. See wiki for more details.

## Features
+ Get **public IP** of server

### Setup
+ Create a database
+ Fill the data in `.env.example`
+ Copy `.env.example` to `.env`
+ Run `php artisan db:migrate`

#### Contributions
All contributes are welcome! See CONTRIBUTING.md for more informations.

#### Testing
Run `composer test`.

If you get `permission denied` from `Phpunit`:

+ `sudo chmod 777 -R vendor`
+ `sudo chmod 777 /vendor/phpunit/phpunit/phpunit && chmod +x /vendor/phpunit/phpunit/phpunit`

If you use `PhpStorm`, you could access to Clover Code Coverage directly to [http://localhost:63342/domotic-management/logs/clover/index.html](http://localhost:63342/domotic-management/logs/clover/index.html)

#### Thanks to
[php-ipify](https://github.com/benjamin-smith/php-ipify)