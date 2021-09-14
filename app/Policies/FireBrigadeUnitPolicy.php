<?php

namespace App\Policies;

use App\Models\FireBrigadeUnit;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FireBrigadeUnitPolicy
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
        // return $user->privilege_id == Privilege::IS_GLOBAL_ADMIN || ($user->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN);
        return in_array($user->privilege_id, [Privilege::IS_GLOBAL_ADMIN, Privilege::IS_SUPERIOR_UNIT_ADMIN]);

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FireBrigadeUnit  $fireBrigadeUnit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FireBrigadeUnit $fireBrigadeUnit)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FireBrigadeUnit  $fireBrigadeUnit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FireBrigadeUnit $fireBrigadeUnit)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FireBrigadeUnit  $fireBrigadeUnit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FireBrigadeUnit $fireBrigadeUnit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FireBrigadeUnit  $fireBrigadeUnit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FireBrigadeUnit $fireBrigadeUnit)
    {
        //
    }
}
