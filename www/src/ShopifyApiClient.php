<?php

namespace StoreOAuth;

use Shopify\Auth\OAuth;
use Shopify\Clients\Rest;
use Shopify\Utils;
use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;

class ShopifyApiClient extends ShopifyApiInit
{

    const PATH = 'src/js/script.js';

    public static function auth(): void
    {
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
    public static function callback()
    {
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

        self::writeJs('chocoala', 1);

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
        file_put_contents($_ENV['FILE_NAME'], $session->getAccessToken());

        // Redirection after API install to own folder on the store
        header("Location: " . Utils::getEmbeddedAppUrl($_GET['host']));

        exit();
    }

    public static function writeJs($url, $active)
    {
        $script = file_get_contents(self::PATH);
        $data = explode(';', $script, 3);
        $data[0] = sprintf("let url = '%s'", $url);
        $data[1] = sprintf("\r\nlet showPopup = %d", $active);
        $newScript = implode(';', $data);
        file_put_contents(self::PATH, $newScript);
    }
}
