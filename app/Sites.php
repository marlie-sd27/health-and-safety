<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    protected $fillable = ['site', 'azure_group_id', 'code'];


    // get the submissions associated with this submission
    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }


    // get the assignments associated with this submission
    public function assignments()
    {
        return $this->hasMany('App\Assignments');
    }
}
