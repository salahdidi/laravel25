<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    //id 
    //class name . singular form
    // protected $table = 'tasks';
    // //primary key
    // protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'priority',
        'created_by_id'
    ];
}
