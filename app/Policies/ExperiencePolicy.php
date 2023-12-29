<?php

namespace App\Policies;

use App\Models\Candidate;
use App\Models\Experience;
use Illuminate\Auth\Access\Response;

class ExperiencePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(Candidate $candidate, Experience $experience): bool
    {
        return $candidate->id === $experience->candidate_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Candidate $candidate, Experience $experience): bool
    {
        return $candidate->id === $experience->candidate_id;
    }
}
