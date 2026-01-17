<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ApiCheck implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $numero_id, private string $numero_cnaas)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //communicate with api
        sleep(5);

        //comunicate cnaas api
        sleep(4);

        info('terminated job');
    }
}
