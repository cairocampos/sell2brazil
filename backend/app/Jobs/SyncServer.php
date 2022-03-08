<?php

namespace App\Jobs;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $service;

    public $tries = 4;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $service)
    {
        $this->order = $order;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            app($this->service)->handle($this->order);
        } catch (\Throwable $exception) {
            if ($this->attempts() > 3) {
                throw $exception;
            }
            $this->release(300);
            return;
        }
    }
}
