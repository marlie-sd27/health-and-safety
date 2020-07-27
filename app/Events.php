<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'forms_id', 'date'
    ];


    public function forms()
    {
        return $this->belongsTo('App\Forms', 'forms_id', 'id');
    }

    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }

}
