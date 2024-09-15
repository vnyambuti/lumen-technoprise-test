<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status','due_date'];
    public static function boot()
    {
        parent::boot();

       
    }
}
