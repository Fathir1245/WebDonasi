<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Semua user (termasuk guest) bisa melihat daftar campaign
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Campaign $campaign): bool
    {
        // Semua user (termasuk guest) bisa melihat detail campaign
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // User yang sudah login bisa membuat campaign
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        // User bisa mengupdate campaign jika:
        // 1. User adalah admin, atau
        // 2. User adalah pemilik campaign
        return $user->is_admin || $user->id === $campaign->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        // User bisa menghapus campaign jika:
        // 1. User adalah admin, atau
        // 2. User adalah pemilik campaign
        return $user->is_admin || $user->id === $campaign->user_id;
    }
} 