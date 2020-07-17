<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    protected $fillable = [
        'forms_id', 'username', 'email', 'data'
    ];


    // get the user who submitted
    public function user()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }


    // get the form associated with this submission
    public function forms()
    {
        return $this->belongsTo('App\Forms');
    }


    // convert data string to array
    public function prepareData()
    {
        // convert http_query to key-value array
        parse_str($this['data'], $data);

        // replace underscores with spaces in each key-value pair and push pair into new array
        $parsedData = array();
        foreach ($data as $key => $value)
        {
            // if value is an array (as in case for a checkbox), replace each entry's underscores with spaces
            $newValue = (is_array($value)) ? str_replace("_", " ", join(", ", array_keys($value))) : str_replace("_", " ", $value);
            $newKey = str_replace("_", " ", $key);

            $parsedData[$newKey] = $newValue;
        }

        $this['data'] = $parsedData;
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
