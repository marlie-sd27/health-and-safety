<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    protected $fillable = [
        'events_id', 'forms_id', 'site', 'email', 'data', 'files',
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


    // convert data string to array
    public function prepareData()
    {
        $this['data'] = Helper::parseHTTPQuery($this->data);
        $this['files'] = Helper::parseHTTPQuery($this->files);
    }


    public function prepareSubmission()
    {
        $this->prepareData();
        $this->created_at_readable = Helper::makeTimeStampReadable($this->created_at);
        $this->updated_at_readable = Helper::makeTimeStampReadable($this->updated_at);
        $this->form = $this->forms->fullForm();

        return $this;
    }
}
