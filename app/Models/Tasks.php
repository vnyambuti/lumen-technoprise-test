<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Tasks extends Model
{
    protected $fillable = ['title', 'description', 'status'];
    public static function boot()
    {
        parent::boot();

       
    }
}
