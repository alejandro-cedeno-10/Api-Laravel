<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tamano_producto extends Model
{
    protected $fillable = [
        
        'id','id_tamano','id_producto','precio','stock','url_imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at','updated_at','admin'
    ];
    //
}
