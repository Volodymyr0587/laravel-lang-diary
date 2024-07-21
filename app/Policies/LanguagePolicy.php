<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
{
    /**
     * Determine whether the user can edit model.
     */
    public function editLanguage(User $user, Language $language): bool
    {
        return $language->user->is($user);
    }

}
