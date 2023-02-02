<?php

namespace StoreOAuth;

use Shopify\Auth\OAuth;
use Shopify\Clients\Rest;
use Shopify\Utils;
use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;
//use StoreOAuth\ShopifyHandler;

class ShopifyApiClient extends ShopifyApiInit
{

    public static function auth(): void {
        parent::init();

        $uri = OAuth::begin(
            $_ENV['STORE_NAME'],
            "auth-callback.php",
            true
        );

        // Sending request to plugin install
        header("Location: " . $uri);
        exit();
    }


    // Callback registration //
    public static function callback() {
        parent::init();

        $session = OAuth::callback($_COOKIE, $_GET);

        $response = Registry::register(
            'hook-callback.php',
            Topics::APP_UNINSTALLED,
            $session->getShop(),
            $session->getAccessToken(),
        );


        if ($response->isSuccess()) {
            // Webhook registered!
        } else {
        }

        $response = Registry::register(
            'hook-callback.php',
            Topics::ORDERS_CREATE,
            $session->getShop(),
            $session->getAccessToken(),
        );


        if ($response->isSuccess()) {
            // Webhook registered!
        }

        //restart js file
        $script = file_get_contents('src/js/script.js');
        $data = explode(';',$script, 3);
        $data[0] = sprintf('let url = "%s"', "chocoala");
        $data[1] = sprintf('let showPopup = %s', 1);
        $newScript = implode(';', $data);
        file_put_contents('src/js/script.js', $newScript);

        // initialize ScripTag API
        $client = new Rest($session->getShop(), $session->getAccessToken());
        $client->post('script_tags', [
            "script_tag" => [
                "event" => "onload",
                "display_scope" => "order_status",
                "src" => $_ENV['SHOPIFY_APP_HOST_NAME'] . "/src/js/script.js",
            ],
        ]);


        // Create the file with application token
        file_put_contents( $_ENV['FILE_NAME'], $session->getAccessToken() );

        // Redirection after API install to own folder on the store
        header("Location: " . Utils::getEmbeddedAppUrl($_GET['host']) );

    }
}
