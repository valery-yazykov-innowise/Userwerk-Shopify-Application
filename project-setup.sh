#!/bin/bash

docker compose up --build
docker compose up -d

echo Enter your Shopify Api Key:

read shopify_api_key

echo Enter your Shopify Api Secret:

read shopify_api_secret

echo Enter your Shopify App Host Name:

read shopify_app_host_name

echo Enter your Shopify Store Name:

read shopify_store_name

cd www

composer install --ignore-platform-reqs

sudo mv .env.example .env

sudo cat > .env <<EOF
SHOPIFY_API_KEY=$shopify_api_key
SHOPIFY_API_SECRET=$shopify_api_secret
SHOPIFY_APP_SCOPES=write_script_tags,read_script_tags
SHOPIFY_APP_HOST_NAME=$shopify_app_host_name
STORE_NAME=$shopify_store_name
API_VERSION=2023-01
FILE_NAME=shopify-token.txt
EOF

docker exec -it php-apache chown -R www-data:www-data /var/www/

clear

echo Fill the fields in the Partners Shopify settings with these fields
echo 'App URL'
echo ''
echo $shopify_app_host_name
echo ''
echo 'Allowed redirection URL(s)'
echo ''
echo $shopify_app_host_name'/hookcallback.php'
echo $shopify_app_host_name'/authcallback.php'