<?php

namespace App\Policies;

use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JurnalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin, guru, dan siswa boleh lihat daftar jurnal
        return in_array($user->role, ['admin', 'guru', 'siswa']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Jurnal $jurnal): bool
    {
        return $user->id === $jurnal->user_id || $user->role == 'guru' || $user->role == 'admin' || $user->role == 'siswa';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role==='siswa';
    }
    public function siswa(User $user): bool
    {
        return $user->role==='siswa';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Jurnal $jurnal): bool
    {
        return $user->id === $jurnal->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Jurnal $jurnal): bool
    {
        return $user->id === $jurnal->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Jurnal $jurnal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Jurnal $jurnal): bool
    {
        return false;
    }
}
