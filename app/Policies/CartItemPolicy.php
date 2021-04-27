<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\Sku;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can update the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CartItem  $cartItem
     * @return mixed
     */
    public function update(User $user, CartItem $cartItem)
    {
        if ($user->id === $cartItem->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the cart item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CartItem  $cart
     * @return mixed
     */
    public function delete(User $user, CartItem $cart)
    {
        if ($user->id === $cart->users_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can store sku to the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Sku  $sku
     * @return mixed
     */
    public function cartStore(User $user, Sku $sku)
    {
        if ($user->id != $sku->users_id) {
            return true;
        }
        return false;
    }
}
