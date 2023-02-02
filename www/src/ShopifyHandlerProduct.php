<?php
namespace StoreOAuth;

use Shopify\Webhooks\Handler;

class ShopifyHandlerProduct implements Handler
{

    public function handle(string $topic, string $shop, array $body): void
    {
        // Handle your webhook here!
    }

}
