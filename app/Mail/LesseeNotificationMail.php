<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LesseeNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $contentBody;
    protected $viewName;

    public function __construct($subjectLine, $contentBody, $viewName)
    {
        $this->subjectLine = $subjectLine;
        $this->contentBody = $contentBody;
        $this->viewName = $viewName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->viewName,
            with: [
                'body' => $this->contentBody,
                'subjectLine' => $this->subjectLine,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}