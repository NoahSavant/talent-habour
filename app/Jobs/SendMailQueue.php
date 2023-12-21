<?php

namespace App\Jobs;

use App\Constants\AuthenConstant\SendCodeType;
use App\Mail\VerifyCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMailQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $type;

    public function __construct($user, $type=SendCodeType::ACTIVE)
    {
        $this->user = $user;
        $this->type = $type;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new VerifyCodeMail($this->user, $this->type));
    }
}
