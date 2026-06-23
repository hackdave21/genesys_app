<?php

namespace App\Mail;

use App\Models\ContentIdea;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContentIdeaMail extends Mailable
{
    use Queueable, SerializesModels;

    public ContentIdea $idea;

    public function __construct(ContentIdea $idea)
    {
        $this->idea = $idea;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vos idées de contenu — Inspira',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inspira.content-idea',
        );
    }
}
