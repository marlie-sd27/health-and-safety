<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'forms_id', 'start'
    ];


    public function forms()
    {
        return $this->belongsTo('App\Forms');
    }

    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }

}
