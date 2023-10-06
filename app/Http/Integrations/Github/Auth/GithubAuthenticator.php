<?php

namespace App\Http\Integrations\Github\Auth;

use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class GithubAuthenticator implements Authenticator
{
    public function __construct()
    {
        //
    }

    /**
     * Apply the authentication to the request.
     */
    public function set(PendingRequest $pendingRequest): void
    {
        //
    }
}
