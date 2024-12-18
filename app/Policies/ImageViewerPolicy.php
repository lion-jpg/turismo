<?php
namespace App\Policies;

use App\Models\User;

class ImageViewerPolicy
{
    
    public function viewAny(User $user): bool
    {   
        // dd($user->roles->pluck('name'));
        return $user->hasRole(['admin','editar guia']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        // dd($user->roles);
        return $user->hasRole(['admin','editar guia']); // Cambia esto según tu lógica.
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin','editar guia']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {   
        return $user->hasRole(['admin','editar guia']);
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole(['admin','editar guia']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(['admin','editar guia']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole(['admin','editar guia']);
    }
}
