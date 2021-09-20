<?php

namespace App\Policies;

use App\Models\Privilege;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Vehicle $vehicle)
    {
        return ($user->privilege_id == Privilege::IS_GLOBAL_ADMIN) ||
            ($vehicle->fire_brigade_unit_id == $user->fire_brigade_unit_id) ||
            ($user->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN && $vehicle->unit->superior_unit_id == $user->fire_brigade_unit_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Vehicle $vehicle)
    {
        return ($user->privilege_id == Privilege::IS_GLOBAL_ADMIN) ||
            ($vehicle->fire_brigade_unit_id == $user->fire_brigade_unit_id) ||
            ($user->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN && $vehicle->unit->superior_unit_id == $user->fire_brigade_unit_id);
    }
}
