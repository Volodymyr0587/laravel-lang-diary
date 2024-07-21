<?php

namespace App\Policies;

use App\Models\Phrase;
use App\Models\User;

class PhrasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function editPhrase(User $user, Phrase $phrase): bool
    {
        return $phrase->user->is($user);
    }
}
