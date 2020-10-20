<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    protected $fillable = ['site', 'azure_group_id'];
}
