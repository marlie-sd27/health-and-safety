<?php

namespace App\Providers;

use App\Policies\SubmissionPolicy;
use App\Policies\TrainingPolicy;
use App\Submissions;
use App\Training;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Submissions::class => SubmissionPolicy::class,
        Training::class => TrainingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
