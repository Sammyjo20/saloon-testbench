<?php

use App\Http\Integrations\Test\Requests\TestRequest;
use App\Http\Integrations\Test\TestConnector;
use App\Jobs\SendRequestJob;

test('send async with config', function () {
    SendRequestJob::dispatchSync();
});
