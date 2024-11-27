<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
use App\Models\Comment;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        Gate::before(function(User $user) {
            if($user->role == 'moderator') return true;
        });
        Gate::define('update_comment', function(User $user, Comment $comment) {
            if ($user->id == $comment->user_id) {
                return Response::allow();
            } else {
                return Response::deny('Вы не являетесь автором комментария');
            }
        });
    }
}
