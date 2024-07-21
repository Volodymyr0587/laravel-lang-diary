<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = ['translation', 'word_id', 'phrase_id', 'language_id'];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    public function phrase(): BelongsTo
    {
        return $this->belongsTo(Phrase::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
