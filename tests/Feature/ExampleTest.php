<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Integrations\Test\Requests\TestRequest;
use App\Http\Integrations\Test\TestConnector;
use Generator;
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

    public function test_saloon_concurrency(): void
    {
        $connector = new TestConnector;

        $requests = function () {
            for ($i = 0; $i < 100; $i++) {
                yield new TestRequest;
            }
        };

        $pool = $connector->pool($requests(), 10);

        $count = 0;

        $pool->withResponseHandler(function ($value) use (&$count) {
            // dump($value);
            $count++;
        });

        $pool->send()->wait();

        dump($count);
    }
}
