<?php

require_once ("vendor/autoload.php");

use StoreOAuth\ShopifyApiClient;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

ShopifyApiClient::writeJs($_POST['url'], $_POST['show-popup']);

require_once 'formLoader.php';