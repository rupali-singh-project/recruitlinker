<?php

namespace App\Http\Traits;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

trait MailUtils
{

    public function send_mail($mailData)
    {
        if (!isset($mailData['attachments']))
            $mailData['attachments'] = [];
        Mail::to($mailData['to'])->send(new SendMail($mailData));
        //check mails at https://mailtrap.io/signin
    }
}
