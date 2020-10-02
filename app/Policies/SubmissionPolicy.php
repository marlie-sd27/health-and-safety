<?php

namespace App\Policies;

use App\Submissions;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;


    // user must own the submission or be admin or principal to view
    public function view(User $user, Submissions $submission)
    {
        return strcasecmp($submission->email, $user->email) == 0 | $user->isAdmin() | $user->isPrincipal() | $user->isReporter();
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


    // user be admin or principal to report
    public function report(User $user)
    {
        return $user->isAdmin() | $user->isPrincipal() | $user->isReporter();
    }
}
