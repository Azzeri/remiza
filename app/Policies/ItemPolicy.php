<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Item $item)
    {
        return $user->privilege_id == Privilege::IS_GLOBAL_ADMIN || $item->fire_brigade_unit_id == $user->fire_brigade_unit_id
            || ($user->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN && $item->fireBrigadeUnit->superior_unit_id == $user->fire_brigade_unit_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Item $item)
    {
        return $user->privilege_id == Privilege::IS_GLOBAL_ADMIN || $item->fire_brigade_unit_id == $user->fire_brigade_unit_id
            || ($user->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN && $item->fireBrigadeUnit->superior_unit_id == $user->fire_brigade_unit_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Item $item)
    {
        return $user->privilege_id == Privilege::IS_GLOBAL_ADMIN || $item->fire_brigade_unit_id == $user->fire_brigade_unit_id
            || ($user->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN && $item->fireBrigadeUnit->superior_unit_id == $user->fire_brigade_unit_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Item $item)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Item $item)
    {
        //
    }
}
