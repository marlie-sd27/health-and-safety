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

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Submissions  $submissions
     * @return mixed
     */
    public function view(User $user, Submissions $submissions)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    // determine whether the current user can update the submission
    public function update(User $user, Submissions $submission)
    {
        return $submission->email === $user->email;
    }


    public function delete(User $user, Submissions $submission)
    {
        return $submission->email === $user->email | $user->isAdmin();
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
