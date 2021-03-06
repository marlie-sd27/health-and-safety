<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }


    public function getSites_id()
    {
        return $this->sites()->id;
    }

    public function sites()
    {
        return Sites::firstWhere('code',$this->site);
    }

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

    public function hasReportingPrivileges() {
        return $this->isAdmin() | $this->isPrincipal() | $this->isReporter();
    }
}
