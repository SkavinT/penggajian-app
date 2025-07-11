<?php

namespace App\Policies;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PegawaiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pegawai $pegawai): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->role === 'a';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pegawai $pegawai): bool
    {
        return $user->role === 'a'; // hanya admin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pegawai $pegawai): bool
    {
        return $user->role === 'a'; // hanya admin
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pegawai $pegawai): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pegawai $pegawai): bool
    {
        return false;
    }
}
