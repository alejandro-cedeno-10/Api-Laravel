<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class modo_pago extends Model
{
    //

    protected $fillable = [  
        'id', 'id_tipo','pago','detalles'
    ];

    protected $hidden = [
     'created_at','updated_at'
    ];
}
