<?php

namespace App\Jobs;

use App\Http\Integrations\Test\Requests\TestRequest;
use App\Http\Integrations\Test\TestConnector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Saloon\Http\Connector;

class SendRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Connector $connector;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->connector = new TestConnector;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = new TestRequest;

        dd($this->connector->sendAsync($request)->wait());
    }
}
