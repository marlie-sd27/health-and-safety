<?php

namespace App\Policies;

use App\Submissions;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    // user must own the submission or be admin to view
    public function view(User $user, Submissions $submission)
    {
        return strcasecmp($submission->email, $user->email) == 0 | $user->isAdmin();
    }



    // user must own the submission to update
    public function update(User $user, Submissions $submission)
    {
        return strcasecmp($submission->email, $user->email) == 0;
    }


    // user must own the submission or be admin to delete
    public function delete(User $user, Submissions $submission)
    {
        return strcasecmp($submission->email, $user->email) == 0 | $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Submissions  $submissions
     * @return mixed
     */
    public function restore(User $user, Submissions $submissions)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Submissions  $submissions
     * @return mixed
     */
    public function forceDelete(User $user, Submissions $submissions)
    {
        //
    }
}
