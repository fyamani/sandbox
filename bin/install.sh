	#!/bin/bash
set -e

if [ -z "$1" ]; then
  env="dev"
else
  env=$1
fi

echo "##########################################################"

echo "Environment: " $env
echo ""

echo ">>> Cleanup cache and vendor"
rm -rf app/cache/*
rm -rf vendor

if [ ! -f composer.phar ]; then
    echo ">>> Downloading composer.phar"
    curl -s http://getcomposer.org/installer | php
fi

if [ ! -d vendor ]; then
    echo ">>> Installing dependencies"
    php composer.phar install
fi

echo ">>> Installing assets"
rm -Rf web/bundles
php app/console assets:install

echo ">>> Update Database"
php app/console doctrine:schema:update --force

echo ">>> Dumping assetic"
# rm -Rf web/{css,js}/*
php app/console assetic:dump web --env=$env
