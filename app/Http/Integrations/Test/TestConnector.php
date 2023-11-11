<?php

namespace App\Http\Integrations\Test;

use Saloon\Http\Connector;

class TestConnector extends Connector
{
    /**
     * @inheritDoc
     */
    public function resolveBaseUrl(): string
    {
        $url = config('services.test.url');

        return "https://$url";
    }
}
