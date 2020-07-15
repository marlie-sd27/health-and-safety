<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    protected $fillable = [
        'title', 'forms_id', 'columns', 'description'
    ];


    // get associated form
    public function forms()
    {
        return $this->belongsTo('App\Forms');
    }


    // get the fields for this section
    public function fields()
    {
        return $this->hasMany('App\Fields');

    }
}
