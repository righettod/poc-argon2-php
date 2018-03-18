#!/bin/sh
export CDIR=`pwd`
ARGON2_RELEASE_NAME=20171227
PHP_RELEASE_NAME=7.2.3
echo "#### Install Argon2 from PHC release on Github repository ####"
cd $CDIR
wget https://github.com/P-H-C/phc-winner-argon2/archive/$ARGON2_RELEASE_NAME.zip
unzip $ARGON2_RELEASE_NAME.zip
cd phc-winner-argon2-$ARGON2_RELEASE_NAME
make
make test > tests-argon2-library.txt
TESTS_CONTAINS_ERROR=`grep -c FAIL tests-argon2-library.txt`
if [ "$TESTS_CONTAINS_ERROR" != "0" ]
then
    exit 1
fi
sudo make install
ls -l /usr/lib/*argon2*
echo "#### Install PHP 7.2 from sources with Argon2 option enabled ####"
cd $CDIR
wget http://de2.php.net/get/php-$PHP_RELEASE_NAME.tar.gz/from/this/mirror
mv mirror mirror.tgz
tar xf mirror.tgz
cd php-$PHP_RELEASE_NAME
./configure --with-password-argon2=/usr/lib --with-openssl --enable-mbstring --enable-dom --enable-json --enable-xml --enable-libxml
make
# make test
sudo make install
echo "#### Cleanup temporary stuff ####"
cd $CDIR
rm $ARGON2_RELEASE_NAME.zip
rm -rf phc-winner-argon2-$ARGON2_RELEASE_NAME
rm mirror.tgz
rm -rf php-$PHP_RELEASE_NAME
ls -l
