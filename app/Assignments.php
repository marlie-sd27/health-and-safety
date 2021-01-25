<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    protected $fillable = ['events_id', 'email', 'sites_id'];


    // get the site associated with this submission
    public function sites()
    {
        return $this->belongsTo('App\Sites');
    }


    // get the event associated with this submission
    public function events()
    {
        return $this->belongsTo('App\Events')->withTrashed();
    }
}
