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
     * Determine whether the user can update the sku.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Sku  $sku
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
     * @param  \App\Models\Sku  $sku
     * @return mixed
     */
    public function delete(User $user, Sku $sku)
    {
        if ($user->id === $sku->users_id) {
            return true;
        }
        return false;
    }
}
