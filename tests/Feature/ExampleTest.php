<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Integrations\Test\Requests\TestRequest;
use App\Http\Integrations\Test\TestConnector;
use Generator;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_config_with_send_async()
    {
        $connector = new TestConnector;
        $request = new TestRequest;

        dd($connector->sendAsync($request)->wait()->status());
    }

    public function test_saloon_concurrency(): void
    {
        $connector = new TestConnector;

        $connector->sender()->addMiddleware(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                // dump('Send Guzzle!');

                return $handler($request, $options);
            };
        });

        $connector->middleware()->onRequest(function () {
             // dump('Send!');
        });

        $connector->middleware()->onResponse(function () {
            // dump('response');
        });

        $requests = function () {
            for ($i = 0; $i < 1000; $i++) {
                yield new TestRequest;
            }
        };

        $pool = $connector->pool($requests(), 20);

        $count = 0;
        $responses = [];

        $pool->withResponseHandler(function ($value) use (&$count, &$responses) {
            $responses[] = $value?->body();
            $count++;
        });

        $pool->withExceptionHandler(function ($value) use (&$count) {
            ray($value);
        });

        $pool->send()->wait();

        dump($count);
        dump($responses);
    }
}
