<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'email', 'course', 'description', 'notes', 'course_date', 'expiry_date', 'site','union','designated_fa_attendant','fa_level','full_part_hours', 'inspection_date'
    ];


    // get the user who submitted
    public function users()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }
}
