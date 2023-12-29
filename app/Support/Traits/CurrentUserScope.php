<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CurrentUserScope
{
    public function scopeCurrentUser(Builder $query): Builder
    {
        return $query->where('candidate_id', auth()->id());
    }
}
