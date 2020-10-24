<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_pago extends Model
{
    //

    protected $fillable = [  
        'id', 'tipo_pago'
    ];

    protected $hidden = [
     'created_at','updated_at'
    ];
}
