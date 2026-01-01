<?php

namespace App\Policies;

use App\Models\Paste;
use App\Models\User;

class PastePolicy
{
    /**
     * Determine whether the user can view the paste.
     */
    public function view(?User $user, Paste $paste): bool
    {
        return true; // Pastes are publicly viewable
    }

    /**
     * Determine whether the user can delete the paste.
     */
    public function delete(?User $user, Paste $paste): bool
    {
        // Allow deletion by the paste owner or anyone if it's not owned
        return $user?->id === $paste->user_id || $paste->user_id === null;
    }
}
