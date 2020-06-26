<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = [
        'title', 'description', 'recurrence', 'required_role', 'full_year'
    ];
}
