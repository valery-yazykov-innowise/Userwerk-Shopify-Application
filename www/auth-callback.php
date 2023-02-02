<?php
require_once ("vendor/autoload.php");

use StoreOAuth\ShopifyApiClient;

// loading credentials from .env with $_ENV['PARAM'] - https://github.com/vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

ShopifyApiClient::callback();

