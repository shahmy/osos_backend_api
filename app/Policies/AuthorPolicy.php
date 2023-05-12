<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the author can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the author can view the model.
     */
    public function view(User $user, Author $model): bool
    {
        return true;
    }

    /**
     * Determine whether the author can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the author can update the model.
     */
    public function update(User $user, Author $model): bool
    {
        return true;
    }

    /**
     * Determine whether the author can delete the model.
     */
    public function delete(User $user, Author $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the author can restore the model.
     */
    public function restore(User $user, Author $model): bool
    {
        return false;
    }

    /**
     * Determine whether the author can permanently delete the model.
     */
    public function forceDelete(User $user, Author $model): bool
    {
        return false;
    }
}
