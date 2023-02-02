<?php
require_once ("vendor/autoload.php");

use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;
use StoreOAuth\ShopifyApiInit;
use StoreOAuth\ShopifyHandler;

// loading credentials from .env with $_ENV['PARAM'] - https://github.com/vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


try {

    ShopifyApiInit::init();
    Registry::addHandler(Topics::APP_UNINSTALLED, new ShopifyHandler());

    $response = Registry::process(getallheaders(), file_get_contents('php://input'));

    if ($response->isSuccess()) {

        // Respond with HTTP 200 OK
    } else {
        // The webhook request was valid, but the handler threw an exception

    }
} catch (\Exception $error) {
    // The webhook request was not a valid one, likely a code error or it wasn't fired by Shopify

}
