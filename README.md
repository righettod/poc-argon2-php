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

I have used Ubuntu 14 in order to test proposed configuration strengh capacities on TravisCI cloud environments.

The 3rd party linux repo `ondrej/php` provide pre-compiled packages for Argon2 and PHP7.2 but I have decided to not trust it because is not an official repository.

Apparently even on Ubuntu 16, PHP 7.0 is the provided version so manual install is required or using `ondrej/php` repository


## Step 0: Install system dependencies

```
sudo apt-get install gcc libxml2-dev unzip wget curl make openssl libssl-dev
```

## Step 1: Install Argon2 from PHC release on Github repository

```
wget https://github.com/P-H-C/phc-winner-argon2/archive/20171227.zip
unzip 20171227.zip
phc-winner-argon2-20171227
sudo make uninstall
make
make test
sudo make install
```

## Step 2: Install PHP7.2 from source with Argon2 option enabled

```
wget http://de2.php.net/get/php-7.2.3.tar.gz/from/this/mirror
mv mirror mirror.tgz
tar xf mirror.tgz
cd php-7.2.3
./configure --with-password-argon2=/usr/lib --with-openssl
sudo make clean
sudo make distclean
make
make test
sudo make install
```

## Step 3: Create a utility functions

*same like for java project.*

Done in class `password_util.php`

## Step 4: Create test cases

*Same like for java project.*

**TODO, i'm on it...**



## DOCS:

* https://wiki.php.net/rfc/argon2_password_hash
* https://framework.zend.com/blog/2017-08-17-php72-argon2-hash-password.html
* https://www.colinodell.com/blog/201711/installing-php-72
* http://php.net/supported-versions.php
