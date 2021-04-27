<?php

namespace App\Policies;

use App\Models\Spu;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpuPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can index the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Spu  $spu
     * @return mixed
     */
    public function index(User $user, Spu $spu)
    {
        if ($user->id === $spu->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Spu  $spu
     * @return mixed
     */
    public function update(User $user, Spu $spu)
    {
        if ($user->id === $spu->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Spu  $spu
     * @return mixed
     */
    public function delete(User $user, Spu $spu)
    {
        if ($user->id === $spu->users_id) {
            return true;
        }
        return false;
    }
}
