<?php

namespace App\Http\Integrations\Test\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class TestRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/user';
    }
}
