<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $fillable = [
        'section_id', 'label', 'name', 'type', 'required', 'options'
    ];
}
