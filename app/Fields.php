<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $fillable = [
        'sections_id', 'label', 'name', 'type', 'required', 'options'
    ];


    // get associated section
    public function sections()
    {
        return $this->belongsTo('App\Sections');
    }
}
