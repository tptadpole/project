<?php

namespace App\Policies;

use App\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can update the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        if ($user->id === $comment->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        if ($user->id === $comment->users_id) {
            return true;
        }
        return false;
    }
}
