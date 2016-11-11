<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manager(User $user, Comment $comment)
    {
        return isAdmin($user) || $user->id == $comment->user_id;
    }

    public function restore(User $user, Comment $comment)
    {
        return isAdmin($user);
    }
}
