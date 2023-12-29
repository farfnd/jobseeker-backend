<?php

namespace App\Policies;

use App\Models\Candidate;
use App\Models\Education;
use Illuminate\Auth\Access\Response;

class EducationPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(Candidate $candidate, Education $education): bool
    {
        return $candidate->id === $education->candidate_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Candidate $candidate, Education $education): bool
    {
        return $candidate->id === $education->candidate_id;
    }
}
