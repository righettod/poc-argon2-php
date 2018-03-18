## Introduction

This project is a prototype in order to materialize concepts described in the following OWASP cheatsheet, in *Leverage an adaptive one-way function* section in PHP technology:

https://www.owasp.org/index.php/Password_Storage_Cheat_Sheet#Leverage_an_adaptive_one-way_function


The objective is to propose a example of secure usage/integration of the **Argon2** algorithm in PHP application to protect password when stored by using:
* The [PHC reference implementation](https://github.com/P-H-C/phc-winner-argon2) of Argon2.
* The support for Argon2 from [PHP 7.2](https://wiki.php.net/rfc/argon2_password_hash).

It's the sibling project of this project : https://github.com/righettod/poc-argon2

This POC is under heavy work in progress...


## Notes

Focus on non-installing binaries from untrusted sources (non official linux repos - PHC Github repo for Argon2 is considered as trusted)

I have used Ubuntu 14 in order to test proposed configuration strenght capacities on TravisCI cloud environments.

The 3rd party linux repo `ondrej/php` provide pre-compiled packages for Argon2 and PHP 7.2 but I have decided to not trust it because is not an official repository.

Apparently even on Ubuntu 16, PHP 7.0 is the provided version so manual install is required or using `ondrej/php` repository


## Step 0: Install system dependencies

```
sudo apt-get install gcc clang libxml2-dev unzip wget curl make openssl libssl-dev
```


### Step 1: Install Argon2 from PHC release on Github repository and PHP 7.2 from sources with Argon2 option enabled

The following PHP compilation options are needed by Composer and PHPUnit and not for Argon2:
* `--with-openssl`
* `--enable-mbstring`
* `--enable-dom`
* `--enable-json`
* `--enable-xml`
* `--enable-libxml`

See this complete setup shell [script](setup-php-with-argon2ri.sh).


## Step 2: Install project dependencies and execute unit tests
```
composer install
vendor/phpunit/phpunit/phpunit password_util_testcase.php --colors=always --verbose
```


## References:

* https://wiki.php.net/rfc/argon2_password_hash
* https://framework.zend.com/blog/2017-08-17-php72-argon2-hash-password.html
* https://www.colinodell.com/blog/201711/installing-php-72
* http://php.net/supported-versions.php
