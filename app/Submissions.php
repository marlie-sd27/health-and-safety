<?php

namespace App;

use App\Http\Requests\StoreSubmission;
use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    protected $fillable = [
        'forms_id', 'username', 'email', 'data'
    ];


    // get the form associated with this submission
    public function forms()
    {
        return $this->belongsTo('App\Forms');
    }


    // convert data to a string
    public function dataToString(StoreSubmission $validated)
    {
        return http_build_query($validated->data);
    }
}
