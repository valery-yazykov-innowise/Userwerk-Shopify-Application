<?php
namespace StoreOAuth;

use Shopify\Webhooks\Handler;

class ShopifyHandler implements Handler
{
    public function handle(string $topic, string $shop, array $body): void
    {
        // Handle your webhook here!

        if(file_exists("shopify-token.txt")) {
            unlink("shopify-token.txt");
        }
    }
}