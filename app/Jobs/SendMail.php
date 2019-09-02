<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $mailClass;

    public function __construct($to, $mailClass)
    {
        $this->to = $to;
        $this->mailClass = $mailClass;
    }

    public function handle()
    {
        Mail::to($this->to)->send($this->mailClass);
    }
}
