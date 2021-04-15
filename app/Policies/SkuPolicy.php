<?php

namespace App\Policies;

use App\Models\Sku;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkuPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any skus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the sku.
     *
     * @param  \App\User  $user
     * @param  \App\Sku  $sku
     * @return mixed
     */
    public function view(User $user, Sku $sku)
    {
        //
    }

    /**
     * Determine whether the user can create skus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the sku.
     *
     * @param  \App\User  $user
     * @param  \App\Sku  $sku
     * @return mixed
     */
    public function update(User $user, Sku $sku)
    {
        if ($user->id === $sku->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the sku.
     *
     * @param  \App\User  $user
     * @param  \App\Sku  $sku
     * @return mixed
     */
    public function delete(User $user, Sku $sku)
    {
        if ($user->id === $sku->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the sku.
     *
     * @param  \App\User  $user
     * @param  \App\Sku  $sku
     * @return mixed
     */
    public function restore(User $user, Sku $sku)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the sku.
     *
     * @param  \App\User  $user
     * @param  \App\Sku  $sku
     * @return mixed
     */
    public function forceDelete(User $user, Sku $sku)
    {
        //
    }
}
