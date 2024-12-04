<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\Comment;
use App\Models\Article;

class NewCommentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $article;

    public function __construct(protected Comment $comment, protected $article_name){}


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'New Comment Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newcomment',
            with: [
                'text_comment'=>$this->comment->desc,
                'article_name'=>$this->article_name,
                'url'=>'http://127.0.0.1:3000/comment/'.$this->comment->id.'/accept',
            ]
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path().'/preview.jpg'),
        ];
    }
}