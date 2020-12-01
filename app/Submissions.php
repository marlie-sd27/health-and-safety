<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    protected $fillable = [
        'events_id', 'forms_id', 'site', 'email', 'data', 'files', 'assignments_id', 'sites_id'
    ];


    // get the user who submitted
    public function users()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }


    // get the events associated with this submission
    public function events()
    {
        return $this->belongsTo('App\Events');
    }


    // get the form associated with this submission
    public function forms()
    {
        return $this->belongsTo('App\Forms');
    }


    // get the form associated with this submission
    public function sites()
    {
        return $this->belongsTo('App\Sites');
    }


//    // get the assignment associated with this submission
//    public function assignments()
//    {
//        return $this->hasOne('App\Assignments');
//    }


    // convert data string to array
    public function prepareData()
    {
        $this['data'] = Helper::parseHTTPQuery($this->data);
        $this['files'] = Helper::parseHTTPQuery($this->files);
    }


    public function prepareSubmission()
    {
        $this->prepareData();
        $this->form = $this->forms->fullForm();

        return $this;
    }
}
