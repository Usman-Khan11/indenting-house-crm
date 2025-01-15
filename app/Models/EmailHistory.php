<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    use HasFactory;
    protected $table = "email_history";

    protected static function booted()
    {
        static::created(function ($email_history) {
            $imapHost = $email_history->user->imap_setting['host'];
            $imapUsername = $email_history->user->imap_setting['username'];
            $imapPassword = $email_history->user->imap_setting['password'];

            saveMailToSentFolder(
                @$email_history->to[0],
                $email_history->subject,
                $email_history->content,
                $imapHost,
                $imapUsername,
                $imapPassword
            );
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'to' => 'array'
    ];
}
