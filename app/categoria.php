<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    //
    
    protected $fillable = [  
        'id', 'nombre','descripcion', 'url_imagen'
    ];

    protected $hidden = [
     'created_at','updated_at'
    ];
}
