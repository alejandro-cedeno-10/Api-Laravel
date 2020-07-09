<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tamano extends Model
{
    //
    protected $fillable = [
        
        'nombre'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at','updated_at','admin'
    ];
}
