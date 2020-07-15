<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    protected $fillable = [
        'forms_id', 'username', 'email', 'data'
    ];


    // get the form associated with this submisson
    public function forms()
    {
        return $this->belongsTo('App\Forms');
    }
}
