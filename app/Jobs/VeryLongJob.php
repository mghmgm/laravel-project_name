<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NewCommentMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Comment;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Comment $comment, protected $article_name){}

    public function handle(): void
    {
        Mail::to('irina.yaltantseva@mail.ru')->send(new NewCommentMail($this->comment, $this->article_name));
    }
}
