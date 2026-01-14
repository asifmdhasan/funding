<?php

namespace App\Jobs;

use App\Mail\LowStockMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $email;
    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (isset($this->data['mail_name'], $this->data['variant'], $this->data['warehouseStock']) &&
            $this->data['mail_name'] === 'low_stock_notify') 
        {
            Mail::to($this->email)->send(
                new LowStockMail($this->data['variant'], $this->data['warehouseStock'])
            );
        }
    }
}
