<?php

namespace App\Policies;

use App\User;
use App\Training;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class TrainingPolicy
{
    use HandlesAuthorization;

    // user must own the training or be admin or principal to view
    public function view(User $user, Training $training)
    {
        return strcasecmp($training->email, $user->email) == 0 | $user->isAdmin() | $user->isPrincipal() | $user->isReporter();
    }


    // user must be admin to create new training entry
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    // user must be admin to update
    public function update(User $user)
    {
        return $user->isAdmin();
    }


    // user must be admin to delete
    public function delete(User $user)
    {
        return $user->isAdmin();
    }


    // user must be admin or principal to report
    public function report(User $user)
    {
        return $user->isAdmin() | $user->isPrincipal() | $user->isReporter();
    }
}
