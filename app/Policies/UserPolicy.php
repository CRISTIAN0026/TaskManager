<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can create new users.
     */
    public function create(User $user): bool
    {
        return $user->is_super_admin;
    }
}
