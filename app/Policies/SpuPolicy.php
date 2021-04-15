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
     * Determine whether the user can view any spus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Spu  $spu
     * @return mixed
     */
    public function view(User $user, Spu $spu)
    {
        //
    }

    /**
     * Determine whether the user can create spus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Spu  $spu
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
     * @param  \App\Spu  $spu
     * @return mixed
     */
    public function delete(User $user, Spu $spu)
    {
        if ($user->id === $spu->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Spu  $spu
     * @return mixed
     */
    public function restore(User $user, Spu $spu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the spu.
     *
     * @param  \App\User  $user
     * @param  \App\Spu  $spu
     * @return mixed
     */
    public function forceDelete(User $user, Spu $spu)
    {
        //
    }
}
