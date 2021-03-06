<?php

namespace App\Policies;

use App\Models\RankType;
use App\MOdels\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 *
 */
class RankTypePolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any rankTypes.
     *
     * @param User $authUser
     * @return bool
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermission('view_any_rank_type');

    }

    /**
     * Determine whether the user can view the rankType.
     *
     * @param User $authUser
     * @param RankType $rankType
     * @return bool
     */
    public function view(User $authUser, RankType $rankType): bool
    {
        return $authUser->hasPermission('view_single_rank_type');

    }

    /**
     * Determine whether the user can create rankTypes.
     *
     * @param User $authUser
     * @return bool
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasPermission('create_rank_type');

    }

    /**
     * Determine whether the user can update the rankType.
     *
     * @param User $authUser
     * @param RankType $rankType
     * @return bool
     */
    public function update(User $authUser, RankType $rankType): bool
    {
        return $authUser->hasPermission('update_rank_type');

    }

    /**
     * Determine whether the user can delete the rankType.
     *
     * @param User $authUser
     * @param RankType $rankType
     * @return bool
     */
    public function delete(User $authUser, RankType $rankType): bool
    {
        return $authUser->hasPermission('delete_rank_type');
    }
}
