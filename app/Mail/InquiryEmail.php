<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $email =  $this->subject($this->data['subject'])
            ->view('email.templates.inquiry')
            ->with('data', $this->data);

        if (isset($this->data['bcc']) && !empty($this->data['bcc'])) {
            $email->bcc($this->data['bcc']);
        }

        return $email;
    }
}
