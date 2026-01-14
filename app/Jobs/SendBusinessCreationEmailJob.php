<?php

namespace App\Jobs;

use App\Models\GmeBusinessForm;
use App\Mail\BusinessCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBusinessCreationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $business;
    /**
     * Create a new job instance.
     */
    public function __construct(GmeBusinessForm $business)
    {
        $this->business = $business;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->business->customer->email)
            ->send(new BusinessCreatedMail($this->business));
    }
}
