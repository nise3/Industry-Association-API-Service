<?php

namespace App\Policies;


use App\Models\FourIRInitiative;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FourIRInitivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any jobSectors.
     *
     * @param User $authUser
     * @return bool
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermission('view_any_4ir_initiatives');

    }

    /**
     * Determine whether the user can view the jobSector.
     *
     * @param User $authUser
     * @param FourIRInitiative $fourIRInitiative
     * @return bool
     */
    public function view(User $authUser, FourIRInitiative $fourIRInitiative): bool
    {
        return $authUser->hasPermission('view_single_4ir_initiatives');

    }

    /**
     * Determine whether the user can create jobSectors.
     *
     * @param User $authUser
     * @return bool
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasPermission('create_4ir_initiatives');
    }

    /**
     * Determine whether the user can update the jobSector.
     *
     * @param User $authUser
     * @param FourIRInitiative $fourIRInitiative
     * @return bool
     */
    public function update(User $authUser, FourIRInitiative $fourIRInitiative): bool
    {
        return $authUser->hasPermission('update_4ir_initiatives');
    }

    /**
     * Determine whether the user can delete the jobSector.
     *
     * @param User $authUser
     * @param FourIRInitiative $fourIRInitiative
     * @return bool
     */
    public function delete(User $authUser, FourIRInitiative $fourIRInitiative): bool
    {
        return $authUser->hasPermission('delete_4ir_initiatives');
    }
}
