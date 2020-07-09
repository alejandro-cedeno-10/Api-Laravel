<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class factura extends Model
{
    //
    protected $fillable = [  
        'id', 'id_user','num_pago','fecha'
    ];

    protected $hidden = [
     'created_at','updated_at'
    ];
}
