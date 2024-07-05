<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class SendMail extends Mailable
{
    public array $content;

    use Queueable, SerializesModels;
    public function __construct(array $content) {
        $this->content = $content;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->content['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->content['bladeName'],
        );
    }

    public function attachments(): array
    {
        $attachmentArray = [];
        foreach($this->content['attachments'] as $attachment) {
            $attachmentArray[] = Attachment::fromPath($attachment['path'])
                ->as($attachment['name'])
                ->withMime($attachment['mime']);
        }
        return $attachmentArray;
    }

}
