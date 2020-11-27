<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'admin', 'principal', 'elementary_principal', 'last_login', 'report_access', 'job_title', 'site'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin() {
        return $this->admin;
    }

    public function isPrincipal() {
        return $this->principal;
    }

    public function isReporter() {
        return $this->report_access;
    }

    public function isElementaryPrincipal() {
        return $this->elementary_principal;
    }

    public function isSecondaryPrincipal() {
        return !$this->elementary_principal && $this->principal;
    }

    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }

    public function canViewAllSubmissions() {
        return $this->isAdmin() | $this->isPrincipal() | $this->isReporter();
    }
}
