#!/bin/sh
export CDIR=`pwd`
echo "#### Install Argon2 from PHC release on Github repository ####"
cd $CDIR
RELEASE_NAME=20171227
wget https://github.com/P-H-C/phc-winner-argon2/archive/$RELEASE_NAME.zip
unzip $RELEASE_NAME.zip
cd phc-winner-argon2-$RELEASE_NAME
sudo make uninstall
make clean
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
wget http://de2.php.net/get/php-7.2.3.tar.gz/from/this/mirror
mv mirror mirror.tgz
tar xf mirror.tgz
cd php-7.2.3
./configure --with-password-argon2=/usr/lib --with-openssl --enable-mbstring --enable-dom --enable-json --enable-xml --enable-libxml
sudo make clean
sudo make distclean
make
make test
sudo make install
