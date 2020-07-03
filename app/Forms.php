<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = [
        'title', 'description', 'recurrence', 'required_role', 'full_year'
    ];


    // get the sections and fields for a form
    public function fullForm()
    {
        $this['sections'] = $this->sections;

        foreach ($this['sections'] as $section)
        {
            $section['fields'] = $section->fields;
        }

        return $this;
    }


    // Get the sections for a form
    public function sections()
    {
        return $this->hasMany('App\Sections');
    }


    // Get the submissions for a form
    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }
}
