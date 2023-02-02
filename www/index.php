<?php

require_once ("vendor/autoload.php");

use StoreOAuth\ShopifyApiClient;
use StoreOAuth\ShopifyAdminApi;

// loading credentials from .env with $_ENV['PARAM'] - https://github.com/vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(!file_exists($_ENV['FILE_NAME'])) {
    ShopifyApiClient::auth();
} else {
    require_once 'formLoader.php';
}
