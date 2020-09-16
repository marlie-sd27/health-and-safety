<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{

    use SoftDeletes;

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
