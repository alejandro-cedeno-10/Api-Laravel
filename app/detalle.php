<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle extends Model
{
    //
    protected $fillable = [  
        'id_factura', 'id_producto','cantidad','precio'
    ];

    protected $hidden = [
     'created_at','updated_at'
    ];
}
