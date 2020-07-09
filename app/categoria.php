<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    //
    
    protected $fillable = [  
        'id', 'nombre','descripcion'
    ];

    protected $hidden = [
     'created_at','updated_at'
    ];
}
