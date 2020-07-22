<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'date', 'forms_id'
    ];


    public function form()
    {
        return $this->belongsTo('App\Forms');
    }


    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }
}
