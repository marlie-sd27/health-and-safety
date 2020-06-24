<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    protected $fillable = [
        'title', 'form_id', 'columns', 'description'
    ];
}
