<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticleControllerPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Article $article): bool
    {
        //
    }

    public function create(User $user): Response
    {
        return ($user->role == 'moderator') ?
            Response::allow() :
            Response::deny('Вы не модератор');
    }

    public function update(User $user, Article $article): bool
    {
        return ($user->role == 'moderator');
    }

    public function delete(User $user, Article $article): bool
    {
        //
    }

    public function restore(User $user, Article $article): bool
    {
        //
    }

    public function forceDelete(User $user, Article $article): bool
    {
        //
    }
}
