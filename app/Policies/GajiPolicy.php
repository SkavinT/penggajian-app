<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gaji;

class GajiPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'a'; // hanya admin
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Gaji $gaji): bool
    {
        return $user->role === 'a'; // hanya admin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Gaji $gaji): bool
    {
        return $user->role === 'a'; // hanya admin
    }
}
