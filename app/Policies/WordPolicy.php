<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Word;

class WordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function editWord(User $user, Word $word): bool
    {
        return $word->user->is($user);
    }
}
