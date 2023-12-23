<?php

namespace App\Mail;

use App\Constants\AuthenConstant\SendCodeType;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $type;

    public function __construct($user, $type)
    {
        $this->user = $user;
        $this->type = $type;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $accountVerify = $this->user->accountVerify;

        $view = 'emails.active-account';
        if ($this->type === SendCodeType::SEND_CODE) {
            $view = 'emails.send-verify-code';
        }

        return new Content(
            view: $view,
            with: [
                'name' => $this->user->name,
                'verifyCode' => $accountVerify->verify_code,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
